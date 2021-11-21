$(document).ready(function() {
	
	$("#login_form").submit(function() {
		//Message - Box zu Beginn der Prüfung
		$("#msgbox").removeClass().addClass('messagebox').text('Nutzerkontrolle ...').fadeIn(1000);
		
		//Ermitteln des Nutzers über die ajax_login.php
		$.post("ajax_login.php",{ username:$('#username').val(),password:$('#password').val(),rand:Math.random() } ,function(data) {
		if(jQuery.trim(data)=='yes') {						//Nutzer gefunden und Abgleich erfolgreich
		  	$("#msgbox").fadeTo(200,0.1,function() { 		//MessageBox mit den Resulatetn einblenden
			  //Anzeige der Erfolgsmeldung
			  $(this).html('Einloggen').addClass('messageboxok').fadeTo(900,1,
              function()
			  { 
			  	 //Weiterleitung
				 document.location='page_1.php';
			  });
			  
			});
		  } else {
		  	$("#msgbox").fadeTo(200,0.1,function() { 		//MessageBox mit den Resulatetn einblenden
		  	//Anzeige der Misserfolgsmeldung
			  $(this).html('Fehlerhafte Nutzerinformationen').addClass('messageboxerror').fadeTo(900,1);
			});		
          }
				
        });
 		return false;
	});
	
});

/************************************************************************************
 * Workaround für den Internet Explorer zur Darstellung des placeholder - Attributes
 * im Login - Fenster
 * 
 * @param element
 * @param attribute
 * @returns {Boolean}
 ************************************************************************************/

function testAttribute(element, attribute) {
	var test = document.createElement(element);
	if (attribute in test) 
		return true;
	else 
		return false;
}

if (!testAttribute("input", "placeholder"))  {
	
	window.onload = function() {
		
		var username = document.getElementById("username");
		var userpwd = document.getElementById("password");
		
		var name_content = "Nutzer";
		var pwd_content = "Passwort";
		 		
		username.value = name_content;
		userpwd.value = pwd_content;

		username.onfocus = function() {
			if (this.value == name_content)
				this.value = ""; 
		}

		username.onblur = function() {
			if (this.value == "") { 
				this.value = name_content; 
			}
		}
		
		userpwd.onfocus = function() {
			if (this.value == pwd_content)
				this.value = ""; 
		}

		userpwd.onblur = function() {
			if (this.value == "") { 
				this.value = pwd_content; 
			}
		}
	} 
	
}

