<?php



/**
 * Definiere Startzeit
 */ 
define('PAGE_PARSE_START_TIME', microtime());

/**
 * Lade globale Definition
 */  


if(DEBUG) {
 ini_set('display_errors', true);
 ini_set('error_reporting', E_ALL);


 // ggf. Source zeigen

 if (isset($_GET['showsource'])){
 highlight_file(basename(__FILE__));
 exit();
 }
}




// if gzip_compression is enabled, start to buffer the output
if ((GZIP_COMPRESSION == 'true') && ($ext_zlib_loaded = extension_loaded('zlib')) && (PHP_VERSION >= '4')) {
	if (($ini_zlib_output_compression = (int) ini_get('zlib.output_compression')) < 1) {
		ob_start('ob_gzhandler');
	} else {
		ini_set('zlib.output_compression_level', GZIP_LEVEL);
	}
}

$userid = 1; //!$_SESSION["user_id"]?1:$_SESSION["user_id"];
 //echo "USERID: .$userid";
 // Das scheint so nicht ausreichend
 if (!$userid || $userid > 1) 
 {
 	echo "<br><br><br><center><h2>Sie sind nicht eingeloggt.</h2><br>";
 	echo "<a href=\"index.php\">Klicken Sie hier um sich einzuloggen</a></center>";
 	//echo "User ID:".$userid;	
 	
 	echo '<meta http-equiv="refresh" content="1; URL='.PFAD.'/'.APPNAME.'">'; 
 	
 	die();
 }
 
//$oTracking = new Tracking();
//$oTracking->sessionschreiben($userid);

/**
 * Zuweisung - Datum englisch, deutsch und Uhrzeit
 */ 
 //$timestamp=time();
 //$datum = date("Y-m-d H:i:s",$timestamp);
 $datum = date("y-m-d G:i:s", time());
 $datumdeutsch = date("d.m.Y",time());
 $uhrzeitdeutsch = date("H:i",time());
  
                                                                                                                                                                                     6

?>         

<!DOCTYPE html>
<html lang="de-DE" prefix="og: http://ogp.me/ns#" class="no-js no-svg">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php
//echo '<link rel="stylesheet" type="text/css" href="'.PFAD.'/'.APPNAME.'/lib/bootstrap-3.3.5-dist/css/bootstrap.min.css" />
echo '<!-- Das neueste kompilierte und minimierte CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">';

echo '<link rel="stylesheet" type="text/css" href="'.PFAD.'/'.APPNAME.'/css/style.css" />';
echo '<link rel="stylesheet" type="text/css" href="'.PFAD.'/'.APPNAME.'/lib/css/rrs.css" />
<link href="https://fonts.googleapis.com/css?family=Oswald:300,400,500|Lobster+Two:400|Lato:300,400,500,700,900|Josefin+Sans:400,i,600,700|Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i|Work+Sans:300,400,600,700|Fira+Sans:200,200i,300,400,i,600,700|Oswald:300,400,500|Lobster+Two:400|Lato:300,400|Fjalla+One:400,i,600,700|Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i|Work+Sans:300,400,600,700|Fira+Sans:200,200i,300,400,i,600,700" rel="stylesheet">
	
<title>Rezept - Verwaltung von Rezepten, Speiseplänen und Bestellzetteln</title>';

   echo '<script language="JavaScript" type="text/javascript">
          <!--
          function start() {
              textLayer1 = document.getElementById(\'visib1\').style;
              textLayer2 = document.getElementById(\'visib2\').style;
			  textLayer3 = document.getElementById(\'visib3\').style;
			  textLayer4 = document.getElementById(\'visib4\').style;
			  textLayer5 = document.getElementById(\'visib5\').style;
          }
          

		 
		  // komplette Speise 3 Elemente
          function ea_check(radiocheckbox) {
              if(radiocheckbox.value=="1"){
                  textLayer1.zIndex = 6;
				  textLayer2.zIndex = 2;
				  textLayer3.zIndex = 3;
				  textLayer4.zIndex = 4;
				  textLayer5.zIndex = 5;
                  textLayer1.visibility = "visible";
                  textLayer2.visibility = "hidden";
				  textLayer3.visibility = "hidden";
				  textLayer4.visibility = "hidden";
				  textLayer5.visibility = "hidden";
                 
				}
			  // Suppe
              else if(radiocheckbox.value=="4") {
                  textLayer1.zIndex = 2;
				  textLayer2.zIndex = 6;
				  textLayer3.zIndex = 3;
				  textLayer4.zIndex = 4;
				  textLayer5.zIndex = 5;
                  textLayer1.visibility = "hidden";
                  textLayer2.visibility = "visible";
                  textLayer3.visibility = "hidden";
				  textLayer4.visibility = "hidden";
				  textLayer5.visibility = "hidden";
                 
              }

			 // Vorspeise
              else if(radiocheckbox.value=="5") {
                  textLayer1.zIndex = 2;
				  textLayer2.zIndex = 3;
				  textLayer3.zIndex = 6;
				  textLayer4.zIndex = 4;
				  textLayer5.zIndex = 5;
                  textLayer1.visibility = "hidden";
                  textLayer2.visibility = "hidden";
                  textLayer3.visibility = "visible";
				  textLayer4.visibility = "hidden";
				  textLayer5.visibility = "hidden";
                 
              }
			 // Dessert
              else if(radiocheckbox.value=="6") {
                  textLayer1.zIndex = 2;
				  textLayer2.zIndex = 4;
				  textLayer3.zIndex = 3;
				  textLayer4.zIndex = 6;
				  textLayer5.zIndex = 5;
                  textLayer1.visibility = "hidden";
                  textLayer2.visibility = "hidden";
                  textLayer3.visibility = "hidden";
				  textLayer4.visibility = "visible";
				  textLayer5.visibility = "hidden";
                 
              }

			 // kleine Speise
              else if(radiocheckbox.value=="7") {
                  textLayer1.zIndex = 2;
				  textLayer2.zIndex = 5;
				  textLayer3.zIndex = 3;
				  textLayer4.zIndex = 4;
				  textLayer5.zIndex = 6;
                  textLayer1.visibility = "hidden";
                  textLayer2.visibility = "hidden";
                  textLayer3.visibility = "hidden";
				  textLayer4.visibility = "hidden";
				  textLayer5.visibility = "visible";
                 
              }

          }
          </script>';

echo '</head>
<body onload="start()">

<center>';
//<div style="top:0;right:0;font-size:0.6em;color:lightgrey;">'.date("d.m.y", time()).'</div>
?>
