<?php
/****************************************************************************
 *
 * Diese Klasse wurde durch eine Datei des Paketes IMS erstellt.
 *
 * IMS steht für Intelligence Management Software und stellt das Ziel
 * sich wiederholende Schritte zu automatisieren.
 *
 * Es gibt Ansätze Persistenzschichten zu separieren. Sowohl in Java
 * und zwischenzeitlich auch in PHP und in ROR sowieso. Doch die Persistenzschicht
 * allein ist nur ein Teil.
 *
 * Es geht mir insbesondere um die Formulare, -daten und -validierung.
 *
 *
 * Author: "Rainer Reimold"
 * KlassenName: >> Fehler <<
 * Tabelle: fehler
 * Version : V0.1
 * Date 27.06.2008
 * $this->Angelegt = date("y-m-d G:i:s", time());
 *
 * 20.04 addFehler angepasst

##########################################################################################

	Ich übernehme diese Klasse am 16.07.2021 in das Projekt todo und werde versuchen 
	Funktion für Funktion in den neuen Sprachstandard zu übernehmen.

	Die DB Zugriffsklasse kann ich so nicht mehr verwenden,
	ich werde eine ähnliche Lösung anstreben, damit sich die notwendigen Änderungen in 
	Grenzen halten. 

 *
 *****************************************************************************/

// Einsatzmoeglichkeit
/*
 // erzeuge Objekt
 fehlerObject = new Fehler($id);

 // Zugriff auf Funktionen bspw.
 $id = fehlerObject ->getId();
 ...
 */

//require_once("inc/DB.inc.php");

class Fehler
{


	/** die Eigenschaften sind "public" und sollten auf die
	 * jeweiligen Beduerfnisse angepasst werden.
	 * protected oder private.
	 */
	public $Id;
	public $Titel;
	public $Erklaerung;
	public $Ziel;
	public $Wunsch;
	public $Angelegt;
	public $Erledigt;
	public $Prioritaet;
	public $Geaendert;
	public $Status;
	public $UserId;
	public $ProjektId;
	public $Geloescht;
	public $Url;
	public $Loesungsweg;
	public $Hinweis;
	public $Sichtbar;
	public $InitialId;
	public $ParentId;

	public function getFehler( $id )
	{
		$oZeit = new Zeit();

		//$dbh = new DB_Mysql_Prod;
		//$dbh = new DatenbankZugriff;
		//id, titel, erklaerung, ziel, wunsch, angelegt 
		$query = "Select *
			From fehler Where fid_md5 = '".$id."'";
		
		print "<br>".$query."<br>";	


		$db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
        $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
        $rueckgabe = $db->query($query);
          
		$result = $rueckgabe->fetchAll(PDO::FETCH_BOTH);
		// Aha des Rätsels Lösung 

		//echo "<br>".sizeOf($result)."<br>".$result[0]['id'];
		//[0]; //
		//foreach ($erg as $result) 
		//{

		$this->Id = $result[0]['id']; 
		$this->Titel = $result[0]['titel'];
		$this->Erklaerung = $result[0]['erklaerung'];
		$this->Ziel = $result[0]['ziel'];
		$this->Wunsch = $result[0]['wunsch'];
		
		$this->Angelegt = $oZeit->datumEinD($result[0]['angelegt']);
	    
		$wi=0;
		$i=0;
		$dat=0;
/*		
		if ($this->Angelegt != "" )
			{
				$bestandteile = explode(" ",$dat[$i+5]);
					
				if (sizeOf($bestandteile) >1) {

					foreach ($bestandteile as $teil){
						if($wi==0){$datum = $teil;}
						else {$zeit = $teil;}
						$wi++;

					}
					$deutschesDatum = $oZeit->datumEinD($datum);
					# Funktion in Klasse "Zeit" ausgelagert
					$difTage = $oZeit->getDifferentTime($datum);
				}
				else {
					$datum ="kein Datum";
					$deutschesDatum="";
					$difTage="";
				}
				$this->Angelegt = $difTage;
			}
*/
		$this->Erledigt = $result[0]['erledigt'];
		$this->Prioritaet = $result[0]['prioritaet'];
		$this->Geaendert = $result[0]['geaendert'];
		$this->Status = $result[0]['status'];
		$this->UserId = $result[0]['user_id'];
		$this->ProjektId = $result[0]['projekt_id'];
		$this->Geloescht = $result[0]['geloescht'];
		$this->Url = $result[0]['url'];
		$this->Loesungsweg = $result[0]['loesungsweg'];
		$this->Hinweis = $result[0]['hinweis'];
		$this->Sichtbar = $result[0]['sichtbar'];
		$this->InitialId = $result[0]['initial_id'];
		$this->ParentId = $result[0]['parent_id'];
		
		// Prüfung, ob im Objekt Inhalt vorhanden ist
		//echo "<br>".$this->Erklaerung."<br>";
		//}
		return $this;
	}


