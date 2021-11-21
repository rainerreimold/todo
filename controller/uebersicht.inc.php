<?php
session_start();

//require_once 'inc/classDBInformation.php';

require_once './inc/global_config.inc.php';
require_once './class/Zaehler.classes.php';



$_SESSION['title'] = 'Rezept - Verwaltung von Rezepten, Speiseplänen und Bestellzetteln';
$_SESSION['start'] = isset($_SESSION['start'])?$_SESSION['start']:false;


$Ergebnis= isset($_SESSION['Eintrag'])?$_SESSION['Eintrag']:null;

if ($Ergebnis){
	echo "<div class=\"block eyecatch\">".$Ergebnis."</div>";
	$_SESSION['Eintrag']=null;
}


// Zugriff auf die Übersichtsseite
$oZaehler=new Zaehler();
$oZaehler->addCount('uebersicht');



function doAction( $action = '', $id = '', $von=0, $lim=0, $order='asc' ) {



	if (DEBUG) {
		echo "<br /><br />ID ".$id;
		echo "<br /><br />ACTION ".$action;
	}
	//$oDbName = new  DBInformation();

	//Aber die Übersicht ist doch nicht die action sondern der
	//controller.....
       	include 'inc/header.php';
	if ( $action == '') {
	

//		$db = $id;
		if ($_SESSION['start']==false) {

			$_SESSION['start']=true;
			echo "<h1>Wochenplan und Rezepte</h1>";
			echo "<h2>Ansatz?</h2>";

			echo '<div style="background-color:white;border:green 2px solid;padding:15px;width:80%;margin:4 auto 4 auto;">
		
		Im ersten Schritt habe ich Ingridenzien gesammelt und ein paar Rezepte erstellt. Jetzt sollen die EIngabemasken folgen.
	<br />	
	</div> ';  

          echo '<p>Test Datenbank:</p>';
         // try{
              if ($db==true) 
                 echo " Ok"; 
              else 
                echo "nicht verbunden!";
         // }


			die();
		}



		}

	  echo '<div class="table">';
      echo '<div class="spalte" tyle="backcolor:darksalmon;">';
      echo '<h3>Aufgaben</h3>';
	  echo '<a href="aufgabe/zeigeOffeneAufgaben">zeige alle Aufgaben</a>';
      echo "<br>";
	  echo '<a href="aufgabe/zeigeAlleAufgaben">zeige alle - auch gel&ouml;schte- Aufgaben</a>';
      echo "<br>";
      echo '<a href="aufgabe/anlegen">Aufgabe anlegen</a>';
      echo "<br>";
	
	  /***********************************************

			FEHLER

	  ***********************************************/
     
	  echo "<br><h3>Fehler</h3>";
	  echo '<a href="fehler/alleFehler">zeige alle Fehler</a>';
	  echo "<br>";	

      echo "<br><h3>L&ouml;sungen</h3>";
	 /* echo "Damit eine Ingredienz Teil eines Rezeptes werden kann,<br>";
	  echo "muss sie zuerst eine Speisekomponente werden.<br><br>";
   */

      echo '<a href="loesung/alleAnzeigen">zeigeAlleLoesungen</a>';
      echo "<br>";
	  echo '<a href="loesung/anlegen">Aufgabe l&ouml;sen</a>';
     
	  /*  echo '<a href="produkte/anlegen">Neues Produkt anlegen</a>';
      echo "<br>";
      echo "<br><h3>Nutzer</h3>";
      
      echo '<a href="nutzer/zeigeAlleNutzer">zeigeAlleNutzer</a>';
      echo "<br>";
      echo '<a href="nutzer/anlegen">neuen Nutzer anlegen</a>';
      echo "<br>";
      echo '<a href="nutzer/liesNutzerDatei">Nutzer importieren</a>';
      echo "<br>";
      echo "<br>";
       */
      echo '</div>';
      
      echo '<div class="spalte">';
      
	  echo "<h3>Projekt</h3>";
	  echo '<a href="projekt/zeigeAlleProjekte">zeige alle Projekte</a>';
      echo "<br>";
      echo "<br>";

      echo "<h3>Projektplanung</h3>";
      
      
	  echo '<a href="projektplanung/zeigeAlleProjektPlanungen">zeige alle ProjektPlanungen</a>';
      echo "<br>";
      
	  echo '<a href="projektplanung/anlegen">Lege an ProjektPlanung</a>';
      echo "<br>";
      

      echo '<a href="projekt/zeigeAlleProjekte">zeige alle Projekte</a>';
      echo "<br>";
 	  echo "<br>";


	  echo "<h3>Ideen</h3>";
      
      
	  echo '<a href="idee/zeigeAlleIdeen">zeige alle Ideen</a>';
      echo "<br>";
      
	  echo '<a href="idee/anlegen">Erfasse eine Idee</a>';
      echo "<br>";
      

     /* echo '<a href="projekt/zeigeAlleProjekte">zeige alle Projekte</a>';
      echo "<br>";*/


/*
      echo '<a href="rezept/anlegen">Rezept anlegen</a>';  
      echo "<br>";
	  / * echo '<a href="rezeptbestandteil/zeigeAlleRezepte">zeige alle Rezeptbestanteile</a>';
      echo "<br>";
      echo '<a href="rezeptbestandteil/anlegen">Rezeptbestanteil anlegen</a>';
      echo "<br>"; * /
      echo "<br>";   
     
      echo "<br><h3>Speiseplan</h3>";
      
      echo '<a href="speiseplan/anlegen" title="Die installierte Software auf dem PC des Nutzers">Speiseplan anlegen</a>';
      echo "<br>";
       echo '<a href="speiseplan/anzeigen">Speiseplan anzeigen</a>';
      echo "<br>";
     / * * / 
      echo "<br><h3>Bestellzettel</h3>";
      
      echo '<a href="bestellzettel/erstellen">Bestellzettel erstellen</a>';
      echo "<br>";
      echo '<a href="bestellzettel/anzeigen">Bestellzettel anzeigen</a>';
      echo "<br>";
      
      echo '</div>';
      echo '<div class="clear"></div>';
      */
	  echo '</div>';  
      echo '</div>'; 
      
      die();
      
	 /* INSERT INTO `liz_hersteller` (`hersteller_id`, `hersteller_name`, `hersteller_strasse`, `hersteller_hausnummer`, `hersteller_plz`, `hersteller_ort`, `hersteller_telefonnummer`, `hersteller_email`, `hersteller_website`) */
	 try 
     {
      
         $sql = "Select hersteller_id,hersteller_name from liz_hersteller where hersteller_aktiv=1";

          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $rueckgabe = $db->query($sql);
          
          $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
          
         // echo $ergebnis[0]['hersteller_name'];
         //  echo "<br>";
         
      
      
          echo "<table  style=\"background:darkgrey;padding:4px;border:1px;\"   cellpadding=\"6\" cellspacing=\"1\">"; 
          foreach ($ergebnis as  $inhalt)
          {
             $hersteller_id=$inhalt['hersteller_id'];
            
             echo "<tr><td style=\"background:lightgrey;a color:orange;width:550px;\" class=\"odd\">";
            
             echo "<a href=\"hersteller/produkte/".$hersteller_id."\">".$inhalt['hersteller_name']."</a>&nbsp;&nbsp;&nbsp;<small><small><em style=\"color:red;\">(<a href=\"hersteller/details/".$hersteller_id."\">bearbeiten</a>)</em></small></small><br>";
            // echo "<a href=\"../hersteller/produkte/".$hersteller_id."\">".$inhalt['hersteller_name']."</a>&nbsp;&nbsp;&nbsp;<small><em style=\"color:red;\">(<a href=\"../hersteller/details/".$hersteller_id."\">bearbeiten</a>)</em></small><br>";
         
             echo "</td></tr>"; 
           }
            
       }
       catch(PDOException $e){
          print $e->getMessage();
       }
       echo "</table>";
	   $db=null;
	 
	 
    /*  echo '<p>Test Datenbank:</p>';
              if ($db==true)
                 echo " Ok";
              else
                echo "nicht verbunden!";
     
     Hersteller:
      */
     






		# wenn keine Datenbank gewählt, dann gib erst alle
		# Datenbanken zur Auswahl aus
		// wenn aber dok ausgewählt ist dann kann $id nicht mehr leer sein.
		// stimmt es ist keine action definiert also ist die id die action
		// $id = $action;
		//$dat = $action;
		if (DEBUG) {
			echo "<br /><br />action= $action<br /><br />";
			echo "<br /><br />id= $id<br /><br />";
		}


		//$dat = $oDbName -> getAlleDatenbanken();
	//	echo '<h2>Alle Datenbanken</h2>'."\n";

	//	foreach ($dat as $data) {
//			echo '<span><a href="uebersicht/'.$data.'">'.$data.'</a></span><br />'."\n";
//		}

		include 'inc/footer.php';
	}

	
/*	if (DEBUG) {
		echo "<br/>ACTION ".$action;
		echo "<br/>ID ".$id;
	}
  */

