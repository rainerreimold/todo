<?php
/*******************************************************************************************

 "alleFehler" ist ein Teil des ehemaligen Fehlertools.

 es folgen als nächstes
	- details
	- anlegen
	- eintragen


 wieder lauffähig ab dem 17.07.2021
 Autor: Rainer 

/******************************************************************************************/

	//echo var_dump($_REQUEST);

	include 'inc/header.php';

		$projekt_md5=isset($_GET['projekt'])?md5($_GET['projekt']):'';

		/*
		 * Die id übernimmt hier die Auswahl des Projektes
		 */

	$projekt_md5 = $id;

		if ($projekt_md5 != '') {
			$oProjekt = new Projekt();
			$oProjekt->getMd5Projekt($projekt_md5);
			$projektid=$oProjekt->getProjektId($id);

		}

		$userid = isset($_SESSION["user_id"])?:false;

		/*$pid = isset($_GET['pid'])?intval($_GET['pid']):0;
		 $von = isset($_GET['von'])?intval($_GET['von']):0;
		 $lim = isset($_GET['lim'])?intval($_GET['lim']):30;

		 $order = isset($_GET['order'])?$_GET['order']:'desc';*/
		$gegenorder = $order=='desc'?'asc':'desc';


		$oFehler = new Fehler(1);
		$alleFehler = array();

		if(!isset($projektid)) {
			//  Bitte wieder einkommentieren!
			// echo "<br><h2>Projekt_id ist leer!</h2><br>";
			$alleFehler = $oFehler->getJedeFehler( $von, $lim, $order );
		}
		else {
			$alleFehler =	$oFehler->getProjektFehler($projektid, $von, $lim, $order );
		}

		// Anzahl Schleifendurchläufe

		if (sizeOf($alleFehler)<($lim*16)) $lim = sizeOf($alleFehler)/13;

		$zeile=1;

		//echo sizeOf($alleFehler)." ".$alleFehler[1];

		if (sizeOf($alleFehler)==0 ) {

			echo 'keine Einträge gefunden.';
			include('inc/footer.php');
			die();
		}
		//echo "<ul>";
		echo '<br /><a href="fehler/neu">neuen Eintrag erstellen</a><br />';
		echo '<table class="tabelleprojektuebersicht" cellspacing="0">'."\n";
		echo '<tr>'."\n".'<th style="text-align:center;" colspan="2">';
		if ($von > 1) {
			echo '<a href="'.PFAD.'/'.APPNAME.'/fehler/uebersicht/'.($von-30).'"><<</a>';
		}
		echo '&nbsp; &nbsp; &nbsp;'.($von/30).' &nbsp; &nbsp; &nbsp;
		<a href="'.PFAD.'/'.APPNAME.'/fehler/uebersicht/'.($von+30).'">>></a>
		</th>'."\n".'<th>
		<a href="'.PFAD.'/'.APPNAME.'/fehler/uebersicht/'.$von.'/'.$lim.'/'.$gegenorder.'">'.$order.'</a>
		</th></tr>'."\n";

		foreach ($alleFehler as $data)
		{
		//for ($i = 0; $i < $lim*13; $i=$i+13 )
		//{
			if ($zeile%2 == 0) {
				$style = FEHLERSTYLE1;
			}
			else
			$style = FEHLERSTYLE2;
			
			
			// hier noch weitere Styles für erledigt/sichtbar/unsichtbar

			//echo "<div id=\"\" >""
			//echo "<li style=\"".$style."\">".$zeile.". <a href=fehlerdetail.php?id=".$data['id'].">".$data['erklaerung']."</a>(".$data['angelegt'].")</li>";
			echo "<tr style=\"".$style."\"><td class=\"tabletdnumber\">".$zeile.". </td>
 <td class=\"tabletd\">\n<a href=".PFAD."/".APPNAME."/fehler/detail/".md5($data['id']).">";
			if ($projekt_md5=='') echo "<small>".$data['name']."</small> - ";
			echo $data['titel']."</a>\n</td>\n <td class=\"tabletd_fehler\">(".$data['angelegt'].")</td></tr>\n<tr>";


			//echo ' <div class="number">'.$zeile.'</div>';
			//echo ' <div class="fehleruebersicht"><a href=fehlerdetail.php?id=".$data['id'].">".$data['erklaerung']."</a></div>'


			++$zeile;

		}
		//echo "</ul>";
		echo "</table>";



//include 'inc/footer.php';