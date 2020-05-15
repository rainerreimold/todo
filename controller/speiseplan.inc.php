<?php

/****

Der Speiseplan soll eine Zusammenstellung der vorhandenen Rezepte erstellen.

Im Sinne einer ausgewogenen/abwechslungsreichen Ernährung sollte Mo-Fr 1-2 Mal Suppe und 1 Mal Fleisch eingehalten werden.
Dafür müssen natürlich ausreichend Rezepte vorhanden sein, was im Moment 13.04.20 noch nicht der Fall ist.


***/


session_start();


require_once './inc/global_config.inc.php';
$_SESSION['title'] = 'Speiseplan- Wochenplan';
$_SESSION['start'] = isset($_SESSION['start'])?$_SESSION['start']:false;


static $db;




function doAction( $action = '', $id = '', $von=0, $lim=0, $order='asc' ) {



	if (DEBUG) {
		echo "<br /><br />ID ".$id;
		echo "<br /><br />ACTION ".$action;
	}
	
	//$oDbName = new  DBInformation();

	//Aber die Übersicht ist doch nicht die action sondern der
	//controller.....
    
    // include 'inc/header.php';
	
    if ( $action == '') {
	

		$db = $id;
		if ($_SESSION['start']==false) {
    		$_SESSION['start']=true;
			echo "<h1>Lizenzen</h1>";
			echo "<h2>Ansatz?</h2>";

			die();
		}



		}

    /***

	*/


    else if ( $action == 'zeigeAlleSpeiseplaene') {
   include 'inc/header.php';
	        

       try {
		echo "HIER";
               //    SELECT domain_id, domain_name FROM `domain` WHERE 1
		$sql = "Select domain_id, domain_name from domain";

		if (DEBUG) echo "<br>".$sql."<br>";
       
	 
          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
          $rueckgabe = $db->query($sql);
          
		  $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
	        
	        
	        
	        echo "<table  style=\"background:#777;padding:4px;border:1px;\"   cellpadding=\"6\" cellspacing=\"1\">";
	        echo '<tr style="padding:8px;"><th colspan=3 style="font-family: Fira ;color:#ddd">Lizenzen f&uuml;r Clients</th></tr>';
	        echo "<tr  style=\"padding:8px;\"><td style=\"background:darkgrey;a color:orange;width:350px;\" class=\"odd\">

          </td>
           <td style=\"background:darkgrey;a color:orange;width:350px;\" class=\"odd\">Lizenz</td><td style=\"background:darkgrey;a color:orange;width:80px;\" class=\"odd\">Anzahl</td></tr>";
	        foreach ($ergebnis as  $inhalt)
	        {
	            $domain_id=$inhalt['domain_id'];
	            
	            echo "<tr style=\"border:1px dotted black;\"><td style=\"background:lightgrey;a color:orange;width:350px;padding:6px;\" class=\"odd\">";
	            
	            echo "<a href=\"../auspraegung/zeigeAlleEigenschaftenFuerDomain/$domain_id\">".$inhalt['domain_name']."</a>";
	            
	            
	 
           
                //&nbsp;&nbsp;&nbsp;<small><small><em style=\"color:red;\">(<a href=\"details/".$domain_id."\">bearbeiten</a>)</em></small></small>";
	            echo "</td><td style=\"background:lightgrey;a color:orange;width:50px;padding:6px;\" class=\"odd\"> ";
	            echo "<br></td></tr>";
	        }
	        
	    }
	    catch(PDOException $e){
	        print $e->getMessage();
	    }
	    echo "</table>";
	    $db=null;
	    
      
        echo "<br><a href=\"anlegen\">neuen Speiseplan anlegen</a><br>";

		if (DEBUG) {
			echo "<br /><br />action= $action<br /><br />";
			echo "<br /><br />id= $id<br /><br />";
		}




		include 'inc/footer.php';
	}
	
    else if ( $action == 'zeigeDomains') {
           include 'inc/header.php';
	
       try {
		echo "HIER";
               //    SELECT domain_id, domain_name FROM `domain` WHERE 1
		$sql = "Select domain_id, domain_name from domain";

		if (DEBUG) echo "<br>".$sql."<br>";
       
	 
          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
          $rueckgabe = $db->query($sql);
          
		  $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
	        
	        
	        
	        echo "<table  style=\"background:#777;padding:4px;border:1px;\"   cellpadding=\"6\" cellspacing=\"1\">";
	        echo '<tr style="padding:8px;"><th colspan=3 style="font-family: Fira ;color:#ddd">Lizenzen f&uuml;r Clients</th></tr>';
	        echo "<tr  style=\"padding:8px;\"><td style=\"background:darkgrey;a color:orange;width:350px;\" class=\"odd\">

          </td>
           <td style=\"background:darkgrey;a color:orange;width:350px;\" class=\"odd\">Lizenz</td><td style=\"background:darkgrey;a color:orange;width:80px;\" class=\"odd\">Anzahl</td></tr>";
	        foreach ($ergebnis as  $inhalt)
	        {
	            $domain_id=$inhalt['domain_id'];
	            
	            echo "<tr style=\"border:1px dotted black;\"><td style=\"background:lightgrey;a color:orange;width:350px;padding:6px;\" class=\"odd\">";
	            
	            echo "<a href=\"auspraegung/".$domain_id."\">".$inhalt['domain_name']."</a>";
	            
	            
	 
           
                //&nbsp;&nbsp;&nbsp;<small><small><em style=\"color:red;\">(<a href=\"details/".$domain_id."\">bearbeiten</a>)</em></small></small>";
	            echo "</td><td style=\"background:lightgrey;a color:orange;width:50px;padding:6px;\" class=\"odd\"> ";
	            echo "<br></td></tr>";
	        }
	        
	    }
	    catch(PDOException $e){
	        print $e->getMessage();
	    }
	    echo "</table>";
	    $db=null;
	    
      
      

		if (DEBUG) {
			echo "<br /><br />action= $action<br /><br />";
			echo "<br /><br />id= $id<br /><br />";
		}




		include 'inc/footer.php';
	}

    /****************************************
  
    Formular zum Erstellen eines Speiseplans
  
	*****************************************/
  	
    else if ( $action == 'anlegen') {
  	
       include 'inc/header.php';
	
	// Im Schritt 0 sollten wohl zunächst alle bereits exitierenden Wochenpläne angezeigt werden?
	
	 $Wochenplaene=getAlleWochenplaene();
	/*
     $i=0;
	 echo '<h1 style="background: red; color:white;
	             padding-left:120px;">Wochenplan</h1>';
     echo '<div class="form" style="width:750px; text-align:right; padding:10px; margin:10px auto auto auto;">';
 
	 echo '<table width=100%><tr><th> W O C H E N P L A N</th></tr>';	
	 echo '<tr><th>Bezeichnung</th><th>Beschreibung</th></tr>';
	
	 foreach ( $Wochenplaene as $Wochenplan) {

	 echo '<tr><td>';
	 echo $Wochenplan[$i]['rid'];
	 echo '</td></tr>';
	 $i++;
     }
*/





	// Im Schritt 1 müssen alle Rezepte angezeigt werden.

	// Ich glaube, dass die Auswahl über ein multiple Formular ungünstig ist.
	// Das Auslesen wäre lösbar, aber die Zuordnung zu den Wochentagen wäre schwierig.
	// Das ist zwar im ersten Moment für das Projekt und die Bestellzettel unwichtig, dennoch 
	// stellt die App Vorschläge, aber keine Vorschrift für die möglichen Speisenpläne der Woche dar.
	
		 echo '<h1 style="background: orange; color:black;
	             padding-left:120px;">Rezepte</h1>';
         echo '<div class="form" style="width:1150px; text-align:right; padding:10px; margin:10px auto auto auto;">

         <form method="post" action="eintragen" style="width:1100px; padding:10px; margin:10px;" class="artikelform">
           <fieldset style="background:#cfcfcf; width:1050px; text-align:center; padding:10px; margin-right:10px;">
           <legend>5 Rezepte ausw&auml;hlen</legend>';       
   
		     echo '<label>Wocehenplan: </label><input class="textform eyecatch" type="text" name="bezeichnung"  required /><br>';

			 echo "<br>Montag<br>";
	         $RezepteMo="\n<select class=\"auswahl eyecatch\" name=\"rezeptMo\" size=\"5\" >\n";
             $RezepteMo.=getAlleRezepte()."\n";
             $RezepteMo.="</select>\n";
			
  			 echo $RezepteMo;
						
			 echo "<br>Dienstag<br><br>";	
			 $RezepteDi="\n<select class=\"auswahl eyecatch\" name=\"rezeptDi\" size=\"5\" >\n";
             $RezepteDi.=getAlleRezepte()."\n";
             $RezepteDi.="</select>\n";
			
  			 echo $RezepteDi;
		
			 echo "<br>Mittwoch<br><br>";	
			 $RezepteMi="\n<select class=\"auswahl eyecatch\" name=\"rezeptMi\" size=\"5\" >\n";
             $RezepteMi.=getAlleRezepte()."\n";
             $RezepteMi.="</select>\n";
			
  			 echo $RezepteMi;
		
		     echo "<br>Donnerstag<br><br>";	
			 $RezepteDo="\n<select class=\"auswahl eyecatch\" name=\"rezeptDo\" size=\"5\" >\n";
             $RezepteDo.=getAlleRezepte()."\n";
             $RezepteDo.="</select>\n";
			
  			 echo $RezepteDo;
		
			 echo "<br>Freitag<br><br>";	
			 $RezepteFr="\n<select class=\"auswahl eyecatch\" name=\"rezeptFr\" size=\"5\" >\n";
             $RezepteFr.=getAlleRezepte()."\n";
             $RezepteFr.="</select>\n";
			
  			 echo $RezepteFr;
		
			 echo '<br><br>';
				// Wochenende
	
	/*		echo "<br>Dienstag<br>";	
			 $RezepteDi="\n<select class=\"auswahl eyecatch\" name=\"rezeptDi\" size=\"5\" >\n";
             $RezepteDi.=getAlleRezepte()."\n";
             $RezepteDi.="</select>\n";
			
  			 echo $RezepteDi;
		

			echo "<br>Dienstag<br>";	
			 $RezepteDi="\n<select class=\"auswahl eyecatch\" name=\"rezeptDi\" size=\"5\" >\n";
             $RezepteDi.=getAlleRezepte()."\n";
             $RezepteDi.="</select>\n";
			
  			 echo $RezepteDi;
		
*/

      echo "<br>Beschreibung:<br>";
	  echo "<textarea id='editor' name='editor'></textarea>";

	   echo ' </fieldset>';
	
       echo ' <fieldset style="background:#cfcfcf; text-align:right; padding:10px; margin-right:10px;">
              <button type="reset">Eingaben l&ouml;schen</button>
              <button type="submit">Absenden</button>
            </fieldset>
          </form>
       </div>
       <br>
       <br>
       <br>
       <br>';
	    echo '<script type="text/javascript">';
        echo "	CKEDITOR.replace('editor');";
        echo "</script>";

     include 'inc/footer.php';


	}


	/***************************************

	Das eigentliche Eintragen erfolgt erst hier

	****************************************/

	else if ( $action == 'eintragen') {

     $bezeichnung      = $_POST['bezeichnung'];
     $editor        = $_POST['editor'];

	 $rezeptMo        = $_POST['rezeptMo'];
	 $rezeptDi        = $_POST['rezeptDi'];
 	 $rezeptMi        = $_POST['rezeptMi'];
	 $rezeptDo        = $_POST['rezeptDo'];
	 $rezeptFr        = $_POST['rezeptFr'];
	 /*
	 $rezeptSa        = $_POST['rezeptSa'];
	 $rezeptSo        = $_POST['rezeptSo'];
     */



    
	/*   echo '<pre>';
		var_dump($_POST);
        print_r($_POST);
        echo  '</pre>';
 */ 
	 //echo $editor."<br><br>";
	 
          try {

                    
	      

          $sql = "replace into wochenplan set rezept_id_mo= '".$rezeptMo."',rezept_id_di= '".$rezeptDi."',rezept_id_mi= '".$rezeptMi."',
					rezept_id_do= '".$rezeptDo."',rezept_id_fr= '".$rezeptFr."',  bezeichnung='".$bezeichnung."', beschreibung = '".$editor."'";


          //print $sql."<br>";
	      $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $db->beginTransaction();
		  $db->query($sql);

		  $sql = "update wochenplan  set initial_id=wochenplan_id order by wochenplan_id desc Limit 1;";

		   $db->query($sql);


		  $db->commit();
  	
          $db=null;

          }
          catch(PDOException $e){
			  $db->rollBack();
              print "<br>".$e->getMessage();
          }


 		  // getArtikelInitialId	
           
          //die();
          
		   $_SESSION['Eintrag']	= $bezeichnung.' erfolgreich eingetragen';
          header('location:../uebersicht');



    }



}
	
