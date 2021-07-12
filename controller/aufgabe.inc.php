

<?php




session_start();


require_once './inc/global_config.inc.php';
$_SESSION['title'] = 'Rezepte - Verwaltung von INgredenzien';
$_SESSION['start'] = isset($_SESSION['start'])?$_SESSION['start']:false;

require_once './class/Log.classes.php';
//require_once './class/LetzteAktivitaet.class.php';
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
	
		echo "<h2>todo-was ist noch zu erledigen.</h2>";
		
		$pid = isset($_GET['pid'])?intval($_GET['pid']):0;
		$von = isset($_GET['von'])?intval($_GET['von']):0;
		$lim = isset($_GET['lim'])?intval($_GET['lim']):30;
		 
		//$order = isset($_GET['order'])?$_GET['order']:'desc';
		$gegenorder = $order=='desc'?'asc':'desc';

		$anzahl = 0;
  
       	try {
		
       
		//  DATE_FORMAT (angelegt, '%e.%m.%y')
		//  DATE_FORMAT (angelegt, '%e.%m.%y') as angelegt
 
        $sql = "SELECT `tid_md5`, `titel`, `erklaerung`, `ziel`, `wunsch`, DATE_FORMAT (angelegt, '%e.%m.%y') as formangelegt, angelegt, sichtbar, geloescht, prioritaet, status, aktiv FROM `todo` where id
		in (select max(id) From todo group by initial_id ) 
		and status != 'erledigt' order by angelegt desc Limit ".$von. ", ". $lim;
		
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
            <!--<td style=\"background:darkgrey;a color:orange;width:350px;\" class=\"odd\">Beschreibung</td>-->
		    <td style=\"background:darkgrey;a color:orange;width:80px;\" class=\"odd\">Bearbeit</td>
			<td style=\"background:darkgrey;a color:orange;width:80px;\" class=\"odd\">Angelegt</td>
			<td style=\"background:darkgrey;a color:orange;width:80px;\" class=\"odd\">Priorit&auml;</td>
			<td style=\"background:darkgrey;a color:orange;width:80px;\" class=\"odd\">Status</td>
			<td style=\"background:darkgrey;a color:orange;width:20px;\" class=\"odd\">erledigt</td>
			<td style=\"background:darkgrey;a color:orange;width:20px;\" class=\"odd\">Sicht</td>
			<td style=\"background:darkgrey;a color:orange;width:20px;\" class=\"odd\">L&ouml;sch</td>
          </tr>";
	    
		foreach ($ergebnis as  $inhalt)
	        {
	            $aufgabe_id=$inhalt['tid_md5'];
	            
	            echo "<tr style=\"border:1px dotted black;\">
					<td style=\"background:lightgrey;a color:orange;width:350px;padding:6px;\" class=\"odd\">";
	            
	            echo "<a href=\"details/$aufgabe_id\">".$inhalt['titel']."</a>";
	            
	 			echo "<td style=\"background:lightgrey;a color:orange;width:50px;padding:6px;\" class=\"odd\"> ";
				echo "<small><small><a href=\"bearbeiten/$aufgabe_id\" class=\"btn btn-default btn-sm\"><span class=\"glyphicon glyphicon-pencil\"></span></a></small></small>";
	            echo "<br></td>";
           

                //&nbsp;&nbsp;&nbsp;<small><small><em style=\"color:red;\">(<a href=\"details/".$domain_id."\">bearbeiten</a>)</em></small></small>";
	            echo "</td>";
				/*
				echo "<td style=\"background:lightgrey;a color:orange;width:50px;padding:6px;\" class=\"odd\"> ";
				echo "<a href=\"details/$aufgabe_id\">".$inhalt['erklaerung']."</a>";
	            echo "<br></td>";
				*/

				echo "<td style=\"background:lightgrey;a color:orange;width:50px;padding:6px;\" class=\"odd\"> ";
				echo "<small><small><a href=\"details/$aufgabe_id\">".$inhalt['formangelegt']."</a></small></small>";
	            echo "<br></td>";

				/* Priorität */
				echo "<td style=\"background:lightgrey;a color:orange;width:50px;padding:6px;\" class=\"odd\"> ";
				echo "<small><small><a href=\"details/$aufgabe_id\">".$inhalt['prioritaet']."</a></small></small>";
	            echo "<br></td>";

				/* Status */
				echo "<td style=\"background:lightgrey;a color:orange;width:50px;padding:6px;\" class=\"odd\"> ";
				echo "<small><small><a href=\"details/$aufgabe_id\">".$inhalt['status']."</a></small></small>";
	            echo "<br></td>";
			

				//echo "<td style=\"background:lightgrey;a color:orange;width:50px;padding:6px;\" class=\"odd\"> ";
			    //echo  $inhalt['zb'];
				//echo "</td>";
				
				$color = $inhalt['aktiv'] == 1?'green':'red';
             	echo "<td style=\"background:".$color.";a::link,a::hover { text-decoration: none; color: white; };width:50px;\" class=\"tdhersteller\">";
             	echo "<small><a href=\"geloest/".$aufgabe_id."\" class=\"btn btn-default btn-sm\"><span class=\"glyphicon glyphicon-ok\"></span></a></small>";
             	echo "</td>";

				$color = $inhalt['sichtbar'] == 1?'green':'red';
             	echo "<td style=\"background:".$color.";a::link,a::hover { text-decoration: none; color: white; };width:50px;\" class=\"tdhersteller\">";
             	echo "<small><a href=\"sichtbar/".$aufgabe_id."\" class=\"btn btn-default btn-sm\"><span class=\"glyphicon glyphicon-search\"></span></a></small>";
             	echo "</td>";
             
		   	    $color = $inhalt['geloescht'] == 0?'green':'red';
             	echo "<td style=\"background:".$color.";a::link,a::hover { text-decoration: none; color: white; };width:50px;\" class=\"tdhersteller\">";
             	echo "<small><a href=\"loeschbar/".$aufgabe_id."\" class=\"btn btn-default btn-sm\"><span class=\"glyphicon glyphicon-remove\"></span></a></small>";
             	echo "</td>";


				echo "</tr>";
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
     
	    }
	    catch(PDOException $e){
	        print $e->getMessage();
	    }
	   



        echo "<br><a href=\"anlegen\">neue Komponente anlegen</a><br>";
      

		if (DEBUG) {
			echo "<br /><br />action= $action<br /><br />";
			echo "<br /><br />id= $id<br /><br />";
		}

	


		include 'inc/footer.php';
	}

	else if ( $action == 'zeigeAlleOffenenAufgaben') {
      
	 	include 'inc/header.php';
	
		echo "<h2>todo-was ist noch zu erledigen.</h2>";
		
		$pid = isset($_GET['pid'])?intval($_GET['pid']):0;
		$von = isset($_GET['von'])?intval($_GET['von']):0;
		$lim = isset($_GET['lim'])?intval($_GET['lim']):30;
		 
		//$order = isset($_GET['order'])?$_GET['order']:'desc';
		$gegenorder = $order=='desc'?'asc':'desc';

		$anzahl = 0;
  
       	try {
		
       
		//  DATE_FORMAT (angelegt, '%e.%m.%y')
		//  DATE_FORMAT (angelegt, '%e.%m.%y') as angelegt
 
        $sql = "SELECT `tid_md5`, `titel`, `erklaerung`, `ziel`, `wunsch`, DATE_FORMAT (angelegt, '%e.%m.%y') as formangelegt, angelegt, sichtbar, geloescht, prioritaet, status, aktiv FROM `todo` where id
		in (select max(id) From todo group by initial_id ) 
		and geloescht = 0 and sichtbar = 1 
		and status != 'erledigt' order by angelegt desc Limit ".$von. ", ". $lim;
		
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
            <!--<td style=\"background:darkgrey;a color:orange;width:350px;\" class=\"odd\">Beschreibung</td>-->
		    <td style=\"background:darkgrey;a color:orange;width:80px;\" class=\"odd\">Bearbeit</td>
			<td style=\"background:darkgrey;a color:orange;width:80px;\" class=\"odd\">Angelegt</td>
			<td style=\"background:darkgrey;a color:orange;width:80px;\" class=\"odd\">Priorit&auml;</td>
			<td style=\"background:darkgrey;a color:orange;width:80px;\" class=\"odd\">Status</td>
			<td style=\"background:darkgrey;a color:orange;width:20px;\" class=\"odd\">erledigt</td>
			<td style=\"background:darkgrey;a color:orange;width:20px;\" class=\"odd\">Sicht</td>
			<td style=\"background:darkgrey;a color:orange;width:20px;\" class=\"odd\">L&ouml;sch</td>
          </tr>";
	    
		foreach ($ergebnis as  $inhalt)
	        {
	            $aufgabe_id=$inhalt['tid_md5'];
	            
	            echo "<tr style=\"border:1px dotted black;\">
					<td style=\"background:lightgrey;a color:orange;width:350px;padding:6px;\" class=\"odd\">";
	            
	            echo "<a href=\"details/$aufgabe_id\">".$inhalt['titel']."</a>";
	            
	 			echo "<td style=\"background:lightgrey;a color:orange;width:50px;padding:6px;\" class=\"odd\"> ";
				echo "<small><small><a href=\"bearbeiten/$aufgabe_id\" class=\"btn btn-default btn-sm\"><span class=\"glyphicon glyphicon-pencil\"></span></a></small></small>";
	            echo "<br></td>";
           

                //&nbsp;&nbsp;&nbsp;<small><small><em style=\"color:red;\">(<a href=\"details/".$domain_id."\">bearbeiten</a>)</em></small></small>";
	            echo "</td>";
				/*
				echo "<td style=\"background:lightgrey;a color:orange;width:50px;padding:6px;\" class=\"odd\"> ";
				echo "<a href=\"details/$aufgabe_id\">".$inhalt['erklaerung']."</a>";
	            echo "<br></td>";
				*/

				echo "<td style=\"background:lightgrey;a color:orange;width:50px;padding:6px;\" class=\"odd\"> ";
				echo "<small><small><a href=\"details/$aufgabe_id\">".$inhalt['formangelegt']."</a></small></small>";
	            echo "<br></td>";

				/* Priorität */
				echo "<td style=\"background:lightgrey;a color:orange;width:50px;padding:6px;\" class=\"odd\"> ";
				echo "<small><small><a href=\"details/$aufgabe_id\">".$inhalt['prioritaet']."</a></small></small>";
	            echo "<br></td>";

				/* Status */
				echo "<td style=\"background:lightgrey;a color:orange;width:50px;padding:6px;\" class=\"odd\"> ";
				echo "<small><small><a href=\"details/$aufgabe_id\">".$inhalt['status']."</a></small></small>";
	            echo "<br></td>";
			

				//echo "<td style=\"background:lightgrey;a color:orange;width:50px;padding:6px;\" class=\"odd\"> ";
			    //echo  $inhalt['zb'];
				//echo "</td>";
				
				$color = $inhalt['aktiv'] == 1?'green':'red';
             	echo "<td style=\"background:".$color.";a::link,a::hover { text-decoration: none; color: white; };width:50px;\" class=\"tdhersteller\">";
             	echo "<small><a href=\"geloest/".$aufgabe_id."\" class=\"btn btn-default btn-sm\"><span class=\"glyphicon glyphicon-ok\"></span></a></small>";
             	echo "</td>";

				$color = $inhalt['sichtbar'] == 1?'green':'red';
             	echo "<td style=\"background:".$color.";a::link,a::hover { text-decoration: none; color: white; };width:50px;\" class=\"tdhersteller\">";
             	echo "<small><a href=\"sichtbar/".$aufgabe_id."\" class=\"btn btn-default btn-sm\"><span class=\"glyphicon glyphicon-search\"></span></a></small>";
             	echo "</td>";
             
		   	    $color = $inhalt['geloescht'] == 0?'green':'red';
             	echo "<td style=\"background:".$color.";a::link,a::hover { text-decoration: none; color: white; };width:50px;\" class=\"tdhersteller\">";
             	echo "<small><a href=\"loeschbar/".$aufgabe_id."\" class=\"btn btn-default btn-sm\"><span class=\"glyphicon glyphicon-remove\"></span></a></small>";
             	echo "</td>";


				echo "</tr>";
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
     
	    }
	    catch(PDOException $e){
	        print $e->getMessage();
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

		Es sollten 2 Versionen entstehen.

		1. details für die Detail Ansicht
		2. Bearbeiten für das Barbeiten der Berechtigten.	

		Zunächst sollte sowohl aus der DetailsAnsicht, wie auch 
		bei einem Neuanlegen ein Eintrag möglich sein. 
		Das ist derzeit nicht der Fall.

		Für die DetailAnsicht muss die eingetragene 
			- Projekt:
			- Projektart:
			- Thema
			- Tags 
			- Priorität 

		angezeigt bzw. vorausgewählt werden!

		Rainer: 03.05.2021


		es könnte bi der detail-ansicht auch gerne das 
		Erstelldatum mit angezeigt werden.

		Rainer: 04.05.2021

	*****************************************/

	else if ( $action == 'bearbeiten') {
     

 	   $todo_id=$id;

   	   include 'inc/header.php';

	   try {
		 
		$sql = "select id, titel, erklaerung, ziel, wunsch, thema, initial_id, parent_id, angelegt, user_id, status
				from todo 
				where tid_md5 = '".$todo_id."'";


		if (DEBUG) echo "<br>".$sql."<br>";
    
	 
        $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
        $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
        $rueckgabe = $db->query($sql);
          
		$ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
	       
		//$id =	$ergebnis[0]['id'];
		$initial_id =	$ergebnis[0]['initial_id'];

		//$parent_id =	$ergebnis[0]['parent_id']; 
		// für die Versionierung muss die aktuelle id zur parent_id werden
		$parent_id =	$ergebnis[0]['id']; 	
		$headline = $ergebnis[0]['titel'];
		$erklaerung = $ergebnis[0]['erklaerung'];
 		$ziel = $ergebnis[0]['ziel'];
		$wunsch = $ergebnis[0]['wunsch'];
		$angelegt = $ergebnis[0]['angelegt'];	
		$user_id = $ergebnis[0]['user_id'];
		$status = $ergebnis[0]['status'];

		// Überschrift headline

		echo '<h1 style="background: darkslategray; color:white;
	             padding:20px; padding-left:120px; bottom:1px black solid;">zu erledigen - todo</h1>';

	    // Ebene des Formular 
        //echo '<div class="form" style="width:1050px; text-align:right; padding:10px; margin:10px auto auto auto;">';
		echo '<div class="form">';	
        echo '<form method="post" action="../eintragen" style="width:1000px; padding:10px; margin:10px;" class="artikelform">';
        echo '<input type="hidden" name="tid" value="'.$todo_id.'">';
		echo '<input type="hidden" name="initial_id" value="'.$initial_id.'">';
		echo '<input type="hidden" name="parent_id" value="'.$parent_id.'">';
		echo '<fieldset style="background:#cfcfcf; width:950px; text-align:right; padding:10px; margin-right:10px;">';
        
		echo '<legend>ToDo Details</legend>';       

        echo '<label>&Uuml;berschrift: </label>';
		echo '<input class="textform eyecatch" type="text" name="headline" value="'.$headline.'" required />';
		echo '<br>';
		echo '<br><span class="tiny">'.$angelegt.'</span><br>';

      
        echo '<label>Erkl&auml;rung: </label>'."<br>";	
		echo "<textarea id='erklaerung' name='erklaerung'>".$erklaerung."</textarea>";
			
  		echo '<label>Ziel: </label>'."<br>";
	    echo "<textarea id='ziel' name='ziel'>".$ziel."</textarea>";

		echo '<label>Wunsch: </label>'."<br>";
	    echo "<textarea id='wunsch' name='wunsch'>".$wunsch."</textarea>";		


		echo "<br>";
		       
        echo '<label>Projekt: </label>';
		$ProjektSelect="\n<select class=\"produktform\" name=\"projekt\" size=\"1\">\n";
        $ProjektSelect.=getProjekt()."\n";
        $ProjektSelect.="</select>\n";
			
		echo $ProjektSelect;
		echo "<br><br>";

	/*	echo '<label>Projektart: </label>';
		$ProjektArtSelect="\n<select class=\"produktform\" name=\"projektart\" size=\"1\">\n";
        $ProjektArtSelect.=getProjektArt()."\n";
        $ProjektArtSelect.="</select>\n";
			
		echo $ProjektArtSelect;
		echo "<br><br>";
  	    
		echo '<label>Thema: </label>'; //echo '<input class="textform2" type="text" name="thema" placeholder="Thema" required /><br>';

 		$ThemaSelect="\n<select class=\"produktform\" name=\"thema\" size=\"1\">\n";
        $ThemaSelect.=getThema()."\n";
        $ThemaSelect.="</select>\n";
			
		echo $ThemaSelect;
		echo "<br><br>";

        echo '<label>Tags: </label><input class="textform2" type="text" name="tags" placeholder="Tag1, Tag2, Tag3" /><br>';
        echo "<br><br>";
			
		echo '<label>Priorit&auml;t: </label>';
*/
		$PrioritaetSelect="\n<select class=\"produktform\" name=\"prioritaet\" size=\"1\">\n";
        $PrioritaetSelect.="<option value=\"5\">gelegentlich</option>\n";
		$PrioritaetSelect.="<option value=\"4\">gering</option>\n";
		$PrioritaetSelect.="<option value=\"3\" selected>mittel</option>\n";
		$PrioritaetSelect.="<option value=\"2\">hoch</option>\n";
		$PrioritaetSelect.="<option value=\"1\">sehr hoch</option>\n";
				//getAlleDomains()."\n";
        $PrioritaetSelect.="</select><br><br>\n";
			
		echo $PrioritaetSelect;

		echo '<br><span style="text-align:center"><button type="text"><a href="../loesen">Problem l&ouml;sen</a></button></span><br>';

		echo '</fieldset>';
        echo "<br><br>\n";
        echo '<fieldset style="background:#cfcfcf; text-align:right; padding:10px; margin-right:10px;">';
		echo '  <button type="reset">Eingaben l&ouml;schen</button>';
        echo '  <button type="submit">Absenden</button>';
        echo '</fieldset>';
        echo '</form>';
        echo '</div>';
        echo '<br>';
        echo '<br>';
        echo '<br>';
        echo '<br>';
		
   	    echo '<script type="text/javascript">';
   	    echo "	CKEDITOR.replace('erklaerung');";
        echo "	CKEDITOR.replace('ziel');";
	    echo "	CKEDITOR.replace('wunsch');";
	    echo " </script>";

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
     

 		 $todo_id=$id;

   		 include 'inc/header.php';

		 try {
		 
		$sql = "select id, titel, erklaerung, ziel, wunsch, thema, initial_id, parent_id, angelegt, user_id, status
				from todo 
				where tid_md5 = '".$todo_id."'";


		if (DEBUG) echo "<br>".$sql."<br>";
    
	 
        $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
        $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
        $rueckgabe = $db->query($sql);
          
		$ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
	       
		//$id =	$ergebnis[0]['id'];
		$initial_id =	$ergebnis[0]['initial_id'];

		//$parent_id =	$ergebnis[0]['parent_id']; 
		// für die Versionierung muss die aktuelle id zur parent_id werden
		$parent_id =	$ergebnis[0]['id']; 	
		$headline = $ergebnis[0]['titel'];
		$erklaerung = $ergebnis[0]['erklaerung'];
 		$ziel = isset($ergebnis[0]['ziel'])?$ergebnis[0]['ziel']:null;
		$wunsch = isset($ergebnis[0]['wunsch'])?$ergebnis[0]['wunsch']:null;
		$angelegt = $ergebnis[0]['angelegt'];	
		$user_id = $ergebnis[0]['user_id'];
		$status = $ergebnis[0]['status'];

		// Überschrift headline

		echo '<h1 style="background: darkslategray; color:white;
	             padding:20px; padding-left:120px; bottom:1px black solid;">zu erledigen - todo</h1>';

	    // Ebene des Formular 
        //echo '<div class="form" style="width:1050px; text-align:right; padding:10px; margin:10px auto auto auto;">';
		echo '<div class="form">';	
        echo '<form method="post" action="../eintragen" style="width:1000px; padding:10px; margin:10px;" class="artikelform">';
        echo '<input type="hidden" name="tid" value="'.$todo_id.'">';
		echo '<input type="hidden" name="initial_id" value="'.$initial_id.'">';
		echo '<input type="hidden" name="parent_id" value="'.$parent_id.'">';
		echo '<fieldset style="background:#cfcfcf; width:950px; text-align:right; padding:10px; margin-right:10px;">';
        
		echo '<legend>ToDo Details</legend>';       

        echo '<label>&Uuml;berschrift: </label>';
		echo '<input class="textform eyecatch" type="text" name="headline" value="'.$headline.'" required />';
		echo '<br>';
		echo '<br><span class="tiny">'.$angelegt.'</span><br>';

      
        echo '<label>Erkl&auml;rung: </label>'."<br>";
		echo '<div class="block">'.$erklaerung.'</div>';
		
			
		if ($ziel) {
  			echo '<label>Ziel: </label>'."<br>";
			echo '<div class="block">'.$ziel.'</div>';	    	
		}

		if ($wunsch) {
			echo '<label>Wunsch: </label>'."<br>";
			echo '<div class="block">'.$wunsch.'</div>';	    			
		}

		echo "<br>";
/*		       
        echo '<label>Projekt: </label>';
		$ProjektSelect="\n<select class=\"produktform\" name=\"projekt\" size=\"1\">\n";
        $ProjektSelect.=getProjekt()."\n";
        $ProjektSelect.="</select>\n";
			
		echo $ProjektSelect;
		echo "<br><br>";

		echo '<label>Projektart: </label>';
		$ProjektArtSelect="\n<select class=\"produktform\" name=\"projektart\" size=\"1\">\n";
        $ProjektArtSelect.=getProjektArt()."\n";
        $ProjektArtSelect.="</select>\n";
			
		echo $ProjektArtSelect;
		echo "<br><br>";
  	    
		echo '<label>Thema: </label>'; //echo '<input class="textform2" type="text" name="thema" placeholder="Thema" required /><br>';

 		$ThemaSelect="\n<select class=\"produktform\" name=\"thema\" size=\"1\">\n";
        $ThemaSelect.=getThema()."\n";
        $ThemaSelect.="</select>\n";
			
		echo $ThemaSelect;
		echo "<br><br>";

        echo '<label>Tags: </label><input class="textform2" type="text" name="tags" placeholder="Tag1, Tag2, Tag3" /><br>';
        echo "<br><br>";
			
		echo '<label>Priorit&auml;t: </label>';

		$PrioritaetSelect="\n<select class=\"produktform\" name=\"prioritaet\" size=\"1\">\n";
        $PrioritaetSelect.="<option value=\"5\">gelegentlich</option>\n";
		$PrioritaetSelect.="<option value=\"4\">gering</option>\n";
		$PrioritaetSelect.="<option value=\"3\" selected>mittel</option>\n";
		$PrioritaetSelect.="<option value=\"2\">hoch</option>\n";
		$PrioritaetSelect.="<option value=\"1\">sehr hoch</option>\n";
				//getAlleDomains()."\n";
        $PrioritaetSelect.="</select><br><br>\n";
			
		echo $PrioritaetSelect;
*/
		echo '<br><span style="text-align:center"><button type="text"><a href="../loesen">Problem l&ouml;sen</a></button></span><br>';

		echo '</fieldset>';
        echo "<br><br>\n";
        echo '<fieldset style="background:#cfcfcf; text-align:right; padding:10px; margin-right:10px;">';
		echo '  <button type="reset">Eingaben l&ouml;schen</button>';
        echo '  <button type="submit">Absenden</button>';
        echo '</fieldset>';
        echo '</form>';
        echo '</div>';
        echo '<br>';
        echo '<br>';
        echo '<br>';
        echo '<br>';
		
   	    echo '<script type="text/javascript">';
   	    echo "	CKEDITOR.replace('erklaerung');";
        echo "	CKEDITOR.replace('ziel');";
	    echo "	CKEDITOR.replace('wunsch');";
	    echo " </script>";

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

  
  
    /*****
		
 	hier sollten wir wohl mal dirngend aktiv werden!	
	27.05.21


	Das ANlegen von Projekten sollte wesentlich vereinfacht werden. 
	Überdies muss ein Projekt auch deaktiviert und reaktivierbar sein.


	******/
	
	
	else if ( $action == 'anlegen') {

		 include 'inc/header.php';
	

		 echo '<h1 style="background: darkslategray; color:white;
	             padding:20px; padding-left:120px; bottom:1px black solid;">zu erledigen - todo</h1>';
         echo '<div class="form" style="width:1050px; text-align:right; padding:10px; margin:10px auto auto auto;">

         <form method="post" action="eintragen" style="width:1000px; padding:10px; margin:10px;" class="artikelform">
           <fieldset style="background:#cfcfcf; width:950px; text-align:right; padding:10px; margin-right:10px;">
           <legend>ToDo erfassen</legend>';       

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
		  $ProjektSelect="\n<select class=\"produktform3\" name=\"projekt\" size=\"1\">\n";
          $ProjektSelect.=getProjekt()."\n";
          $ProjektSelect.="</select>\n";
		  /* Neuanlage eines Projektes */		
		  $ProjektSelect.="\n".'<a href="../projekt/anlegen">+</a>';
	
		  echo $ProjektSelect;
		  echo "<br>";
		  echo "<br>";
/*
		  echo '<label>Projektart: </label>';
		  $ProjektArtSelect="\n<select class=\"produktform3\" name=\"projektart\" size=\"1\">\n";
          $ProjektArtSelect.=getProjektArt()."\n";
          $ProjektArtSelect.="</select>\n";
			
		  echo $ProjektArtSelect;
		  echo "<br>";
  	    
		 echo '<label>Thema: </label>'; //echo '<input class="textform2" type="text" name="thema" placeholder="Thema" required /><br>';

 		  $ThemaSelect="\n<select class=\"produktform3\" name=\"thema\" size=\"1\">\n";
          $ThemaSelect.=getThema()."\n";
          $ThemaSelect.="</select>\n";
			
		  echo $ThemaSelect;
		  echo "<br>";

        echo '<label>Tags: </label><input class="textform2" type="text" name="tags" placeholder="Tag1, Tag2, Tag3" required /><br>';
        echo "<br>";
			*/
		echo '<label>Priorit&auml;t: </label>';

		$PrioritaetSelect="\n<select class=\"produktform3\" name=\"prioritaet\" size=\"1\">\n";
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
	 //$thema       	= $_POST['thema']; 
     //$tags       	= $_POST['tags'];     

	 $initial_id = isset($_POST['initial_id'])?$_POST['initial_id']:null;
	 $parent_id = isset($_POST['parent_id'])?$_POST['parent_id']:null;
	 $todo_id = isset($_POST['tid'])?:null;


	/*     echo '<pre>';
		var_dump($_POST);
        print_r($_POST);
        echo  '</pre>';
	*/

	 //echo $editor."<br><br>";
	 

          try {

			$a=isset($todo_id)?true:false;            
        
          	if (!$a) {    
   
   	      	//	$sql = "replace into todo set titel='".$headline."', erklaerung = '".$erklaerung."', ziel = '".$ziel."', wunsch = '".$wunsch."',
			// 	thema = ".$thema.", initial_id=0, parent_id=0, angelegt=NOW(), user_id=1, status='unerledigt'";

				$sql = "replace into todo set titel='".$headline."', erklaerung = '".$erklaerung."', ziel = '".$ziel."', wunsch = '".$wunsch."',
			 	initial_id=0, parent_id=0, angelegt=NOW(), user_id=1, status='unerledigt'";

				$sql2 = "update todo set initial_id=id, tid_md5=md5(id) order by id desc Limit 1;"; 
		  	}
			else {

			//	$sql = "replace into todo set titel='".$headline."', erklaerung = '".$erklaerung."', ziel = '".$ziel."', wunsch = '".$wunsch."',
			// 	thema = ".$thema.", initial_id=".$initial_id.", parent_id=".$parent_id.", angelegt=NOW(), user_id=1, status='unerledigt'";

				$sql = "replace into todo set titel='".$headline."', erklaerung = '".$erklaerung."', ziel = '".$ziel."', wunsch = '".$wunsch."',
			 	initial_id=".$initial_id.", parent_id=".$parent_id.", angelegt=NOW(), user_id=1, status='unerledigt'";
	

				$sql2 = "update todo set tid_md5=md5(id) order by id desc Limit 1;"; 


			}

		  		if (DEBUG) {
          			print $sql."<br>";
		  			die();
          		}
		  
	     		$db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          		$db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          		$db->beginTransaction();

		  	//	print $sql."<br>";

		  		$db->query($sql);
		
          		//$sql = "update todo set initial_id=id, tid_md5=md5(id) order by id desc Limit 1;"; 
		  		

				


				$db->query($sql2);
		  	//	print $sql."<br>";

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
           
          //die('im EInsatz seit 05.05.2021');
          
				   
		  $oLAkt = new LetzteAktivitaet();
		
		     
  	       $oLAkt -> writeLetzteAktivitaet( "todo - eingetragen", "Ich kann das komplette SQL Statement nicht hier eintragen, aber dies wird 
in die LogDatei eingetragen.", 1, "Rainer", 1, "todo");	 
			//die('im EInsatz seit 05.05.2021');

          header('location:../uebersicht');





	}

	else if ( $action == 'sichtbar') {
		//echo "noch zu implementieren";

		  try {
		  //einfacher Switch	
          $sql = "update `todo` Set `sichtbar`=(`sichtbar`-1)*-1 where `tid_md5`='".$id."';";

        //  print $sql."<br>";

          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $db->query($sql);
          $db=null;
         // echo "<br>".$sql."<br>";
         // die();
          }
          catch(PDOException $e){
              print "<br>".$e->getMessage();
          }
         //die();
          header('location:../zeigeAlleAufgaben') ;
	}

    else if ( $action == 'loeschbar') {
		//echo "noch zu implementieren";
		try {
		  // einfacher Switch	
          $sql = "update `todo` Set `geloescht`=(`geloescht`-1)*-1 where `tid_md5`='".$id."';";

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
          header('location:../zeigeAlleAufgaben') ;

	}

	else if ( $action == 'geloest') {
		//echo "noch zu implementieren";
		try {
		  // einfacher Switch	
          $sql = "update `todo` Set `erledigt`=NOW(), aktiv=0  where `tid_md5`='".$id."';";

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
          header('location:../zeigeAlleAufgaben') ;

	}


	else if ( $action == 'loesen') {
		echo "noch zu implementieren";
		echo "<br> mglw. in separaten Controller auslagern<br>";
	}
	

}
