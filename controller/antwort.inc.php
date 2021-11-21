<?php

require_once './inc/global_config.inc.php';

require_once 'class/Fehler.classes.php';
require_once 'class/Zeit.classes.php';
require_once 'class/Projekt.classes.php';
require_once 'class/Loesung.classes.php';
function doAction( $action = '0', $id='0', $von=0, $lim=0, $order='asc' ) {


	//echo "ACTION= ".$action;
	// einfache Übersicht Seite 1

	// zeige alle Antworten eines Fehlers ?
	if ($action == '0' || $action == 'uebersicht' ) {

		include 'inc/header.php';
		$fid = $id;
		$oLoesung = new Loesung(1);
		//etAlleLoesungen ( $fehlerid, $von=0, $lim=30, $order=asc )
		if (DEBUG) {
			echo "<div class=\"mittig fehlerbox\"><br>".$fid."<br /></div>";
		}
		// hier muss die Initial Id des Fehlers übergeben werden 
		$alleLoesungen = $oLoesung -> getAlleLoesungen($fid);

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
 <td class=\"tabletd\">\n<a href='.PFAD.'/'.APPNAME.'/antwort/detail/".md5($alleLoesungen[$i]).">".$bezeichnung[0]." ...</a>\n</td>\n
 <td class=\"tabletd_fehler\">(".$alleLoesungen[$i+5].")</td></tr>\n<tr>"; 

				++$zeile;

			}

			echo "</table>";

		}


		echo '</td>
</tr>


</table>';
			

		include('inc/footer.php');


	}
	// anzeige des Fehlers, der beantwortet werden soll

	elseif ( $action == 'neu' ) {

		include('inc/header.php');

		$userid = $_SESSION["user_id"];

		$fehlerid=$id;
		//isset($_GET['id'])?$_GET['id']:'854d6fae5ee42911677c739ee1734486';
		// Request in DB schreiben
		//if (DEBUG) $oZeit->sessionschreiben($userid);;

		// Umstellung auf OOP geht Fehler

		// obwohl der Konstruktor bereits das Objekt laden soll
		$fehler = new Fehler(md5($fehlerid));

		// muss das nochmal separat erfolgen.
		$fehler = $fehler->getFehler( md5($fehlerid) );

		//jetzt die nicht md5Variante
		$fehlerid =  $fehler->getId();
		//$projektId = $fehler->getProjektIdFromDB( $id );
		$projektId = $fehler->getProjektId( md5($fehlerid) );
		$title = $fehler->Titel;


		$projekt = new Projekt($projektId);
			

		echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="'.PFAD.'/'.APPNAME.'/css/style2.css" />
</head>
<body>
<center>
<br>
<br>
<!--  der Fehler nur als Ansicht  -->
<form title="das Fehlerformular" name="fehlerformular"
	action="'.PFAD.'/'.APPNAME.'/antwort/eintragen" method="post">
<Table>
	<input type="hidden" name="id" value="'.$fehlerid.'" />
	<tr>
		<td align="right">Betrifft das Projekt:</td>
		<!-- muss editierbar werden -->
		<td>
		<div class="fehler">'.$projekt->getNameFromDB($projektId).'</div>
		</td>
	</tr>

	<tr>
		<td align="right">Url:</td>
		<td>
		<div class="fehler">'.$fehler->getUrl().'</div>
		</td>
	</tr>

	<tr>
		<td align="right">Fehler Kurzbeschreibung:</td>
		<td>
		<div class="fehler">'.$fehler->getTitel().'</div>
		</td>
	</tr>

	<tr>
		<td align="right">Fehler Gesamtbeschreibung:</td>
		<td>

		<div class="fehler">'.html_entity_decode( $fehler->getErklaerung() ).'
		</div>
		</td>
	</tr>

	<tr>
		<th colspan=2>
		<hr />
		</th>
	</tr>

	<tr>
		<td align="right">Loesungsweg:</td>
		<td><textarea name="ziel" rows="15" cols="80">';
		//echo $fehler->getZiel();
		echo '</textarea></td>
	</tr>
	<tr>
		<td align="right">Wunsch Beschreibung:</td>
		<td><textarea name="wunsch" rows="15" cols="80">';
		//echo $fehler->getWunsch();
		echo '</textarea></td>
	</tr>
	<tr>
		<td></td>
		<td><input name="absenden" type="submit" value="eintragen" /></td>
	</tr></table>';

		include('inc/footer.php');

	}
	/**
	 *
	 * // eintragen  evtl auch Kombination mit Änderung eintragen
	 *
	 *
	 */


	elseif ( $action == 'eintragen' ) {


	 require_once 'inc/global_config.inc.php';

	 $userid = $_SESSION["user_id"];


	 /*
	  $ziel = htmlentities($_POST['ziel']);
	  $wunsch = htmlentities($_POST['wunsch']);
	  $projekt = intval(htmlentities($_POST['projekt']));
	  $prio = intval(htmlentities($_POST['prio']));
	  $fehlerid = htmlentities($_POST['id']);
	  */
	 $ziel = isset ($_POST['ziel'])?htmlentities($_POST['ziel']):'';
	 $wunsch = isset ($_POST['wunsch'])?htmlentities($_POST['wunsch']):'';
	 $projekt = isset ($_POST['projekt'])?intval(htmlentities($_POST['projekt'])):'';
	 $prio = isset ($_POST['prio'])?intval(htmlentities($_POST['prio'])):'';

	 $fehlerid = isset ($_POST['id'])?$_POST['id']:'';
	 $parentid = isset ($_POST['parent_id'])?$_POST['parent_id']:'0';
	 $initialid = isset ($_POST['initial_id'])?($_POST['initial_id']):'';
	 
	  

	 $Nochoffen ="ja";

	 if ( !isset ($_POST['loesung_id'] )) {
	 	$oLoesung = new Loesung(1);
	 
	 	$oLoesung->addLoesung( $fehlerid, $ziel, $wunsch, $Nochoffen, $userid );

	 	header('location:'.PFAD.'/'.APPNAME.'/fehler/detail/'.md5($fehlerid));

	 }
	 else {

        $loesungid = isset ($_POST['loesung_id'])?$_POST['loesung_id']:'-1';
	 	$oLoesung = new Loesung($loesungid);
	 	$oLoesung->replaceLoesung( $fehlerid, $ziel, $wunsch, $Nochoffen, $userid, $loesungid ,$parentid,$initialid );
		//die('replace durchgeführt');
	 	header('location:'.PFAD.'/'.APPNAME.'/fehler/detail/'.md5($fehlerid));
	 }




	}




	elseif ( $action == 'detail' ) {



		include('inc/header.php');







		echo '<!-- TinyMCE
ersetzt das Textarea einfache und sehr interessante Lösung
-->
<script type="text/javascript" src="'.PFAD.'/'.APPNAME.'/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		mode : "textareas",
		theme : "advanced",
		plugins : "advimage,emotions,insertdatetime"

		});

