<?php




session_start();


require_once './inc/global_config.inc.php';
$_SESSION['title'] = 'Rezepte - Verwaltung von INgredenzien';
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
    
    include 'inc/header.php';
	
    if ( $action == '') {
	

		$db = $id;
		if ($_SESSION['start']==false) {
    		$_SESSION['start']=true;
			echo "<h1>Rezept</h1>";
			echo "<h2>Ansatz?</h2>";

			die();
		}



		}

    else if ( $action == 'zeigeAlleRezepte') {
        
       try {
		
               //   SELECT speisekomponente_id, sk.bezeichnung as skb,m.bezeichnung, m.einheit FROM `speisekomponente` sk, `menge` m WHERE m.menge_id=sk.menge_id order By sk.bezeichnung asc
		//$sql = "SELECT speisekomponente_id, sk.bezeichnung as skb, m.bezeichnung as mb, m.einheit as me FROM `speisekomponente` sk, `menge` m WHERE m.menge_id=sk.menge_id order By sk.bezeichnung asc";
		$sql = "SELECT rt.rezept_id as rid, rt.rezeptteil_id as rtid, rt.bezeichnung as rtb, rez.bezeichnung as rb FROM `rezeptteil` rt, rezept rez WHERE rt.rezept_id=rez.rezept_id group by rt.rezept_id";

		if (DEBUG) echo "<br>".$sql."<br>";
       
	 
          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
          $rueckgabe = $db->query($sql);
          
		  $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
	        
	        
	        
	        echo "<table  style=\"background:#777;padding:4px;border:1px;\"   cellpadding=\"6\" cellspacing=\"1\">";
	        echo '<tr style="padding:8px;"><th colspan=3 style="font-family: Fira ;color:#ddd">Speisekomponenten f&uuml;r Rezepte</th></tr>';
	        echo "<tr  style=\"padding:8px;\"><td style=\"background:darkgrey;a color:orange;width:350px;\" class=\"odd\">
            Rezept
            </td>
            <td style=\"background:darkgrey;a color:orange;width:350px;\" class=\"odd\">Rezeptbestandteil</td>
		    <td style=\"background:darkgrey;a color:orange;width:80px;\" class=\"odd\">   </td>
          </tr>";
	        foreach ($ergebnis as  $inhalt)
	        {
	            $rezeptteil_id=$inhalt['rtid'];
	             $rezept_id=$inhalt['rid'];
	            echo "<tr style=\"border:1px dotted black;\"><td style=\"background:lightgrey;a color:orange;width:350px;padding:6px;\" class=\"odd\">";
	            
	            echo "<a href=\"/details/$rezept_id\">".$inhalt['rb']."</a>";
	            
	 
           
                //&nbsp;&nbsp;&nbsp;<small><small><em style=\"color:red;\">(<a href=\"details/".$domain_id."\">bearbeiten</a>)</em></small></small>";
	            echo "</td><td style=\"background:lightgrey;a color:orange;width:50px;padding:6px;\" class=\"odd\"> ";
				echo "<a href=\"/details/$rezeptteil_id\">".$inhalt['rb']."</a>";
	            echo "<br></td>";
				echo "<td style=\"background:lightgrey;a color:orange;width:50px;padding:6px;\" class=\"odd\"> ";
			    echo  $inhalt['rtb'];
				echo "</td>";
				echo "</tr>";
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
	
    else if ( $action == 'details') {
        
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
  
    kleines Formular zum hinzufügen eines Rezept
  
	*****************************************/
  	
    else if ( $action == 'anlegen') {
  	
		 echo '<h1 style="background: orange;
	             padding-left:120px;">Rezept</h1>';
         echo '<div class="form" style="width:750px; text-align:right; padding:10px; margin:10px auto auto auto;">

         <form method="post" action="eintragen" style="width:700px; padding:10px; margin:10px;">
           <fieldset style="background:#cfcfcf; width:500px; text-align:right; padding:10px; margin-right:10px;">
           <legend>Rezept anlegen</legend>';       
             echo '<label>Rezept: </label><input class="textform eyecatch" type="text" name="rezept" placeholder="xxx.xx" required /><br>';
             echo '</fieldset>';
             echo "<br>\n";
			 echo "Was soll es f&uuml;r ein Rezept werden?<br>\n";
			 
			 //speiseKategorie
			 echo '<label>Suppe: </label><input type="radio" id="speisekategorie" name="speisekategorie" value="4"  onClick="ea_check(this)" /><br/>';
			 echo '<label>Dessert: </label><input type="radio" id="speisekategorie" name="speisekategorie" value="6" onClick="ea_check(this)" /><br/>';
			 echo '<label>Vorspeise: </label><input type="radio" id="speisekategorie" name="speisekategorie" value="5" onClick="ea_check(this)" /><br/>';
			 echo '<label>Hauptspeise: </label><input type="radio" id="speisekategorie" name="speisekategorie" value="1" checked="checked" onClick="ea_check(this)" /><br/>'; // 1 -3
			 echo '<label>kleine Speise: </label><input type="radio" id="speisekategorie" name="speisekategorie" value="7" onClick="ea_check(this)" /><br/>'; // 7 oder 8

	
/*** Vorlage aus der Produktauswahl der Lizenzanwendung

  
         echo '<fieldset id="gender">
         <legend>Client oder Server</legend>
         <label for="client"><input type="radio" id="client" name="client" value="client" checked="checked" onClick="ea_check(this)" /> Client </label>
         
         <label for="client"><input type="radio" id="client" name="client" value="server" onClick="ea_check(this)" /> Server </label>
         </fieldset>'
**/



/*
		    
			echo '<div id="visib1" >';
        
			 $SpeisekomponenteSelect="\n<select class=\"auswahl eyecatch\" name=\"speisekomponente\" size=\"10\" multiple>\n";
             $SpeisekomponenteSelect.=getSpeiseKomponenten()."\n";
             $SpeisekomponenteSelect.="</select>\n";
			
			 echo $SpeisekomponenteSelect;
*/
		   echo '<div class="aussen_box">';
		   echo '<div id="visib1" >';
		
        	 $HauptbeilageSelect="\n<select class=\"auswahl eyecatch\" name=\"hauptbeilage\" size=\"5\" multiple>\n";
             $HauptbeilageSelect.=getHauptBeilage()."\n";
             $HauptbeilageSelect.="</select>\n";
			
			 echo $HauptbeilageSelect;

			 $SaettigungsbeilageSelect="\n<select class=\"auswahl eyecatch\" name=\"saettigungsbeilage\" size=\"5\" multiple>\n";
             $SaettigungsbeilageSelect.=getSaettigungsBeilage()."\n";
             $SaettigungsbeilageSelect.="</select>\n";
			
			 echo $SaettigungsbeilageSelect;

			 $GemuesebeilageSelect="\n<select class=\"auswahl eyecatch\" name=\"gemuesebeilage\" size=\"5\" multiple>\n";
             $GemuesebeilageSelect.=getGemueseBeilage()."\n";
             $GemuesebeilageSelect.="</select>\n";
			
			 echo $GemuesebeilageSelect;





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

      // Ende visb1 für die EIngabe einer Hauptspeise mit 3 Komponenten (klassisch)
	  echo '</div>';

		// visib2 	  
		echo '<div id="visib2" >';
	
			echo 'Layer2';		

		// Ende visb 2
		echo '</div>';
		
		// visib3 	  
		echo '<div id="visib3" >';
	
			echo 'Layer3';
	
		// Ende visib3
		echo '</div>';

		// visib4 	  
		echo '<div id="visib4" >';
	
			echo 'Layer4';	
		// Ende visib4
		echo '</div>';

		// visib5 	  
		echo '<div id="visib5" >';
	
		
			echo 'Layer5';	
		// Ende visib5
		echo '</div>';
		// ENde des umfassenden Box Layers
		echo '</div>';





     include 'inc/footer.php';


	}


	/***************************************

	Das eigentliche Eintragen erfolgt erst hier

	****************************************/

	else if ( $action == 'eintragen') {

     
     $domain        = $_REQUEST['domain'];


          try {

                    
              
        //    $sql = "Replace INTO `liz_anzahl_lizenz` SET `anzahl_lizenz_gesamt` = '".$anzahl."', `anzahl_lizenz_produkt_id` = '".$produkt."', `anzahl_lizenz_verfuegbar` =  '".$anzahl."', `anzahl_lizenz_innutzung` =  0, `lizenz_id` =  '".$lizenz_id."',
        //     `eingetragen` = NOW(), `anzahl_lizenz_datum` = NOW();";
		
		  $sql = "replace into domain set domain_name = '".$domain."'";


          print $sql."<br>";

          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $db->query($sql);
          $db=null;

          }
          catch(PDOException $e){
              print "<br>".$e->getMessage();
          }



        
          //die();
          

          header('location:../uebersicht');



    }



}
	
