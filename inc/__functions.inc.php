<?php




function getAktuellGenutzteLizenzen($id){
    
    try {
        
        /* an dieser Stelle wird nur die Anzahl an Lizenzarten eines Produktes bestimmt */
        
        /* Das gefällt mir noch nicht wirklich, weil hier lediglich ein Produkt eines Herstellers gezählt wird.
         * Was wir benötigen ist eine Übersicht der gesamten Lizenzen, aller Produkte und aller Hersteller.
         * Es wird daher auf eine solche Funktion zurückgegriffen werden.
         *
         */
        
        $sql = "Select tagesaktuelle_lizenzauswertung_innutzung from  liz_tagesaktuelle_lizenzauswertung where tagesaktuelle_lizenzauswertung_produkt_id=".$id;
        
        $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
        $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $rueckgabe = $db->query($sql);
        
        $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
        
        //echo
        //echo "<br>";
        $db=null;
        
        
        return $ergebnis[0]['tagesaktuelle_lizenzauswertung_innutzung'];
        
    }
    
    catch(PDOException $e){
        print $e->getMessage();
    }
    return -1;
    
    
}



function getGesamtLizenzen($id) {
try {
    
    /* an dieser Stelle wird nur die Anzahl an Lizenzarten eines Produktes bestimmt */
    
    /* Das gefällt mir noch nicht wirklich, weil hier lediglich ein Produkt eines Herstellers gezählt wird.
     * Was wir benötigen ist eine Übersicht der gesamten Lizenzen, aller Produkte und aller Hersteller.
     * Es wird daher auf eine solche Funktion zurückgegriffen werden.
     *
     */
    
    $sql = "Select tagesaktuelle_lizenzauswertung_gesamt from  liz_tagesaktuelle_lizenzauswertung where tagesaktuelle_lizenzauswertung_produkt_id=".$id;
    
    $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
    $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $rueckgabe = $db->query($sql);
    
    $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
    
    //echo
    //echo "<br>";
    $db=null;
    
    
    return $ergebnis[0]['tagesaktuelle_lizenzauswertung_gesamt'];
    
}

catch(PDOException $e){
    print $e->getMessage();
}
return -1;


}




function getTagesAktuelleLizenzAuswertungParentId($id){
    
    try {
        
        /* an dieser Stelle wird nur die Anzahl an Lizenzarten eines Produktes bestimmt */
        
        /* Das gefällt mir noch nicht wirklich, weil hier lediglich ein Produkt eines Herstellers gezählt wird.
         * Was wir benötigen ist eine Übersicht der gesamten Lizenzen, aller Produkte und aller Hersteller.
         * Es wird daher auf eine solche Funktion zurückgegriffen werden.
         *
         */
        
        $sql = "Select Max(tagesaktuelle_lizenzauswertung_id) from  liz_tagesaktuelle_lizenzauswertung where tagesaktuelle_lizenzauswertung_produkt_id=".$id;
        
        $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
        $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $rueckgabe = $db->query($sql);
        
        $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
        
        //echo
        //echo "<br>";
        $db=null;
        
        
        return $ergebnis[0]['Max(tagesaktuelle_lizenzauswertung_id)'];
        
    }
    
    catch(PDOException $e){
        print $e->getMessage();
    }
    return -1;
    
    
}


function getTagesAktuelleLizenzAuswertungInitialId($id){
    
    try {
        
        /* an dieser Stelle wird nur die Anzahl an Lizenzarten eines Produktes bestimmt */
        
        /* Das gefällt mir noch nicht wirklich, weil hier lediglich ein Produkt eines Herstellers gezählt wird.
         * Was wir benötigen ist eine Übersicht der gesamten Lizenzen, aller Produkte und aller Hersteller.
         * Es wird daher auf eine solche Funktion zurückgegriffen werden.
         *
         */
        
        $sql = "Select tagesaktuelle_lizenzauswertung_lizenz_initial_id from  liz_tagesaktuelle_lizenzauswertung where tagesaktuelle_lizenzauswertung_produkt_id=".$id;
        
        $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
        $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $rueckgabe = $db->query($sql);
        
        $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
        
        //echo
        //echo "<br>";
        $db=null;
        
        
        return $ergebnis[0]['tagesaktuelle_lizenzauswertung_lizenz_initial_id'];
        
    }
    
    catch(PDOException $e){
        print $e->getMessage();
    }
    return -1;
    
    
}


   
    
    
    
