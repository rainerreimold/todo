<?php
/************************************************************************************

Projekt: todo
Datei: gedanken.inc.php

Ziel: Ich benötige eine Art Gedankenerfassung... Nicht alles kann ich in Artikelverwaltung 
oder sonstige Dinge rumliegen lassen.

Hinweis: Ich brauch noch immer eine Möglichkeit die Geschehnisse in Halle zu verarbeiten,
insbesondere einige Dinge wie

	- das Verhalten der Kollegen
	- wie die AG in die privaten Bereich des Computers eindringen dürfen und damit 
	  die Privatsphäre des Angestellten verletzen dürfen, mit dem Ziel diesen zu entlassen.
	  das ArbG Halle hat dieses handeln legitimiert und das LArbG hat die gleiche 
	  Einschätzung durchblicken lassen.
	- die absurde Motivationslage des Arbeitgebers - warum geht es um eine 
	  Abwertung der Person, statt um eine saubere einvernehmliche Lösung
	- Wie soll man damit weiter klarkommen?

überdies möchte ich meine eigene Ideen zum Thema geschäftliche Gestaltung in private 
und nichtzugängliche Bereiche abtrennen.
So gabe es in dieser Woche einen Super Pddcast um Thema GmbH Holding.(Caroline Preuß)
Hier ging es nicht um Größenwahn, sondern um Absicherung und Steuersparmöglichkeiten. 
Für mich ist das Thema noch nicht vom Tisch.

Datum: 18.06.2021 
Autor: Rainer Reimold - rainerreimold@gmx.de

*************************************************************************************/

session_start();


require_once './inc/global_config.inc.php';
$_SESSION['title'] = 'todo';
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
    
//    include 'inc/header.php';
	
    if ( $action == '') {
	

		$db = $id;
		if ($_SESSION['start']==false) {
    		$_SESSION['start']=true;
			echo "<h1>KC4060 Serververwaltung</h1>";
			echo "<h2>Ansatz?</h2>";

			die();
		}



		}

    /***

	hier könnten ohne id alle Artikel gelistet werden
	oder mit id alle Artikel der jeweiligen Domain

	*/


    else if ( $action == 'zeigeAlleGedanken') {


    }

	else if ( $action == 'anlegen') {


    }

	else if ( $action == 'eintragen') {


    }

	else if ( $action == 'bearbeiten') {


    }
	// bloße Anzeige
	else if ( $action == 'details') {


    }
	// verschlüsseln
	else if ( $action == 'encrypt') {


    }
	// entschlüsseln
	else if ( $action == 'decrypt') {


    }


}




?>