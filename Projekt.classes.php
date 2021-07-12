<?php

/** 
 * @author Rainer
 * 
 */
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
 * KlassenName: >> Projekt <<
 * Tabelle: projekt
 * Version : V0.1
 * Date 27.06.2008
 *
 * addProjekt angepasst
 *
 *****************************************************************************/

// Einsatzmoeglichkeit
/*
 // erzeuge Objekt
 projektObject = new Projekt($id);

 // Zugriff auf Funktionen bspw.
 $id = projektObject ->getId();
 ...
 */

//require_once("inc/DB.inc.php");

class Projekt
{


	/** die Eigenschaften sind "public" und sollten auf die
	 * jeweiligen Beduerfnisse angepasst werden.
	 * protected oder private.
	 */
	public $ProjektId;
	public $Name;
	public $Erlaeuterung;
	public $Beginn;
	public $Deadline;
	public $Angelegt;
	public $Anzahlprogramierer;
	public $Loeschbar;
	public $Sichtbar;
	private $Pidmd5;

	public function getProjekt( $id )
	{
		$dbh = new DB_Mysql_Prod;
		$query = 'Select * From projekt  Where projekt_id = ::1';
		$result = $dbh->prepare( $query )->execute( $id )->fetch_assoc();

		$this->ProjektId = $result['projekt_id'];
		$this->Name = $result['name'];
		$this->Erlaeuterung = $result['erlaeuterung'];
		$this->Beginn = $result['beginn'];
		$this->Deadline = $result['deadline'];
		$this->Angelegt = $result['angelegt'];
		$this->Anzahlprogramierer = $result['anzahlprogramierer'];
		$this->Loeschbar = $result['loeschbar'];
		$this->Sichtbar = $result['sichtbar'];
		$this->Pidmd5 = $result['pid_md5'];
		return $this;
	}

   public function getMd5Projekt( $pidmd5 )
	{
		$dbh = new DB_Mysql_Prod;
		$query = 'Select * From projekt  Where pid_md5 LIKE ::1 LIMIT 1';

		//echo  'Select * From projekt  Where pid_md5 = '.$pidmd5;
		$result = $dbh->prepare( $query )->execute( $pidmd5 )->fetch_assoc();

		$this->ProjektId = $result['projekt_id'];
		$this->Name = $result['name'];
		$this->Erlaeuterung = $result['erlaeuterung'];
		$this->Beginn = $result['beginn'];
		$this->Deadline = $result['deadline'];
		$this->Angelegt = $result['angelegt'];
		$this->Anzahlprogramierer = $result['anzahlprogramierer'];
		$this->Loeschbar = $result['loeschbar'];
		$this->Sichtbar = $result['sichtbar'];
		// $this->Pidmd5 = $result['pid_md5'];
		$this->Pidmd5 = $pidmd5;
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
		$query = 'SHOW INDEX From projekt';
		$res = $dbh->execute($query);
		while($data = $res->fetch_row() ) {
			return $data[4];
		}
	}




