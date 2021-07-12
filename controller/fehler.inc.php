<?php


session_start();


require_once './inc/global_config.inc.php';
/***
 *
 * Fehler
 *  - anlegen, (add)
 *  - aendern
 *  - loeschen,
 *  - sichtbarkeit
 *
 *  erledigt - class =\"red\"
 *  
 *  nur ein Test 
 */




// testhalber die Übersicht
function doAction( $action = '0', $id='0', $von=0, $lim=0, $order='desc' ) {

	//echo "ACTION= ".$action;
	// einfache Übersicht Seite 1
	if ($action == '0' || $action == 'uebersicht' ) {

		include 'inc/header.php';

		//$projekt_md5=isset($_GET['projekt'])?md5($_GET['projekt']):'';

		/*
		 * Die id übernimmt hier die AUswahl des Projektes
		 */

		$projekt_md5 = $id;

		if ($projekt_md5 != '') {
			$oProjekt = new Projekt();
			$oProjekt->getMd5Projekt($projekt_md5);
			$projektid=$oProjekt->getProjektId($id);

		}
		else 
		  $projektid='';
		// Vorbereitung für eine weitere Auswahlmöglichkeit
		$wahlstring='';

		$userid = $_SESSION["user_id"];

		/*$pid = isset($_GET['pid'])?intval($_GET['pid']):0;
		 $von = isset($_GET['von'])?intval($_GET['von']):0;
		 $lim = isset($_GET['lim'])?intval($_GET['lim']):30;

		 $order = isset($_GET['order'])?$_GET['order']:'desc';*/
		$gegenorder = $order=='desc'?'asc':'desc';

		$lim = 30;
		$oFehler = new Fehler(1);
		$alleFehler = array();

		$anzahlEintraege = $oFehler->getCountEntries($wahlstring);
		
		if($projektid=='') {
			$alleFehler = $oFehler->getAlleFehler( $von, $lim, $order );
		}
		else {
			$alleFehler =	$oFehler->getProjektFehler($projektid, $von, $lim, $order );
		}
		
	
		
		$weiter = $anzahlEintraege >($von+$lim)? $von+$lim: $anzahlEintraege;
		$zurueck= ($von-$lim)<0?0:($von-$lim) ;
		
		//$ende=$anzahlEintraege-$lim;
		$letzteSeiteAnzahleintraege=($anzahlEintraege%$lim);
		$ende =$anzahlEintraege-$letzteSeiteAnzahleintraege;
		// Anzahl Schleifendurchläufe

		$aktuelleseite = ceil($von/$lim);
		
		if (sizeOf($alleFehler)<($lim*13)) $lim = sizeOf($alleFehler)/13;

		
		
		
		$zeile=1;

		//echo sizeOf($alleFehler)." ".$alleFehler[1];

		if (sizeOf($alleFehler)==0 ) {

			echo 'keine Einträge gefunden.';
			include('inc/footer.php');
			die();
		}
		//echo "<ul>";
		echo '<br /><a href="'.PFAD.'/'.APPNAME.'/fehler/neu">neuen Eintrag erstellen</a>&nbsp;<a href="'.PFAD.'/'.APPNAME.'/todo/uebersicht/">TODO</a><br />';
		echo '<table class="tabelleprojektuebersicht" cellspacing="0">'."\n";
		echo '<tr class="paging">'."\n".'<th style="text-align:center;" colspan="2">';
		if ($von > 2) {
			echo '<a href="'.PFAD.'/'.APPNAME.'/fehler/uebersicht/0/'.$lim.'/'.$gegenorder.'"><<<</a>';
		}
		if ($von > 1) {
			echo '&nbsp;<a href="'.PFAD.'/'.APPNAME.'/fehler/uebersicht/'.$zurueck.'/'.$lim.'/'.$gegenorder.'"><<</a>';
		}
		
		echo '&nbsp; &nbsp; &nbsp;'.($von/$lim).' &nbsp; &nbsp; &nbsp;
		<a href="'.PFAD.'/'.APPNAME.'/fehler/uebersicht/'.$weiter.'/'.$lim.'/'.$gegenorder.'">>></a>
		<a href="'.PFAD.'/'.APPNAME.'/fehler/uebersicht/'.$ende.'/'.$lim.'/'.$gegenorder.'">>>></a>
		</th>'."\n".'<th>
		
		<a href="'.PFAD.'/'.APPNAME.'/fehler/uebersicht/'.$von.'/'.$lim.'/'.$gegenorder.'">'.$order.'</a>
		</th></tr>'."\n";
		//foreach ($alleFehler as $data)
		//{
		for ($i = 0; $i < $lim*13; $i=$i+13 )
		{
			if ($zeile%2 == 0) {
				$style = FEHLERSTYLE1;
			}
			else
			$style = FEHLERSTYLE2;

			//echo "<div id=\"\" >""
			//echo "<li style=\"".$style."\">".$zeile.". <a href=fehlerdetail.php?id=".$alleFehler[$i].">".$alleFehler[$i+2]."</a>(".$alleFehler[$i+5].")</li>";
			echo "<tr style=\"".$style."\"><td class=\"tabletdnumber\">".$zeile.". </td>
 			<td class=\"tabletd\">\n<a href=\"".PFAD."/".APPNAME."/fehler/detail/".md5($alleFehler[$i])."\">";
			if ($projekt_md5=='') echo "<small>".$alleFehler[$i+10]."</small> - ";
			echo $alleFehler[$i+1]."</a>\n</td>\n <td class=\"tabletd_fehler\">(".$alleFehler[$i+5].")
			</td>
			<td class=\"tabletdnumber\"><a href=\"".PFAD."/".APPNAME."/fehler/sichtbar/".md5($alleFehler[$i])."\">S</a></td>
			<td class=\"tabletdnumber\"><a href=\"".PFAD."/".APPNAME."/fehler/loeschen/".md5($alleFehler[$i])."\">L</a></td>
			</tr>\n<tr>";


			//echo ' <div class="number">'.$zeile.'</div>';
			//echo ' <div class="fehleruebersicht"><a href=fehlerdetail.php?id=".$alleFehler[$i].">".$alleFehler[$i+2]."</a></div>'


			++$zeile;

		}
		//echo "</ul>";
		echo "</table><br />";
		
		echo '<a href="'.PFAD.'/'.APPNAME.'/todo/uebersicht/">TODO</a>';
		






	}
	
	
	elseif ( $action == '7tage' ) {
	
		include 'inc/header.php';

		//$projekt_md5=isset($_GET['projekt'])?md5($_GET['projekt']):'';

		/*
		 * Die id übernimmt hier die AUswahl des Projektes
		 */

		$projekt_md5 = $id;

		if ($projekt_md5 != '') {
			$oProjekt = new Projekt();
			$oProjekt->getMd5Projekt($projekt_md5);
			$projektid=$oProjekt->getProjektId($id);

		}

		$userid = $_SESSION["user_id"];

	
		$gegenorder = $order=='desc'?'asc':'desc';

		$lim = 30;
		$oFehler = new Fehler(1);
		$alleFehler = array();

		$anzahlEintraege = $oFehler->getCountEntries();
		
		if($projektid=='') {
			$alleFehler = $oFehler->getAlleFehler7Tage( $von, $lim, $order );
		}
		else {
			$alleFehler =	$oFehler->getProjektFehler($projektid, $von, $lim, $order );
		}
		
	
		
		$weiter = $anzahlEintraege >($von+$lim)? $von+$lim: $anzahlEintraege;
		$zurueck= ($von-$lim)<0?0:($von-$lim) ;
		
		//$ende=$anzahlEintraege-$lim;
		$letzteSeiteAnzahleintraege=($anzahlEintraege%$lim);
		$ende =$anzahlEintraege-$letzteSeiteAnzahleintraege;
		// Anzahl Schleifendurchläufe

		$aktuelleseite = ceil($von/$lim);
		
		if (sizeOf($alleFehler)<($lim*13)) $lim = sizeOf($alleFehler)/13;

		
		
		
		$zeile=1;

		//echo sizeOf($alleFehler)." ".$alleFehler[1];

		if (sizeOf($alleFehler)==0 ) {

			echo 'keine Einträge gefunden.';
			include('inc/footer.php');
			die();
		}
		//echo "<ul>";
		echo '<br /><a href="'.PFAD.'/'.APPNAME.'/fehler/neu">neuen Eintrag erstellen</a><br />';
		echo '<table class="tabelleprojektuebersicht" cellspacing="0">'."\n";
		echo '<tr class="paging">'."\n".'<th style="text-align:center;" colspan="2">';
		if ($von > 2) {
			echo '<a href="'.PFAD.'/'.APPNAME.'/fehler/uebersicht/0/'.$lim.'/'.$gegenorder.'"><<<</a>';
		}
		if ($von > 1) {
			echo '&nbsp;<a href="'.PFAD.'/'.APPNAME.'/fehler/uebersicht/'.$zurueck.'/'.$lim.'/'.$gegenorder.'"><<</a>';
		}
		
		echo '&nbsp; &nbsp; &nbsp;'.($von/$lim).' &nbsp; &nbsp; &nbsp;
		<a href="'.PFAD.'/'.APPNAME.'/fehler/uebersicht/'.$weiter.'/'.$lim.'/'.$gegenorder.'">>></a>
		<a href="'.PFAD.'/'.APPNAME.'/fehler/uebersicht/'.$ende.'/'.$lim.'/'.$gegenorder.'">>>></a>
		</th>'."\n".'<th>
		
		<a href="'.PFAD.'/'.APPNAME.'/fehler/uebersicht/'.$von.'/'.$lim.'/'.$gegenorder.'">'.$order.'</a>
		</th></tr>'."\n";
		//foreach ($alleFehler as $data)
		//{
		for ($i = 0; $i < $lim*13; $i=$i+13 )
		{
			if ($zeile%2 == 0) {
				$style = FEHLERSTYLE1;
			}
			else
			$style = FEHLERSTYLE2;

			//echo "<div id=\"\" >""
			//echo "<li style=\"".$style."\">".$zeile.". <a href=fehlerdetail.php?id=".$alleFehler[$i].">".$alleFehler[$i+2]."</a>(".$alleFehler[$i+5].")</li>";
			echo "<tr style=\"".$style."\"><td class=\"tabletdnumber\">".$zeile.". </td>
 			<td class=\"tabletd\">\n<a href=\"".PFAD."/".APPNAME."/fehler/detail/".md5($alleFehler[$i])."\">";
			if ($projekt_md5=='') echo "<small>".$alleFehler[$i+10]."</small> - ";
			echo $alleFehler[$i+1]."</a>\n</td>\n <td class=\"tabletd_fehler\">(".$alleFehler[$i+5].")
			</td>
			<td class=\"tabletdnumber\"><a href=\"".PFAD."/".APPNAME."/fehler/sichtbar/".md5($alleFehler[$i])."\">S</a></td>
			<td class=\"tabletdnumber\"><a href=\"".PFAD."/".APPNAME."/fehler/loeschen/".md5($alleFehler[$i])."\">L</a></td>
			</tr>\n<tr>";


			//echo ' <div class="number">'.$zeile.'</div>';
			//echo ' <div class="fehleruebersicht"><a href=fehlerdetail.php?id=".$alleFehler[$i].">".$alleFehler[$i+2]."</a></div>'


			++$zeile;

		}
		//echo "</ul>";
		echo "</table>";







	}
	
    elseif ( $action == 'erledigt' ) {
	
		include 'inc/header.php';

		//$projekt_md5=isset($_GET['projekt'])?md5($_GET['projekt']):'';

		/*
		 * Die id übernimmt hier die AUswahl des Projektes
		 */

		$projekt_md5 = $id;

		if ($projekt_md5 != '') {
			$oProjekt = new Projekt();
			$oProjekt->getMd5Projekt($projekt_md5);
			$projektid=$oProjekt->getProjektId($id);

		}

		$userid = $_SESSION["user_id"];

	
		$gegenorder = $order=='desc'?'asc':'desc';

		$lim = 30;
		$oFehler = new Fehler(1);
		$alleFehler = array();

		$anzahlEintraege = $oFehler->getCountEntries();
		
		if($projektid=='') {
			$alleFehler = $oFehler->getAlleFehlerErledigt( $von, $lim, $order );
		}
		else {
			$alleFehler =	$oFehler->getProjektFehler($projektid, $von, $lim, $order );
		}
		
	
		
		$weiter = $anzahlEintraege >($von+$lim)? $von+$lim: $anzahlEintraege;
		$zurueck= ($von-$lim)<0?0:($von-$lim) ;
		
		//$ende=$anzahlEintraege-$lim;
		$letzteSeiteAnzahleintraege=($anzahlEintraege%$lim);
		$ende =$anzahlEintraege-$letzteSeiteAnzahleintraege;
		// Anzahl Schleifendurchläufe

		$aktuelleseite = ceil($von/$lim);
		
		if (sizeOf($alleFehler)<($lim*13)) $lim = sizeOf($alleFehler)/13;

		
		
		
		$zeile=1;

		//echo sizeOf($alleFehler)." ".$alleFehler[1];

		if (sizeOf($alleFehler)==0 ) {

			echo 'keine Einträge gefunden.';
			include('inc/footer.php');
			die();
		}
		//echo "<ul>";
		echo '<br /><a href="'.PFAD.'/'.APPNAME.'/fehler/neu">neuen Eintrag erstellen</a><br />';
		echo '<table class="tabelleprojektuebersicht" cellspacing="0">'."\n";
		echo '<tr class="paging">'."\n".'<th style="text-align:center;" colspan="2">';
		if ($von > 2) {
			echo '<a href="'.PFAD.'/'.APPNAME.'/fehler/uebersicht/0/'.$lim.'/'.$gegenorder.'"><<<</a>';
		}
		if ($von > 1) {
			echo '&nbsp;<a href="'.PFAD.'/'.APPNAME.'/fehler/uebersicht/'.$zurueck.'/'.$lim.'/'.$gegenorder.'"><<</a>';
		}
		
		echo '&nbsp; &nbsp; &nbsp;'.($von/$lim).' &nbsp; &nbsp; &nbsp;
		<a href="'.PFAD.'/'.APPNAME.'/fehler/uebersicht/'.$weiter.'/'.$lim.'/'.$gegenorder.'">>></a>
		<a href="'.PFAD.'/'.APPNAME.'/fehler/uebersicht/'.$ende.'/'.$lim.'/'.$gegenorder.'">>>></a>
		</th>'."\n".'<th>
		
		<a href="'.PFAD.'/'.APPNAME.'/fehler/uebersicht/'.$von.'/'.$lim.'/'.$gegenorder.'">'.$order.'</a>
		</th></tr>'."\n";
		//foreach ($alleFehler as $data)
		//{
		for ($i = 0; $i < $lim*13; $i=$i+13 )
		{
			if ($zeile%2 == 0) {
				$style = FEHLERSTYLE1;
			}
			else
			$style = FEHLERSTYLE2;

			//echo "<div id=\"\" >""
			//echo "<li style=\"".$style."\">".$zeile.". <a href=fehlerdetail.php?id=".$alleFehler[$i].">".$alleFehler[$i+2]."</a>(".$alleFehler[$i+5].")</li>";
			echo "<tr style=\"".$style."\"><td class=\"tabletdnumber\">".$zeile.". </td>
 			<td class=\"tabletd\">\n<a class=\"green\" href=\"".PFAD."/".APPNAME."/fehler/detail/".md5($alleFehler[$i])."\">";
			if ($projekt_md5=='') echo "<small>".$alleFehler[$i+10]."</small> - ";
			echo $alleFehler[$i+1]."</a>\n</td>\n <td class=\"tabletd_fehler\">(".$alleFehler[$i+5].")
			</td>
			<td class=\"tabletdnumber\"><a href=\"".PFAD."/".APPNAME."/fehler/sichtbar/".md5($alleFehler[$i])."\">S</a></td>
			<td class=\"tabletdnumber\"><a href=\"".PFAD."/".APPNAME."/fehler/loeschen/".md5($alleFehler[$i])."\">L</a></td>
			</tr>\n<tr>";


			//echo ' <div class="number">'.$zeile.'</div>';
			//echo ' <div class="fehleruebersicht"><a href=fehlerdetail.php?id=".$alleFehler[$i].">".$alleFehler[$i+2]."</a></div>'


			++$zeile;

		}
		//echo "</ul>";
		echo "</table>";







	}

	elseif ( $action == 'neu' ) {

		include 'inc/header_neu.php';
		
		echo'<br>
<br><!--
<form enctype="multipart/form-data" method="post" class="body" action="fehler/eintragen" accept-charset="UTF-8"> -->
<form  title="das Fehlerformular" name="fehlerformular" action="eintragen" method="post">
<Table>
<tr>
<td align="right">Betrifft das Projekt:</td>
<td>';

		$oProjekt = new Projekt(1);
		$oProjekt->Projekteausgeben();
		echo '<a href="'.PFAD.'/'.APPNAME.'/projekt/uebersicht" title="Link noch zu ändern !!! Projektübersicht - Neues anlegen !"><b>+</b></a></td>
</tr>

<tr>
<td align="right">Url:</td>
<td><input title="in Adressleiste <strg a>, <strg c>, dann hierher und <strg v>" name="url" type="text" size="30"/></td>
</tr>

<tr>
<td align="right">Fehler Kurzbeschreibung:</td>
<td><input title="Kurz und Knackig das Problem kennzeichen" name="kurzbeschreibung" type="text" size="30"/></td>
</tr>

<tr>
<td align="right">Fehler Gesamtbeschreibung:</td>
<td><textarea title="Was passiert genau, wenn was gemacht wurde. Gibt es eine Fehlerausgabe (Code)" name="fehler" cols="45" rows="10"></textarea></td>
</tr>

<!-- hier bietet es sich den wysiwygEditor einzusetzen -->
<!-- Gets replaced with TinyMCE, remember HTML in a textarea should be encoded 
	<textarea id="elm1" name="elm1" rows="15" cols="80" style="width: 80%">
		&lt;p&gt;
		&lt;img src="media/logo.jpg" alt=" " hspace="5" vspace="5" width="250" height="48" align="right" /&gt;	TinyMCE is a platform independent web based Javascript HTML &lt;strong&gt;WYSIWYG&lt;/strong&gt; editor control released as Open Source under LGPL by Moxiecode Systems AB. It has the ability to convert HTML TEXTAREA fields or other HTML elements to editor instances. TinyMCE is very easy to integrate into other Content Management Systems.
		&lt;/p&gt;
		&lt;p&gt;
		We recommend &lt;a href="http://www.getfirefox.com" target="_blank"&gt;Firefox&lt;/a&gt; and &lt;a href="http://www.google.com" target="_blank"&gt;Google&lt;/a&gt; &lt;br /&gt;
		&lt;/p&gt;
	</textarea>
-->
<!-- 
<tr>
<td align="right">Ziel Beschreibung:</td>
<td><textarea  title="Was genau soll erreicht werden. Je genauer die Beschreibung desto einfacher die Lösungsansätze" name="ziel" cols="45=" rows="10"></textarea></td>
</tr>
<tr>
<td align="right">Wunsch Beschreibung:</td>
<td><textarea title="Was wäre wünschenswert aber nicht zwingend notwendig" name="wunsch" cols="45" rows="10"></textarea></td>
</tr>
<tr> -->
<tr>
<td align="right">Priorität:</td>
<td><select name="prio" id="prioritaet" title="Hier die Priorität festlegen (Nicht jedes Problem muss sofort erledigt werden !)">
	<option value="1">Sofort erledigen</option>
	<option value="2">hoch</option>
	<option selected value="3">mittel</option>
	<option value="4">bei Gelegenheit</option>
	</select>
</td>
</tr>
<tr>
<td></td>
<td><input name="abschicken" type="submit" value="abschicken" /></td>
</tr>


</Table>
</form>

<br />';


	}
	/**
	 *
	 * // eintragen  evtl auch Kombination mit Änderung eintragen
	 *
	 *
	 */


	elseif ( $action == 'eintragen' ) {


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
		//if (DEBUG) $oZeit->sessionschreiben($userid);



		$timestamp=time();
		$datum = date('Y-m-d  H:i:s',$timestamp);
		//$datum = date('y-m-d',$timestamp);
		//echo $datum;


		$userid	=	intval($_SESSION["user_id"]);
		//echo "Priorität: $prio<br>";




		if ($fid=='') {
			//$status	=	"unerledigt";
			$neuerFehler = new Fehler(1);
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

	}


	/************************************************************
	 *
	 * Fehlerdetail
	 *
	 * hier werden die Details des Fehlers dargestellt
	 *
	 ************************************************************/


	elseif ( $action == 'detail' ) {

		/*
		 $pid = isset($_GET['pid'])?intval($_GET['pid']):0;
		 $von = isset($_GET['von'])?intval($_GET['von']):0;
		 $lim = isset($_GET['lim'])?intval($_GET['lim']):30;
		 */
		$userid = $_SESSION["user_id"];
		//echo "USERID: .$userid";
		// Das scheint so nicht ausreichend
		if (!$userid || $userid > 1)
		{
			echo "<br /><br /><br /><center><h2>Sie sind nicht eingeloggt.</h2><br />";
			echo "<a href=\"index.php\">Klicken Sie hier um sich einzuloggen</a></center>";
			//echo "User ID:".$userid;
			die();
		}

		include 'inc/header_editor.php';
		
		
		$fehlerid = $id;
		//=isset($_GET['id'])?$_GET['id']:'854d6fae5ee42911677c739ee1734486';

		if (DEBUG) {
			echo "<h3>".$fehlerid."</h3>";
		}
		// Request in DB schreiben
		//if (DEBUG) $oZeit->sessionschreiben($userid);;



		// obwohl der Konstruktor bereits das Objekt laden soll
		$fehler = new Fehler($fehlerid);

		// muss das nochmal separat erfolgen.
		$fehler = $fehler->getFehler( $fehlerid );

		$fid=$fehler->getId();

		$gegenorder = $order=='desc'?'asc':'desc';
		
		//$projektId = $fehler->getProjektIdFromDB( $id );
		$projektId = $fehler->getProjektId( $fehlerid );
		$title = $fehler->getTitel();


		$projekt = new Projekt($projektId);
			

  
echo '<center><h1>Fehler Detail</h1>
<br />
<br />
<div><center>
<form  title="das Fehlerformular" name="fehlerformular" action="../eintragen" method="post">
<input type="hidden" name="fid" value="'.$fehlerid.'" />
<input type="hidden" name="paid" value="'.$fehler->getId() .'" />
<input type="hidden" name="inid" value="'.$fehler->getInitialId().'" />
<table>
<tr>
<td align="right">Betrifft das Projekt:</td>
<!-- muss editierbar werden -->
<td>';
		$projekt->Projekteausgebenvorauswahl($projektId);
		echo ' aktuell: '.$projekt->getNameFromDB($projektId).'</td>
</tr>

<tr>
<td align="right">Url:</td>
<td><input title="in Adressleiste <strg a>, <strg c>, dann hierher und <strg v>" name="url" value="'.$fehler->getUrl().'" type="text" size="30"/></td>
</tr>

<tr>
<td align="right">Fehler Kurzbeschreibung:</td>
<td><input name="kurzbeschreibung" value="'.$fehler->getTitel().'"  type="text" size="50"/></td>
</tr>

<tr>
<td align="right">Fehler Gesamtbeschreibung:</td>
<td>
	<textarea id="fehler" name="fehler" rows="15" cols="80">
    '.$fehler->getErklaerung().'
	</textarea>
</td>
</tr>
<tr>
<td align="right">Priorität:</td>
<td><select name="prio" id="prioritaet" title="Hier die Priorität festlegen">';

		$stat[1]="sofort erledigen";
		$stat[2]="hoch";
		$stat[3]="mittel";
		$stat[4]="bei Gelegenheit";

		for( $h = 1 ; $h < 5; $h++ ){
			echo "$fehler->getPrioritaet() == $stat[$h] \n";
			// if ($row[$fs]==$stat[$h])
			if ( $fehler->getPrioritaet() == $h )
			{
				echo "<option selected value=\"$h\">$stat[$h]</option>\n";
			}
			else
			{
				echo "<option value=\"$h\">$stat[$h]</option>\n";
			}
		}

		echo	'</select> aktuell: '.$stat[$fehler->getPrioritaet()].' <!-- " /> --></td>
</td>
</tr>

<tr>
<td align="right">Status:</td>
<td><!--<input name="status" size="30" value="-->
<select name="status" id="prioritaet" title="Hier den Status ändern">';

			
		// hier muss ich den Status einbringen
		// das ist gar nicht doof
			
		$stat[0]="unerledigt";
		$stat[1]="vorbereitet";
		$stat[2]="begonnen";
		$stat[3]="teilweise";
		$stat[4]="erledigt";

		for( $h = 0 ; $h < 5; $h++ ){
			echo "$fehler->getStatus() == $stat[$h] \n";
			// if ($row[$fs]==$stat[$h])
			if ( $fehler->getStatus() == $stat[$h])
			{
				echo"<option selected value=\"$stat[$h]\">$stat[$h]</option>\n";
			}
			else
			{
				echo"<option value=\"$stat[$h]\">$stat[$h]</option>\n";
			}
		}

		echo	'</select> aktuell: '.$fehler->getStatus().' <!-- " /> --></td>
</tr>
<tr>
<td></td>
<td><input name="abschicken" type="submit" value="abschicken" /></td>
</tr>
<tr>
<td></td>
<td><a href="'.PFAD.'/'.APPNAME.'/antwort/neu/'.$fehler->getInitialId().'">Neue Antwort</a>&nbsp;&nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp;<a href="'.PFAD.'/'.APPNAME.'/kommentar/neu/f'.$fehlerid.'">Kommentar abgeben</a></td>
</tr>

</tr>
<tr>
<td></td>
<td><h3>Liste aller bisherigen Lösungen</h3></td>
</tr>
<tr><td></td>
<td>';

	/*	$oLoesung = new Loesung(1);
		//etAlleLoesungen ( $fehlerid, $von=0, $lim=30, $order=asc )
		if (DEBUG) {
		echo '<div class="mittig fehlerbox">';
		echo "<br>".$fid."<br /></div>";
		}
		// es muss die INitial id des Fehlers übergeben werden
		$alleLoesungen = $oLoesung -> getAlleLoesungen($fehler->getInitialId());

		if (sizeOf($alleLoesungen)<($lim*10)) $lim = sizeOf($alleLoesungen)/10;

		$zeile=1;

		//echo "fehlerid = ".$fehlerid;
		if (sizeOf($alleLoesungen)) {

			echo '<table class="tabelleprojektuebersicht" cellspacing="0">'."\n";
			echo '<tr>'."\n".'<th style="text-align:center;" colspan="2"><a href="'.$_SERVER['PHP_SELF'].'?von='.($von-30).'"><<</a> &nbsp; &nbsp; &nbsp;'.($von/30).' &nbsp; &nbsp; &nbsp;<a href="'.$_SERVER['PHP_SELF'].'?von='.($von+30).'">>></a></th>'."\n".'<th><a href="'.$_SERVER['PHP_SELF'].'?order='.$gegenorder.'&von='.$von.'">'.$order.'</a></th></tr>'."\n";
			//foreach ($alleFehler as $data)
			//{
			for ($i = 0; $i < ($lim*10)-1; $i=$i+10 )
			{
				if ($zeile%2 == 0) {
					$style = FEHLERSTYLE1;
				}
				else
				$style = FEHLERSTYLE2;

					
				$bezeichnung = str_split( html_entity_decode($alleLoesungen[$i+4]),40 );

				//echo "<div id=\"\" >""
				//echo "<li style=\"".$style."\">".$zeile.". <a href=fehlerdetail.php?id=".$alleFehler[$i].">".$alleFehler[$i+2]."</a>(".$alleFehler[$i+5].")</li>";
				echo "<tr style=\"".$style."\"><td class=\"tabletdnumber\">".$zeile.". </td>
 <td class=\"tabletd\">\n<a href=".PFAD."/".APPNAME."/antwort/detail/".md5($alleLoesungen[$i]).">".$bezeichnung[0]." ...</a>\n</td>\n
 <td class=\"tabletd_fehler\">(".$alleLoesungen[$i+5].")</td></tr>\n<tr>"; 

				++$zeile;

			}

			echo "</table>";

		}


		echo '</td>
</tr>


</table></div>'."\n\n\n\n<center>";
		*/
include_once 'inc/footer.php';
die();
	}
	
	/*
	 * alle zeigt im Gegensatz zur Übersicht tatsächlich
	 * alle Einträge
	 */
	
	
	elseif ( $action == 'alle' ) {

		include_once("fehler/alleFehler.php"); 


	}
	
	
	// swtichVisibility - sichtbar
	elseif ( $action == 'sichtbar' ) {

	include('inc/global_config.inc.php');

		$fehlerid = $id; 
		//isset( $_GET['id'] )? $_GET['id']: -1;

		$oFehler = new Fehler($fehlerid);
		$oFehler->setSichtbar($fehlerid);
		header('location:../../../fehlerreport/fehler/uebersicht');

	}
	// switchDeletable loeschen
	elseif ( $action == 'loeschen' ) {

	include('inc/global_config.inc.php');

		$fehlerid = $id; 
		//isset( $_GET['id'] )? $_GET['id']: -1;

		$oFehler = new Fehler($fehlerid);
		$oFehler->setGeloescht($fehlerid);
		header('location:../../../fehlerreport/fehler/uebersicht');

	}



	include 'inc/footer.php';
}
