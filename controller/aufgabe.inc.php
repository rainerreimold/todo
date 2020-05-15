

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
			echo "<h1>Aufgabe</h1>";
			echo "<h2>Ansatz?</h2>";

			die();
		}



	}

    else if ( $action == 'zeigeAlleAufgaben') {
      
	 	include 'inc/header.php';
	

		
		$pid = isset($_GET['pid'])?intval($_GET['pid']):0;
		$von = isset($_GET['von'])?intval($_GET['von']):0;
		$lim = isset($_GET['lim'])?intval($_GET['lim']):30;
		 
		//$order = isset($_GET['order'])?$_GET['order']:'desc';
		$gegenorder = $order=='desc'?'asc':'desc';


  
       	try {
		
        
        $sql = "SELECT `tid_md5`, `titel`, `erklaerung`, `ziel`, `wunsch`, angelegt, sichtbar, geloescht FROM `todo` order by angelegt asc Limit ".$von. ", ". $lim;
		
		if (DEBUG) echo "<br>".$sql."<br>";
       
	 
        $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
        $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
        $rueckgabe = $db->query($sql);
          
		$ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
	        
	        
	        
	    echo "<table  style=\"background:#777;padding:4px;border:1px;\"   cellpadding=\"6\" cellspacing=\"1\">";
	    echo '<tr style="padding:8px;"><th colspan=3 style="font-family: Fira ;color:#ddd">Aufgaben die zu erledigen sind</th></tr>';
	    echo "<tr  style=\"padding:8px;\"><td style=\"background:darkgrey;a color:orange;width:350px;\" class=\"odd\">
            Bezeichnung
            </td>
            <td style=\"background:darkgrey;a color:orange;width:350px;\" class=\"odd\">Beschreibung</td>
		    <td style=\"background:darkgrey;a color:orange;width:80px;\" class=\"odd\">Angelegt</td>
			<td style=\"background:darkgrey;a color:orange;width:20px;\" class=\"odd\">A</td>
			<td style=\"background:darkgrey;a color:orange;width:20px;\" class=\"odd\">L</td>
          </tr>";
	    
		foreach ($ergebnis as  $inhalt)
	        {
	            $aufgabe_id=$inhalt['tid_md5'];
	            
	            echo "<tr style=\"border:1px dotted black;\"><td style=\"background:lightgrey;a color:orange;width:350px;padding:6px;\" class=\"odd\">";
	            
	            echo "<a href=\"/details/$aufgabe_id\">".$inhalt['titel']."</a>";
	            
	 
           
                //&nbsp;&nbsp;&nbsp;<small><small><em style=\"color:red;\">(<a href=\"details/".$domain_id."\">bearbeiten</a>)</em></small></small>";
	            echo "</td><td style=\"background:lightgrey;a color:orange;width:50px;padding:6px;\" class=\"odd\"> ";
				echo "<a href=\"/details/$aufgabe_id\">".$inhalt['angelegt']."</a>";
	            echo "<br></td>";
				//echo "<td style=\"background:lightgrey;a color:orange;width:50px;padding:6px;\" class=\"odd\"> ";
			    //echo  $inhalt['zb'];
				//echo "</td>";
				
				$color = $inhalt['sichtbar'] == 1?'green':'red';
             	echo "<td style=\"background:".$color.";a::link,a::hover { text-decoration: none; color: white; };width:50px;\" class=\"tdhersteller\">";
             	echo "<small><a href=\"aktiv/".$aufgabe_id."\">AK</a></small>";
             	echo "</td>";
             
            	$color = $inhalt['geloescht'] == 0?'green':'red';
             	echo "<td style=\"background:".$color.";a::link,a::hover { text-decoration: none; color: white; };width:50px;\" class=\"tdhersteller\">";
             	echo "<small><a href=\"loeschbar/".$aufgabe_id."\">L&Ouml;</a></small>";
             	echo "</td>";


				echo "</tr>";
	        }
	        
	    }
	    catch(PDOException $e){
	        print $e->getMessage();
	    }
	    echo "</table>";
	    $db=null;
		
		echo "<br><br>";
			
		if ($von < 30) $zurueck = 0;
		else $zurueck = $von - 30;

		$weiter = $von + 30;
		
		if ($von > 1) {
			echo '<a href="'.PFAD.'/'.APPNAME.'/todo/zeigeAlleAufgaben/'.$zurueck.'/'.$lim.'"><<</a>';
		}
		echo '&nbsp;';
		if ($anzahl>28) {
			echo '<a href="'.PFAD.'/'.APPNAME.'/todo/zeigeAlleAufgaben/'.$vor.'/'.$lim.'">>></a>';
			echo '</b></center>';
		}



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
	

		 echo '<h1 style="background: darkslategray; color:white;
	             padding:20px; padding-left:120px; bottom:1px black solid;">Ereignis</h1>';
         echo '<div class="form" style="width:1050px; text-align:right; padding:10px; margin:10px auto auto auto;">

         <form method="post" action="eintragen" style="width:1000px; padding:10px; margin:10px;" class="artikelform">
           <fieldset style="background:#cfcfcf; width:950px; text-align:right; padding:10px; margin-right:10px;">
           <legend>Ereignis erfassen</legend>';       

         echo '<label>&Uuml;berschrift: </label><input class="textform eyecatch" type="text" class="textform" name="headline" placeholder="&Uuml;berschrift" required /><br>';
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


		echo "<br>";
		       
         echo '<label>Projekt: </label>';
		  $ProjektSelect="\n<select class=\"produktform\" name=\"projekt\" size=\"1\">\n";
          $ProjektSelect.=getProjekt()."\n";
          $ProjektSelect.="</select>\n";
			
		  echo $ProjektSelect;
		  echo "<br>";

		  echo '<label>Projektart: </label>';
		  $ProjektArtSelect="\n<select class=\"produktform\" name=\"projektart\" size=\"1\">\n";
          $ProjektArtSelect.=getProjektArt()."\n";
          $ProjektArtSelect.="</select>\n";
			
		  echo $ProjektArtSelect;
		  echo "<br>";
  	    
		 echo '<label>Thema: </label>'; //echo '<input class="textform2" type="text" name="thema" placeholder="Thema" required /><br>';

 		  $ThemaSelect="\n<select class=\"produktform\" name=\"thema\" size=\"1\">\n";
          $ThemaSelect.=getThema()."\n";
          $ThemaSelect.="</select>\n";
			
		  echo $ThemaSelect;
		  echo "<br>";

        echo '<label>Tags: </label><input class="textform2" type="text" name="tags" placeholder="Tag1, Tag2, Tag3" required /><br>';
        echo "<br>";
			
		echo '<label>Priorit&auml;t: </label>';

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


CREATE TABLE `todo` (
  `id` int(11) NOT NULL,
  `initial_id` int(11) NOT NULL,
  `tid_md5` varchar(32) NOT NULL,
  `titel` varchar(250) DEFAULT '',
  `erklaerung` text,
  `ziel` text,
  `wunsch` text,
  `angelegt` datetime DEFAULT NULL COMMENT 'NOW()',
  `erledigt` datetime DEFAULT NULL,
  `prioritaet` tinyint(1) DEFAULT NULL,
  `geaendert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` varchar(30) DEFAULT '1',
  `parent_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `projekt_id` varchar(120) DEFAULT NULL,
  `kategorie_id` int(11) DEFAULT NULL,
  `geloescht` tinyint(1) DEFAULT '0',
  `url` varchar(250) DEFAULT NULL,
  `loesungsweg` text,
  `hinweis` text,
  `sichtbar` tinyint(1) DEFAULT '1',
  `thema` tinyint(1) NOT NULL,
  `zuErledigenBis` date NOT NULL,
  `abweichungErledigung` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;




		
	**/ 

	else if ( $action == 'eintragen') {
	

     $headline      = $_POST['headline'];
     $erklaerung    = $_POST['erklaerung'];
	 $ziel        	= $_POST['ziel'];
	 $wunsch        = $_POST['wunsch'];

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

                    
              
   
   	      $sql = "replace into todo set titel='".$headline."', erklaerung = '".$erklaerung."', ziel = '".$ziel."', wunsch = '".$wunsch."',
			 thema = ".$thema.", initial_id=0, parent_id=0, angelegt=NOW(), user_id=1, status='unerledigt'";

		  if (DEBUG) {
          	print $sql."<br>";
		  	die();
          }
		  
	      $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $db->beginTransaction();

		  print $sql."<br>";

		  $db->query($sql);
		
          $sql = "update todo set initial_id=id, tid_md5=md5(id) order by id desc Limit 1;"; 
		  $db->query($sql);
		  print $sql."<br>";

		  // Transaktion abschliessen	
		  $db->commit();	
          $db=null;
		  //print "<strong>hier</strong>";	
          }
          catch(PDOException $e){
			  $db->rollback();
              print "<br>".$e->getMessage();
          }


 		  // getArtikelInitialId	
           
         // die();
          

          header('location:../uebersicht');





	}

	else if ( $action == 'aktiv') {
	
	}

    else if ( $action == 'loeschbar') {
	
	}

}
