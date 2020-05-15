<?php




session_start();


require_once './inc/global_config.inc.php';
$_SESSION['title'] = 'Rezepte - Verwaltung von INgredenzien';
$_SESSION['start'] = isset($_SESSION['start'])?$_SESSION['start']:false;


static $db;




function doAction( $action = '', $id = '', $von=0, $lim=0, $order='asc' ) {



	if (DEBUG) {
		echo "<br /><br />ID ".$id;
		echo "<br /><br />ACTION ".$action;
	}
	
	//$oDbName = new  DBInformation();

	//Aber die Übersicht ist doch nicht die action sondern der
	//controller.....
    
    
	
    if ( $action == '') {
	

		$db = $id;
		if ($_SESSION['start']==false) {
    		$_SESSION['start']=true;
			echo "<h1>Ingredenzien</h1>";
			echo "<h2>Ansatz?</h2>";

			die();
		}



		}

	/** Eintrag sollte gelöscht werden können 
		03.05.20 

	*/

    else if ( $action == 'zeigeAlleIngredienzien') {
        
        include 'inc/header.php';
	    try {
		
               //   
		$sql = "SELECT Distinct `ingredienz_id`,`bezeichnung`,`beschreibung`, `aktiv`, `loeschbar` FROM `ingredienz` where 1 order By `bezeichnung` asc";

		if (DEBUG) echo "<br>".$sql."<br>";
       
	 
          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
          $rueckgabe = $db->query($sql);
          
		  $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
	        
	        
	        
	        echo "<table  style=\"background:#777;padding:4px;border:1px;\"   cellpadding=\"6\" cellspacing=\"1\">";
	        echo '<tr style="padding:8px;"><th style="font-family: Fira ;color:#ddd">Ingredienzen f&uuml;r Rezepte</th>';
			echo '<th>A</th><th>L</th>';
			echo '</tr>';
	        echo "<tr style=\"padding:8px;\"><td style=\"background:darkgrey;a color:orange;width:350px;\" class=\"odd\">
            Bezeichnung
            </td>
            <td style=\"background:darkgrey;a color:orange;width:350px;\" class=\"odd\">Beschreibung</td>";
		    //<td style=\"background:darkgrey;a color:orange;width:80px;\" class=\"odd\">Rezepte</td>
          echo "</tr>";
	        foreach ($ergebnis as  $inhalt)
	        {
	            $ingredienz_id=$inhalt['ingredienz_id'];
	            
	            echo "<tr style=\"border:1px dotted black;\">";
				echo "<td style=\"background:lightgrey;a color:orange;width:350px;padding:6px;\" class=\"odd\">";
	            
	            echo "<a href=\"/wochenplan/ingredienzien/details/$ingredienz_id\">".$inhalt['bezeichnung']."</a>";
	            
	                      //&nbsp;&nbsp;&nbsp;<small><small><em style=\"color:red;\">(<a href=\"details/".$domain_id."\">bearbeiten</a>)</em></small></small>";
	            echo "</td>";
			    echo "<td style=\"background:lightgrey;a color:orange;width:50px;padding:6px;\" class=\"odd\"> ";
				echo "<a href=\"/wochenplan/ingredienzien/details/$ingredienz_id\">".$inhalt['beschreibung']."</a>";
	            echo "<br></td>";

				$color = $inhalt['aktiv'] == 1?'green':'red';
             	echo "<td style=\"background:".$color.";a::link,a::hover { text-decoration: none; color: white; };width:50px;\" class=\"tdhersteller\">";
             	echo "<small><a href=\"aktiv/".$ingredienz_id."\">AK</a></small>";
             	echo "</td>";
             
            	 $color = $inhalt['loeschbar'] == 0?'green':'red';
             	echo "<td style=\"background:".$color.";a::link,a::hover { text-decoration: none; color: white; };width:50px;\" class=\"tdhersteller\">";
             	echo "<small><a href=\"loeschbar/".$ingredienz_id."\">L&Ouml;</a></small>";
             	echo "</td>";

				//echo "<td>A</td>";
			    //echo "<td>L</td>";	
				echo "</tr>";
	        }
	        
	    }
	    catch(PDOException $e){
	        print $e->getMessage();
	    }
	    echo "</table>";
	    $db=null;
	    
        echo "<br><a href=\"anlegen\">neue Ingredienz anlegen</a><br>";
      

		if (DEBUG) {
			echo "<br /><br />action= $action<br /><br />";
			echo "<br /><br />id= $id<br /><br />";
		}




		include 'inc/footer.php';
	}
	
    else if ( $action == 'details') {
     
       include 'inc/header.php';        

       try {
		 
		$sql = "Select bezeichnung, beschreibung from ingredienz where ingredienz_id = ".$id;


		if (DEBUG) echo "<br>".$sql."<br>";
       
	 
          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
          $rueckgabe = $db->query($sql);
          
		  $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
	        
		  $bezeichnung = $ergebnis[0]['bezeichnung'];
		  $beschreibung = $ergebnis[0]['beschreibung'];
 
		 echo '<h1 style="background: orange;
	             padding-left:120px;">Ingredienz</h1>';
         echo '<div class="form" style="width:750px; text-align:right; padding:10px; margin:10px auto auto auto;">

         <form method="post" action="../eintragen" style="width:700px; padding:10px; margin:10px;">
           <fieldset style="background:#cfcfcf; width:500px; text-align:right; padding:10px; margin-right:10px;">
           <legend>Ingredienz anlegen</legend>';  

		 echo "<input type=\"hidden\" name=\"ingredienz_id\" value=\"".$id."\">";     

         echo "<label>Ingredienz: </label><input class=\"textform eyecatch\" type=\"text\" name=\"ingredienz\"  value=\"".$bezeichnung."\" required /><br>";
         echo '</fieldset>';
         echo "<br>\n";

		echo "<textarea id='editor' name='editor'>".$beschreibung."</textarea>";


         echo ' <fieldset style="background:#cfcfcf; text-align:right; padding:10px; margin-right:10px;">
              <button type="reset">Eingaben l&ouml;schen</button>
              <button type="submit">Absenden</button>
            </fieldset>
          </form>
       </div>
       <br>
       <br>
       <br>
       <br>';

   echo '<script type="text/javascript">';
   echo "	CKEDITOR.replace('editor');";
   echo "</script>";
			

    }
	    catch(PDOException $e){
	        print $e->getMessage();
	    }
	    echo "</table>";
	    $db=null;
	    
      
      

		if (DEBUG) {
			echo "<br /><br />action= $action<br /><br />";
			echo "<br /><br />id= $id<br /><br />";
		}




		include 'inc/footer.php';
	}


    /****************************************
  
    kleines Formular zum hinzufügen einer Ingredienz
  
	*****************************************/
  	
    else if ( $action == 'anlegen') {
  	
		 include 'inc/header.php';

		 echo '<h1 style="background: orange;
	             padding-left:120px;">Ingredienz</h1>';
         echo '<div class="form" style="width:750px; text-align:right; padding:10px; margin:10px auto auto auto;">

         <form method="post" action="eintragen" style="width:700px; padding:10px; margin:10px;">
           <fieldset style="background:#cfcfcf; width:500px; text-align:right; padding:10px; margin-right:10px;">
           <legend>Ingredienz anlegen</legend>';       
         echo '<label>Ingredienz: </label><input class="textform eyecatch" type="text" name="ingredienz"  required /><br>';
         echo '</fieldset>';
         echo "<br>\n";

		echo "<textarea id='editor' name='editor'></textarea>";


         echo ' <fieldset style="background:#cfcfcf; text-align:right; padding:10px; margin-right:10px;">
              <button type="reset">Eingaben l&ouml;schen</button>
              <button type="submit">Absenden</button>
            </fieldset>
          </form>
       </div>
       <br>
       <br>
       <br>
       <br>';

   echo '<script type="text/javascript">';
   echo "	CKEDITOR.replace('editor');";
   echo "</script>";
			

     include 'inc/footer.php';


	}


	/***************************************

	 Eintragen der Ingredienz 01.05.2020

	****************************************/

	else if ( $action == 'eintragen') {

     
     $ingredienz    = $_REQUEST['ingredienz'];
	 $beschreibung  = $_REQUEST['editor'];
	 $ingredienz_id = isset($_REQUEST['ingredienz_id'])?$_REQUEST['ingredienz_id']:null;
	 if (DEBUG) print "<br><br><br>$ingredienz_id<br><br>";

     try {

	 	  $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          if(!$ingredienz_id) { 

		  	$sql = "replace into ingredienz set bezeichnung = '".$ingredienz."', beschreibung='".$beschreibung."' ";
          	//print $sql."<br>";
		  	$db->beginTransaction();          

		  	$db->query($sql);

	      	$sql="update ingredienz set initial_id = ingredienz_id order by ingredienz_id desc limit 1";		
		  	$db->query($sql);
				
   		  	$db->commit();
          	
		  } else {

		    $sql="update ingredienz set bezeichnung = '".$ingredienz."', beschreibung='".$beschreibung."' where ingredienz_id=".$ingredienz_id;		
           	//print $sql."<br>";
			$db->beginTransaction();          
		  	$db->query($sql);
			$db->commit();
          	
		   }
		  $db=null;
 	
          }
          catch(PDOException $e){
            $db->rollBack();  
			print "<br>".$e->getMessage();
          }



        
          //die();
          

          header('location:../uebersicht');



    }

	else if ( $action == "aktiv" ) {

	 
        try {
		  // einfacher Switch	
          $sql = "update `ingredienz` Set `aktiv`=(`aktiv`-1)*-1 where `ingredienz_id`=".$id.";";

  
         // print $sql."<br>";

          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $db->query($sql);
          $db=null;

          //echo "<br>".$sql."<br>";
          //die();


          }
          catch(PDOException $e){
              print "<br>".$e->getMessage();
          }
         //die();
        header('location:../zeigeAlleIngredienzien') ;

	}

	else if ( $action == "loeschbar" ) {

	 
        try {
		  // einfacher Switch	
          $sql = "update `ingredienz` Set `loeschbar`=(`loeschbar`-1)*-1 where `ingredienz_id`=".$id.";";

  
         // print $sql."<br>";

          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $db->query($sql);
          $db=null;

          //echo "<br>".$sql."<br>";
          //die();


          }
          catch(PDOException $e){
              print "<br>".$e->getMessage();
          }
         //die();
        header('location:../zeigeAlleIngredienzien') ;

	}


}
	
