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

    else if ( $action == 'zeigeAlleEigenschaftenFuerDomain') {
        
       try {
		 
		/* ermittle den Domainnamen anhand der id */

		$domain_name=getDomainNameById($id);
		echo "<h1>".$domain_name."</h1>";
              
		$sql = "Select eigenschaft_id, bezeichnung, erklaerung from eigenschaft";

		if (DEBUG) echo "<br>".$sql."<br>";
       
	 
          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
          $rueckgabe = $db->query($sql);
          
		  $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
	        
	        
	        
	        echo "<table  style=\"background:#777;padding:4px;border:1px;\"   cellpadding=\"6\" cellspacing=\"1\">";
	        echo '<tr style="padding:8px;"><th colspan=3 style="font-family: Fira ;color:#ddd">Auspr&auml;gungen der Eigenschaften f&uuml;r die Domain:'.$domain_name.'</th></tr>';
	        echo "<tr  style=\"padding:8px;\"><td style=\"background:darkgrey;a color:orange;width:350px;\" class=\"odd\">

          </td>
           <td style=\"background:darkgrey;a color:orange;width:350px;\" class=\"odd\">Auspr&auml;gung</td><td style=\"background:darkgrey;a color:orange;width:80px;\" class=\"odd\">erledigt</td></tr>";
	        foreach ($ergebnis as  $inhalt)
	        {
	            $eigenschaft_id=$inhalt['eigenschaft_id'];
	            
	            echo "<tr style=\"border:1px dotted black;\">";
				echo "<td style=\"background:lightgrey;a color:orange;width:350px;padding:6px;\" class=\"odd\">";
	            
	            echo $inhalt['bezeichnung'];
	            echo "</td>";
				echo "<td>";
	            echo $inhalt['erklaerung'];
	 
           	// sofern die EIgenschaft für die Domain ausgeprägt ist, soll das Feld grün sein,
			// rot - sonst
				$wert=getAuspraegung( $id, $eigenschaft_id);

		        $color=$wert==1?'green':'red';		

				
				if ($color=='green') {
					echo "<td style=\"background:".$color.";a::link,a::hover { text-decoration: none; color: white; }width:50px;\" class=\"tdhersteller\">";
   		     		echo "<small><a href=\"../erledigt/".$id."/".$eigenschaft_id."\">Ja</a></small>";
				}	
             	else {
					echo "<td style=\"background:".$color.";a::link,a::hover { text-decoration: none; color: black; }width:50px;\" class=\"tdhersteller\">";
					echo "<small><a href=\"../erledigt/".$id."/".$eigenschaft_id."\">Nein</a></small>";
				}
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

	else if ( $action == 'erledigt' ) {

		$eigenschaft_id = $von;

		// exisitert ein Eintrag ? dann hole die letz	   
		$wert=getAuspraegung( $id, $eigenschaft_id);

		//$wert=$wert!=1?1:0;
		// oder 
		$wert=($wert-1)*-1;
		
		if (DEBUG) {
		 echo "ID: ".$id;
		 echo "<br>eigenschaft_id ".$von;
		 die();
		}
         $sql = "replace into auspraegung set `domain_id`=".$id.", `eigenschaft_id`=".$eigenschaft_id.", `wert`=".$wert." ";
         
         echo "<br>".$sql."<br>";
	   //die();
        try {


          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $db->query($sql);
          $db=null;

          }
          catch(PDOException $e){
              print "<br>".$e->getMessage();
          }

        header('location:../../../auspraegung/zeigeAlleEigenschaftenFuerDomain/'.$id) ;


	}	

}
	
