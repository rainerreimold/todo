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
* KlassenName: >> Loesung << 
* Tabelle: loesung 
* Version : V0.1
* Date 27.06.2008
* 
* add angepasst 20.04
*
*****************************************************************************/

// Einsatzmoeglichkeit
/* 
// erzeuge Objekt 
loesungObject = new Loesung($id);

// Zugriff auf Funktionen bspw.
$id = loesungObject ->getId();
...
*/

//require_once("inc/DB.inc.php");

class Loesung
{


/** die Eigenschaften sind "public" und sollten auf die 
 * jeweiligen Beduerfnisse angepasst werden.
 * protected oder private.
 */
	public $LoesungId;
	public $LoesungMd5;
	public $ParentId;
	public $IntitialId;
	public $Loesungsweg;
	public $Beschreibung;
	public $Nochoffen;
	public $Angelegt;
	public $Geaendert;
	public $Sichtbar;
	public $Loeschbar;
	public $BenutzerId;
	public $FehlerInitialId;
	public $Lastchange;



	public function getLoesung( $id )
	{
        if (strlen($id) < 10) $mid = md5($id);
		//$dbh = new DB_Mysql_Prod;
		$query = "Select loesung_id,lid_md5,parent_id,initial_id,loesungsweg,beschreibung,nochoffen,
 		angelegt,geaendert, sichtbar, loeschbar, benutzer_id, lastchange, fehler_id From loesung  Where lid_md5 = '".$mid."'";
		
		echo "<br>".$query."<br><br>";
        //$result = $dbh->prepare( $query )->execute( $id )->fetch_assoc();

		$db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
        $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
        $rueckgabe = $db->query($query);
          
		$result = $rueckgabe->fetchAll(PDO::FETCH_BOTH);

		var_dump($result);
		$this->LoesungId = $result['loesung_id'];
		$this->LoesungMd5 = $result[0]['lid_md5'];
		$this->ParentId = $result[0]['parent_id'];
		$this->IntitialId = $result[0]['initial_id'];
		$this->Loesungsweg = $result[0]['loesungsweg'];
		$this->Beschreibung = $result[0]['beschreibung'];
		$this->Nochoffen = $result[0]['nochoffen'];
		$this->Angelegt = $result[0]['angelegt'];
		$this->Geaendert = $result[0]['geaendert'];
		$this->Sichtbar = $result[0]['sichtbar'];
		$this->Loeschbar = $result[0]['loeschbar'];
		$this->BenutzerId = $result[0]['benutzer_id'];
		$this->Lastchange = $result[0]['lastchange'];
		$this->FehlerInitialId = $result[0]['fehler_id'];
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
		$query = 'SHOW INDEX From loesung';
		$res = $dbh->execute($query);
		while($data = $res->fetch_row() ) {
			return $data[4];  
		}
	}

						  