function getTagesAktuelleLizenzAuswertungLastId() {
        
        
        
        /* INSERT INTO `liz_hersteller` (`hersteller_id`, `hersteller_name`, `hersteller_strasse`, `hersteller_hausnummer`, `hersteller_plz`, `hersteller_ort`, `hersteller_telefonnummer`, `hersteller_email`, `hersteller_website`) */
        try {
            
            /* an dieser Stelle wird nur die Anzahl an Lizenzarten eines Produktes bestimmt */
            
            /* Das gefï¿½llt mir noch nicht wirklich, weil hier lediglich ein Produkt eines Herstellers gezï¿½hlt wird.
             * Was wir benï¿½tigen ist eine ï¿½bersicht der gesamten Lizenzen, aller Produkte und aller Hersteller.
             * Es wird daher auf eine solche Funktion zurï¿½ckgegriffen werden.
             *
             */
            
            $sql = "Select MAX(tagesaktuelle_lizenzauswertung_id) from  liz_tagesaktuelle_lizenzauswertung";
            
           // echo "<br>".$sql."<br>";
            
            
            $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
            $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $rueckgabe = $db->query($sql);
            
            $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
            
            
            //echo "<br>";
            $db=null;
            
            
            $erg = $ergebnis[0]['MAX(tagesaktuelle_lizenzauswertung_id)'];
           // echo "<br>".$erg."<br>";
            
            return $erg;
        }
        
        catch(PDOException $e){
            print $e->getMessage();
        }
        return -1;
        
        
    }
    
    function setTagesAktuelleLizenzAuswertungInitialId() {
        
        
        
        $LastAnzahlId = getTagesAktuelleLizenzAuswertungLastId();
        
        //echo "<br>".$LastAnzahlId."<br>";
        
        /* INSERT INTO `liz_hersteller` (`hersteller_id`, `hersteller_name`, `hersteller_strasse`, `hersteller_hausnummer`, `hersteller_plz`, `hersteller_ort`, `hersteller_telefonnummer`, `hersteller_email`, `hersteller_website`) */
        try {
            
            /* an dieser Stelle wird nur die Anzahl an Lizenzarten eines Produktes bestimmt */
            
            /* Das gefï¿½llt mir noch nicht wirklich, weil hier lediglich ein Produkt eines Herstellers gezï¿½hlt wird.
             * Was wir benï¿½tigen ist eine ï¿½bersicht der gesamten Lizenzen, aller Produkte und aller Hersteller.
             * Es wird daher auf eine solche Funktion zurï¿½ckgegriffen werden.
             *
             */
            
            $sql = "update liz_tagesaktuelle_lizenzauswertung set tagesaktuelle_lizenzauswertung_lizenz_initial_id=".$LastAnzahlId." where tagesaktuelle_lizenzauswertung_id=".$LastAnzahlId.";";
        
           // echo "<br>".$sql."<br>";
            
            
            $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
            
            $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->query($sql);
            
            
            
        }
        
        catch(PDOException $e){
            print $e->getMessage();
            //die();
        }
        return -1;
        
    }
    
    






function getNutzerName($id){
   
    try {
        
        /* an dieser Stelle wird nur die Anzahl an Lizenzarten eines Produktes bestimmt */
        
        /* Das gefällt mir noch nicht wirklich, weil hier lediglich ein Produkt eines Herstellers gezählt wird.
         * Was wir benötigen ist eine Übersicht der gesamten Lizenzen, aller Produkte und aller Hersteller.
         * Es wird daher auf eine solche Funktion zurückgegriffen werden.
         *
         */
        
        $sql = "Select ad_nutzer_name_vorname from  liz_adnutzer where adnutzer_id=".$id; 
        
        $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
        $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $rueckgabe = $db->query($sql);
        
        $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
        
        //echo
        //echo "<br>";
        $db=null;
        
        
        return $ergebnis[0]['ad_nutzer_name_vorname'];
        
    }
    
    catch(PDOException $e){
        print $e->getMessage();
    }
    return -1;
    
    
}

