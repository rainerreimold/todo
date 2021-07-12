<?php

/**************************************************************************************************************

 Name: Zaehler.class.php
 Ziel: Es wird eine Objekt Zaehler erzeugt und die Statements in eine LogDatei geschrieben.


Autor: Rainer
Reaktivierung: 08.06.2021



**************************************************************************************************************/


class Zaehler {

// Debug Meldung schreiben

public function __construct() {}	
	

// prinzipiell ist es doch nur ein inkrementieren
// der Tabellenname wird übergeben,
// es gibt ein Count -Feld in der betreffenden Tabelle
// und dieser Eintrag wird bei Zugriff um eins erhöht.

// Diese Herangehensweise ist am Anfang in Ordnung, wird aber bei vermehrten Zugriffszahlen extremen
// Einfluss auf die Performance haben.

// Bevor ich beginne, wäre für den puren Counter ein Textdatei womöglich sogar besser?

  public function addCount($tabelle='test') {

	// liest den Inhalt einer Datei in einen String
	$filename = 'log/'.$tabelle.'_count.log';
	$handle = fopen($filename, "r");
	$contents = fread($handle, filesize($filename));
	fclose($handle);
//	echo "->".$contents;
//	echo "<br>";
	(int)$contents++;
//	echo "<br>";
//	echo "->".$contents;
//	echo "<br>";
	
	try {
		$logFile = 'log/'.$tabelle.'_count.log';
		$fp = fopen($logFile, 'w');
		fwrite($fp, $contents);
		fclose($fp);
	}
	catch(Exception $e){
		print ($e);
	}
	//$logFH = fopen ($logFile, 'w'); // Zahl lesen
	

  }


}