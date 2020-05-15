<?php
require './inc/global_config.inc.php';

function __autoload ($className) {
	
	require_once './model/'.$className.'.classes.php';
}


spl_autoload_register("__autoload");


$db = new PDO('mysql:host=localhost; dbname=kino' , DB_USER , DB_PASS );

$controller = $_GET['controller'];
if (is_file("./controller/$controller.inc.php")) {
	require_once "./controller/$controller.inc.php";
	try {
		doAction();
	} catch (PDOException $e) {
		echo "Datenbankfehler!";
	} catch (MovieParseException $e) {
		echo "Filme wurden nicht importiert";
	}
} else {
	echo "404 Page Not Found!";
}