function getCountProduktLizenz($id) {
    


	 /* INSERT INTO `liz_hersteller` (`hersteller_id`, `hersteller_name`, `hersteller_strasse`, `hersteller_hausnummer`, `hersteller_plz`, `hersteller_ort`, `hersteller_telefonnummer`, `hersteller_email`, `hersteller_website`) */
	 try {

         /* an dieser Stelle wird nur die Anzahl an Lizenzarten eines Produktes bestimmt */

         /* Das gefällt mir noch nicht wirklich, weil hier lediglich ein Produkt eines Herstellers gezählt wird.
          * Was wir benötigen ist eine Übersicht der gesamten Lizenzen, aller Produkte und aller Hersteller.
          * Es wird daher auf eine solche Funktion zurückgegriffen werden.
          *
          */

          $sql = "Select Count(*) from liz_lizenz where produkt_id=".$id;

          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $rueckgabe = $db->query($sql);

          $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);

          echo 
          //echo "<br>";
          $db=null;
               
          
          return $ergebnis[0]['Count(*)'];

       }
       
       catch(PDOException $e){
              print $e->getMessage();
       }
       return -1;

 
          /*
          die('ENDE !');





          echo "<table border=\"1\">";
          foreach ($ergebnis as  $inhalt)
          {
            echo "<tr><td class=\"odd\">";
             echo "<a href=\"../lizenzen/".$inhalt['hersteller_id']."\">".$inhalt['hersteller_name']."</a><br>";
            echo "</td></tr>";
              }

          }
          catch(PDOException $e){
              print $e->getMessage();
          }
          echo "</table>";
	     $db=null;
         */

 }
 
 
function  getAlleProdukte() {
    
 
    try {

         $sql = "Select produkt_id, produkt_bezeichnung, produkt_beschreibung, produkt_version from liz_produkt";

         $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
         $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

         $rueckgabe = $db->query($sql);

         $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);



        // Darstellung nur, wenn ein Ergebnis vorhanden ist

        if ($ergebnis){

             $ret="";
             foreach ($ergebnis as  $inhalt)
              {
                $ret=$ret."<option value=\"".$inhalt['produkt_id']."\">".$inhalt['produkt_bezeichnung']." - ".$inhalt['produkt_beschreibung']." ".$inhalt['produkt_version']."</option>\n";
               
              }
              return $ret;
              }
            $db=null;

         }


            catch(PDOException $e){
              print $e->getMessage();
            }
            
    return -1;           

} 


function  getAlleLizenzArten() {


    try {

         $sql = "Select lizenzart_id, lizenzart_bezeichnung, lizenzart_beschreibung, lizenzart_version from liz_lizenzart";

         $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
         $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

         $rueckgabe = $db->query($sql);

         $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);



        // Darstellung nur, wenn ein Ergebnis vorhanden ist

        if ($ergebnis){

             $ret="";
             foreach ($ergebnis as  $inhalt)
              {
                $ret=$ret."<option value=\"".$inhalt['lizenzart_id']."\">".$inhalt['lizenzart_bezeichnung']." - ".$inhalt['lizenzart_beschreibung']."</option>\n";

              }
              return $ret;
              }
            $db=null;

         }


            catch(PDOException $e){
              print $e->getMessage();
            }

    return -1;

}

 



