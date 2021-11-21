<?php

/***************************************************************************************************
*
* Projekt: todo/fehlertool
* Dateiname: fehler.inc.php
* Aufruf über controller
* Aufgabe/Funktion: Verteilung der Funktionen auf die verschiedenen Unterfunktionen im Verzeichnis
* 
* Hinweis:	
*
*
* Autor: Rainer Reimold * rainerreimold@gmx.de * 0151/28872748
* Datum: 05.10.2021 * 
*
**************************************************************************************************/

session_start();
require_once './inc/global_config.inc.php';

require_once 'class/Fehler.classes.php';
require_once 'class/Zeit.classes.php';
require_once 'class/Projekt.classes.php';
require_once 'class/Loesung.classes.php';

function doAction( $action = '0', $id='0', $von=0, $lim=0, $order='desc' ) {

	// einfache Übersicht Seite 1
	if ($action == 'alleFehler' || $action == 'uebersicht' ) {

		require_once 'fehler/alleFehler.php';

	}
	
	
	elseif ( $action == '7tage' ) {
	
		include 'inc/header.php';

	}


	elseif ( $action == 'detail' ) {

		require_once 'fehler/fehler-detail.php';
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
    elseif ( $action == 'neu' ) {

		require_once 'fehler/fehler-neu.php';

    }


	elseif ( $action == 'eintragen' ) {

		require_once 'fehler/fehler-eintragen.php';

	}

	//include 'inc/footer.php';
}