	/**
	 * getPrimaryKey ist nur eine erste Funktion zur Ermittlung des Primärschluessels
	 * und berücksichtigt einige Fälle nicht.
	 *
	 * z.B. kombinierte PrimaryKeys, Umgang mit ForeignKeys (in Tests immer an letzter Stelle)
	 */


	public function getPrimaryKey( )
	{
		$dbh = new DB_Mysql_Prod;
		$query = 'SHOW INDEX From fehler';
		$res = $dbh->execute($query);
		while($data = $res->fetch_row() ) {
			return $data[4];
		}
	}


	/*
	INSERT INTO  `fehlerreport`.`fehler` (
`id` ,
`fid_md5` ,
`angelegt` ,
`erklaerung` ,
`erledigt` ,
`geaendert` ,
`geloescht` ,
`hinweis` ,
`loesungsweg` ,
`parent_id` ,
`prioritaet` ,
`projekt_id` ,
`sichtbar` ,
`status` ,
`titel` ,
`url` ,
`user_id` ,
`wunsch` ,
`ziel`
)
VALUES (
NULL ,  '',  '2010-06-16 22:46:13',  'qwe',  '0000-00-00 00:00:00',  '2010-06-16 22:46:24',  '0', NULL , NULL , NULL , NULL , NULL ,  '1', NULL , NULL , NULL , NULL , NULL , NULL
);
	
	
	
	$sql = "INSERT INTO `fehlerreport`.`fehler` (`id`, `fid_md5`, `angelegt`, `erklaerung`, `erledigt`, `geaendert`, `geloescht`, `hinweis`, `loesungsweg`, `parent_id`, `prioritaet`, `projekt_id`, `sichtbar`, `status`, `titel`, `url`, `user_id`, `wunsch`, `ziel`) VALUES (NULL, \'\', \'2010-06-16 22:46:13\', \'qwe\', \'0000-00-00 00:00:00\', \'2010-06-16 22:46:24\', \'0\', NULL, NULL, NULL, NULL, NULL, \'1\', NULL, NULL, NULL, NULL, NULL, NULL);";
	
	*/


 /*****
  Im Moment noch fehlerhaft



*/

	//$kurzbeschreibung, $fehler, $ziel, $wunsch, $prio, $status, $userid, $projekt
	public function addFehler(  $sTitel, $sErklaerung, $sPrioritaet, $sStatus, $sUserId, $sProjektId, $sUrl, $InitialId, $ParentId )	{
		

		$db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
        $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$angelegt = date("Y-m-d G:i:s", time());
		
		$datum = date("Y-m-d H:i:s", time());//("y-m-d G:i:s", time())
		
		$query = 'INSERT INTO fehler (  `titel`, `erklaerung`, `prioritaet`,  `status`, 
		`user_id`, `projekt_id`,  `url`  ) 
		VALUES ( $sTitel, $sErklaerung,   $sPrioritaet,  $sStatus, $sUserId, $sProjektId, $sUrl ) ';

		$rueckgabe = $db->query($query);
          
		$result = $rueckgabe->fetchAll(PDO::FETCH_BOTH);
		
		if (DEBUG) {
			echo $UserId;
			echo "<br />";
			echo $Status;
			echo "<br />";
	    	echo $datum;
			echo "<br />";
			echo "<br />QUERY : INSERT INTO fehler (  titel, erklaerung, angelegt ,  prioritaet,  status, user_id, projekt_id,  url ) VALUES <br /> (". $Titel.", ".$Erklaerung.", ".date("Y-m-d H:i:s", time()).", ". $Prioritaet.", ".  $Status.", ". $UserId.", ". $ProjektId.", ". $Url.");" ;
		    echo "<br />";
			echo "<br />QUERY : ". $Titel, $Erklaerung,    $Prioritaet,  $Status, $UserId, $ProjektId, $Url ;
	  		echo "<br />";
			
		}
		
		
		
		
		// get LastinsertID
		