function getLastLizenzId() {



	 /* INSERT INTO `liz_hersteller` (`hersteller_id`, `hersteller_name`, `hersteller_strasse`, `hersteller_hausnummer`, `hersteller_plz`, `hersteller_ort`, `hersteller_telefonnummer`, `hersteller_email`, `hersteller_website`) */
	 try {

         /* an dieser Stelle wird nur die Anzahl an Lizenzarten eines Produktes bestimmt */

         /* Das gefällt mir noch nicht wirklich, weil hier lediglich ein Produkt eines Herstellers gezählt wird.
          * Was wir benötigen ist eine Übersicht der gesamten Lizenzen, aller Produkte und aller Hersteller.
          * Es wird daher auf eine solche Funktion zurückgegriffen werden.
          *
          */

          $sql = "Select MAX(lizenz_id) from liz_lizenz";

          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $rueckgabe = $db->query($sql);

          $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);

          echo
          //echo "<br>";
          $db=null;


          return $ergebnis[0]['MAX(lizenz_id)'];

       }

       catch(PDOException $e){
              print $e->getMessage();
       }
       return -1;


 }
 
 
 function getLastAnzahlLizenzId() {



	 /* INSERT INTO `liz_hersteller` (`hersteller_id`, `hersteller_name`, `hersteller_strasse`, `hersteller_hausnummer`, `hersteller_plz`, `hersteller_ort`, `hersteller_telefonnummer`, `hersteller_email`, `hersteller_website`) */
	 try {

         /* an dieser Stelle wird nur die Anzahl an Lizenzarten eines Produktes bestimmt */

         /* Das gefällt mir noch nicht wirklich, weil hier lediglich ein Produkt eines Herstellers gezählt wird.
          * Was wir benötigen ist eine Übersicht der gesamten Lizenzen, aller Produkte und aller Hersteller.
          * Es wird daher auf eine solche Funktion zurückgegriffen werden.
          *
          */

          $sql = "Select MAX(anzahl_lizenz_id) from liz_anzahl_lizenz";

          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $rueckgabe = $db->query($sql);

          $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);

          echo
          //echo "<br>";
          $db=null;


          return $ergebnis[0]['MAX(anzahl_lizenz_id)'];

       }

       catch(PDOException $e){
              print $e->getMessage();
       }
       return -1;


 }

 function SetAnzahlLizenz_InitialId() {



     $LastAnzahlLizenzId = getLastAnzahlLizenzId();

	 /* INSERT INTO `liz_hersteller` (`hersteller_id`, `hersteller_name`, `hersteller_strasse`, `hersteller_hausnummer`, `hersteller_plz`, `hersteller_ort`, `hersteller_telefonnummer`, `hersteller_email`, `hersteller_website`) */
	 try {

         /* an dieser Stelle wird nur die Anzahl an Lizenzarten eines Produktes bestimmt */

         /* Das gefällt mir noch nicht wirklich, weil hier lediglich ein Produkt eines Herstellers gezählt wird.
          * Was wir benötigen ist eine Übersicht der gesamten Lizenzen, aller Produkte und aller Hersteller.
          * Es wird daher auf eine solche Funktion zurückgegriffen werden.
          *
          */

          $sql = "update liz_anzahl_lizenz set anzahl_lizenz_initial_id=".$LastAnzahlLizenzId." where anzahl_lizenz_id=".$LastAnzahlLizenzId.";";

          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );

          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $db->query($sql);



       }

       catch(PDOException $e){
              print $e->getMessage();
              //die();
       }
       return -1;

  }





 
 function getStringAsUTF8($string) {
 
    if(mb_detect_encoding($string) != 'UTF-8') {          $string = utf8_encode($string); }
    return $string; 
 }
 
 
 
 function getUmlauteArray() { 
 
    return array( 'Ã¼'=>'ü', 'Ã¤'=>'ä', 'Ã¶'=>'ö', 'Ã–'=>'Ö', 'ÃŸ'=>'ß', 'Ã '=>'à', 'Ã¡'=>'á', 'Ã¢'=>'â', 'Ã£'=>'ã', 'Ã¹'=>'ù', 'Ãº'=>'ú', 'Ã»'=>'û', 
                  'Ã™'=>'Ù', 'Ãš'=>'Ú', 'Ã›'=>'Û', 'Ãœ'=>'Ü', 'Ã²'=>'ò', 'Ã³'=>'ó', 'Ã´'=>'ô', 'Ã¨'=>'è', 'Ã©'=>'é', 'Ãª'=>'ê', 'Ã«'=>'ë', 'Ã€'=>'À',
                  'Ã�'=>'Á', 'Ã‚'=>'Â', 'Ãƒ'=>'Ã', 'Ã„'=>'Ä', 'Ã…'=>'Å', 'Ã‡'=>'Ç', 'Ãˆ'=>'È', 'Ã‰'=>'É', 'ÃŠ'=>'Ê', 'Ã‹'=>'Ë', 'ÃŒ'=>'Ì', 'Ã�'=>'Í', 
                  'ÃŽ'=>'Î', 'Ã�'=>'Ï', 'Ã‘'=>'Ñ', 'Ã’'=>'Ò', 'Ã“'=>'Ó', 'Ã”'=>'Ô', 'Ã•'=>'Õ', 'Ã˜'=>'Ø', 'Ã¥'=>'å', 'Ã¦'=>'æ', 'Ã§'=>'ç', 'Ã¬'=>'ì', 
                  'Ã­'=>'í', 'Ã®'=>'î', 'Ã¯'=>'ï', 'Ã°'=>'ð', 'Ã±'=>'ñ', 'Ãµ'=>'õ', 'Ã¸'=>'ø', 'Ã½'=>'ý', 'Ã¿'=>'ÿ', 'â‚¬'=>'€' );
 
 }
    
    
function fixeUmlauteDb() {                  
  
   $umlaute = $this->getUmlauteArray();                  
   foreach ($umlaute as $key => $value){                                        
   
     $sql = "UPDATE table SET tracks = REPLACE(row, '{$key}', '{$value}') WHERE row LIKE '%{$key}%'";                   
   } 
 }
 

?>