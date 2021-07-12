<?php

/****

Sprüche 

T-Shirt Sprüche

1. Anlegen
2. Eintragen 
3. Anzeigen
4. Änderung 



***/


session_start();


require_once './inc/global_config.inc.php';
$_SESSION['title'] = 'TShirtSpr&uumle;- ';
$_SESSION['start'] = isset($_SESSION['start'])?$_SESSION['start']:false;