		die("STOP");
		$query = 'Select Max(id) From fehler';
		$result = $db->execute($query); 
		$data = $result->fetch_row();
		$lastid = $data[0];
		
		if ($InitalId == 0) $InitalId = $lastid;
		
		echo "<br />ID = ".$InitalId."<br>";
		//die();
		
		//  `angelegt`,`geaendert`,
		// den verschlüsselten Key hinzufügen
		
		//$query = 'update fehler Set fid_md5=md5(Max(id))';
		$query = 'update fehler Set fid_md5=md5(id), initial_id=::3, parent_id=::4, angelegt=::2 where id = ::1 Limit 1';
		//echo "<br />".$query."<br />";
		$dbh->prepare($query)->execute( $lastid, $angelegt, $InitalId, $ParentId); 
		
		//die('Update durchgeführt !');
		
		// an der Stelle endet 
		
	}


// Initial Funktion schreibt falsche initial_id
					//updateFehler($fid,$kurzbeschreibung,$fehler, $ziel,$wunsch,$prio,$status,$url, $projekt, $initialid, $parentid);
	public function updateFehler( $Id, $Titel, $Erklaerung,  $Prioritaet, $Status, $user_id, $Url, $Projekt, $InitalId, $parentId)
	//updateFehler( $Id, $Titel, $Erklaerung, $Ziel, $Wunsch, $Erledigt, $Prioritaet, $Geaendert, $Status, $UserId, $ProjektId, $Geloescht, $Url, $Loesungsweg, $Hinweis, $Sichtbar )
	{
		$dbh = new DB_Mysql_Prod;
		$datum = date("Y-m-d H:i:s", time());
		//echo "<br />".$Status."<br />";
		//die ("Vor Update");
		//$query = 'UPDATE fehler SET   titel = ::1, erklaerung = ::2, ziel = ::3, wunsch = ::4, prioritaet = ::5, status = ::6, url = ::7, projekt_id = ::I8, initial_id = ::I9, parent_id = ::I10   Where fid_md5 = ::9 limit 1';
		$query = 'INSERT INTO fehler (  `titel`, `erklaerung`, `prioritaet`,  `status`, `user_id`, `projekt_id`,  `url` ,`initial_id`, `parent_id` ) VALUES ( ::1, ::2, ::3, ::4, ::5, ::6, ::7, ::I8, ::I9 ) ';
		$dbh->prepare($query)->execute(  $Titel, $Erklaerung,  $Prioritaet, $Status,  $userid, $Projekt, $Url, $InitalId,  $parentId  );

		$query = 'Select Max(id) From fehler';
		$result = $dbh->execute($query); 
		$data = $result->fetch_row();
		$lastid = $data[0];
		//echo "<br />ID = ".$lastid."<br>";
		//die();
		
		//,`angelegt`,`erledigt`
		
		// den verschlüsselten Key hinzufügen
		
		//$query = 'update todo Set fid_md5=md5(Max(id))';
		$query = 'update fehler Set fid_md5=md5(id), angelegt =::1 , geaendert =::2, geloescht=0, sichtbar=1, erledigt="00-00-00 00:00:00" where id = ::3';
		$dbh->prepare($query)->execute($datum, $datum, $lastid);
	
	}

	
	

	
	
	
	

	/**
	 * Hier muss ich davon ausgehen, dass in der Tabelle ein Attribut existiert,
	 * welches den Datensatz erst auf 'loeschen' oder 'deletable' stellt.
	 *
	 * Da ich nicht wissen kann, ob dieses für jede Tabelle auch wirklich existert,
	 * kommentiere ich diese Funktion zunächst aus !
	 *
	 * Ich halte diese Funktion für sehr wichtig, da sie ein 'zurück' ermöglicht.
	 * Der Datensatz wird nicht mehr angezeigt, ist nicht verfügbar, existiert
	 * aber noch. Es handelt sich aber noch nicht um das eigentliche 'loeschen'
	 */

	/*


	public function setDeletableFehler( $sichtbar )
	{
	$dbh = new DB_Mysql_Prod;
	$query = 'UPDATE fehler SET ( loeschen = 1 ) Where '.$this->getPrimaryKey().' = ::1';
	$dbh->prepare($query)->execute($this->id);
	}

	*/



	public function deleteFehler( $sichtbar )
	{
		$dbh = new DB_Mysql_Prod;
		$query = 'Delete From fehler Where '.$this->getPrimaryKey().' = ::1';
		$dbh->prepare($query)->execute($this->Id);
	}

	/**
	 * und noch Limit einsetzen
	 */

	public function getAlleFehler ( $von=0, $lim=30, $order=asc )
	{
		$oZeit = new Zeit();
		$dat = array();
		$dbh = new DB_Mysql_Prod;
		//echo 'Select * From fehler  Where geloescht = 0 and sichtbar = 1 order by id '.$order.' Limit '.$von.', '.$lim;
		/* $query = 'Select * From fehler f, projekt p  Where f.geloescht = 0 
		and f.sichtbar = 1 order by id ::I1 Limit ::I2 ,::I3';
		*/
		/* $query = 'Select Distinct f.id,f.titel,f.erklaerung,f.ziel,
		 f.wunsch,f.angelegt, f.erledigt,f.prioritaet,f.status,
		 f.user_id,p.name,f.loesungsweg,f.loesungsweg,f.url,f.hinweis
		 From fehler f, projekt p  Where f.geloescht = 0 
		and f.sichtbar = 1 and f.status Not Like "erledigt"
		and f.projekt_id = p.projekt_id
		order by id ::I1 Limit ::I2 ,::I3'; */ 
		
		 
		 $query = 'Select Distinct f.id,f.titel,f.erklaerung,f.ziel,
		 f.wunsch,f.angelegt, f.erledigt,f.prioritaet,f.status,
		 f.user_id,p.name,f.loesungsweg,f.loesungsweg,f.url,f.hinweis
		 
		 From fehler f, projekt p  Where 
		 f.id in (select Max(f2.id) from fehler f2 group by initial_id)
		 
		 and
		 f.geloescht = 0 
		and f.sichtbar = 1 and f.status Not Like "erledigt"
		and f.projekt_id = p.projekt_id
		 order by id ::I1 Limit ::I2 ,::I3'; 
		 
		
	 //echo "<br />".$query."<br />";

		$result =
		$dbh->
		prepare( $query )->
		execute( $order,intval($von),intval($lim)  );

	 //$rs = new DB_Result($dbh->execute($query));
	 $i=0;
	 while($data=$result->fetch_row())
	 {
	 	// verschiedene werden natürlich nicht mehr benötigt werden

	 	// und mir gefällt der Ansatz ein eindimensionales Array zu verwenden
	 	// überhaupt nicht
	 	// aber erstmal soll es funktionieren.
			$difTage = "";
			$dat[$i] = $data[0];
			$dat[$i+1]=$data[1];
			$dat[$i+2]=$data[2];
			//if ($dat[$i+1] == '') $dat[$i+1] = $dat[$i+2];
			$dat[$i+3]=$data[3];
			$dat[$i+4]=$data[4];
			$dat[$i+5]=$data[5];
			$angelegt = $dat[$i+5];
			
			$wi=0;
			//$datum = $tag = $zeit = $teil = 0;
			
	 		if ($angelegt != "" ) //&& $dat[$i+5]!= "0000-00-00 00:00:00" )
			{
				$bestandteile = explode(" ",$angelegt);
					
				if (sizeOf($bestandteile) >1) {

					foreach ($bestandteile as $teil){
						if($wi==0){$datum = $teil;}
						else {$zeit = $teil;}
						$wi++;

					}
					$deutschesDatum = $oZeit->datumEinD($datum);
					# Funktion in Klasse "Zeit" ausgelagert
					$difTage = $oZeit->getDifferentTime($datum);
				}
				else {
					
					$difTage="eben";
					$datum ="kein Datum";
					$deutschesDatum="";
				}
				//$bestandteile = "";
				//$datum = "";
				//
			
				if ($difTage == '')	{
					
					$dat[$i+5] = $angelegt;
				}
				else {
					$dat[$i+5] = $difTage;
				    $difTage = '';
				}
				
			}
			
			$wi=0;
			
			$dat[$i+6]=$data[6];
			$dat[$i+7]=$data[7];
			$dat[$i+8]=$data[8];
			$dat[$i+9]=$data[9];
			$dat[$i+10]=$data[10];
			$dat[$i+11]=$data[11];
			$dat[$i+12]=$data[12];
			$dat[$i+13]=$data[13];
			
			
			$i=$i+13;


		}
			
		return $dat;
	}
	
	
