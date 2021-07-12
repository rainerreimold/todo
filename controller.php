<?php

$timeStart = microtime(true);
//set_include_path('inc');
//include_path='C:\xampplite\php\PEAR')
//include_once ("inc\global_config.inc.php");


require './inc/global_config.inc.php';
require './inc/functions.inc.php';

 function __autoload ($className) {
    echo $className;
	require_once './class/'.$className.'.classes.php';
	
}


spl_autoload_register("__autoload");

$controller = isset($_GET['controller'])?$_GET['controller']:'uebersicht';
$action = isset($_GET['action'])?$_GET['action']:'';
$id = isset($_GET['id'])?$_GET['id']:'';
$pid = isset($_GET['pid'])?intval($_GET['pid']):0;
$von = isset($_GET['von'])?intval($_GET['von']):0;
$lim = isset($_GET['lim'])?intval($_GET['lim']):30;
$order = isset($_GET['order'])?$_GET['order']:'desc';

if (DEBUG) {
	echo "<h2>$id</h2>";
	// die ();
}

$controller = $_GET['controller'];
if (is_file("./controller/$controller.inc.php")) {
	require_once "./controller/$controller.inc.php";
	try {
		doAction($action,$id,$von,$lim,$order);
	} catch (PDOException $e) {
		echo "Datenbankfehler!";
	} catch (MovieParseException $e) {
		echo "Filme wurden nicht importiert";
	}
} else {
	header('location:uebersicht');
	echo "404 Page Not Found!";
}

$timeStop = microtime(true);