	public function addLoesung( $FehlerId, $Loesungsweg, $Beschreibung, $Nochoffen, $BenutzerId )
	{
		$dbh = new DB_Mysql_Prod;
		$angelegt = date("y-m-d G:i:s", time());
		
		// ich muss zunächst feststellen, ob zur FehlerId bereits eine Lösung 
		// eingetragen wurde und diese ID ermitteln, denn das wäre die 
		// parent_id hier.
		
		$parentid = $this->getParentId($FehlerId);
		//echo $parentid;
		// 
		$query = 'INSERT INTO loesung (  loesungsweg, beschreibung, nochoffen, angelegt, benutzer_id, fehler_id, parent_id, sichtbar ) VALUES ( ::1, ::2, ::3, ::4, ::5, ::6, ::7, ::8 ) ';
		$dbh->prepare($query)->execute(  $Loesungsweg, $Beschreibung, $Nochoffen, $angelegt, $BenutzerId, $FehlerId, $parentid, 1 ); 
	
		// get LastinsertID
		$query = 'Select Max(loesung_id) From loesung';
		$result = $dbh->execute($query); 
		$data = $result->fetch_row();
		$lastid = $data[0];
		
		//get vid --- FUnktion muss noch angepasst werden
		// bei einer reinen Add Funktion entspricht die 
		// vid der Id
		/*
		$query = 'Select Max(projekt_id) From projekt';
		$result = $dbh->execute($query); 
		$data = $result->fetch_row();
		$lastid = $data[0];
		*/
		
		
		
		if (DEBUG) {
			echo "<br />".$lastid;
			echo "<br />update loesung Set lid_md5=md5(loesung_id), initial_id=loesung_id, loeschbar = 0, sichtbar = 1 where loesung_id = ".$lastid;
		}
		$query = 'UPDATE loesung SET lid_md5 = md5(loesung_id), initial_id=loesung_id, loeschbar = 0, sichtbar = 1 WHERE loesung_id = ::1';
		$dbh -> prepare( $query ) -> execute( $lastid ); 
			
	
	
	}
				//replaceLoesung( $fehlerid, $ziel, $wunsch, $Nochoffen, $userid, $loesungid ,$parentid,$initialid );
public function replaceLoesung( $FehlerId, $Loesungsweg, $Beschreibung, $Nochoffen, $BenutzerId, $LoesungId, $ParentId, $InitialId )
	{
		$dbh = new DB_Mysql_Prod;
		$angelegt = date("y-m-d G:i:s", time());
		
		// ich muss zunächst feststellen, ob zur FehlerId bereits eine Lösung 
		// eingetragen wurde und diese ID ermitteln, denn das wäre die 
		// parent_id hier.
		
		//$parentid = $this->getParentId($FehlerId);
		//echo $parentid;
		// 
		$query = 'INSERT INTO loesung (  loesungsweg, beschreibung, nochoffen, angelegt, benutzer_id, fehler_id, parent_id, initial_id, sichtbar ) VALUES ( ::1, ::2, ::3, ::4, ::5, ::6, ::7, ::8, ::9 ) ';
		$dbh->prepare($query)->execute(  $Loesungsweg, $Beschreibung, $Nochoffen, $angelegt, $BenutzerId, $FehlerId, $LoesungId, $InitialId, 1 ); 
	
		// get LastinsertID
		$query = 'Select Max(loesung_id) From loesung';
		$result = $dbh->execute($query); 
		$data = $result->fetch_row();
		$lastid = $data[0];
		
		//get vid --- FUnktion muss noch angepasst werden
		// bei einer reinen Add Funktion entspricht die 
		// vid der Id
		/*
		$query = 'Select Max(projekt_id) From projekt';
		$result = $dbh->execute($query); 
		$data = $result->fetch_row();
		$lastid = $data[0];
		*/
		
		
		
		if (DEBUG) {
			echo "<br />".$lastid;
			echo "<br />update loesung Set lid_md5=md5(loesung_id), initial_id=loesung_id, loeschbar = 0, sichtbar = 1 where loesung_id = ".$lastid;
		}
		$query = 'UPDATE loesung SET lid_md5 = md5(loesung_id), loeschbar = 0, sichtbar = 1 WHERE loesung_id = ::1';
		$dbh -> prepare( $query ) -> execute( $lastid ); 
			
	
	
	}

	
	public function updateLoesung( $LoesungId, $Loesungsweg, $Beschreibung, $Nochoffen, $Angelegt, $Geaendert, $Sichtbar, $Loeschbar, $BenutzerId )
	{
		$dbh = new DB_Mysql_Prod;
		$query = 'UPDATE loesung SET (  loesung_id = ::1, loesungsweg = ::2, beschreibung = ::3, nochoffen = ::4, angelegt = ::5, geaendert = ::6, sichtbar = ::7, loeschbar = ::8, benutzer_id = ::9 ) Where '.$this->getPrimaryKey().' = '.$this->id;
		$dbh->prepare($query)->execute( $LoesungId, $Loesungsweg, $Beschreibung, $Nochoffen, $Angelegt, $Geaendert, $Sichtbar, $Loeschbar, $BenutzerId ); 
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


	public function setDeletableLoesung( $benutzer_id )
	{
		$dbh = new DB_Mysql_Prod;
		$query = 'UPDATE loesung SET ( loeschen = 1 ) Where '.$this->getPrimaryKey().' = ::1';
		$dbh->prepare($query)->execute($this->id); 
	}

*/

	
	public function getParentId($fehlerId) {
		
		$dbh = new DB_Mysql_Prod;
		$query = 'Select Max(loesung_id) From loesung  Where fehler_id = ::1';
		
	//	echo 'Select Max(loesung_id) From loesung  Where fehler_id = '.$fehlerId;
	
		//$res = $dbh->prepare($query)->execute( $fehlerId );

		
		$data = $dbh->prepare( $query )->execute( $fehlerId )->fetch_row();
		/*
		if (!$data) {
			echo "0".$data[0];
		}
		else {
			echo " 1 ".$data[0];
		//	echo " 2 ".$data[1];
		//	echo " 3 ".$data[2];
		}
		//die();
		 *
		 */
		if (!$data) return 0;
		else
		  return $data[0];  
		
		
		
		
		//while($data = $res->fetch_row() ) {
	//		return $data[0];  
	//	}
	//	return 0;
		
	}

	
	

	public function deleteLoesung( $benutzer_id )
	{
		$dbh = new DB_Mysql_Prod;
		$query = 'Delete From loesung Where '.$this->getPrimaryKey().' = ::1';
		$dbh->prepare($query)->execute($this->id); 
	}



	public function __construct( $id )
	{
		return $this->getLoesung ( $id );
	}


	public function getLoesungId( $id )
	{
		return $this->LoesungId;
	}


	public function getLoesungIdFromDB( $id )
	{
		$dbh = new DB_Mysql_Prod;
		$query = 'Select loesung_id From loesung Where '.$this->getPrimaryKey().' = ::1';
		$data = $dbh->prepare( $query )->execute( $id )->fetch_assoc();
		return $data['loesung_id'];  
	}


	public function setLoesungId( $loesung_id )
	{
		$dbh = new DB_Mysql_Prod;
		$query = 'UPDATE loesung SET ( loesung_id = ::1 ) Where '.$this->getPrimaryKey().' = ::2';
		$dbh->prepare( $query )->execute( $loesung_id, $this->id );
	}


	public function getLoesungsweg( $id )
	{
		return $this->Loesungsweg;
	}


	public function getLoesungswegFromDB( $id )
	{
		$dbh = new DB_Mysql_Prod;
		$query = 'Select loesungsweg From loesung Where '.$this->getPrimaryKey().' = ::1';
		$data = $dbh->prepare( $query )->execute( $id )->fetch_assoc();
		return $data['loesungsweg'];  
	}


	public function setLoesungsweg( $loesungsweg )
	{
		$dbh = new DB_Mysql_Prod;
		$query = 'UPDATE loesung SET ( loesungsweg = ::1 ) Where '.$this->getPrimaryKey().' = ::2';
		$dbh->prepare( $query )->execute( $loesungsweg, $this->id );
	}


	public function getBeschreibung( $id )
	{
		return $this->Beschreibung;
	}


	public function getBeschreibungFromDB( $id )
	{
		$dbh = new DB_Mysql_Prod;
		$query = 'Select beschreibung From loesung Where '.$this->getPrimaryKey().' = ::1';
		$data = $dbh->prepare( $query )->execute( $id )->fetch_assoc();
		return $data['beschreibung'];  
	}


	public function setBeschreibung( $beschreibung )
	{
		$dbh = new DB_Mysql_Prod;
		$query = 'UPDATE loesung SET ( beschreibung = ::1 ) Where '.$this->getPrimaryKey().' = ::2';
		$dbh->prepare( $query )->execute( $beschreibung, $this->id );
	}


	public function getNochoffen( $id )
	{
		return $this->Nochoffen;
	}


	public function getNochoffenFromDB( $id )
	{
		$dbh = new DB_Mysql_Prod;
		$query = 'Select nochoffen From loesung Where '.$this->getPrimaryKey().' = ::1';
		$data = $dbh->prepare( $query )->execute( $id )->fetch_assoc();
		return $data['nochoffen'];  
	}


	public function setNochoffen( $nochoffen )
	{
		$dbh = new DB_Mysql_Prod;
		$query = 'UPDATE loesung SET ( nochoffen = ::1 ) Where '.$this->getPrimaryKey().' = ::2';
		$dbh->prepare( $query )->execute( $nochoffen, $this->id );
	}


	public function getAngelegt( $id )
	{
		return $this->Angelegt;
	}


	public function getAngelegtFromDB( $id )
	{
		$dbh = new DB_Mysql_Prod;
		$query = 'Select angelegt From loesung Where '.$this->getPrimaryKey().' = ::1';
		$data = $dbh->prepare( $query )->execute( $id )->fetch_assoc();
		return $data['angelegt'];  
	}


	public function setAngelegt( $angelegt )
	{
		$dbh = new DB_Mysql_Prod;
		$query = 'UPDATE loesung SET ( angelegt = ::1 ) Where '.$this->getPrimaryKey().' = ::2';
		$dbh->prepare( $query )->execute( $angelegt, $this->id );
	}


	public function getGeaendert( $id )
	{
		return $this->Geaendert;
	}


	public function getGeaendertFromDB( $id )
	{
		$dbh = new DB_Mysql_Prod;
		$query = 'Select geaendert From loesung Where '.$this->getPrimaryKey().' = ::1';
		$data = $dbh->prepare( $query )->execute( $id )->fetch_assoc();
		return $data['geaendert'];  
	}


	public function setGeaendert( $geaendert )
	{
		$dbh = new DB_Mysql_Prod;
		$query = 'UPDATE loesung SET ( geaendert = ::1 ) Where '.$this->getPrimaryKey().' = ::2';
		$dbh->prepare( $query )->execute( $geaendert, $this->id );
	}


	public function getSichtbar( $id )
	{
		return $this->Sichtbar;
	}


	public function getSichtbarFromDB( $id )
	{
		$dbh = new DB_Mysql_Prod;
		$query = 'Select sichtbar From loesung Where '.$this->getPrimaryKey().' = ::1';
		$data = $dbh->prepare( $query )->execute( $id )->fetch_assoc();
		return $data['sichtbar'];  
	}


	public function setSichtbar( $sichtbar )
	{
		$dbh = new DB_Mysql_Prod;
		$query = 'UPDATE loesung SET ( sichtbar = ::1 ) Where '.$this->getPrimaryKey().' = ::2';
		$dbh->prepare( $query )->execute( $sichtbar, $this->id );
	}


	public function getLoeschbar( $id )
	{
		return $this->Loeschbar;
	}


	public function getLoeschbarFromDB( $id )
	{
		$dbh = new DB_Mysql_Prod;
		$query = 'Select loeschbar From loesung Where '.$this->getPrimaryKey().' = ::1';
		$data = $dbh->prepare( $query )->execute( $id )->fetch_assoc();
		return $data['loeschbar'];  
	}


	public function setLoeschbar( $loeschbar )
	{
		$dbh = new DB_Mysql_Prod;
		$query = 'UPDATE loesung SET ( loeschbar = ::1 ) Where '.$this->getPrimaryKey().' = ::2';
		$dbh->prepare( $query )->execute( $loeschbar, $this->id );
	}


	public function getBenutzerId( $id )
	{
		return $this->BenutzerId;
	}


	public function getBenutzerIdFromDB( $id )
	{
		$dbh = new DB_Mysql_Prod;
		$query = 'Select benutzer_id From loesung Where '.$this->getPrimaryKey().' = ::1';
		$data = $dbh->prepare( $query )->execute( $id )->fetch_assoc();
		return $data['benutzer_id'];  
	}


	public function setBenutzerId( $benutzer_id )
	{
		$dbh = new DB_Mysql_Prod;
		$query = 'UPDATE loesung SET ( benutzer_id = ::1 ) Where '.$this->getPrimaryKey().' = ::2';
		$dbh->prepare( $query )->execute( $benutzer_id, $this->id );
	}
	
	
	//	public $LoesungMd5;
	
	public function getLoesungMd5(  )
	{
		return $this->LoesungMd5;
	}
	
	public function setLoesungMd5( $id )
	{
		$dbh = new DB_Mysql_Prod;
		$query = 'UPDATE loesung SET ( lid_md5 = ::1 ) Where loesung_id = ::2';
		$dbh->prepare( $query )->execute( $lid_md5, $this->id );
	}
	
	//  public $ParentId;
	
	/*public function getParentId( )
	{
		return $this->ParentId;
	}
	*/
	public function setParentId( $parent_id )
	{
		$dbh = new DB_Mysql_Prod;
		$query = 'UPDATE loesung SET ( parent_id = ::1 ) Where '.$this->getPrimaryKey().' = ::2';
		$dbh->prepare( $query )->execute( $parent_id, $this->id );
	}
		
	//  public $IntitialId;
	public function getIntitialId(  )
	{
		return $this->IntitialId;
	}
	
	public function setInitialId( $initial_id )
	{
		$dbh = new DB_Mysql_Prod;
		$query = 'UPDATE loesung SET ( initial_id = ::1 ) Where '.$this->getPrimaryKey().' = ::2';
		$dbh->prepare( $query )->execute( $initial_id, $this->id );
	}
	
	//  Lastchange
	
	public function getLastchanged(  )
	{
		return $this->Lastchange;
	}
	
	public function getFehlerId(  )
	{
		return $this->FehlerId;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	public function getAlleLoesungen ( $fehlerid, $von=0, $lim=30, $order='desc' )
	{
		$oZeit = new Zeit();
		$dat = array();
		$db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
        $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
       
		
		// $sql = "SELECT * FROM `loesung` WHERE `fehler_id` = 237 AND `loeschbar` = 0 AND `sichtbar` = 1 LIMIT 0, 30 ";
		
		//echo "<br />".'Select * From `loesung`  Where `fehler_id` = '.$fehlerid.' and `loeschbar` = 0 and `sichtbar` = 1 order by `loesung_id` '.$order.' Limit '.$von.', '.$lim;
		 //f.id in (select Max(f2.id) from fehler f2 group by initial_id)
		
		$query = 'Select * From `loesung`  
		Where 
		 loesung_id in (select Max(l2.loesung_id) from loesung l2 group by initial_id)
		and
		 `fehler_id` = '.$fehlerid.' 
		and `loeschbar` = 0 
		and `sichtbar` = 1 
		order by `loesung_id` '.$order.' 
		Limit '.intval($von).' ,'.intval($lim);

		
	    echo "<br />".$query."<br />";

	/*	$result =
		$dbh->
		prepare( $query )->
		execute( $order,intval($von),intval($lim),$fehlerid  );
   */
	      
        $rueckgabe = $db->query($query);
         
		//$result = $rueckgabe->fetchAll(PDO::FETCH_BOTH);

	 //$rs = new DB_Result($dbh->execute($query));
	 $i=0;


	echo "<br> Es ist mir noch nicht gelungen dieses Konstrukt, neu anzupassen<br>";
	// Hier läuft die Schleife, solange etwas geladen werden kann
	echo 'while($data=$result->fetch_assoc())';
	// diese prüft den Inhalt nicht.
	echo "<br><br>Ansatz: ".'$data=$result'."<br><br>";

	// Aber so scheint es zu funktionieren! Nein auch noch nicht. 

	 $j=0;
	 $data=$rueckgabe->fetchAll(PDO::FETCH_BOTH);
	// echo "<br />". sizeOf($data)."<br />";	
	 while($j<sizeOf($data))
	 {
	 	// verschiedene werden natürlich nicht mehr benötigt werden
	//	echo "<br />". $i." < - > ". sizeOf($data)."<br />";	
	 	// und mir gefällt der Ansatz ein eindimensionales Array zu verwenden
	 	// überhaupt nicht
	 	// aber erstmal soll es funktionieren.
			
			$difTage = "";
			
			$dat[$i] = $data[$j]['loesung_id'];

		//	echo "TEST: ".$dat[$i]."<br>";

			$dat[$i+1]=$data[$j]['benutzer_id'];
			$dat[$i+2]=$data[$j]['fehler_id'];
			//if ($dat[$i+1] == '') $dat[$i+1] = $dat[$i+2];
			$dat[$i+3]=$data[$j]['beschreibung'];
			$dat[$i+4]=$data[$j]['loesungsweg'];
			$dat[$i+5]=$data[$j]['angelegt'];
			$angelegt = $dat[$i+5];
			
			$wi = 0;
			
	 		if ($dat[$i+5] != "" && $dat[$i+5]!= "0000-00-00 00:00:00" )
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
				}
				
			}
			
			
			
			$dat[$i+6]=$data[$j]['loeschbar'];
			$dat[$i+7]=$data[$j]['sichtbar'];
			$dat[$i+8]=$data[$j]['nochoffen'];
			$dat[$i+9]=$data[$j]['benutzer_id'];
			$dat[$i+10]=$data[$j]['parent_id'];
			
			$i=$i+10;
			$j=$j+1;
		//if ($i>=30) return $dat;
		}
		echo "<br />". sizeOf($dat)."<br />";	
		return $dat;
	}
	
	
}