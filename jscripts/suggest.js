var resObjekt = null;
function erzXMLHttpRequestObject(){
  var resObjekt = null;
  try {
    resObjekt = new ActiveXObject("Microsoft.XMLHTTP");
  }
  catch(Error){
    try {
      resObjekt = new ActiveXObject("MSXML2.XMLHTTP");
    }
    catch(Error){
      try {
        resObjekt = new XMLHttpRequest();
      }
      catch(Error){
        alert("Erzeugung des XMLHttpRequest-Objekts ist nicht möglich");
      }
    }
  }
  return resObjekt;
}
function sndReq() {
  if(document.benutzer.Stadt.value !=""){
	  
	  // die folgende Zeile sagt uns Formular: "Benutzer" und bringt dann "name" ins Spiel...
	  // der mir vorliegende Code verwendet dei Bezeichnung "name" für den das Textfeld umspannenden Span Tag
	  // ich glaube mich aber daran zu erinnern, dass ich in der Ausgangsvarainte diese Bezeichnung 2 Mal hatte, 
	  // nämlich auch als Bezeichnung des Textfeldes. -> nach Prüfung ... richtig... demnach sollte hier die Var Stadt verwendet werden
	  // es gibt allerdingsschon die Möglichkeit, dass durch die doppelte Verwendung des Varaiblen Namens dem Darstellungsproblem IE und FF 
	  // begegnet wird.
	  
    resObjekt.open('get', '../benutzer/suggest.jsp?name=' + escape(document.benutzer.Stadt.value.toLowerCase()) ,true);
    resObjekt.onreadystatechange = handleResponse;
    resObjekt.send(null);
  }
  else {
    document.getElementById("antwort").style.visibility = "hidden";
  }
}
function handleResponse() {
  document.getElementById("antwort").style.visibility = "visible";
  if(resObjekt.readyState == 4){
    document.getElementById("antwort").innerHTML = resObjekt.responseText;
  } 
}
resObjekt=erzXMLHttpRequestObject();
function uebernehme(){
  document.benutzer.Stadt.value = document.benutzer.vorschlag.value;
  // das zweite soll ein Textfeld typ hidden sein. bei dem die ID übergeben wird.
  document.benutzer.StadtID.value = document.benutzer.vorschlag.name;
}