public function getAlleFehler7Tage ( $von=0, $lim=30, $order=asc )
	{
		$oZeit = new Zeit();
		$dat = array();
		$dbh = new DB_Mysql_Prod;
		
		$datum = date("Y-m-d H:i:s", time()-2592000);
		
		//echo 'Select * From fehler  Where geloescht = 0 and sichtbar = 1 order by id '.$order.' Limit '.$von.', '.$lim;
		/* $query = 'Select * From fehler f, projekt p  Where f.geloescht = 0 
		and f.sichtbar = 1 order by id ::I1 Limit ::I2 ,::I3';
		*/
		/* $query = 'Select Distinct f.id,f.titel,f.erklaerung,f.ziel,
		 f.wunsch,f.angelegt, f.erledigt,f.prioritaet,f.status,
		 f.user_id,p.name,f.loesungsweg,f.loesungsweg,f.url,f.hinweis
		 From fehler f, projekt p  Where f.geloescht = 0 
		and f.sichtbar = 1 and f.status Not Like "erledigt"
		and f.projekt_id = p.projekt_id
		order by id ::I1 Limit ::I2 ,::I3'; */ 
		
		 
		 $query = 'Select Distinct f.id,f.titel,f.erklaerung,f.ziel,
		 f.wunsch,f.angelegt, f.erledigt,f.prioritaet,f.status,
		 f.user_id,p.name,f.loesungsweg,f.loesungsweg,f.url,f.hinweis
		 
		 From fehler f, projekt p  Where 
		 f.id in (select Max(f2.id) from fehler f2 group by initial_id)
		 
		 and
		 f.geloescht = 0 
		and f.sichtbar = 1 and f.status Not Like "erledigt"
		and f.projekt_id = p.projekt_id
		and f.angelegt > ::4
		 order by id ::I1 Limit ::I2 ,::I3'; 
		 
		
	 //echo "<br />".$query."<br />";

		$result =
		$dbh->
		prepare( $query )->
		execute( $order,intval($von),intval($lim),$datum  );

	 //$rs = new DB_Result($dbh->execute($query));
	 $i=0;
	 while($data=$result->fetch_row())
	 {
	 	// verschiedene werden natürlich nicht mehr benötigt werden

	 	// und mir gefällt der Ansatz ein eindimensionales Array zu verwenden
	 	// überhaupt nicht
	 	// aber erstmal soll es funktionieren.
			$difTage = "";
			$dat[$i] = $data[0];
			$dat[$i+1]=$data[1];
			$dat[$i+2]=$data[2];
			//if ($dat[$i+1] == '') $dat[$i+1] = $dat[$i+2];
			$dat[$i+3]=$data[3];
			$dat[$i+4]=$data[4];
			$dat[$i+5]=$data[5];
			$angelegt = $dat[$i+5];
			
	 		if ($angelegt != "" ) //&& $dat[$i+5]!= "0000-00-00 00:00:00" )
			{
				$bestandteile = explode(" ",$angelegt);
					
				if (sizeOf($bestandteile) >1) {

					foreach ($bestandteile as $teil){
						if($wi==0){$datum = $teil;}
						else {$zeit = $teil;}
						$wi++;

					}
					$deutschesDatum = $oZeit->datumEinD($datum);
					# Funktion in Klasse "Zeit" ausgelagert
					$difTage = $oZeit->getDifferentTime($datum);
				}
				else {
					
					$difTage="eben";
					$datum ="kein Datum";
					$deutschesDatum="";
				}
				//$bestandteile = "";
				//$datum = "";
				//
			
				if ($difTage == '')	{
					
					$dat[$i+5] = $angelegt;
				}
				else {
					$dat[$i+5] = $difTage;
				    $difTage = '';
				}
				
			}
			
			$wi=0;
			
			$dat[$i+6]=$data[6];
			$dat[$i+7]=$data[7];
			$dat[$i+8]=$data[8];
			$dat[$i+9]=$data[9];
			$dat[$i+10]=$data[10];
			$dat[$i+11]=$data[11];
			$dat[$i+12]=$data[12];
			$dat[$i+13]=$data[13];
			
			
			$i=$i+13;


		}
			
		return $dat;
	}
	
	
	/* Der Datenbankzugriff muss noch geändert werden 
		Rainer 08.10.21
	*/

	public function getAlleFehlerErledigt ( $von=0, $lim=30, $order=asc )
	{
		$oZeit = new Zeit();
		$dat = array();
		$dbh = new DB_Mysql_Prod;
		
		$datum = date("Y-m-d H:i:s", time()-2592000);
		 
		 $query = 'Select Distinct f.id,f.titel,f.erklaerung,f.ziel,
		 f.wunsch,f.angelegt, f.erledigt,f.prioritaet,f.status,
		 f.user_id,p.name,f.loesungsweg,f.loesungsweg,f.url,f.hinweis
		 
		 From fehler f, projekt p  Where 
		 f.id in (select Max(f2.id) from fehler f2 group by initial_id)
		 
		 and
		 f.geloescht = 0 
		and f.sichtbar = 1 and f.status Like "erledigt"
		and f.projekt_id = p.projekt_id
		 order by id ::I1 Limit ::I2 ,::I3'; 
		 
		
	 //echo "<br />".$query."<br />";

		$result =
		$dbh->
		prepare( $query )->
		execute( $order,intval($von),intval($lim),$datum  );
/* Änderung noch nicht eingebaut */
		$db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
        $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $rueckgabe = $db->query($query);         
		$ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);



	 //$rs = new DB_Result($dbh->execute($query));
	 $i=0;
	 while($data=$result->fetch_row())
	 {
	 	// verschiedene werden natürlich nicht mehr benötigt werden

	 	// und mir gefällt der Ansatz ein eindimensionales Array zu verwenden
	 	// überhaupt nicht
	 	// aber erstmal soll es funktionieren.
			$difTage = "";
			$dat[$i] = $data[0];
			$dat[$i+1]=$data[1];
			$dat[$i+2]=$data[2];
			//if ($dat[$i+1] == '') $dat[$i+1] = $dat[$i+2];
			$dat[$i+3]=$data[3];
			$dat[$i+4]=$data[4];
			$dat[$i+5]=$data[5];
			$angelegt = $dat[$i+5];
			
	 		if ($angelegt != "" ) //&& $dat[$i+5]!= "0000-00-00 00:00:00" )
			{
				$bestandteile = explode(" ",$angelegt);
					
				if (sizeOf($bestandteile) >1) {

					foreach ($bestandteile as $teil){
						if($wi==0){$datum = $teil;}
						else {$zeit = $teil;}
						$wi++;

					}
					$deutschesDatum = $oZeit->datumEinD($datum);
					# Funktion in Klasse "Zeit" ausgelagert
					$difTage = $oZeit->getDifferentTime($datum);
				}
				else {
					
					$difTage="eben";
					$datum ="kein Datum";
					$deutschesDatum="";
				}
				//$bestandteile = "";
				//$datum = "";
				//
			
				if ($difTage == '')	{
					
					$dat[$i+5] = $angelegt;
				}
				else {
					$dat[$i+5] = $difTage;
				    $difTage = '';
				}
				
			}
			
			$wi=0;
			
			$dat[$i+6]=$data[6];
			$dat[$i+7]=$data[7];
			$dat[$i+8]=$data[8];
			$dat[$i+9]=$data[9];
			$dat[$i+10]=$data[10];
			$dat[$i+11]=$data[11];
			$dat[$i+12]=$data[12];
			$dat[$i+13]=$data[13];
			
			
			$i=$i+13;


		}
			
		return $dat;
	}
	
	/*
		Funktion auf neues DB-Schema umstellen

	*/
	public function getJederFehler ( $von=0, $lim=30, $order=asc )
	{
		//$oZeit = new Zeit();
		$dat = array();
		//$dbh = new DB_Mysql_Prod;


		 $query = 'Select Distinct f.id,f.titel,f.erklaerung,f.ziel,
		 f.wunsch,f.angelegt, f.erledigt,f.prioritaet,f.status,
		 f.user_id,p.name,f.loesungsweg,f.loesungsweg,f.url,f.hinweis,
		 f.geloescht,f.sichtbar,f.status
		 From fehler f, projekt p  Where f.projekt_id = p.projekt_id
		 order by id '.$order.' Limit '.intval($von).' ,'.intval($lim);
		
		
		
	    //if (DEBUG) 
  		echo "<br />".$query."<br />";


		
		//return $dbh->fetch_assoc($query);

		$db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
        $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
        $rueckgabe = $db->query($query);
          
		return $rueckgabe->fetchAll(PDO::FETCH_ASSOC);


	}
	
	

	
}