<?php
/**
 *
 * Diese Klasse enthält neben den
 * 3 Zeit Methoden
 * zusätzlich 2 Debugging und 2 Pagging Methoden
 *
 * @author Rainer Reimold
 *
 */

class Zeit {


	/* Es muss noch beachtet werden, dass die Uhrzeit mit dabeisteht*/
	function datumEinD($datum){
		$i=0;
		$tag=$monat=$jahr=0;
		$bestandteile = explode("-",$datum);
		foreach ($bestandteile as $datumteil){
			if($i==0){$jahr = $datumteil;}
			else if ($i==1) { $monat = $datumteil;}
			else {$tag = $datumteil;}
			$i++;
		}
		return "$tag.$monat.$jahr";
	}

	function datumDinE($datum){
		$i=0;
		$bestandteile = explode(".",$datum);
		foreach ($bestandteile as $datumteil){
			if($i==0){$day = $datumteil;}
			else if ($i==1) { $month = $datumteil;}
			else {$year = $datumteil;}
			$i++;
		}
		return "$year-$month-$day";
	}

	function getDifferentTime($datum){
		$date_aktuell = time();
		$rueckgabe = "";
		$tag = $monat = $jahr=0;
		$i=0;
		$bestandteile = explode("-",$datum);
		foreach ($bestandteile as $datumteil){
			if($i==0){$jahr = $datumteil;}
			else if ($i==1) { $monat = $datumteil;}
			else {$tag = $datumteil;}
			$i++;
		}
		$timestamp = mktime(0, 0, 0, $monat, $tag, $jahr);
		//date('c', mktime(1, 2, 3, 4, 5, 2006));
		//echo $monat, $tag, $jahr;
		//$timestamp = date('c', mktime(0, 0, 0, $monat, $tag, $jahr));

		// berechne die Differenz
		$differenz =  $date_aktuell - $timestamp;
		$diff_tage = $differenz / 86400;
		$differenz = floor($diff_tage);
		if ($differenz==0){
			$rueckgabe = "heute";
		}
		else if ($differenz==1){
			$rueckgabe = "gestern";
		}

		else if ($differenz<=30){
			$rueckgabe = "$differenz Tage";
		}
		else if ($differenz>30 && $differenz<365) {
			$rueckgabe = ceil($differenz/30)." Mon + ".($differenz%30)." Tg.";
		}
		else {
	  $rueckgabe = ceil($differenz/365)." Jhr + ".ceil(($differenz%365)/30)." Mon";
	  //und ".(($differenz%365)%30)." Tage.";
		}

		return $rueckgabe;
	}


	// session in DB ablegen
	public function sessionschreiben($userid){
		//$benid = getBenutzerId($name,$pass);
		//echo "BenutzerID: $benid";
		$timestamp=time();
		$datum = date("Y-m-d H:i:s",$timestamp);
		$ses = $_SESSION['SID'];

		$uri = $_SERVER['REQUEST_URI'];
		$ip = $_SERVER['REMOTE_ADDR'];
		$db = _DBNAME;
		$sql="insert into tracking (benutzerid, seite, zeit ,sessionid)     Values('$userid', '$uri','$datum','$ses')";
		/*	$sql="insert into tracking (benutzerid, seite, zeit)     Values('$benid', '$uri','$datum')"; */
		//$res=send_sql($db,$sql);
		echo "<br />Session - DB-Eintrag noch nicht realisiert.<br />";

	}

