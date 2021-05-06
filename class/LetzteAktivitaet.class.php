<?php

/**************************************************************************************************************

 Name: Log.classes.php
 Ziel: Es wird eine Objekt Log erzegt und die Statements in eine LogDatei geschrieben.


Author: Rainer
Reaktivierung: 14.05.2021




**************************************************************************************************************/
require_once './class/Log.classes.php';

class LetzteAktivitaet {

// Debug Meldung schreiben

public function __construct() {}	


/* Hier soll das Schreiben in die MYSQL DB erfolgen */

public function writeLetzteAktivitaet ( $bezeichnung="", $beschreibung="", $nutzer_id=1, $nutzername="Rainer", $projekt_id=1, $projektname="todo")
{

 try {
		  
		     $sql = "replace into letzteaktivitaet 
                set 
				letzteaktivitaet_bezeichnung 		= '".$bezeichnung."',
				letzteaktivitaet_beschreibung 		= '".$beschreibung."',
				nutzer_id							= '".$nutzer_id."',
				nutzername							= '".$nutzername."',
				projekt_id							= '".$projekt_id."',
				projektname							= '".$projektname."'
			";	

			//$oLog = new Log();
			//$oLog->writeSqlLog($sql);	

		 	$db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
         	$db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		 	$db->beginTransaction();
         	$db->query($sql);

		 	$db->commit();
         	

         }
         catch(PDOException $e){
		 	$db->rollBack();
            print "<br>".$e->getMessage();
         }
	//	print "<br>";
	//	print $sql;
	// 	die();
	

}
	
/* Dateien Wochen oder Monatsweise */

public function writeLog($line="")
{
	$logFile = 'log/'.date("d-m").'_dok.log';
	$logFH = fopen ($logFile, 'a+');
	//fwrite ($logFH, '################# '.date("d.m.Y - H:i:s").' #################'."\n\n");
	fwrite ($logFH, $_SERVER['REMOTE_ADDR']."\n\n
	User Agent ".$_SERVER['HTTP_USER_AGENT']."\n
	Request URI".$_SERVER['REQUEST_URI']."\n");
	
	foreach ($_REQUEST AS $param => $value)
	{
		fwrite ($logFH, $param.' => '.$value. "\n");

		//if ($param == 'DocPathUrl') $DocPathUrl = $value;
	}

	//fwrite ($logFH, '###############################################'."\n");

	
	/*foreach (parse_url($DocPathUrl) AS $key => $val)
	{
		fwrite($logFH, $key.' => '.$val. "\n");
	}
	//fwrite ($logFH, '###############################################'."\n");
    */

	if ($line)
	{
		fwrite($logFH, $line."\n");
		//fwrite ($logFH, '<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<'."\n\n\n");
	}

	fclose($logFH);
 }
 
 
// Debug Meldung schreiben
public function writeSqlLog( $sql, $line="")
{
	//echo $sql;
	date("d.m.Y - H:i:s");
	$logFile = 'log/'.date("d-m").'_sqlstatement.log';
	$sSql = $sql;
	$logFH = fopen ($logFile, 'a+');
	//fwrite ($logFH, '################# '.date("d.m.Y - H:i:s").' #################'."\n\n");
	fwrite ($logFH, $sSql.";\n");
	
	
	//fwrite ($logFH, '###############################################'."\n");
   // echo "TYP: ".gettype($sql);
	$typ = substr($sSql,0,6);
	//	$fid = substr($id,1,33);
	
	if ($typ == 'insert' || $typ == 'Insert' || $typ == 'INSERT')
	  $this->writeSqlInsertLog($sSql);
	else if ($typ == 'alter ' || $typ == 'Alter ' || $typ == 'ALTER ')
	  $this->writeSqlAlterLog($sSql);
	else if ($typ == 'update' || $typ == 'Update' || $typ == 'UPDATE')
	  $this->writeSqlInsertLog($sSql);

	if ($line)
	{
		fwrite($logFH, $line."\n\n");
		fwrite ($logFH, '<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<'."\n\n\n");
	}

	fclose($logFH);
 }
 
public function writeSqlAlterLog($sql,$line="")
{
	$logFile = 'log/'.date("d-m").'_sql_alter.log';
	$logFH = fopen ($logFile, 'a+');
	//fwrite ($logFH, '################# '.date("d.m.Y - H:i:s").' #################'."\n\n");
	fwrite ($logFH, $sql.";\n\n");
	
	
	//fwrite ($logFH, '###############################################'."\n");
    
	if ($line)
	{
		fwrite($logFH, $line."\n\n");
		//fwrite ($logFH, '<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<'."\n\n\n");
	}

	fclose($logFH);
 }
public function writeSqlInsertLog($sql,$line="")
{
	$logFile = 'log/'.date("d-m").'_sql_insert.log';
	$logFH = fopen ($logFile, 'a+');
	//fwrite ($logFH, '################# '.date("d.m.Y - H:i:s").' #################'."\n\n");
	fwrite ($logFH, $sql.";\n\n");
	
	
	//fwrite ($logFH, '###############################################'."\n");
    
	if ($line)
	{
		fwrite($logFH, $line."\n");
		//fwrite ($logFH, '<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<'."\n\n\n");
	}

	fclose($logFH);
 }
}
?>