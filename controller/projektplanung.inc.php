

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

    else if ( $action == 'zeigeprojektplanung') {
      
	 	include 'inc/header.php';
	
		echo "<a href=\"../anlegen/$id\">anlegen</a>";
	
		$projekt_id = $id;

  		try {
		
     /*   
        $sql = "SELECT `laufendenummer`,`bezeichnung`,`beschreibung`,`sachstand`,`termin`,`verantwortlich`,`beteiligte_mitarbeiter`,
			    `risiko`,`kategorie`,`angelegt`,`status`,`prioritaet` 
				  FROM `aktivitaetenliste` 
				  WHERE `aktivitaet_id` in (select max(`aktivitaet_id`) from `aktivitaetenliste` group by initial_id) 
				  and `pid_md5` = $id;";
    */

		if (DEBUG) echo "<br>".$sql."<br>";
       
	 
          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
          $rueckgabe = $db->query($sql);
          
		  $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
	        
	        
	      if ($ergebnis!=null){  
	        echo "<table  style=\"background:#777;padding:4px;border:1px;\"   cellpadding=\"6\" cellspacing=\"1\">";
	        echo '<tr style="padding:8px;"><th colspan=3 style="font-family: Fira ;color:#ddd">Speisekomponenten f&uuml;r Rezepte</th></tr>';
	        echo "<tr  style=\"padding:8px;\"><td style=\"background:darkgrey;a color:orange;width:350px;\" class=\"odd\">
            Bezeichnung
            </td>
            <td style=\"background:darkgrey;a color:orange;width:350px;\" class=\"odd\">Beschreibung</td>
		    <td style=\"background:darkgrey;a color:orange;width:80px;\" class=\"odd\">Zubereitungsart</td>
			<td style=\"background:darkgrey;a color:orange;width:20px;\" class=\"odd\">A</td>
			<td style=\"background:darkgrey;a color:orange;width:20px;\" class=\"odd\">L</td>
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

				$color = $inhalt['aktiv'] == 1?'green':'red';
             	echo "<td style=\"background:".$color.";a::link,a::hover { text-decoration: none; color: white; };width:50px;\" class=\"tdhersteller\">";
             	echo "<small><a href=\"aktiv/".$speisekomponente_id."\">AK</a></small>";
             	echo "</td>";
             
            	 $color = $inhalt['loeschbar'] == 0?'green':'red';
             	echo "<td style=\"background:".$color.";a::link,a::hover { text-decoration: none; color: white; };width:50px;\" class=\"tdhersteller\">";
             	echo "<small><a href=\"loeschbar/".$speisekomponente_id."\">L&Ouml;</a></small>";
             	echo "</td>";


				echo "</tr>";
	        }

		  }
		  else {
				echo "<br><br>Es sind keine Eintr&auml;ge vorhanden!<br><br>";
		  }
	        
	    }
	    catch(PDOException $e){
	        print $e->getMessage();
	    }
	    echo "</table>";
	    $db=null;
	    
        echo "<br><a href=\"../anlegen/$id\">neuen Eintrag anlegen</a><br>";
      

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
	
	
/****

CREATE TABLE `aktivitaetenliste` (
  `aktivitaet_id` int(11) NOT NULL,
  `initial_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `laufendenummer` int(3) NOT NULL,
  `bezeichnung` varchar(255) NOT NULL,
  `beschreibung` text,
  `sachstand` text, 
  `termin` datetime,
  `verantwortlich` int(11) NOT NULL, -- <-> Hilfstabelle <-> Mitarbeiter
  `beteiligte_mitarbeiter` int(11) NOT NULL, <-> Hilfstabelle <-> Mitarbeiter
  `risiko` text,
  `kategorie` varchar(10), -- PL=Projektlenkung / A=Aktivität
  `projekt_id` int(11),
  `teilprojekt_id` int(11),
  -- Meta
  `angelegt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status`  varchar(100) NOT NULL DEFAULT 'offen',
  `prioritaet` varchar(100) NOT NULL DEFAULT 'normal',
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

ermittle, ob schon Aktivität vorhanden ist, lies die laufende Nummer und inkrementiere den Wert.

***/



	// die Projekt_id wird als PArameter mit übergeben.
	// es wird die letzte laufende Nummer der Aktivitätenliste benötigt
	else if ( $action == 'anlegen') {

		 include 'inc/header.php';
		
		 $laufendeAktivitaetenNummer = getLaufendeAktivitaetenNummer($id)+1;
	

		 echo '<h1 style="background:darkslategray; color:black;
	             padding:20px; padding-left:120px; bottom:1px black solid;">Projektplanung</h1>';
         echo '<div class="form" style="width:1050px; text-align:right; padding:10px; margin:10px auto auto auto;">

         <form method="post" action="eintragen" style="width:1000px; padding:10px; margin:10px;" class="artikelform">';
           echo '<input type="hidden" name="projektId" value="'.$id.'">';
		   echo '<input type="hidden" name="laufendeNummer" value="'.$laufendeAktivitaetenNummer.'">';
           echo '<fieldset style="background:#cfcfcf; width:950px; text-align:right; padding:10px; margin-right:10px;">
           <legend>Aktivit&auml;t erfassen</legend>';       

         echo '<label>&Uuml;berschrift: </label><input class="textform eyecatch" type="text" name="bezeichnung" placeholder="Bezeichnung" required /><br>';
/*        
`titel` varchar(250) DEFAULT '',
  `erklaerung` text,
  `ziel` text,
  `wunsch` text,
*/
      
         echo '<label>Beschreibung: </label>'."<br>";
	     echo "<textarea id='beschreibung' name='beschreibung'></textarea>";
			
  		 echo '<label>Sachstand: </label>'."<br>";
	     echo "<textarea id='sachstand' name='sachstand'></textarea>";

		// Termin
		echo '<label>Termin: </label>'; //."<br>";
		echo '<input class="textform eyecatch" type="date" name="termin" placeholder="dd.mm.YYYY" required /><br>';

		// verantwortliche Mitarbeiter (Select)
		echo '<label>MA verantwortlich: </label>'; //."<br>";
		echo '<input class="textform eyecatch" type="text" name="verantwortlich" placeholder="verantwortlich" required /><br>';

		// beteiligte Mitarbeiter	(Select)
		echo '<label>MA beteiligt: </label>'; //."<br>";
		echo '<input class="textform eyecatch" type="text" name="beteiligt" placeholder="beteiligt" required /><br>';
	
		


		 echo '<label>Risiko: </label>'."<br>";
	     echo "<textarea id='risiko' name='risiko'></textarea>";		

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



  	    
		// echo '<label>Thema: </label><input class="textform2" type="text" name="thema" placeholder="Thema" required /><br>';
        // echo '<label>Tags: </label><input class="textform2" type="text" name="tags" placeholder="Tag1, Tag2, Tag3" required /><br>';
         
         echo "<br>\n";
		 echo '<label>Status:&nbsp;</label>';
		 $StatusSelect="\n<select class=\"produktform\" name=\"status\" size=\"1\">\n";
         $StatusSelect.="<option value=\"1\" selected>offen</option>\n";
		 $StatusSelect.="<option value=\"2\">in Bearbeitung</option>\n";
		 $StatusSelect.="<option value=\"3\">umgesetzt</option>\n";
		 $StatusSelect.="<option value=\"4\">verschoben</option>\n";
		 $StatusSelect.="<option value=\"5\">zur&uuml;ck gewiesen</option>\n";
         $StatusSelect.="</select>\n";			
		 echo $StatusSelect;

		// Prioritaet
		 echo "<br><br>\n";
		 echo '<label>Priorit&auml;t:&nbsp;</label>';		
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
   	echo "	CKEDITOR.replace('beschreibung');";
    echo "	CKEDITOR.replace('sachstand');";
	echo "	CKEDITOR.replace('risiko');";
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




CREATE TABLE `aktivitaetenliste` (
  `aktivitaet_id` int(11) NOT NULL,
  `initial_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `laufendenummer` int(3) NOT NULL,
  `bezeichnung` varchar(255) NOT NULL,
  `beschreibung` text,
  `sachstand` text, 
  `termin` datetime,
  `verantwortlich` int(11) NOT NULL, -- <-> Hilfstabelle <-> Mitarbeiter
  `beteiligte_mitarbeiter` int(11) NOT NULL, <-> Hilfstabelle <-> Mitarbeiter
  `risiko` text,
  `kategorie` varchar(10), -- PL=Projektlenkung / A=Aktivität
  `projekt_id` int(11),
  `teilprojekt_id` int(11),
  -- Meta
  `angelegt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status`  varchar(100) NOT NULL DEFAULT 'offen',
  `prioritaet` varchar(100) NOT NULL DEFAULT 'normal',


		
	**/ 

	else if ( $action == 'eintragen') {
	
	 $laufendeNummer 	= isset($_POST['laufendeNummer'])?$_POST['laufendeNummer']:1;
	 $projekt_id 	 	= 3;// $_POST['projektId'];

	 $bezeichnung 		= $_POST['bezeichnung'];
	 $beschreibung 		= $_POST['beschreibung'];
	 $sachstand 		= $_POST['sachstand'];
	 $termin 			= $_POST['termin'];
	 $verantwortlich 	= $_POST['verantwortlich'];
	 $beteiligt 		= $_POST['beteiligt']; 
	 $risiko        	= $_POST['risiko'];
	 $kategorie       	= $_POST['kategorie'];
	 $status        	= $_POST['status'];
	 $prioritaet    	= $_POST['prioritaet'];
	 	

	/*     echo '<pre>';
		var_dump($_POST);
        print_r($_POST);
        echo  '</pre>';
	*/

	 echo "TERMIN: ".$termin."<br><br>";
	 

          try {

                    
              
   
   	      $sql = "replace into aktivitaetenliste set laufendeNummer=".$laufendeNummer.", projekt_id = ".$projekt_id.", bezeichnung = '".$bezeichnung."',
				   beschreibung='".$beschreibung."', sachstand = '".$sachstand."', termin = '".$termin."', verantwortlich = '".$verantwortlich."',beteiligte_mitarbeiter = '".$beteiligt."',
				   risiko = '".$risiko."', kategorie = '".$kategorie."' ,status = '".$status."',prioritaet = '".$prioritaet."'";

		  print $sql."<br><br><br>";

		  if (DEBUG) {
          	print $sql."<br>";
		  	die();
          }
		  
	      $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $db->beginTransaction();

		  $db->query($sql);
		
          $sql = "update aktivitaetenliste  set initial_id=aktivitaet_id order by aktivitaet_id desc Limit 1;"; 
  		  print $sql."<br><br><br>";

		  $db->query($sql);
		
		  // Transaktion abschliessen	
		  $db->commit();	
          $db=null;

          }
          catch(PDOException $e){
              print "<br>".$e->getMessage();
          }


 		  // getArtikelInitialId	
           
          die();
          

          header('location:../uebersicht');





	}

	else if ( $action == 'aktiv') {
	
	}

    else if ( $action == 'loeschbar') {
	
	}

}
