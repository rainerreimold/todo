<?php




session_start();


require_once './inc/global_config.inc.php';
$_SESSION['title'] = 'Lizenz - Verwaltung von Lizenzen';
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
			echo "<h1>Lizenzen</h1>";
			echo "<h2>Ansatz?</h2>";

			die();
		}



		}

    else if ( $action == 'zeigeAlleDomains') {
        
       try {
		//echo "HIER";
               //    SELECT domain_id, domain_name FROM `domain` WHERE 1
		$sql = "Select domain_id, domain_name from domain";

		if (DEBUG) echo "<br>".$sql."<br>";
       
	 
          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
          $rueckgabe = $db->query($sql);
          
		  $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
	        
	        
	        
	        echo "<table  style=\"background:#777;padding:4px;border:1px;\"   cellpadding=\"6\" cellspacing=\"1\">";
	        echo '<tr style="padding:8px;"><th colspan=3 style="font-family: Fira ;color:#ddd">Domains f&uuml;r Clients</th></tr>';
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
	    
      
      

		if (DEBUG) {
			echo "<br /><br />action= $action<br /><br />";
			echo "<br /><br />id= $id<br /><br />";
		}




		include 'inc/footer.php';
	}
	
    else if ( $action == 'zeigeDomains') {
        
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
  
    kleines Formular zum hinzufügen einer Domain
  
	*****************************************/
  	
    else if ( $action == 'anlegen') {
  	
		 echo '<h1 style="background: orange;
	             padding-left:120px;">Domain</h1>';
         echo '<div class="form" style="width:750px; text-align:right; padding:10px; margin:10px auto auto auto;">

         <form method="post" action="eintragen" style="width:700px; padding:10px; margin:10px;">
           <fieldset style="background:#cfcfcf; width:500px; text-align:right; padding:10px; margin-right:10px;">
           <legend>Domain anlegen</legend>';       
         echo '<label>Domain: </label><input class="textform eyecatch" type="text" name="domain" placeholder="xxx.xx" required /><br>';
         echo '</fieldset>';
         echo "<br>\n";
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
	