	public function addProjekt(  $Name, $Erlaeuterung, $Beginn, $Deadline, $Anzahlprogramierer ,$userid,$kuerzel,$initialId,$parentId )
	{
		$dbh = new DB_Mysql_Prod;
		$Angelegt = date("Y-m-d H:i:s", time());
		$query = 'INSERT INTO projekt (  name, erlaeuterung, beginn, deadline, angelegt, anzahlprogramierer, benutzer_id,kuerzel) VALUES ( ::1, ::2, ::3, ::4, ::5, ::6, ::7, ::8 ) ';
		$dbh->prepare($query)->execute(  $Name, $Erlaeuterung, $Beginn, $Deadline, $Angelegt, $Anzahlprogramierer,$userid, $kuerzel );
	
		// get LastinsertID
		
		if ($initialId==0){
		$query = 'Select Max(projekt_id) From projekt';
		$result = $dbh->execute($query); 
		$data = $result->fetch_row();
		$lastid = $data[0];
		$initialId = $lastid;
		}
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
		  echo '<div class="mittig dumpbox">';
			echo "<br />".$lastid;
			echo "<br />update projekt Set pid_md5=md5(projekt_id), initial_id=projekt_id, loeschbar = 0, sichtbar = 1 where projekt_id = ".$lastid;
	    echo '</div>';
  	}
		$query = 'UPDATE projekt SET pid_md5 = md5(projekt_id), initial_id = ::2, parent_id = ::3, loeschbar = 0, sichtbar = 1 WHERE projekt_id = ::1';
		$dbh -> prepare( $query ) -> execute( $lastid,$initialId,$parentId ); 
		
	
	}

   /**
   
    Initial_id und parent_id werden nicht eingetragen
   **/


	public function updateProjekt( $ProjektId, $Name="", $Kuerzel="",$Erlaeuterung="", $Beginn, $Deadline,$Anzahlprogramierer )
	{
		$dbh = new DB_Mysql_Prod;
		$query = 'UPDATE projekt SET ';
		if ($Name=='') {} else $query .= ' name = ::2,';
		if ($Erlaeuterung=='') {} else $query .= ' erlaeuterung = ::3,';
		if ($Kuerzel=='') {} else $query .= ' kuerzel = ::4,';
		if ($Beginn=='') {} else $query .= ' beginn = ::5,';
		if ($Deadline=='') {} else $query .= ' deadline = ::6, ';
		if ($Anzahlprogramierer=='') {} else $query .= ' anzahlprogramierer = ::7 ';	
		$query .= '  Where pid_md5 = ::1';
		echo $query;
		$dbh->prepare($query)->execute( $ProjektId, $Name, $Erlaeuterung, $Kuerzel,$Beginn, $Deadline,$Anzahlprogramierer );// $Beginn, $Deadline, $Anzahlprogramierer );
	
		
		/*
		$query = 'Select Max(projekt_id) From projekt';
		$result = $dbh->execute($query);
		$data = $result->fetch_row();
		$lastid = $data[0];
		//echo "<br />ID = ".$lastid."<br>";
		//die();

		//,`angelegt`,`erledigt`

		// den verschlüsselten Key hinzufügen

		//$query = 'update todo Set fid_md5=md5(Max(id))';
		
		
		$query = 'UPDATE projekt SET pid_md5 = md5(projekt_id), initial_id = ::2, parent_id = ::3, loeschbar = 0, sichtbar = 1 WHERE projekt_id = ::1';
		$dbh -> prepare( $query ) -> execute( $lastid,$initialId,$parentId ); 
		*/
	}
		/*$query = 'update projekt Set tid_md5=md5(id), angelegt =::1 , geaendert =::2, geloescht=0, sichtbar=1, erledigt="00-00-00 00:00:00", initial_id=::4, user_id=::5, thema=::6, parent_id=::7 where id = ::3';
		$dbh->prepare($query)->execute($datum, $datum, $lastid, $InitialId, $userid, $thema, $parentid);
		
		
		
		
		
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


	public function setDeletableProjekt( $sichtbar )
	{
	$dbh = new DB_Mysql_Prod;
	$query = 'UPDATE projekt SET ( loeschen = 1 ) Where '.$this->getPrimaryKey().' = ::1';
	$dbh->prepare($query)->execute($this->id);
	}

	*/



	public function deleteProjekt(  )
	{
		$dbh = new DB_Mysql_Prod;
		$query = 'Delete From projekt Where loeschbar=1';
		$dbh->prepare($query)->execute();
	}



	public function __construct( $id=0 )
	{
		if ($id!=0)
		{
			return $this->getProjekt($id);
		}
		return $this->id = $id;
	}


	public function getProjektId( $id )
	{
		return $this->ProjektId;
	}


	public function getProjektIdFromDB( $pro_id )
	{
		$dbh = new DB_Mysql_Prod;
		$query = 'Select projekt_id From projekt  Where pid_md5 LIKE ::1 LIMIT 1';
		$data = $dbh->prepare( $query )->execute( $pro_id )->fetch_assoc();
		return $data['projekt_id'];
	}


	public function setProjektId( $projekt_id )
	{
		$dbh = new DB_Mysql_Prod;
		$query = 'UPDATE projekt SET ( projekt_id = ::1 ) Where '.$this->getPrimaryKey().' = ::2';
		$dbh->prepare( $query )->execute( $projekt_id, $this->id );
	}


	public function getName(  )
	{
		return $this->Name;
	}


	public function getNameFromDB( $id )
	{
		$dbh = new DB_Mysql_Prod;
		$query = 'Select name From projekt Where '.$this->getPrimaryKey().' = ::1';
		$data = $dbh->prepare( $query )->execute( $id )->fetch_assoc();
		return $data['name'];
	}


	public function setName( $name )
	{
		$dbh = new DB_Mysql_Prod;
		$query = 'UPDATE projekt SET ( name = ::1 ) Where '.$this->getPrimaryKey().' = ::2';
		$dbh->prepare( $query )->execute( $name, $this->id );
	}


	public function getErlaeuterung( $id )
	{
		return $this->Erlaeuterung;
	}


	public function getErlaeuterungFromDB( $id )
	{
		$dbh = new DB_Mysql_Prod;
		$query = 'Select erlaeuterung From projekt Where '.$this->getPrimaryKey().' = ::1';
		$data = $dbh->prepare( $query )->execute( $id )->fetch_assoc();
		return $data['erlaeuterung'];
	}


	public function setErlaeuterung( $erlaeuterung )
	{
		$dbh = new DB_Mysql_Prod;
		$query = 'UPDATE projekt SET ( erlaeuterung = ::1 ) Where '.$this->getPrimaryKey().' = ::2';
		$dbh->prepare( $query )->execute( $erlaeuterung, $this->id );
	}


	public function getBeginn( $id )
	{
		return $this->Beginn;
	}


	public function getBeginnFromDB( $id )
	{
		$dbh = new DB_Mysql_Prod;
		$query = 'Select beginn From projekt Where '.$this->getPrimaryKey().' = ::1';
		$data = $dbh->prepare( $query )->execute( $id )->fetch_assoc();
		return $data['beginn'];
	}


	public function setBeginn( $beginn )
	{
		$dbh = new DB_Mysql_Prod;
		$query = 'UPDATE projekt SET ( beginn = ::1 ) Where '.$this->getPrimaryKey().' = ::2';
		$dbh->prepare( $query )->execute( $beginn, $this->id );
	}


	public function getDeadline( $id )
	{
		return $this->Deadline;
	}


	public function getDeadlineFromDB( $id )
	{
		$dbh = new DB_Mysql_Prod;
		$query = 'Select deadline From projekt Where '.$this->getPrimaryKey().' = ::1';
		$data = $dbh->prepare( $query )->execute( $id )->fetch_assoc();
		return $data['deadline'];
	}


	public function setDeadline( $deadline )
	{
		$dbh = new DB_Mysql_Prod;
		$query = 'UPDATE projekt SET ( deadline = ::1 ) Where '.$this->getPrimaryKey().' = ::2';
		$dbh->prepare( $query )->execute( $deadline, $this->id );
	}


	public function getAngelegt( $id )
	{
		return $this->Angelegt;
	}


	public function getAngelegtFromDB( $id )
	{
		$dbh = new DB_Mysql_Prod;
		$query = 'Select angelegt From projekt Where '.$this->getPrimaryKey().' = ::1';
		$data = $dbh->prepare( $query )->execute( $id )->fetch_assoc();
		return $data['angelegt'];
	}


	public function setAngelegt( $angelegt )
	{
		$dbh = new DB_Mysql_Prod;
		$query = 'UPDATE projekt SET ( angelegt = ::1 ) Where '.$this->getPrimaryKey().' = ::2';
		$dbh->prepare( $query )->execute( $angelegt, $this->id );
	}


	public function getAnzahlprogramierer( $id )
	{
		return $this->Anzahlprogramierer;
	}


	public function getAnzahlprogramiererFromDB( $id )
	{
		$dbh = new DB_Mysql_Prod;
		$query = 'Select anzahlprogramierer From projekt Where '.$this->getPrimaryKey().' = ::1';
		$data = $dbh->prepare( $query )->execute( $id )->fetch_assoc();
		return $data['anzahlprogramierer'];
	}


	public function setAnzahlprogramierer( $anzahlprogramierer )
	{
		$dbh = new DB_Mysql_Prod;
		$query = 'UPDATE projekt SET ( anzahlprogramierer = ::1 ) Where '.$this->getPrimaryKey().' = ::2';
		$dbh->prepare( $query )->execute( $anzahlprogramierer, $this->id );
	}


	public function getLoeschbar(  )
	{
		return $this->Loeschbar;
	}


	public function getLoeschbarFromDB( $id )
	{
		$dbh = new DB_Mysql_Prod;
		$query = 'Select loeschbar From projekt Where pid_md5 = ::1';
		$data = $dbh->prepare( $query )->execute( $id )->fetch_assoc();
		return $data['loeschbar'];
	}


	public function setLoeschbar( $id )
	{
		
	    //$loeschbar = $this->getLoeschbar();
		$loeschbar = $this->getLoeschbarFromDB($id);
		
		//$sichtbar = 0;
		
		//echo "Sichtbar: ".$sichtbar."<br />";
		$dbh = new DB_Mysql_Prod;
		 if ($loeschbar == 0) { 
			$loeschbar=1;
		}
		else { 
			$loeschbar=0;
		}
		
		
		// echo $query = 'UPDATE projekt SET  loeschbar = 1  Where pid_md5 = '.$id;
		$query = 'UPDATE projekt SET  loeschbar = ::2, sichtbar=0 Where pid_md5 = ::1';
		$dbh->prepare( $query )->execute( $id,$loeschbar );
	}


	public function getSichtbar( $id="" )
	{
		return $this->Sichtbar;
	}


	public function getSichtbarFromDB( $id )
	{
		$dbh = new DB_Mysql_Prod;
		//echo "<strong>Funktioniert noch nicht korrekt !</strong>";
		
		$query = 'Select sichtbar From projekt Where pid_md5  = ::1';
		//echo "<br />".'Select sichtbar From projekt Where projekt_id  = '.$id."<br />";
		$data = $dbh->prepare( $query )->execute( $id )->fetch_assoc();
		$this->Sichtbar = $data['sichtbar'];
		return  $this->Sichtbar;
	}


	public function setSichtbar( $id )
	{
		//$sichtbar = $this->getSichtbar();
		$sichtbar = $this->getSichtbarFromDB($id);
		
		//$sichtbar = 0;
		
		//echo "Sichtbar: ".$sichtbar."<br />";
		
		 if ($sichtbar == 0) { 
			$sichtbar=1;
		}
		else { 
			$sichtbar=0;
		}
		
		//echo "Sichtbar: ".$sichtbar."<br />";
		
		$dbh = new DB_Mysql_Prod;
		if (DEBUG) {
		  echo '<div class="mittig dumpbox">';
		  echo 'UPDATE projekt SET sichtbar = '.$sichtbar.' Where pid_md5 = '.$id;
		  echo '</div>';
		}
		$query = 'UPDATE projekt SET sichtbar = ::2 Where pid_md5 = ::1';
		$dbh->prepare( $query )->execute( $id, $sichtbar );
	}


	/**
	 * Nachfolgend der Versuch die SQL Funktionen
	 * in diese Klasse zu integrieren.
	 */

	public function Projekteausgeben()
	{

		$dbh = new DB_Mysql_Prod;
		$query = 'Select projekt_id, name From projekt where loeschbar=0 and sichtbar=1 order by name asc';
		$res = $dbh->execute( $query );
 		
		//echo "<select name=\"projekt\" onChange=\"validateInput(this.value)\">";
		echo "<select name=\"projekt\" onChange=\"JAVASCRIPT:auswertung();\">";

		while($data = $res->fetch_row() )
		{
			echo"<option value=".($data[0]).">".$data[1]."</option>";
		}

		echo "</select>";
		
	}

	public function Projekteausgebenvorauswahl($pid)
	{

		$dbh = new DB_Mysql_Prod;
		$query = 'Select projekt_id, name From projekt where loeschbar=0 and sichtbar=1 order by name asc';
		$res = $dbh->execute( $query );

		echo "<select name=\"projekt\">";

		while($data = $res->fetch_row() )
		{
			$projektid = $data[0];	
			if ($pid != $projektid  )
			  echo"<option value=".$projektid .">".$data[1]."</option>";
			else
			  echo"<option selected value=".$projektid .">".$data[1]."</option>";
		}

		echo "</select>";
	}

	/**
	 * in anlehung an "Projekteuebersicht" aus sqlfunction
	 *
	 * Enter description here ...
	 */
	public function Projekteuebersicht()
	{

		$dbh = new DB_Mysql_Prod;
		$query = 'Select projekt_id, name, sichtbar, loeschbar From projekt where projekt_id
		in (select max(p2.projekt_id) From projekt p2 group by p2.initial_id ) order by name asc';
		$res = $dbh->execute( $query );
		
		if (DEBUG) echo $query;
		//echo "<select name=\"projekt\">";

		$j=0;
		echo '<table>';
		while($data = $res->fetch_row() )
		{

			$bcol = $j%2 ? '#eaefef' : '#f3f3f4';
			$projektid = md5($data[0]);	
			
			if (DEBUG) {
				echo '<div class="mittig dumpbox">';
				echo "<br />".$data[0]." ".$data[1]." ".$data[2]." ".$data[3];
				echo '</div>';
			}
			
			
			$sichtbar = $data[2];
			
			$loeschbar =$data[3];
		
			echo '<tr style="background-color:'.$bcol.';border:black 1px solid;">';
			echo '<td>'."\n".'<a style="font-size: 14px; font-weight: bold;" ';
		 	echo 'href="../../../fehlerreport/projekt/detail/'.$projektid .'">'.$data[1].'</a>'."\n";
		 	echo '</td>'."\n";
		 	echo '<td>'."\n";
		 	//echo "<br />sichtbar ".$sichtbar."<br />loeschbar ".$loeschbar."<br />";
		 	if ( $sichtbar!=0 ){
		 	 echo '<a style="font-size: 10px; font-weight: bold;" ';
		 	}
		 	else {
		 		echo '<a style="font-size: 10px; font-weight: bold; text-decoration:line-through;font-color:#cccccc;" ';
		 	}
		 	
		 	echo 'href="../../../fehlerreport/projekt/sichtbar/'.$projektid .'"  title="Sie können das Projekt hier unsichtbar stellen">sichtbar</a>'."\n";
		 	echo '</td>';
		 	
		 	if ( $loeschbar!=1  ){
		 	  echo '<td>'."\n".'<a style="font-size: 10px; font-weight: bold;" ';
		 	}
		 	else {
		 		echo '<td>'."\n".'<a style="font-size: 10px; font-weight: bold; background-color:red; font-color:#fff;" ';
		 	}
		 	echo 'href="../../../fehlerreport/projekt/loeschen/'.$projektid .'"  title="Sie können das Projekt hier löschen">l&ouml;schen</a>'."\n";
		 	echo '</td>';
		 	echo '</tr>';

		 	++$j;
		 	$data=null;
		 	$sichtbar=null;
		 	$loeschbar=null;
		  if (DEBUG) {
        echo '<div class="mittig dumpbox">';
        echo"<option value=".$data[0].">".$data[1]."</option>";
        echo '</div>';
        }
		}

		echo '</table>';
	}

	
	public function sichtbarProjektUebersicht () {
	/*** anpassen ***/
        $dbh = new DB_Mysql_Prod;
		$query = 'Select projekt_id, name, sichtbar, loeschbar From projekt  where sichtbar=1 and loeschbar=0 
		and projekt_id in (select max(p2.projekt_id) From projekt p2 group by p2.initial_id ) order by name asc';
	
		$res = $dbh->execute( $query );

		//echo "<select name=\"projekt\">";

		$j=0;
		echo '<table>';
		while($data = $res->fetch_row() )
		{

			$bcol = $j%2 ? '#eaefef' : '#f3f3f4';
			//$projektid = md5($data[0]);	
			$projektid = $data[0];
			echo '<tr style="background-color:'.$bcol.';border:black 1px solid;">';
			echo '<td>'."\n".'<a style="font-size: 14px; font-weight: bold;" ';
		 	echo 'href="'.PFAD.'/'.APPNAME.'/teilprojekt/auswahl/'.$projektid .'">'.$data[1].'</a>'."\n";
		 	echo '</td>'."\n";
		 	
		 	echo '<td>'."\n".'<a style="font-size: 7px; font-weight: bold;" ';
		 	echo 'href="'.PFAD.'/'.APPNAME.'/teilprojekt/detail/'.$projektid .'">bearbeiten</a>'."\n";
		 	echo '</td>'."\n";
		 	if ($data[2]==0) {
		 	  echo '<td>'."\n".'<a style="font-size: 7px; font-weight: bold;text-decoration:line-through;font-color:#cccccc;" ';
		 	}
		 	else {
		 	  echo '<td>'."\n".'<a style="font-size: 7px; font-weight: bold;" ';	
		 	}
		 	echo 'href="'.PFAD.'/'.APPNAME.'/teilprojekt/sichtbar/'.$projektid .'"  title="Sie können das Konzept hier unsichtbar stellen">eingeschränkt/offen</a>'."\n";
		 	echo '</td>';
		 	
		 	if ($data[3]==1) {
		 	  echo '<td>'."\n".'<a style="font-size: 7px; font-weight: bold;background-color:red; font-color:#fff;" ';
		 	}
		 	else {
		 		echo '<td>'."\n".'<a style="font-size: 7px; font-weight: bold;" ';
		 	}
		
		 	echo 'href="'.PFAD.'/'.APPNAME.'/teilprojekt/loeschen/'.$projektid .'"  title="Sie können das Konzept hier löschen">l&ouml;schen</a>'."\n";
		 	echo '</td>';
		 	echo '</tr>';

		 	++$j;
		 	
		 //echo"<option value=".$data[0].">".$data[1]."</option>";
		}

		echo '</table>';
	}
	
	public function sichtbarProjektuebersichtTeilprojekt () {
	/*** anpassen ***/
        $dbh = new DB_Mysql_Prod;
		$query = 'Select  p1.name, p1.projekt_id, p1.sichtbar, p1.loeschbar, p1.kuerzel, p1.angelegt, p1.prioritaet 
				From projekt p1 
				where projekt_id
				in (select max(p2.projekt_id) From projekt p2 group by p2.initial_id ) 
				and
				p1.sichtbar=1 and p1.loeschbar=0 order by p1.name asc';
		$res = $dbh->execute( $query );

		//echo "<select name=\"projekt\">";

		$j=0;
		echo '<table style="background-color:white;">';
		echo '<tr style="background-color:darkblue;border:black 1px solid;">';
		echo '<th style="color:white;font-size:0.8em;font-weight:boldest;padding:3px;">NAME</th>';
		echo '<th style="color:white;font-size:0.8em;font-weight:boldest;padding:3px;">KÜRZ</th>';	
		echo '<th style="color:white;font-size:0.8em;font-weight:boldest;padding:3px;">ANGE</th>';	
		echo '<th style="color:white;font-size:0.8em;font-weight:boldest;padding:3px;">STAT</th>';	
		echo '<th colspan=2 style="color:white;font-size:0.8em;font-weight:boldest;padding:3px;">PRIO</th>';
		//echo '<th style="color:white;font-size:0.8em;font-weight:boldest;padding:3px;">PRIO</th>';		
		
		while($data = $res->fetch_row() )
		{

			$bcol = $j%2 ? '#eaefef' : '#f3f3f4';
			//$projektid = md5($data[0]);	
			$projektid = $data[1];
			$datum = substr($data[5],0,10);
			$oZeit= new Zeit();
			$datum = $oZeit->datumEinD($datum); 
			echo '<tr style="background-color:'.$bcol.';border:black 1px solid;">';
			echo '<td padding:3px;>'."\n".'<a style="font-size: 14px; font-weight: bold;" ';
		 	echo 'href="'.PFAD.'/'.APPNAME.'/teilprojekt/auswahl/'.$projektid .'">'.$data[0].'</a>'."\n";
		 	echo '</td>'."\n";
			echo '<td style="font-size:0.9em;padding:3px;">'.$data[4].'</td>'."\n";
			echo '<td style="font-size:0.8em;padding:3px;">'.$datum.'</td>'."\n";
			echo '<td style="font-size:0.8em;padding:3px;"><a href=""'.PFAD.'/'.APPNAME.'/projekt/planung/'.$projektid .'"">Planung<a/></td>'."\n";
		 	echo '<td style="font-size:0.8em;padding:3px;">'.$data[6].'</td>
		 	<td style="font-size:0.7em;padding:0px;"><small><a href="'.PFAD.'/'.APPNAME.'/teilprojekt/prioinkrement/'.$projektid .'"">(+)</a><br/><a href="'.PFAD.'/'.APPNAME.'/teilprojekt/priodekrement/'.$projektid .'"">(-)</a></small></td>'."\n";
			echo '</tr>';

		 	++$j;
		 	
		 //echo"<option value=".$data[0].">".$data[1]."</option>";
		}

		echo '</table>';
	}
	
	public function zeigeProjekt($id)  {
		
		$dbh = new DB_Mysql_Prod;
		$query = 'Select p1.name, p1.erlaeuterung, p1.beginn ,p1.deadline, 
		p1.anzahlprogramierer, p1.angelegt,p1.kuerzel,p1.initial_id,p1.parent_id  From projekt p1 where  p1.projekt_id
				in (select max(p2.projekt_id) From projekt p2 group by p2.initial_id ) 
				and p1.pid_md5 = ::1';
		$res = $dbh->prepare( $query )->execute($id);
		
		

		$data = $res->fetch_row();
		$ret[0]=$data[0];
		$ret[1]=$data[1];
		$ret[2]=$data[2];
		$ret[3]=$data[3];
		$ret[4]=$data[4];
		$ret[5]=$data[5];
		$ret[6]=$data[6];
		$ret[7]=$data[7];
		$ret[8]=$data[8];
		return $ret;
	}
	
	


}

