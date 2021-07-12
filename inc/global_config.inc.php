<?php








 define ('PFAD','../../../../../..');

 define ('PATH_CONTROLLERS','controller/');

// define('DEBUG', false);
 
 define('GZIP_COMPRESSION', false);
 define('STORE_PAGE_PARSE_TIME', 30);
 define('DISPLAY_PAGE_PARSE_TIME', true);

 
 
 define('SQLTRACKING', false);
 
 define ('DocPathUrl', dirname(__FILE__)); 


/**
 *
 * DEBUG MODUS an oder .
 *
 */   


  define('DEBUG', false);


/**
 *
 * Pfad, in den die Klassen abgelegt werden sollen.
 *
 */   


 // define('PFAD', '../');

  
  /**
 *
 * Pfad, in den die Klassen abgelegt werden sollen.
 *
 */   


  define('APPNAME', 'todo');






  
/**
 *
 * Pfad, in den die Klassen abgelegt werden sollen.
 *
 */   


  define('CLASS_PATH', 'class');



/**
 * DB Zugangsdaten
 *      Host
 *
 */


  define( 'DB_HOST', 'localhost' );



/**
 * DB Zugangsdaten
 *      Name der Datenbank
 */


  define( 'DB_NAME' ,'todo' );



/**
 * DB Zugangsdaten
 *      User der Datenbank
 */


  define( 'DB_USER', 'root' );




/**
 * DB Zugangsdaten
 *     Passwort der Datenbank
 */


  define( 'DB_PASS', 'root' );


/**
 * DSN
 *
 */  

    
//require_once './class/DatenbankZugriff.classes.php';
//require_once './class/LetzteAktivitaet.classes.php';
//require_once './class/Log.classes.php';
//require_once './class/Fehler.classes.php';


/**
 * Definition des alternierenden Styles in der 
 * todoebersicht #c7d3cf; #dee2e1;
 * fehler, etc
 * 
 */

define ('TODOSTYLE1','background-color:#ede3cf;font-size:0.70em;padding:5px;');
define ('TODOSTYLE2','background-color:#eef2d1;font-size:0.70em;padding:5px;');

define ('FEHLERSTYLE1','background-color:#f6f6f6;font-size:0.70em;padding:5px;');
define ('FEHLERSTYLE2','background-color:#e6e6f0;font-size:0.70em;padding:5px;');


define ('TODOSTYLE1_DRUCK','background-color:#ffffff;font-size:0.70em;padding:5px;');
define ('TODOSTYLE2_DRUCK','background-color:#fdfdfd;font-size:0.70em;padding:5px;');

define ('FEHLERSTYLE1_DRUCK','background-color:#ffffff;font-size:0.70em;padding:5px;');
define ('FEHLERSTYLE2_DRUCK','background-color:#fcfcfc;font-size:0.70em;padding:5px;');




?>