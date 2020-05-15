<?php
session_start();

// require_once 'inc/classDBInformation.php';

require_once './inc/global_config.inc.php';

$_SESSION['title'] = 'Domain - Verwaltung von Domains';
$_SESSION['start'] = isset($_SESSION['start']) ? $_SESSION['start'] : false;

static $db;

function doAction($action = '', $id = '', $von = 0, $lim = 0, $order = 'asc')
{
    if (DEBUG) {
        echo "<br /><br />ID " . $id;
        echo "<br /><br />ACTION " . $action;
    }
    
    // $oDbName = new DBInformation();
    
    // Aber die Übersicht ist doch nicht die action sondern der
    // controller.....
    
    include 'inc/header.php';
    
    if ($action == '') {
        
        $db = $id;
        if ($_SESSION['start'] == false) {
            $_SESSION['start'] = true;
            echo "<h1>Lizenzen</h1>";
            echo "<h2>Ansatz?</h2>";
            
            die();
        }
    } 
    /**
     * Auswertung anlegen
     *
     * Tag Produkt ANzahl
     */
    
    else if ($action == 'insgesamt') {
        
        // Die Tabelle
        // Select pb.produkt_bezeichnung, (SELECT Count(*) FROM `nutzer_produkt_zaehlung` WHERE produkt_id=pb.produkt_id ) from liz_produkt pb
        echo '<h1 style="background: darkorange;
	             padding-left:10px;">BS und APP Bestand </h1>';
        
        echo  '<h2><small>erfasste Betriebssysteme und Anwendungen</small></h2>';

        echo '<h3>am '.date("d.m.y", time()).'</h3>';
        
        try {
            
            $sql = "Select pb.produkt_id, pb.produkt_bezeichnung, pb.produkt_version, pb.produkt_beschreibung, (SELECT Count(*) FROM `nutzer_produkt_zaehlung`  WHERE produkt_id=pb.produkt_id ) AS zaehler from liz_produkt pb";
            
            $db = new PDO('mysql:host=' . DB_HOST . '; dbname=' . DB_NAME, DB_USER, DB_PASS);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $rueckgabe = $db->query($sql);
            
            $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
            
            // Darstellung nur, wenn ein Ergebnis vorhanden ist
            
            if ($ergebnis) {
                
                $i = 0;
                echo "<table style=\"background:#cccbdc;padding:4px;border:1px;\"   cellpadding=\"6\" cellspacing=\"1\">";
                foreach ($ergebnis as $inhalt) {
                    $zaehler = $inhalt['zaehler'];
                    if ($zaehler != 0) {
                        
                        $farbe = $i % 2 == 0 ? '#cccbdc' : '#fefeff';
                        echo "<tr>";
                        echo "<td style=\"background:" . $farbe . ";a color:orange;width:600px;text-align:right;\" class=\"odd\" title=\"" . $inhalt['produkt_beschreibung'] . "\">";
                        echo $inhalt['produkt_bezeichnung'] . " " . $inhalt['produkt_version']. " ". $inhalt['produkt_beschreibung'];
                        echo "</td>";
                        echo "<td style=\"background:" . $farbe . ";a color:orange;width:60px;text-align:right;\" class=\"odd\">";
                        echo $zaehler;
                        echo "</td></tr>";
                        
                        //  tagesaktuelle_lizenzauswertung_datum
                        
                        // existiert bereits ein Eintrag? (initial_id und parent_id)
                        $initial_id=getTagesAktuelleLizenzAuswertungInitialId($inhalt['produkt_id']);
                        
                        // existiert bereits ein Eintrag? (initial_id und parent_id)
                        $parent_id=getTagesAktuelleLizenzAuswertungParentId($inhalt['produkt_id']);
                        
                       // echo "Initial: ".$initial_id." | ParentID: ". $parent_id."<br><br>";
                        
                       // Analog sollte jetzt noch der Wert, der bereits in Nutzung stehenden Lizenzen ermittelt werden.
                        $aktuellGenutzteLizenzen=getAktuellGenutzteLizenzen($inhalt['produkt_id']);
                        $gesamtLizenzen=getGesamtLizenzen($inhalt['produkt_id']);
                        $verfuegbar=$gesamtLizenzen-$aktuellGenutzteLizenzen;
                        // tagesaktuelle_lizenzauswertung_lizenz_initial_id
                        
                        
                        /***
                         * 
                         * Das muss jetzt noch in die Tabelle anzahl_lizenz eingefügt werden
                         * 
                         * 
                         */
                        
                        
                        
                        
                        
                       // die();
                        
                        try {
                            
                            // $sql = "REPLACE INTO `liz_hersteller` SET `hersteller_name` = '".$herstellername."'";
                            
                            if ($initial_id==null)
                            {
                                $sql = 'Replace Into `liz_tagesaktuelle_lizenzauswertung` SET tagesaktuelle_lizenzauswertung_datum = NOW(), 
                                        `tagesaktuelle_lizenzauswertung_produkt_id` = '.$inhalt['produkt_id'].', 
                                        `tagesaktuelle_lizenzauswertung_innutzung` = '.$zaehler.';';
                                
                            } else {
                                
                                $sql = 'Replace Into `liz_tagesaktuelle_lizenzauswertung` SET tagesaktuelle_lizenzauswertung_datum = NOW(),
                                        `tagesaktuelle_lizenzauswertung_lizenz_initial_id` = '.$initial_id.',
                                        `tagesaktuelle_lizenzauswertung_parent_id` = '.$parent_id.',
                                        `tagesaktuelle_lizenzauswertung_produkt_id` = '.$inhalt['produkt_id'].',
                                        `tagesaktuelle_lizenzauswertung_innutzung` = '.$zaehler.';';
                            }
                            
                            
                            
                            //print $sql."<br>";
                           
                           // die();
                            
                            
                            $db = new PDO('mysql:host=' . DB_HOST . '; dbname=' . DB_NAME, DB_USER, DB_PASS);
                            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $db->query($sql);
                            $db = null;
                            
                            if ($initial_id==null){
                                
                                // füge eine initial Id ein
                                setTagesAktuelleLizenzAuswertungInitialId();
                                
                            }
                            
                            
                            
                        } catch (PDOException $e) {
                            print "<br>" . $e->getMessage();
                        }
                        
                        
                        
                        
                        
                        
                        
                        
                        
                       // Das "unten" genügt (noch) nicht!
                       // Es muss noch geprüft werden, ob ein Eintrag mit der produkt_id vorhanden ist. und die Änderungen im Bestand ermittelt und eingetragen werden
                       
                       
                       
                       
                       $lizenz_id=0;
                        
                        try {
                            
                            // $sql = "REPLACE INTO `liz_hersteller` SET `hersteller_name` = '".$herstellername."'";
                            
                            //$sql = 'Select `anzahl_lizenz_produkt_id`,`anzahl_lizenz_innutzung`, anzahl_lizenz_initial_id, anzahl_lizenz_id from `liz_anzahl_lizenz` where `anzahl_lizenz_produkt_id` = '.$inhalt['produkt_id'];
                                                //anzahl_lizenz_produkt_id
                            $sql = 'Select lal.anzahl_lizenz_produkt_id,lal.anzahl_lizenz_innutzung, lal.anzahl_lizenz_initial_id, lal.anzahl_lizenz_id, lil.lizenz_id 
                                    from liz_anzahl_lizenz lal, liz_lizenz lil
                                    where lal.anzahl_lizenz_produkt_id = '.$inhalt['produkt_id'].' 
                                        and lil.produkt_id=lal.anzahl_lizenz_produkt_id order by lal.anzahl_lizenz_id DESC Limit 1';
                            
                            // print $sql."<br>";
                            
                            $db = new PDO('mysql:host=' . DB_HOST . '; dbname=' . DB_NAME, DB_USER, DB_PASS);
                            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $db->query($sql);
                            
                            
                            $rueckgabe = $db->query($sql);
                            
                            $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
                            
                            //echo
                            //echo "<br>";
                            $db=null;
                            
                            if($ergebnis!=null) {
                                $lizenz_id = $ergebnis[0]['lizenz_id'];
                            }
                            
                           
                            
                            $db = null;
                        } catch (PDOException $e) {
                            print "<br>" . $e->getMessage();
                        }
                        
                        
                        // ermittle die Lizenz ID 
                        
                        
                        
                        
                        
                        
                        // die eben ermittelten Id ... wird zur parent id ...
                        // die initial_id bleibt gleich
                        // die zahl in Nutzung wird entsprechend der oben ermittelten Zahl addiert oder subtrahiert. die daraufhin zur Verfügung 
                        // stehenden Lizenzen wird entsprechend umgekehrt angepasst... bedeutet ... jede in Nutzung stehende Lizenz, wird von der zur 
                        // Verfügung stehenden abgezogen.
                        
                        // Eintrag in liz_anzahl_lizenz
                        
                       
                       
                       // `anzahl_lizenz_produkt_id`
                       
                        //$aktuellGenutzteLizenzen=getAktuellGenutzteLizenzen($inhalt['produkt_id']);
                        //$gesamtLizenzen=getGesamtLizenzen($inhalt['produkt_id']);
                        //$verfuegbar=$gesamtLizenzen-$aktuellGenutzteLizenzen;
                        
                        
                        
                        try {
                            
                            // $sql = "REPLACE INTO `liz_hersteller` SET `hersteller_name` = '".$herstellername."'";
                            
                            $sql = 'Replace Into `liz_anzahl_lizenz` SET `anzahl_lizenz_verfuegbar` = '.$verfuegbar.', `anzahl_lizenz_datum` = NOW(), 
                                    `anzahl_lizenz_produkt_id` = '.$inhalt['produkt_id'].', `anzahl_lizenz_innutzung` = '.$zaehler.', `lizenz_id`= '.$lizenz_id.';';
                            
                           //  print $sql."<br>";
                            
                            $db = new PDO('mysql:host=' . DB_HOST . '; dbname=' . DB_NAME, DB_USER, DB_PASS);
                            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $db->query($sql);
                            $db = null;
                        } catch (PDOException $e) {
                            print "<br>" . $e->getMessage();
                        }
                        
                        
                        
                        
                        ++ $i;
                    }
                }
                echo "</table>";
            }
            $db = null;
        } 
        catch (PDOException $e) {
            print $e->getMessage();
        }
        
        echo "<br><br>";
        echo "<a href=\"../produkte/anlegen/" . $id . "\">M&ouml;chten Sie ein neues Produkt anlegen?</a>";
        
        include 'inc/footer.php';
    }
    
    
    else if ($action == 'durchschnitt') {
        
        // Die Tabelle
        // Select pb.produkt_bezeichnung, (SELECT Count(*) FROM `nutzer_produkt_zaehlung` WHERE produkt_id=pb.produkt_id ) from liz_produkt pb
        echo '<h1 style="background: darkorange;
	             padding-left:10px;">Auswertung </h1>';
        
        echo  '<h2>am '.date("d.m.y", time()).'</h2>';
        
        try {
            
            // Das Spuckt zwar erst mal etwas aus, aber hier muss noch dran gearbeitetet werden !
            
            //$sql = "Select pb.produkt_id, pb.produkt_bezeichnung, pb.produkt_version, pb.produkt_beschreibung, (SELECT MIN(tagesaktuelle_lizenzauswertung_innutzung) FROM `liz_tagesaktuelle_lizenzauswertung` WHERE ltl.tagesaktuelle_lizenzauswertung_produkt_id=pb.produkt_id ) AS min, (SELECT AVG(tagesaktuelle_lizenzauswertung_innutzung) FROM `liz_tagesaktuelle_lizenzauswertung` WHERE ltl.tagesaktuelle_lizenzauswertung_produkt_id=pb.produkt_id ) AS max, (SELECT MAX(tagesaktuelle_lizenzauswertung_innutzung) FROM `liz_tagesaktuelle_lizenzauswertung` WHERE ltl.tagesaktuelle_lizenzauswertung_produkt_id=pb.produkt_id ) AS avg from liz_tagesaktuelle_lizenzauswertung ltl, liz_produkt pb";
            
            $sql = "Select Distinct pb.produkt_id, pb.produkt_bezeichnung, pb.produkt_version, pb.produkt_beschreibung
            from  liz_produkt pb;";
            
            
            /*
            (SELECT MIN(tagesaktuelle_lizenzauswertung_innutzung) FROM `liz_tagesaktuelle_lizenzauswertung` WHERE ltl.tagesaktuelle_lizenzauswertung_produkt_id=18 ) AS min,
            (SELECT AVG(tagesaktuelle_lizenzauswertung_innutzung) FROM `liz_tagesaktuelle_lizenzauswertung` WHERE ltl.tagesaktuelle_lizenzauswertung_produkt_id=18 ) AS max,
            (SELECT MAX(tagesaktuelle_lizenzauswertung_innutzung) FROM `liz_tagesaktuelle_lizenzauswertung` WHERE ltl.tagesaktuelle_lizenzauswertung_produkt_id=18 ) AS avg 
                liz_tagesaktuelle_lizenzauswertung ltl,
            */
            $db = new PDO('mysql:host=' . DB_HOST . '; dbname=' . DB_NAME, DB_USER, DB_PASS);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $rueckgabe = $db->query($sql);
            
            $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
            $zaehler=0;
            // Darstellung nur, wenn ein Ergebnis vorhanden ist
            
            if ($ergebnis) {
                
                $i = 0;
                echo "<table style=\"background:#cccbdc;padding:4px;border:1px;\"   cellpadding=\"6\" cellspacing=\"1\">";
                foreach ($ergebnis as $inhalt) {
                   // $zaehler = $inhalt['zaehler'];
                   // if ($zaehler != 0) {
                        
                        $farbe = $i % 2 == 0 ? '#cccbdc' : '#fefeff';
                        echo "<tr>";
                        echo "<td style=\"background:" . $farbe . ";a color:orange;width:600px;text-align:right;\" class=\"odd\" title=\"" . $inhalt['produkt_beschreibung'] . "\">";
                        echo $inhalt['produkt_bezeichnung'] . " " . $inhalt['produkt_version']. " ". $inhalt['produkt_beschreibung'];
                        echo "</td>";
                        echo "<td style=\"background:" . $farbe . ";a color:orange;width:200px;text-align:right;\" class=\"odd\">";
                        //echo $zaehler;
                        
                        
                        
                        try {
                            $sql1="SELECT 
                                    MIN(tagesaktuelle_lizenzauswertung_innutzung) AS min, 
                                    MAX(tagesaktuelle_lizenzauswertung_innutzung) AS max, 
                                    AVG(tagesaktuelle_lizenzauswertung_innutzung) AS avg 
                                FROM `liz_tagesaktuelle_lizenzauswertung`
                                Where `tagesaktuelle_lizenzauswertung_produkt_id`=".$inhalt['produkt_id'];
                            
                           // echo "<br><br>".$sql1."<br><br>";
                            
                            $db1 = new PDO('mysql:host=' . DB_HOST . '; dbname=' . DB_NAME, DB_USER, DB_PASS);
                            $db1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            
                            $rueckgabe1 = $db1->query($sql1);
                            
                            $ergebnis1 = $rueckgabe1->fetchAll(PDO::FETCH_ASSOC);
                            
                        
                            if ( $ergebnis1[0]['min']!=0 ) {
                        
                                echo "Min: ".$ergebnis1[0]['min']." Max: ".$ergebnis1[0]['max'];//" AVG: ".$ergebnis1[0]['avg'];
                            }
                            
                            $db1 = null;
                         }
                         catch (PDOException $e) {
                            print $e->getMessage();
                         }
                        
                        echo "</td></tr>";
                        
                        //  tagesaktuelle_lizenzauswertung_datum
                        
                       /*  try {
                            
                            // $sql = "REPLACE INTO `liz_hersteller` SET `hersteller_name` = '".$herstellername."'";
                            
                            $sql = 'Replace Into `liz_tagesaktuelle_lizenzauswertung` SET tagesaktuelle_lizenzauswertung_datum = NOW(), `tagesaktuelle_lizenzauswertung_produkt_id` = '.$inhalt['produkt_id'].', `tagesaktuelle_lizenzauswertung_innutzung` = '.$zaehler.';';
                            
                            // print $sql."<br>";
                            
                            $db = new PDO('mysql:host=' . DB_HOST . '; dbname=' . DB_NAME, DB_USER, DB_PASS);
                            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $db->query($sql);
                            $db = null;
                        } catch (PDOException $e) {
                            print "<br>" . $e->getMessage();
                        } */
                        
                        ++ $i;
                   // }
                }
                echo "</table>";
            }
            $db = null;
        }
        catch (PDOException $e) {
            print $e->getMessage();
        }
        
        echo "<br><br>";
        echo "<a href=\"../produkte/anlegen/" . $id . "\">M&ouml;chten Sie ein neues Produkt anlegen?</a>";
        
        include 'inc/footer.php';
    }
    
}
          
          
          
          
          
          
      