// O2k7 skin
	tinyMCE.init({
		// General options
		mode : "exact",
		elements : "elm2",
		theme : "advanced",
		skin : "o2k7",
		plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>
<!-- /TinyMCE -->

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="'.PFAD.'/'.APPNAME.'/css/style2.css" />';


		//$userid = $_SESSION["user_id"];
		//echo "USERID: .$userid";
		// Das scheint so nicht ausreichend
/*		if (!$userid || $userid > 1)
		{
			echo "<br /><br /><br /><center><h2>Sie sind nicht eingeloggt.</h2><br />";
			echo "<a href=\"index.php\">Klicken Sie hier um sich einzuloggen</a></center>";
			//echo "User ID:".$userid;
			die();
		}
*/
		//$loesungmd5id = isset($_GET['id'])?$_GET['id']:'854d6fae5ee42911677c739ee1734486';



		echo "<br>0<br>";
		$oLoesung = new Loesung($id);

		echo "<br>1<br>";
		$fehlerid = $oLoesung->FehlerInitialId;
		echo "<br>2<br>";
		if (DEBUG) {
			echo "<div class=\"mittig fehlerbox\">  loesungmd5id: ".$loesungmd5id."<br >";
			echo "  fehlerid: ".$fehlerid."<br >";
			echo "  fehlerid md5: ".md5($fehlerid)."<br ></div>";
		}	
		
		echo "<br>3<br>";
		$oFehler = new Fehler(md5($fehlerid));
		echo "<br>4<br>";

		//$projektId = $fehler->getProjektIdFromDB( $id );
		//$projektId = $oFehler->getProjektId( $fehlerid );
        $projektId = $oFehler-> ProjektId;
		echo "<br>5 projektId ".$projektId."<br>";
		$title = $oFehler->Titel;
		echo "<br>6<br>";


		$oProjekt = new Projekt($projektId);
		
	//	if (DEBUG) {
			echo "<br>";
			var_dump($oProjekt);
			echo "<br><br>";
			var_dump($oFehler);
			echo "<br><br>";
			var_dump($oLoesung);
			echo "<br>";
	//	}	

		echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de-DE" lang="de-DE">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="'.PFAD.'/'.APPNAME.'/css/style2.css" />
</head>
<body>
<center>
<br>
<br>
<!--  der Fehler nur als Ansicht  -->
<form  title="das Fehlerformular" name="fehlerformular" action="'.PFAD.'/'.APPNAME.'/antwort/eintragen" method="post">
<Table>
<input type="hidden" name="id" value="'.$fehlerid.'" />
<input type="hidden" name="loesung_id" value="'.$oLoesung->LoesungId.'" />
<input type="hidden" name="parent_id" value="'.$oLoesung->ParentId.'" />
<input type="hidden" name="initial_id" value="'.$oLoesung->IntitialId.'" />


<tr>
<td align="right">Betrifft das Projekt:</td>
<!-- muss editierbar werden -->
<td><div class="fehler">'.$oProjekt->Name.'</div></td>
</tr>

<tr>
<td align="right">Url:</td>
<td><div class="fehler">'.$oFehler->Url.'</div></td>
</tr>

<tr>
<td align="right">Fehler Kurzbeschreibung:</td>
<td><div class="fehler">'.$oFehler->Titel.'</div></td>
</tr>

<tr>
<td align="right">Fehler Gesamtbeschreibung:</td>
<td>

	<div class="mittig">
    '.html_entity_decode( $oFehler->Erklaerung ).'
	</div>
</td>
</tr>
 
 <tr><th colspan=2><hr /></th></tr>
 
 <tr>
<td align="right">Loesungsweg:</td>
<td><textarea name="ziel" rows="15" cols="80" >'.$oLoesung->Loesungsweg.'</textarea></td>
</tr>
<tr>
<td align="right">Wunsch Beschreibung:</td>
<td><textarea name="wunsch" rows="15" cols="80">'.$oLoesung->Beschreibung.'</textarea></td>
</tr>
<tr>
<td></td>
<td><input name="absenden" type="submit" value="eintragen" /></td>
</tr>';

		echo '</table>';
		include 'inc/footer.php';





	}



	// swtichVisibility - sichtbar
	elseif ( $action == 'sichtbar' ) {



	}
	// switchDeletable loeschen
	elseif ( $action == 'loeschen' ) {



	}

}
