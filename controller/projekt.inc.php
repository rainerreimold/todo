

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

	/***
		17.04.2021
		ich finde ja, dass man die Projektverwaltung in allen anderen Projekten mit nutzen können sollte.
		
		Es ist die Frage, ob man die Tabellen abgleicht oder die Anwendung über eine Datenbank hinweg betreibt,
		R.Reimold
	**/


    else if ( $action == 'zeigeAlleProjekte') {
      
	 	include 'inc/header.php';
	
  
       	try {
		
      
        	$sql = "SELECT `projekt_id`, `name`, `erlaeuterung`, `name`, `kuerzel`, `pid_md5`, `beginn`,`status`  
 					FROM `projekt` 
 					where 
 					projekt_id in (select max(projekt_id) from projekt group by initial_id)
 					and
 					loeschbar=0 and sichtbar=1 order by name asc";

			if (DEBUG) echo "<br>".$sql."<br>";
       
	 
          	$db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          	$db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
          	$rueckgabe = $db->query($sql);          
		  	$ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
	        
	        
	        
	        echo "<table  style=\"background:#777;padding:4px;border:1px;\"   cellpadding=\"6\" cellspacing=\"1\">";
	        echo '<tr style="padding:8px;"><th colspan=3 style="font-family: Fira ;color:#ddd">Projektplanung</th></tr>';
	        echo "<tr  style=\"padding:8px;\">

			<td style=\"background:darkgrey;a color:orange;width:350px;\" class=\"odd\">Projekt</td>
		    <td style=\"background:darkgrey;a color:orange;width:80px;\" class=\"odd\">K&uuml;rzel</td>
            <td style=\"background:darkgrey;a color:orange;width:350px;\" class=\"odd\">Erl&auml;uterung</td>
			<td style=\"background:darkgrey;a color:orange;width:20px;\" class=\"odd\">Beginn</td>
			<td style=\"background:darkgrey;a color:orange;width:20px;\" class=\"odd\">Status</td>
          	</tr>";
	        foreach ($ergebnis as  $inhalt)
	        {
	            //$projekt_id=$inhalt['projekt_id'];
	            $projekt_id=$inhalt['pid_md5'];
				
	            echo "<tr style=\"border:1px dotted black;\"><td style=\"background:lightgrey;a color:orange;width:350px;padding:6px;\" class=\"odd\">";
	            
	            echo "<a href=\"../projektplanung/zeigeprojektplanung/$projekt_id\" title=\"".$inhalt['erlaeuterung']."\">".$inhalt['name']."</a>";
	            
	 
           
                //&nbsp;&nbsp;&nbsp;<small><small><em style=\"color:red;\">(<a href=\"details/".$projekt_id."\">bearbeiten</a>)</em></small></small>";
	            echo "</td><td style=\"background:lightgrey;a color:orange;width:50px;padding:6px;\" class=\"odd\"> ";
				echo "<a href=\"details/$projekt_id\" title=\"".$inhalt['erlaeuterung']."\">".$inhalt['kuerzel']."</a>";
	            echo "<br></td>";
				echo "<td style=\"background:lightgrey;a color:orange;width:50px;padding:6px;\" class=\"odd\"> ";
			    echo  $inhalt['beginn'];
				echo "</td>";
				echo "<td style=\"background:lightgrey;a color:orange;width:50px;padding:6px;\" class=\"odd\"> ";
			     echo  $inhalt['status'];
				echo "</td>";
/*
				$color = $inhalt['aktiv'] == 1?'green':'red';
             	echo "<td style=\"background:".$color.";a::link,a::hover { text-decoration: none; color: white; };width:50px;\" class=\"tdhersteller\">";
             	echo "<small><a href=\"aktiv/".$projekt_id."\">AK</a></small>";
             	echo "</td>";
             
            	 $color = $inhalt['loeschbar'] == 0?'green':'red';
             	echo "<td style=\"background:".$color.";a::link,a::hover { text-decoration: none; color: white; };width:50px;\" class=\"tdhersteller\">";
             	echo "<small><a href=\"loeschbar/".projekt_id."\">L&Ouml;</a></small>";
             	echo "</td>";
*/

				echo "</tr>";
	        }
	        
	    }
	    catch(PDOException $e){
	        print $e->getMessage();
	    }
	    echo "</table>";
	    $db=null;
	    
        echo "<br><a href=\"anlegen\">neue Komponente anlegen</a><br>";
      

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
       
  
    }
	
	
	else if ( $action == 'anlegen') {

		 include 'inc/header.php';
	

		 echo '<h1 style="background:darkslategray; color:black;
	             padding:20px; padding-left:120px; bottom:1px black solid;">Projektplanung</h1>';
         echo '<div class="form" style="width:1050px; text-align:right; padding:10px; margin:10px auto auto auto;">

         <form method="post" action="eintragen" style="width:1000px; padding:10px; margin:10px;" class="artikelform">
           <fieldset style="background:#cfcfcf; width:950px; text-align:right; padding:10px; margin-right:10px;">
           <legend>Ereignis erfassen</legend>';       

         echo '<label>&Uuml;berschrift: </label><input class="textform eyecatch" type="text" name="headline" placeholder="&Uuml;berschrift" required /><br>';
/*        
`titel` varchar(250) DEFAULT '',
  `erklaerung` text,
  `ziel` text,
  `wunsch` text,
*/
      
         echo '<label>Erkl&auml;rung: </label>'."<br>";
	     echo "<textarea id='erklaerung' name='erklaerung'></textarea>";
			
  			echo '<label>Ziel: </label>'."<br>";
	     echo "<textarea id='ziel' name='ziel'></textarea>";

		echo '<label>Wunsch: </label>'."<br>";
	     echo "<textarea id='wunsch' name='wunsch'></textarea>";		


		// Das können wir als Selectfeld machen  	
		 echo "<br>";
		// echo '<label>Projekt: </label>';
			//<input class="textform eyecatch" type="text" name="headline" placeholder="projekt" required /><br>';
/*         
		  $DomainsSelect="\n<select class=\"produktform\" name=\"projekt\" size=\"1\">\n";
          $DomainsSelect.=getAlleDomains()."\n";
          $DomainsSelect.="</select>\n";
			
		  echo $DomainsSelect;
*/
  	    
		 echo '<label>Thema: </label><input class="textform2" type="text" name="thema" placeholder="Thema" required /><br>';
         echo '<label>Tags: </label><input class="textform2" type="text" name="tags" placeholder="Tag1, Tag2, Tag3" required /><br>';
        
		 $PrioritaetSelect="\n<select class=\"produktform\" name=\"prioritaet\" size=\"1\">\n";
         $PrioritaetSelect.="<option value=\"5\">gelegentlich</option>\n";
		 $PrioritaetSelect.="<option value=\"4\">gering</option>\n";
		 $PrioritaetSelect.="<option value=\"3\" selected>mittel</option>\n";
		 $PrioritaetSelect.="<option value=\"2\">hoch</option>\n";
		 $PrioritaetSelect.="<option value=\"1\">sehr hoch</option>\n";
					//getAlleDomains()."\n";
          $PrioritaetSelect.="</select>\n";
			
		 echo $PrioritaetSelect;

		 echo '</fieldset>';
         echo "<br>\n";
                echo '<fieldset style="background:#cfcfcf; text-align:right; padding:10px; margin-right:10px;">
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
   	echo "	CKEDITOR.replace('erklaerung');";
    echo "	CKEDITOR.replace('ziel');";
	echo "	CKEDITOR.replace('wunsch');";
	echo " </script>";

     include 'inc/footer.php';


	

	}


	/** 

		Funktion aus Artikel 
		muss überarbeitet werden

 `projektpreisplanung`

CREATE TABLE `projektpreisplanung` (
  `ppl_id` int(11) NOT NULL,
  `abgeschlossen` smallint(6) NOT NULL,
  `angelegt` date NOT NULL,
  `bis` date NOT NULL,
  `deathline` date NOT NULL,
  `loeschbar` tinyint(1) NOT NULL DEFAULT '0',
  `preis_bis` decimal(5,2) NOT NULL,
  `preis_von` decimal(5,2) NOT NULL,
  `projekt_id` int(11) NOT NULL,
  `sichtbar` tinyint(1) NOT NULL DEFAULT '1',
  `stunden_gesamt` int(11) NOT NULL,
  `von` date NOT NULL,
  `lastchange` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;




		
	**/ 

	else if ( $action == 'eintragen') {
	

     $headline      = $_POST['headline'];
     $editor        = $_POST['editor'];
	 $prioritaet    = $_POST['prioritaet'];
	 $thema       	= $_POST['thema']; 
     $tags       	= $_POST['tags'];     



	/*     echo '<pre>';
		var_dump($_POST);
        print_r($_POST);
        echo  '</pre>';
	*/

	 //echo $editor."<br><br>";
	 

          try {

                    
              
   
   	      $sql = "replace into artikel_entwurf set headline='".$headline."', artikel_reintext = '".$editor."', domain_id = ".$projekt;

		  if (DEBUG) {
          	print $sql."<br>";
		  	die();
          }
		  
	      $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $db->beginTransaction();

		  $db->query($sql);
		
          $sql = "update artikel_entwurf  set initial_id=artikel_entwurf_id order by artikel_entwurf_id desc Limit 1;"; 
		  $db->query($sql);
		
		  // Transaktion abschliessen	
		  $db->commit();	
          $db=null;

          }
          catch(PDOException $e){
              print "<br>".$e->getMessage();
          }


 		  // getArtikelInitialId	
           
          //die();
          

          header('location:../uebersicht');





	}

	else if ( $action == 'aktiv') {
	
	}

    else if ( $action == 'loeschbar') {
	
	}

}
