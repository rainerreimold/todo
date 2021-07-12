<?php
/********************************************************************************************



 Autor: R. Reimold
 Datum: 18.07.2021

********************************************************************************************/


class Projekt {

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
		//$result = $dbh->prepare( $query )->execute( $id )->fetch_assoc();
		$result = $dbh->fetch_assoc( $query );

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

   public function getMd5Projekt( $pidmd5 = 'c042f4db68f23406c6cecf84a7ebb0fe')
	{
		$dbh = new DB_Mysql_Prod;
		$query = 'Select * From projekt  Where pid_md5 LIKE '.$pidmd5.' LIMIT 1';

		$result = $dbh->fetch_assoc( $query );

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

	public function getProjekte( $pid = '0') {

	try {
		
		$dbh = new DB_Mysql_Prod;
		$sql = "SELECT distinct `projekt_id`, `name`, `erlaeuterung`, `name`, `kuerzel`, `pid_md5`, `beginn`,`status`  
 					FROM `projekt` 
 					where 
 					projekt_id in (select max(projekt_id) from projekt group by initial_id)
 					and
 					loeschbar=0 and sichtbar=1 order by name asc";        

		$ergebnis = $dbh->fetch_assoc($sql);
					
        $db=null;
        $i=0;
		$ret="";
		if ($ergebnis) {
		  foreach ( $ergebnis as $inhalt) {
				
			++$i;
			if ($pid==$inhalt['projekt_id']){
				$ret=$ret."<option selected value=\"".$inhalt['projekt_id']."\" title=\"".$inhalt['erlaeuterung']."\">".$inhalt['name']." - ".$inhalt['kuerzel']." </option>\n";
			} else {
				$ret=$ret."<option value=\"".$inhalt['projekt_id']."\" title=\"".$inhalt['erlaeuterung']."\">".$inhalt['name']." - ".$inhalt['kuerzel']." </option>\n";
			}

		  }
		  return $ret;        
        }

    }

    catch(PDOException $e){
        print $e->getMessage();
    }
    return -1;
  }
}