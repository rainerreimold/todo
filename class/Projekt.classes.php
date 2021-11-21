<?php
/********************************************************************************************

 Hinweis: 

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


	public function __construct( $id )
	{
		return $this->getProjekt ( $id );
	}	

	public function getProjekt( $id=10 )
	{

		$query = 'Select projekt_id,name,erlaeuterung,beginn,deadline,angelegt,anzahlprogramierer,
		loeschbar,sichtbar,pid_md5	 From projekt  Where projekt_id ='.$id;
		//echo "<br>ID= ".$id."<br>";

		$db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
        $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
        $rueckgabe = $db->query($query);
          
		$result = $rueckgabe->fetchAll(PDO::FETCH_BOTH);


		$this->ProjektId = $result[0]['projekt_id'];
		$this->Name = $result[0]['name'];
		$this->Erlaeuterung = $result[0]['erlaeuterung'];
		$this->Beginn = $result[0]['beginn'];
		$this->Deadline = $result[0]['deadline'];
		$this->Angelegt = $result[0]['angelegt'];
		$this->Anzahlprogramierer = $result[0]['anzahlprogramierer'];
		$this->Loeschbar = $result[0]['loeschbar'];
		$this->Sichtbar = $result[0]['sichtbar'];
		$this->Pidmd5 = $result[0]['pid_md5'];

		//echo "<br> --> ".$this->Name."<br>";

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
	
	/* 
	 * Die Funktion muss aktualisiert werden 
	 * Datum: 20.11.2021
     * Autor: Rainer
	 */
	

	public function Projekteausgeben()
	{

		$db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
        $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = 'Select projekt_id, name From projekt 
		          where 
 					projekt_id in (select max(projekt_id) from projekt group by initial_id)
 					and
 					loeschbar=0 and sichtbar=1 order by name asc';

        // where loeschbar=0 and sichtbar=1 order by name asc';
		
		//echo "<br><br>".$query."<br><br>";

        $rueckgabe = $db->query($query);
          
		$result = $rueckgabe->fetchAll(PDO::FETCH_BOTH);
		
		//$dbh = new DB_Mysql_Prod;
		//$res = $dbh->execute( $query );
		
 		
		//echo "<select name=\"projekt\" onChange=\"validateInput(this.value)\">";
		echo "<select name=\"projekt\" onChange=\"JAVASCRIPT:auswertung();\">";
		$i=0;
		foreach ($result as $data)
		//while($data = $rueckgabe->fetchAll(PDO::FETCH_BOTH) )
		{
			echo"<option value=".($data['projekt_id']).">".$data['name']."</option>";
			++$i;
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