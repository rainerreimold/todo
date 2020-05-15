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
    
    /* Den Header können wir leider nicht mehr zentral einbinden,
       da sonst die header location nicht mehr funktioniert. 
      
         include 'inc/header.php';
	 */
    
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
      
       include 'inc/header.php';
	
      
        
       try {
		
   		$sql = "SELECT 	rt.rezept_id as rid, 
					   	rt.rezeptteil_id as rtid, 
					 	rt.bezeichnung as rtb, 
						rez.bezeichnung as rb, 
						rez.aktiv as aktiv,
						rez.loeschbar as loeschbar
					FROM `rezeptteil` rt, rezept rez WHERE rt.rezept_id=rez.rezept_id group by rt.rezept_id";

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
			<td style=\"background:darkgrey;a color:orange;width:20px;\" class=\"odd\">A</td>
			<td style=\"background:darkgrey;a color:orange;width:20px;\" class=\"odd\">L</td>
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
			
					$color = $inhalt['aktiv'] == 1?'green':'red';
             	echo "<td style=\"background:".$color.";a::link,a::hover { text-decoration: none; color: white; };width:50px;\" class=\"tdhersteller\">";
             	echo "<small><a href=\"aktiv/".$rezept_id."\">AK</a></small>";
             	echo "</td>";
             
            	 $color = $inhalt['loeschbar'] == 0?'green':'red';
             	echo "<td style=\"background:".$color.";a::link,a::hover { text-decoration: none; color: white; };width:50px;\" class=\"tdhersteller\">";
             	echo "<small><a href=\"loeschbar/".$rezept_id."\">L&Ouml;</a></small>";
             	echo "</td>";


				echo "</tr>";
	        }
	        
	    }
	    catch(PDOException $e){
	        print $e->getMessage();
	    }
	    echo "</table>";
	    $db=null;
	    
         echo "<br><a href=\"anlegen\">neues Rezept anlegen</a><br>";
      

		if (DEBUG) {
			echo "<br /><br />action= $action<br /><br />";
			echo "<br /><br />id= $id<br /><br />";
		}




		include 'inc/footer.php';
	}
	
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
  
    kleines Formular zum hinzufügen eines Rezept
  
	*****************************************/
  	
    else if ( $action == 'anlegen') {
  	
		   include 'inc/header.php';
	

		// neue Tabnavigation 
			echo '<section data-title="Radio und Label">';


    	 echo '<h1 style="background: orange;
	             padding-left:320px;">Rezept</h1>';
        

    
     echo '<div class="tabbed" >
		<input checked="checked" id="tab1" type="radio" name="tabs" />
		<input id="tab2" type="radio" name="tabs" />
		<input id="tab3" type="radio" name="tabs" />
		<input id="tab4" type="radio" name="tabs" />
		<input id="tab5" type="radio" name="tabs" />
		
		<div class="nav nav-w" style="width: 1000px;">
			<label for="tab1">Hauptspeise</label>
			<label for="tab2">Suppe</label>
			<label for="tab3">Vorspeise</label>
			<label for="tab4">Dessert</label>
			<label for="tab5">kl.Speise</label>
		</div>
	
		<figure style="width: 1000px;">
			<div class="tab1">
				<div class="lines">
					<h5>Hauptspeise</h5>
					
					<p>';
					
		      // Formular Hauptspeise	
			  echo '<div class="form" style="width:1000px; text-align:right; padding:10px; margin:10px auto auto auto;">';
 			
			  echo '<form method="post" action="hauptspeiseEintragen" style="width:60px; padding:10px; margin:10px;">

                <fieldset style="background:#cfcfcf; width:950px; text-align:right; padding:10px; margin-right:10px;">
                <legend>Rezept anlegen</legend>';       
             echo '<label>Rezept: </label><input class="textformsuppe" type="text" name="rezept" placeholder="xxx.xx" required /><br>';
             
             echo "<br>\n";
			// echo "Was soll es f&uuml;r ein Rezept werden?<br>\n";
		

			 $HauptbeilageSelect="\n<select class=\"auswahl2\" name=\"hauptbeilage\" size=\"5\" multiple>\n";
             $HauptbeilageSelect.=getHauptBeilage()."\n";
             $HauptbeilageSelect.="</select>\n";
			
			 echo $HauptbeilageSelect;

			 $SaettigungsbeilageSelect="\n<select class=\"auswahl2\" name=\"saettigungsbeilage\" size=\"5\" multiple>\n";
             $SaettigungsbeilageSelect.=getSaettigungsBeilage()."\n";
             $SaettigungsbeilageSelect.="</select>\n";
			
			 echo $SaettigungsbeilageSelect;

			 $GemuesebeilageSelect="\n<select class=\"auswahl2\" name=\"gemuesebeilage\" size=\"5\" multiple>\n";
             $GemuesebeilageSelect.=getGemueseBeilage()."\n";
             $GemuesebeilageSelect.="</select>\n";
			
			 echo $GemuesebeilageSelect;

			 echo "<br/><br/>";
			 echo "<textarea id='editor' name='editor'></textarea>";


             echo '</fieldset>';
			  echo ' <fieldset style="background:#cfcfcf; text-align:right; padding:10px; margin-right:10px;">
              <button type="reset">Eingaben l&ouml;schen</button>
              <button type="submit">Absenden</button>
            </fieldset>
          </form>
       </div>';

			echo	'</p>
				</div>
			</div>';


			// Suppe	
			echo '<div class="tab2">
				  <div class="lines">
					<h5>Suppe</h5>
					<p>';
					  
			  echo '<div class="form" style="width:940px; text-align:right; padding:10px; margin:10px auto auto auto;">';
		 			
			  echo '<form method="post" action="suppeEintragen" style="width:900px; padding:10px; margin:10px;">

              <fieldset style="background:#cfcfcf; width:800px; text-align:right; padding:10px; margin-right:10px;">
              <legend>Rezept anlegen</legend>';       
             echo '<label>Rezept: </label>
			  <input class="textformsuppe" type="text" name="rezept" placeholder="Suppe" required style="width:750px;/><br>';
             echo '</fieldset>';
             echo "<br>\n";
			 
			 echo '<fieldset style="background:#cfcfcf; width:800px; text-align:right; padding:10px; margin-right:10px;">';
              
			 echo "Was soll es f&uuml;r ein Rezept werden?<br>\n";
		

			 $SuppeSelect="\n<select class=\"auswahl eyecatch\" name=\"suppe\" size=\"5\" multiple>\n";
             $SuppeSelect.=getSuppen()."\n";
             $SuppeSelect.="</select>\n";
			
			 echo $SuppeSelect;

			 echo "<br><br>\n";
			 				

			  echo "<textarea id='editorSuppe' name='editorSuppe'></textarea>";
  	

			 echo '</fieldset>';

             echo ' <fieldset style="background:#cfcfcf; text-align:right; padding:10px; margin-right:10px;">
              <button type="reset">Eingaben l&ouml;schen</button>
              <button type="submit">Absenden</button>
            </fieldset>
          </form>
       </div>';
					echo '</p>
				</div>
			
			</div>';


			echo '<div class="tab3">
				
				<div class="lines">
					<h5>Vorspeise</h5>
					<p>';
					  
			  echo '<div class="form" style="width:750px; text-align:right; padding:10px; margin:10px auto auto auto;">';
 		
			  echo '<form method="post" action="vorspeiseEintragen" style="width:700px; padding:10px; margin:10px;">
           <fieldset style="background:#cfcfcf; width:500px; text-align:right; padding:10px; margin-right:10px;">
           <legend>Rezept anlegen</legend>';       
             echo '<label>Rezept: </label><input class="textform eyecatch" type="text" name="rezept"  required /><br>';
             echo '</fieldset>';
             echo "<br>\n";
			 
			 echo '<fieldset style="background:#cfcfcf; width:800px; text-align:right; padding:10px; margin-right:10px;">';
             
			 echo "Was soll es f&uuml;r eine Vorspeise werden?<br>\n";
		
	
			 $VorspeiseSelect="\n<select class=\"auswahl eyecatch\" name=\"vorspeise\" size=\"5\" multiple>\n";
             $VorspeiseSelect.=getVorspeisen()."\n";
             $VorspeiseSelect.="</select>\n";
			
			 echo $VorspeiseSelect;
			 echo "<br><br>\n";
			 
			 echo "<textarea id='editorVorspeise' name='editorVorspeise'></textarea>";
  	
   		     echo '</fieldset>';


             echo ' <fieldset style="background:#cfcfcf; text-align:right; padding:10px; margin-right:10px;">
              <button type="reset">Eingaben l&ouml;schen</button>
              <button type="submit">Absenden</button>
            </fieldset>
          </form>
       </div>';
					echo '
					</p>
				</div>
			
			</div>';


			// Dessert
		echo '<div class="tab4">
				<div class="lines">
					<h5>Dessert</h5>
					<p>';
			  echo '<div class="form" style="width:750px; text-align:right; padding:10px; margin:10px auto auto auto;">';
 		
			  echo '<form method="post" action="dessertEintragen" style="width:700px; padding:10px; margin:10px;">
           <fieldset style="background:#cfcfcf; width:500px; text-align:right; padding:10px; margin-right:10px;">
           <legend>Rezept anlegen</legend>';       
             echo '<label>Rezept: </label><input class="textform eyecatch" type="text" name="rezept"  required /><br>';
             echo '</fieldset>';
             echo "<br>\n";
			 
			 echo '<fieldset style="background:#cfcfcf; width:800px; text-align:right; padding:10px; margin-right:10px;">';
             
			 echo "Was soll es f&uuml;r ein Dessert werden?<br>\n";
		
	
			 $DessertSelect="\n<select class=\"auswahl eyecatch\" name=\"vorspeise\" size=\"5\" multiple>\n";
             $DessertSelect.=getDessert()."\n";
             $DessertSelect.="</select>\n";
			
			 echo $DessertSelect;
			 echo "<br><br>\n";
			 
			  echo "<textarea id='editorDessert' name='editorDessert'></textarea>";
  	
   		     echo '</fieldset>';


             echo ' <fieldset style="background:#cfcfcf; text-align:right; padding:10px; margin-right:10px;">
              <button type="reset">Eingaben l&ouml;schen</button>
              <button type="submit">Absenden</button>
            </fieldset>
          </form>
       </div>';
					echo '</p>
				</div>
			
			</div>';

			// kleine Speisen
			echo '<div class="tab5">
				<div class="lines">
					<h5>Speiseteil</h5>
					<p>';
			  echo '<div class="form" style="width:750px; text-align:right; padding:10px; margin:10px auto auto auto;">';
 		
			  echo '<form method="post" action="dessertEintragen" style="width:700px; padding:10px; margin:10px;">
           <fieldset style="background:#cfcfcf; width:500px; text-align:right; padding:10px; margin-right:10px;">
           <legend>Rezept anlegen</legend>';       
             echo '<label>Rezept: </label><input class="textform eyecatch" type="text" name="rezept"  required /><br>';
             echo '</fieldset>';
             echo "<br>\n";
			 
			 echo '<fieldset style="background:#cfcfcf; width:800px; text-align:right; padding:10px; margin-right:10px;">';
             
			 echo "Was soll es f&uuml;r eine Speiseteil werden?<br>\n";
		
	
			 $SpeiseteilSelect="\n<select class=\"auswahl eyecatch\" name=\"vorspeise\" size=\"5\" multiple>\n";
             $SpeiseteilSelect.=getBestandteil()."\n";
             $SpeiseteilSelect.="</select>\n";
			
			 echo $SpeiseteilSelect;
			 echo "<br><br>\n";
			 
			  echo "<textarea id='editorSpeiseteil' name='editorSpeiseteil'></textarea>";
  	
   		     echo '</fieldset>';


             echo ' <fieldset style="background:#cfcfcf; text-align:right; padding:10px; margin-right:10px;">
              <button type="reset">Eingaben l&ouml;schen</button>
              <button type="submit">Absenden</button>
            </fieldset>
          </form>
       </div>';
					echo '</p>
				</div>
			
			</div>';




		echo '</figure>
	</div>
</section>';
	
   echo '<script type="text/javascript">';
   echo "	CKEDITOR.replace('editor');";
   echo "	CKEDITOR.replace('editorSuppe');";
   echo "	CKEDITOR.replace('editorVorspeise');";
   echo "	CKEDITOR.replace('editorDessert');";
   echo "	CKEDITOR.replace('editorSpeiseteil');";
   echo "    </script>";
			

     include 'inc/footer.php';


	}


	/***************************************

	Das eigentliche Eintragen erfolgt erst hier

	****************************************/

	else if ( $action == 'hauptspeiseEintragen') {

     
    
		 $rezept        	 = $_REQUEST['rezept'];
		 $beschreibung 		 = $_REQUEST['editor'];
		
 		 // exisitert dieses Rezept schon?

		 if (!isRecipeExist($rezept)) {

		
		 // wenn nicht, dann eintragen und die ID ermitteln
		try {
	
		  $sql = "replace into rezept set bezeichnung = '".$rezept."', beschreibung = '".$beschreibung."'";

          //print $sql."<br>";

          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $db->query($sql);
          $db=null;

          }
          catch(PDOException $e){
              print "<br>".$e->getMessage();
          }

		  $rezept_id = getLastRezeptId();
		  setRezeptInitialId( $rezept_id);	


     	/***

			der darf aber auch nur ausgeführt werden, wenn das Rezept nicht existiert.		

		Teil 2  

			// lies die restlichen Daten und trage sie mit der rezeptId in Rezeptbestandteile


		BSP für Transaktionen

		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

 		$dbh->beginTransaction();
  		$dbh->exec("insert into staff (id, first, last) values (23, 'Joe', 'Bloggs')");
  		$dbh->exec("insert into salarychange (id, amount, changedate) 
      		values (23, 50000, NOW())");
  		$dbh->commit();
  
		} catch (Exception $e) {
  			$dbh->rollBack();
  			echo "Failed: " . $e->getMessage();
		}




		*****/

		 
		 $hauptbeilage		 = $_REQUEST['hauptbeilage'];			
		 $bez_hauptbeilage = getBezeichnungSpeisekomponente($hauptbeilage);		   
		 $saettigungsbeilage = $_REQUEST['saettigungsbeilage'];
		 $bez_saettigungsbeilage = getBezeichnungSpeisekomponente($saettigungsbeilage);	
		 $gemuesebeilage 	 = $_REQUEST['gemuesebeilage'];
		 $bez_gemuesebeilage = getBezeichnungSpeisekomponente($gemuesebeilage);			
  
        /* Da es sich um 3 identische Routinen handelt, lagere ich das in eine externe Funktion aus */	   
   
	    try {

       
		  $sql = "replace into rezeptteil set speisekomponente_id = '".$hauptbeilage."', rezept_id = '".$rezept_id."', bezeichnung = '". $bez_hauptbeilage."'  ";
		  

          //print $sql."<br>";

          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		  
 		  $db->beginTransaction();
  		        

		  $db->query($sql);
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
          
		  $db->commit();
  
		  $db=null;

          }
          catch(PDOException $e){
			  $dbh->rollBack();
              print "<br>".$e->getMessage();
          }

		// das Rezept existiert nicht (if)
         }
		else {
 			echo "Das Rezept existiert schon!";
		}
        
          //die();
          

			echo '<script src="window.history.back(-2);"></script>';
			 
 			/* function zurueck() {
    		     window.history.back(-2)
  			 }
  */
          //header('location:../uebersicht');



    }

	/*** 
  
		Suppe eintragen
   
	***/

	/// noch zu überarbeiten

	else if ( $action == 'suppeEintragen') {

     
    
		 $rezept        	 = $_REQUEST['rezept'];
		 $beschreibung 		 = $_REQUEST['editorSuppe'];
		
 		 // exisitert dieses Rezept schon?

		 if (!isRecipeExist($rezept)) {

		
		 // wenn nicht, dann eintragen und die ID ermitteln
		try {
	
		  $sql = "replace into rezept set bezeichnung = '".$rezept."', beschreibung = '".$beschreibung."'";

          //print $sql."<br>";

          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $db->query($sql);
          $db=null;

          }
          catch(PDOException $e){
              print "<br>".$e->getMessage();
          }

		  $rezept_id = getLastRezeptId();
		  setRezeptInitialId( $rezept_id);	


     	/***

			der darf aber auch nur ausgeführt werden, wenn das Rezept nicht existiert.		

		Teil 2  

			// lies die restlichen Daten und trage sie mit der rezeptId in Rezeptbestandteile



		*****/

		 
		 $suppe		 = $_REQUEST['suppe'];			
		 $bez_suppe = getBezeichnungSpeisekomponente($suppe);		   
	
      
	    try {

       
		  $sql = "replace into rezeptteil set speisekomponente_id = '".$suppe."', rezept_id = '".$rezept_id."', bezeichnung = '". $bez_suppe."'  ";
		  

          //print $sql."<br>";

          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		  
 		  $db->beginTransaction();
  		        

		  $db->query($sql);
		  $sql = "update rezeptteil set initial_id=rezeptteil_id order by rezeptteil_id desc Limit 1;";          
          $db->query($sql);		  	  
          
		  $db->commit();
  
		  $db=null;

          }
          catch(PDOException $e){
			  $dbh->rollBack();
              print "<br>".$e->getMessage();
          }

		// das Rezept existiert nicht (if)
         }
		else {
 			echo "Das Rezept existiert schon!";
		}
        
          //die();
          
		   $_SESSION['Eintrag']	= $bezeichnung.' erfolgreich eingetragen';
          header('location:../uebersicht');



    }


	else if ( $action == "aktiv" ) {

	 
        try {
		  // einfacher Switch	
          $sql = "update `rezept` Set `aktiv`=(`aktiv`-1)*-1 where `rezept_id`=".$id.";";

  
         // print $sql."<br>";

          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $db->query($sql);
          $db=null;

          //echo "<br>".$sql."<br>";
          //die();


          }
          catch(PDOException $e){
              print "<br>".$e->getMessage();
          }
         //die();
        header('location:../zeigeAlleRezepte') ;

	}

	else if ( $action == "loeschbar" ) {

	 
        try {
		  // einfacher Switch	
          $sql = "update `rezept` Set `loeschbar`=(`loeschbar`-1)*-1 where `rezept_id`=".$id.";";

  
         // print $sql."<br>";

          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $db->query($sql);
          $db=null;

          //echo "<br>".$sql."<br>";
          //die();


          }
          catch(PDOException $e){
              print "<br>".$e->getMessage();
          }
         //die();
        header('location:../zeigeAlleRezepte') ;

	}




}
	
