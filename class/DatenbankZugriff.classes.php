<?php

/** 
 * @autor Rainer
 * 
 */
class DatenbankZugriff
{

    // TODO - Insert your code here
    // 

	public $db;
    /**
     */
    public function __construct()
    {
        
       	$db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
    	$db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     */
    function __destruct()
    {
        
        // TODO - Insert your code here
    }



	

	// Auslesen eines Statements fetch_assoc
	public function fetch_assoc($sql)
	{
	    $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
        $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
        $rueckgabe = $db->query($sql);
     
		return $rueckgabe->fetchAll(PDO::FETCH_ASSOC);	   
	}

	// Absetzen eines Replace Into


}

