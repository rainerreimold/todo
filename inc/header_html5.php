<?php 

/**
 * Definiere Startzeit
 */ 
define('PAGE_PARSE_START_TIME', microtime());

/**
 * Lade globale Definition
 */  
require_once('inc/global_config.inc.php');

// if gzip_compression is enabled, start to buffer the output
if ((GZIP_COMPRESSION == 'true') && ($ext_zlib_loaded = extension_loaded('zlib')) && (PHP_VERSION >= '4')) {
	if (($ini_zlib_output_compression = (int) ini_get('zlib.output_compression')) < 1) {
		ob_start('ob_gzhandler');
	} else {
		ini_set('zlib.output_compression_level', GZIP_LEVEL);
	}
}
$sTitle = 'MyMemorySupport';
$oTracking = new Tracking();
$oTracking->sessionschreiben($userid);

?>
<!doctype html>
<html lang="de">
<head>
<title><?php  echo $sTitle; ?></title>
<link rel="stylesheet" href="./../../../../../fehlerreport/css/master.css" type="text/css" media="screen" />
<link rel="stylesheet" type="text/css" href="'.PFAD.'/'.APPNAME.'/lib/css/rrs.css" />
</head>
<body>

	<header>
		<h1>>Lizenzmanagement</h1>
	</header>
	
