<?php

		$url = htmlentities($_POST['url']);
		$kurzbeschreibung = htmlentities($_POST['kurzbeschreibung']);
		$fehler = htmlentities($_POST['fehler']);
		// echo "<br />".$fehler."<br />";
		 
		$status = isset($_POST['status'])?$_POST['status']:'unerledigt';
		$ziel = htmlentities($_POST['ziel']);
		$wunsch = htmlentities($_POST['wunsch']);
		//$projekt = intval(htmlentities($_POST['projekt']));
		$projekt = isset($_POST['projekt'])?$_POST['projekt']:'';
		$prio = intval(htmlentities($_POST['prio']));
		
		// parent_id
		// initial_id
		$parentid = isset($_POST['paid'])?$_POST['paid']:'';
		$initialid = isset($_POST['inid'])?$_POST['inid']:'';
		$fid = isset($_POST['fid'])?$_POST['fid']:'';

		if (DEBUG) {
		  echo '<div class="mittig fehlerbox">';
			echo "<br />".$kurzbeschreibung;
			echo "<br />fehler ".$fehler;
			echo "<br />status ".$status;
			echo "<br />PROJEKT ID ".$projekt;
			echo "<br />".$parentid;
			echo "<br />".$fid;
			echo "<br />".$initialid;
			echo "<br /></div>";
			//die();
		 }
		
		
		
		/*
		 * handelt es sich um ein Update, dann existiert eine ID
		 * Ist die leer, dann ist es ein Neueintrag
		 *
		 * Ich bin im Moment überfragt, ob das schon auf die
		 * History Funktion umgestellt wurde
		 *
		 */

		


		// Request in DB schreiben
		// if (DEBUG) $oZeit->sessionschreiben($userid);



		$timestamp=time();
		$datum = date('Y-m-d  H:i:s',$timestamp);
		//$datum = date('y-m-d',$timestamp);
		//echo $datum;


		$userid	=	isset($_SESSION["user_id"])?intval($_SESSION["user_id"]):1;
		if (DEBUG) echo "Priorität: $prio<br>";




		if ($fid=='') {
			//$status	=	"unerledigt";
			$neuerFehler = new Fehler(1);
			if (DEBUG) echo "AddFehler im Moment noch fehlerhaft <br>";	
			$neuerFehler->addFehler(  $kurzbeschreibung, $fehler,  $prio, $status, $userid, $projekt, $url, $initialid, $parentid );
			$newID = $neuerFehler->getLastInsert();
			$ausgabestring = 'Datensatz erfolgreich angelegt';
		}
		else {
			$oFehler = new Fehler($fid);
			
			
			try {
			   //$oFehler->updateFehler($fid,$kurzbeschreibung,$fehler, $ziel,$wunsch,$prio,$status,$url, $projekt, $initialid, $parentid);
			   //$Id, $Titel, $Erklaerung,  $Prioritaet, $Status, $user_id, $Url, $Projekt, $InitalId, $parentId)
			   $oFehler->updateFehler($fid,$kurzbeschreibung,$fehler,$prio,$status,$userid,$url,$projekt,$initialid, $parentid);
			   // setze kurz noch erledigt
				if ($status=='erledigt') $oFehler->setErledigt($initialid);
			   $ausgabestring = 'Änderungen erfolgreich eingetragen.';
			} catch (Exception $e) {
				echo "FEHLER: ".$e;
				die();
			}
			
			
			
		}


			
		echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="style2.css" />
   	<meta http-equiv="refresh" content="1; URL=../fehler/uebersicht">    
   	
   	<center><h1>'.$ausgabestring.'</h1></center>';

	