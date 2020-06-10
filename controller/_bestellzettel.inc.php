<?php




session_start();


require_once './inc/global_config.inc.php';
$_SESSION['title'] = 'Rezepte - Bestellzentteln';
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
			echo "<h1>Ingredenzien</h1>";
			echo "<h2>Ansatz?</h2>";

			die();
		}



	}

    else if ( $action == 'zeigeAlleBestellzettel') {
      
	 	include 'inc/header.php';
	
  
       	try {
		
        	$sql = "SELECT speisekomponente_id, sk.bezeichnung as skb, m.bezeichnung as mb, m.einheit as me, z.zubereitungsart_bezeichnung as zb FROM `speisekomponente` sk, `menge` m, zubereitungsart z WHERE m.menge_id=sk.menge_id and z.zubereitungsart_id= sk.zubereitungsart_id order By sk.bezeichnung asc";

		if (DEBUG) echo "<br>".$sql."<br>";
       
	 
          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
          $rueckgabe = $db->query($sql);
          
		  $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
	        
	        
	        
	        echo "<table  style=\"background:#777;padding:4px;border:1px;\"   cellpadding=\"6\" cellspacing=\"1\">";
	        echo '<tr style="padding:8px;"><th colspan=3 style="font-family: Fira ;color:#ddd">Speisekomponenten f&uuml;r Rezepte</th></tr>';
	        echo "<tr  style=\"padding:8px;\"><td style=\"background:darkgrey;a color:orange;width:350px;\" class=\"odd\">
            Bezeichnung
            </td>
            <td style=\"background:darkgrey;a color:orange;width:350px;\" class=\"odd\">Beschreibung</td>
		    <td style=\"background:darkgrey;a color:orange;width:80px;\" class=\"odd\">Zubereitungsart</td>
          </tr>";
	        foreach ($ergebnis as  $inhalt)
	        {
	            $speisekomponente_id=$inhalt['speisekomponente_id'];
	            
	            echo "<tr style=\"border:1px dotted black;\"><td style=\"background:lightgrey;a color:orange;width:350px;padding:6px;\" class=\"odd\">";
	            
	            echo "<a href=\"/details/$speisekomponente_id\">".$inhalt['skb']."</a>";
	            
	 
           
                //&nbsp;&nbsp;&nbsp;<small><small><em style=\"color:red;\">(<a href=\"details/".$domain_id."\">bearbeiten</a>)</em></small></small>";
	            echo "</td><td style=\"background:lightgrey;a color:orange;width:50px;padding:6px;\" class=\"odd\"> ";
				echo "<a href=\"/details/$speisekomponente_id\">".$inhalt['mb']." ".$inhalt['me']."</a>";
	            echo "<br></td>";
				echo "<td style=\"background:lightgrey;a color:orange;width:50px;padding:6px;\" class=\"odd\"> ";
			    echo  $inhalt['zb'];
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
	
    
	/**************************************** 
		29.04.2020	
		zu überarbeiten 


	*****************************************/

	else if ( $action == 'details') {
       

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
  
    kleines Formular zum hinzufügen der Bestellzetteln
  
	*****************************************/
  	
   else if($action == 'erstellen') {

   /**********
	30.04.2020
    Ein Bestellzettel enthält die Ingredenzien der Rezepte für eine Woche.

	Der Vorgang muss daher theoretisch nur einmal für jede KW durchgeführt werden.
	Zu unterscheiden ist daher, ob ein Bestellzettel für eine Kalenderwoche schon erstellt wurde (also existiert)
	oder noch zu erstellen ist. - Einleitend ist von diesem Fall auszugehen!

    Schritt 1 auslesen aller Ingredenzien mit Mengen und Einheiten, die Ingredienz_id wird für den Bestellzetteleintrag benötigt. 
		Das SQL Statement wird ein wenig komplexer.

   *****/   



 try {


$sql = 'SELECT i.ingredienz_id as iid, i.bezeichnung as ibez, m.bezeichnung as mb,  m.einheit as me 
FROM 
ingredienz i,
`speisekomponente` sk, 
`menge` m, 
`rezeptteil` rt, 
rezept rez, 
wochenplan wp
WHERE 
( m.menge_id=sk.menge_id 
and i.ingredienz_id = sk.ingredienz_id
and rt.speisekomponente_id=sk.speisekomponente_id
and rt.rezept_id=rez.rezept_id
and rt.aktiv=1
and wp.rezept_id_mo=rez.rezept_id
and wp.wochenplan_id=1)
or 
( m.menge_id=sk.menge_id 
and i.ingredienz_id = sk.ingredienz_id
and rt.speisekomponente_id=sk.speisekomponente_id
and rt.rezept_id=rez.rezept_id
and rt.aktiv=1
and wp.rezept_id_di=rez.rezept_id
and wp.wochenplan_id=1)
or 
( m.menge_id=sk.menge_id 
and i.ingredienz_id = sk.ingredienz_id
and rt.speisekomponente_id=sk.speisekomponente_id
and rt.rezept_id=rez.rezept_id
and rt.aktiv=1
and wp.rezept_id_mi=rez.rezept_id
and wp.wochenplan_id=1)
or 
( m.menge_id=sk.menge_id 
and i.ingredienz_id = sk.ingredienz_id
and rt.speisekomponente_id=sk.speisekomponente_id
and rt.rezept_id=rez.rezept_id
and rt.aktiv=1
and wp.rezept_id_do=rez.rezept_id
and wp.wochenplan_id=1)
or 
( m.menge_id=sk.menge_id 
and i.ingredienz_id = sk.ingredienz_id
and rt.speisekomponente_id=sk.speisekomponente_id
and rt.rezept_id=rez.rezept_id
and rt.aktiv=1
and wp.rezept_id_fr=rez.rezept_id
and wp.wochenplan_id=1)
order By i.bezeichnung asc;';


       
		  

          //print $sql."<br>";

          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		  
		  $rueckgabe = $db->query($sql);
          
		  $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);

		  $arr = array();
		  
 	      foreach ($ergebnis as  $inhalt)
	        {
	           // print "<br>".$inhalt['iid']."<br>";			    
	           // $arr[] = $inhalt['iid'];

			   // prüfe ob die ID bereits Teil des Array ist					
			   // falls nicht, dann	
			   // füge die ID in das Array

			   
/***********



		$found = array();
        foreach ($ergebnis as $key=>$val) {
            // Abfrage, ob Wert $val bereits mindestens ein Mal gefunden wurde
            if (isset($found[$val])) {
                // falls ja wird der Wert aus dem Array entfernt
               // unset($arr[$key]);
			} else {
				set($arr[$key]);
            }
            $found[$val] = true;
        }
       
       print_r($arr);


***********/	


			//}
		//	print_r($arr);
		//	$arr = array_unique($arr);
		//	print_r($arr);
	
	//		die();

				/***********************************************
		
				// Festlegung ... muss später angepasst werden 01.05.2020 
	
				/********************************************* */
				$bestellzettel_id=1;


				echo "<tr style=\"border:1px dotted black;\"><td style=\"background:lightgrey;a color:orange;width:350px;padding:6px;\" class=\"odd\">";
	            
	            echo "<a href=\"auspraegung/".$inhalt['iid']."\">".$inhalt['mb']." ".$inhalt['me']." - ".$inhalt['ibez']."</a>";
	            
				echo "<br>";
				$sql_bestellzettelEintragExist = bestellzettelEintragExist($bestellzettel_id, $inhalt['iid']);
		
				 $db->beginTransaction();
		  

				if(!$sql_bestellzettelEintragExist) {

					$sqlinsert="replace into bestellzetteleintrag set bestellzettel_id=".$bestellzettel_id.", ingredienz_id=".$inhalt['iid'].",	ingredienzname='".$inhalt['ibez']."',	menge=".$inhalt['mb'].",	einheit='".$inhalt['me']."'";	  
					print $sqlinsert;
					print "<br>";
					$db->query($sqlinsert);
					$sqlinitial="update bestellzetteleintrag set initial_id = bestellzetteleintrag_id order by bestellzetteleintrag_id desc limit 1";		
					$db->query($sqlinitial);
					
          			print $sqlinitial;
					print "<br>";
          			
	}
				else {
					
					$sqlinsert="update bestellzetteleintrag set menge=menge+".$inhalt['mb']." where bestellzetteleintrag_id=".$sql_bestellzettelEintragExist;
					$db->query($sqlinsert);	
					//print $sqlinsert;
          			//print "<br>";
				}
				$db->commit();
			    print $sqlinsert;
          
	 
           
                //&nbsp;&nbsp;&nbsp;<small><small><em style=\"color:red;\">(<a href=\"details/".$domain_id."\">bearbeiten</a>)</em></small></small>";
	            echo "</td><td style=\"background:lightgrey;a color:orange;width:50px;padding:6px;\" class=\"odd\"> ";
	            echo "<br></td></tr>";
	        }
	




		  $db=null;


          }
          catch(PDOException $e){
			  $db->rollBack();
              print "<br>".$e->getMessage();
          }

		// das Rezept existiert nicht (if)
       //  }
	//	else {
 	//		echo "Das Rezept existiert schon!";
	//	}











  }


/***

		  $sql = "update rezeptteil set initial_id=rezeptteil_id order by rezeptteil_id desc Limit 1;";          
          $db->query($sql);		  

		  $sql = "replace into rezeptteil set speisekomponente_id = '".$saettigungsbeilage."', rezept_id = '".$rezept_id."', bezeichnung = '". $bez_saettigungsbeilage."' ";
		  $db->query($sql);
		  $sql = "update rezeptteil  set initial_id=rezeptteil_id order by rezeptteil_id desc Limit 1;";          
          $db->query($sql);		  
          

		  $sql = "replace into rezeptteil set speisekomponente_id = '".$gemuesebeilage."', rezept_id = '".$rezept_id."' , bezeichnung = '". $bez_gemuesebeilage."'";
		  $db->query($sql);
		  $sql = "update rezeptteil  set initial_id=rezeptteil_id order by rezeptteil_id desc Limit 1;";          
          $db->query($sql);		  
          

***/



	

    else if ( $action == 'anlegen') {

	
       include 'inc/header.php';

  	
		 echo '<h1 style="background: green; color: orange;
	             padding-left:120px;">Speisekomponente</h1>';


		 echo '<div class="eyecatch block">Hier soll ein Bestellzettel aus dem Wochenplan erstellt werden.</div>'; 

         
   
         echo '<div class="form" style="width:750px; text-align:right; padding:10px; margin:10px auto auto auto;">';

	    

  		 echo "<form method=\"post\" action=\"eintragen\" style=\"width:700px; padding:10px; margin:10px;\">";
         
         echo "<fieldset style=\"background:#cfcfcf; width:900px; text-align:right; padding:10px; margin-right:10px;\">";
         echo "<legend>Speisekomponente anlegen</legend>"; 

		 echo '<div class="table">';
         echo '<div class="spalte">';

		 // getIngredenzien()
		 echo '<h2>Ingredienz</h2>';	
		 $IngredienzSelect="\n<select class=\"produktform\" name=\"ingredienz\" size=\"20\" multiple>\n";
         $IngredienzSelect.=getIngredienz()."\n";
         $IngredienzSelect.="</select>\n";
			
		 echo $IngredienzSelect;
		    echo '</div>';
      
          echo '<div class="spalte">';
   	  // Zubereitungsart

		  echo '<h2>Zubereitungsart</h2>';
		  $ZubereitungsartSelect="\n<select class=\"produktform2\" name=\"zubereitungsart\" size=\"5\" multiple>\n";
          $ZubereitungsartSelect.=getZubereitungsart()."\n";
          $ZubereitungsartSelect.="</select>\n";
			
		  echo $ZubereitungsartSelect;
		  echo "<br>";
      
		 	// getMengen()
         
		  echo '<h2>Menge</h2>';
 		  $MengenSelect="\n<select class=\"produktform2\" name=\"mengen\" size=\"7\" multiple>\n";
          $MengenSelect.=getMengen()."\n";
          $MengenSelect.="</select>\n";
			
		  echo $MengenSelect;
		  echo "<br><br>";

		  
    


	

		  // Speisekategorie
		  echo '<h2>Speisekategorie</h2>';
		  $SpeisekategorieSelect="\n<select class=\"produktform2\" name=\"speisekategorie\" size=\"3\" multiple>\n";
          $SpeisekategorieSelect.=getSpeisekategorie()."\n";
          $SpeisekategorieSelect.="</select>\n";
			
		  echo $SpeisekategorieSelect;
		  echo "<br><br>";

		  // evtl Garnitur	

		     echo '</div>';
      echo '<div class="clear"></div>';
      echo '</div>';  
      echo '</div>'; 

		echo '<label>Bezeichnung: </label><input class="textform eyecatch" type="text" name="bezeichnung" placeholder="!" required /><br>';
              
         echo '<label>Beschreibung: </label>'."<br>";
	     echo "<textarea id='editor' name='editor'></textarea>";
  	

         echo "</fieldset>";
         echo "<br>\n";
                echo "<fieldset style=\"background:#cfcfcf; text-align:right; padding:10px; margin-right:10px;\">
              <button type=\"reset\">Eingaben l&ouml;schen</button>
              <button type=\"submit\">Absenden</button>
            </fieldset>
          </form>
       </div>
       <br>
       <br>
       <br>
       <br>";
 	 
       echo '<script type="text/javascript">';
   	   echo "	CKEDITOR.replace('editor');
       </script>";
	 
     include "inc/footer.php";


	}


	/***************************************

	Das eigentliche Eintragen erfolgt erst hier

		28.04.2020
		Da wir feststellen mussten, dass das Weiterleiten auf die Übersichtsseite über php nicht funktioniert,
		da bereits JavaScript ausgegeben wurde, versuchte ich zunächst über die WindowsHistory Javascript Funktion
		zu gehen, aber das will auch nicht richt.
		
		Es sollte doch aber möglich sein, einen anderen Header einzubinden?	

	****************************************/

	else if ( $action == 'eintragen') {

     
    // $speisekomponente        = $_REQUEST['speisekomponente'];
     $speisekategorie		  = $_REQUEST['speisekategorie'];
	 $ingredienz			  = $_REQUEST['ingredienz'];
	 $mengen				  = $_REQUEST['mengen'];
	 $zubereitungsart		  = $_REQUEST['zubereitungsart'];
	  									   
	 $bezeichnung		  	  = $_REQUEST['bezeichnung'];
	 $beschreibung		  	  = $_REQUEST['editor'];						

          try {

                    
         /* 
         INSERT INTO `speisekomponente` (`speisekomponente_id`, `initial_id`, `parent_id`, `menge_id`, `ingredienz_id`, `bezeichnung`, `beschreibung`, `eingetragen`, `zubereitungsart_id`, `speisekategorie_id`, `aktiv`, `loeschbar`) VALUES (NULL, '0', '0', '24', '15', 'Omelette', 'Das Omelette als kleine Speise', CURRENT_TIMESTAMP, '1', '8', '1', '0');

    	 */
	
		  $sql = "replace into speisekomponente 
            set menge_id 			= '".$mengen."',
				ingredienz_id 		= '".$ingredienz."',
				bezeichnung 		= '".$bezeichnung."',
				beschreibung 		= '".$beschreibung."',
				zubereitungsart_id 	= '".$zubereitungsart."',
				speisekategorie_id 	= '".$speisekategorie."' 


			";


          //print $sql."<br>";

		  //die();
		
          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $db->query($sql);
          $db=null;

          }
          catch(PDOException $e){
              print "<br>".$e->getMessage();
          }



        
          //die();
          
		   $_SESSION['Eintrag']	= $bezeichnung.' erfolgreich eingetragen';
          header('location:../uebersicht');



    }



}
	