	// Debug Meldung schreiben
	function writeLog($line="")
	{
		$logFile = 'debug.log';
		$logFH = fopen ($logFile, 'a+');
		fwrite ($logFH, '################# '.date("d.m.Y - H:i:s").' #################'."\n\n");
		fwrite ($logFH, $_SERVER['REMOTE_ADDR']."\n\n
	User Agent ".$_SERVER['HTTP_USER_AGENT']."\n
	Request URI".$_SERVER['REQUEST_URI']."\n");

		foreach ($_REQUEST AS $param => $value)
		{
			fwrite ($logFH, $param.' => '.$value. "\n");

			if ($param == 'DocPathUrl') $DocPathUrl = $value;
		}

		fwrite ($logFH, '###############################################'."\n");

		foreach (parse_url($DocPathUrl) AS $key => $val)
		{
			fwrite($logFH, $key.' => '.$val. "\n");
		}
		fwrite ($logFH, '###############################################'."\n");


		if ($line)
		{
			fwrite($logFH, $line."\n");
			fwrite ($logFH, '<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<'."\n\n\n");
		}

		fclose($logFH);
	}


	function paging($anzahlDS,$begin,$limit)
	{
		/*
		 if (!$anzahlDS) $anzahlDS=0;
		 if (!$begin) $begin=0;
		 if (!$limit) $limit=30;


		 $anzahl = zeigeAlleUnerledigtenFehler($projekt, $von, $lim);

		 ?>
		 <br />
		 <?php
		 */
		if ($von < 30) $zurueck=0;
		else $zurueck = $von - 30;

		$weiter = $von + 30;


		/*

		?>
		<center><b>
		<?php  if ($von > 1) { ?>
		<a href="uebersicht.php?pid=<?php echo $pid?>&von=<?php echo $zurück?>&lim=<?php echo $lim?>"><<</a>
		<?php  } ?>
		&nbsp;
		<?php  if ($anzahl>28) { ?>
		<a href="uebersicht.php?pid=<?php echo $pid?>&von=<?php echo $weiter?>&lim=<?php echo $lim?>">>></a>
		</b></center>
		<?php  } ?>
		*/
	}



	function paging2()
	{

		$zielstringKW .= "<br/><small>";



		// << 300 Einträge oder 10 Schritt zurück blättern
		$actualdsminus300 = $actualds - $dsSite * 10;
		if ($actualdsminus300 >= 0)
		$zielstringKW .= "&nbsp;&nbsp;<a style=\"text-decoration:none;\" href=\"keywords.php?actualds=$actualdsminus300\"><<</a>&nbsp;&nbsp;";
			
		// <  30  Einträge oder 1 Schritt zurück blättern
		$actualdsminus30 = $actualds - $dsSite;
		if ($actualdsminus30 >= 0)
		$zielstringKW .= "&nbsp;&nbsp;<a style=\"text-decoration:none;\" href=\"keywords.php?actualds=$actualdsminus30\"><</a>&nbsp;&nbsp;";


		for ($h = 0; $h < $anz_paginglinks; $h++){
			if ($anz_paginglinks < 2) break;
			$hds = $h * $dsSite;
			if($hds==0) {
				$hds=1;
			}
			$h2 = $h+1;
			// if ($h==0) $zielstringKW .= "Seite ";

			if ($hds != $actualds && $hds <= $actualds + $dsSite*2 && $hds >= $actualds - $dsSite*2)
			$zielstringKW .= "&nbsp;&nbsp;<a style=\"text-decoration:none;\" href=\"keywords.php?actualds=$hds\">$h2</a> &nbsp;&nbsp;";
			else if($hds == $actualds)
			$zielstringKW .= "&nbsp;&nbsp;$h2&nbsp;&nbsp;";
			else if($h == 0)
			$zielstringKW .= "&nbsp;&nbsp;<a style=\"text-decoration:none;\" href=\"keywords.php?actualds=$hds\">$h2 ... </a> &nbsp;&nbsp;";
			else if($h == $anz_paginglinks-1)
			$zielstringKW .= "&nbsp;&nbsp;<a style=\"text-decoration:none;\" href=\"keywords.php?actualds=$hds\"> ... $h2</a> &nbsp;&nbsp;";

		}

		// das Blättern macht natürlich nur dann Sinn, wenn ausreichend Einträge vorhanden sind

		// >  30  Einträge oder 1 Schritt vorwärts blättern
		$actualdsplus30 = $actualds + $dsSite;
		// ist die Gesamtzahl der Datensätze größer als der aktuelle + der gewählten Anzahl dann normaler Pfeil
		if ($numberDS > $actualdsplus30)
		$zielstringKW .= "&nbsp;&nbsp;<a style=\"text-decoration:none;\" href=\"keywords.php?actualds=$actualdsplus30\">></a>&nbsp;&nbsp;";
		// // ist die Gesamtzahl der Datensätze kleiner als der aktuelle + der gewählten Anzahl dann zeige keinen Pfeil
		else if ($numberDS < $actualdsplus30){}
		else {
			$maxDS = $numberDS - $dsSite;
			$zielstringKW .= "&nbsp;&nbsp;<a style=\"text-decoration:none;\" href=\"keywords.php?actualds=$maxDS\">></a>&nbsp;&nbsp;";
		}
		// >> 300 Einträge oder 10 Schritt vorwärts blättern
		$actualdsplus300 = $actualds + $dsSite*10;
		if ($numberDS > $actualdsplus300)
		$zielstringKW .= "&nbsp;&nbsp;<a style=\"text-decoration:none;\" href=\"keywords.php?actualds=$actualdsplus300\">>></a>&nbsp;&nbsp;";
		if ($numberDS < $actualdsplus300){}
		else {
			$maxDS = $numberDS - $dsSite;
			$zielstringKW .= "&nbsp;&nbsp;<a style=\"text-decoration:none;\" href=\"keywords.php?actualds=$maxDS\">>></a>&nbsp;&nbsp;";
		}

		//$zielstringKW .= "&nbsp;>>&nbsp;";

		$_SESSION['zielstringKW'] = $zielstringKW."</small>";

	}
}