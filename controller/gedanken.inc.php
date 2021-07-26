<?php
/************************************************************************************

Projekt: todo
Datei: gedanken.inc.php

Ziel: Ich ben�tige eine Art Gedankenerfassung... Nicht alles kann ich in Artikelverwaltung 
oder sonstige Dinge rumliegen lassen.

Hinweis: Ich brauch noch immer eine M�glichkeit die Geschehnisse in Halle zu verarbeiten,
insbesondere einige Dinge wie

	- das Verhalten der Kollegen
	- wie die AG in die privaten Bereich des Computers eindringen d�rfen und damit 
	  die Privatsph�re des Angestellten verletzen d�rfen, mit dem Ziel diesen zu entlassen.
	  das ArbG Halle hat dieses handeln legitimiert und das LArbG hat die gleiche 
	  Einsch�tzung durchblicken lassen.
	- die absurde Motivationslage des Arbeitgebers - warum geht es um eine 
	  Abwertung der Person, statt um eine saubere einvernehmliche L�sung
	- Wie soll man damit weiter klarkommen?

�berdies m�chte ich meine eigene Ideen zum Thema gesch�ftliche Gestaltung in private 
und nichtzug�ngliche Bereiche abtrennen.
So gabe es in dieser Woche einen Super Pddcast um Thema GmbH Holding.(Caroline Preu�)
Hier ging es nicht um Gr��enwahn, sondern um Absicherung und Steuersparm�glichkeiten. 
F�r mich ist das Thema noch nicht vom Tisch.

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

	//Aber die �bersicht ist doch nicht die action sondern der
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

	hier k�nnten ohne id alle Artikel gelistet werden
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
	// blo�e Anzeige
	else if ( $action == 'details') {


    }
	// verschl�sseln
	else if ( $action == 'encrypt') {


    }
	// entschl�sseln
	else if ( $action == 'decrypt') {


    }


}




?>