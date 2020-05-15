<?php

/****
01.05.2020
Hier sollen Familien angelegt und verwaltet werden.

Der Hintergrund ist lediglich die Berechnung von Portionsmengen für einen Einkaufszettel.

Es geht hier nicht um das Erfassen von Daten, wenngleich es natürlich sinnvoll wäre die Emailadresse, für die 
Information zu erfragen, damit man bei der Fertigstellung eine Mitteilung schicken kann.

***/


session_start();


require_once './inc/global_config.inc.php';
$_SESSION['title'] = 'Speiseplan- Wochenplan';
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
			echo "<h1>Lizenzen</h1>";
			echo "<h2>Ansatz?</h2>";

			die();
		}



		}

    /***

	*/


    else if ( $action == 'zeigeAlleSpeiseplaene') {
  	 include 'inc/header.php';
	        



   }



}