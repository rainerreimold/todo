<?php
/*
		 $pid = isset($_GET['pid'])?intval($_GET['pid']):0;
		 $von = isset($_GET['von'])?intval($_GET['von']):0;
		 $lim = isset($_GET['lim'])?intval($_GET['lim']):30;
		 */
		$userid = isset($_SESSION["user_id"])?$_SESSION["user_id"]:1;
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

		//$fid=$fehler->getId();
		$fid = $fehlerid;

		$gegenorder = $order=='desc'?'asc':'desc';
		
		//$projektId = $fehler->getProjektIdFromDB( $id );
		//$projektId = $fehler->getProjektId( $fehlerid );
		$projektId = $fehler->ProjektId;
		//$title = $fehler->getTitel();
		$title = $fehler->Titel;

		$projekt = new Projekt($projektId);
			

  
echo '<center><h1>Fehler Detail</h1>
<br />
<br />
<div><center>
<form  title="das Fehlerformular" name="fehlerformular" action="../eintragen" method="post">
<input type="hidden" name="fid" value="'.$fehlerid.'" />
<input type="hidden" name="paid" value="'.$fehler->ParentId.'" />
<input type="hidden" name="inid" value="'.$fehler->InitialId.'" />
<table>
<tr>
<td align="right">Betrifft das Projekt:</td>
<!-- muss editierbar werden -->
<td>';
//		$projekt->Projekteausgebenvorauswahl($projektId);
//		echo ' aktuell: '.$projekt->getNameFromDB($projektId).'</td>';
echo '</tr>

<tr>
<td align="right">Url:</td>
<td><input title="in Adressleiste <strg a>, <strg c>, dann hierher und <strg v>" name="url" value="'.$fehler->Url.'" type="text" size="30"/></td>
</tr>

<tr>
<td align="right">Fehler Kurzbeschreibung:</td>
<td><input name="kurzbeschreibung" value="'.$fehler->Titel.'"  type="text" size="50"/></td>
</tr>

<tr>
<td align="right">Fehler Gesamtbeschreibung:</td>
<td>
	<textarea id="fehler" name="fehler" rows="15" cols="80">
    '.$fehler->Erklaerung.'
	</textarea>
</td>
</tr>
<tr>
<td align="right">Priorit&auml;t:</td>
<td><select name="prio" id="prioritaet" title="Hier die Priorit&auml;t festlegen">';

		$stat[1]="sofort erledigen";
		$stat[2]="hoch";
		$stat[3]="mittel";
		$stat[4]="bei Gelegenheit";

		for( $h = 1 ; $h < 5; $h++ ){
			echo "$fehler->Prioritaet == $stat[$h] \n";
			// if ($row[$fs]==$stat[$h])
			if ( $fehler->Prioritaet == $h )
			{
				echo "<option selected value=\"$h\">$stat[$h]</option>\n";
			}
			else
			{
				echo "<option value=\"$h\">$stat[$h]</option>\n";
			}
		}

		echo	'</select> aktuell: '.$stat[$fehler->Prioritaet].' <!-- " /> --></td>
</td>
</tr>

<tr>
<td align="right">Status:</td>
<td><!--<input name="status" size="30" value="-->
<select name="status" id="prioritaet" title="Hier den Status &auml;ndern">';

			
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
			if ( $fehler->Status == $stat[$h])
			{
				echo"<option selected value=\"$stat[$h]\">$stat[$h]</option>\n";
			}
			else
			{
				echo"<option value=\"$stat[$h]\">$stat[$h]</option>\n";
			}
		}

		echo	'</select> aktuell: '.$fehler->Status.' <!-- " /> --></td>
</tr>
<tr>
<td></td>
<td><input name="abschicken" type="submit" value="abschicken" /></td>
</tr>
<tr>
<td></td>
<td><a href="'.PFAD.'/'.APPNAME.'/antwort/neu/'.$fehler->InitialId.'">Neue Antwort</a>&nbsp;&nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;&nbsp;<a href="'.PFAD.'/'.APPNAME.'/kommentar/neu/f'.$fehlerid.'">Kommentar abgeben</a></td>
</tr>

</tr>
<tr>
<td></td>
<td><h3>Liste aller bisherigen L&ouml;sungen</h3></td>
</tr>
<tr><td></td>
<td>';

		$oLoesung = new Loesung(1);
		//etAlleLoesungen ( $fehlerid, $von=0, $lim=30, $order=asc )
		if (DEBUG) {
		echo '<div class="mittig fehlerbox">';
		echo "<br>".$fid."<br /></div>";
		}
		// es muss die INitial id des Fehlers übergeben werden
		echo "Ich gehe davon aus, dass es jetzt zu dem Fehler kommt!<br>";
		$alleLoesungen = $oLoesung -> getAlleLoesungen($fehler->InitialId);
		
		//die('STOP');
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
		
include_once 'inc/footer.php';
die();
?>