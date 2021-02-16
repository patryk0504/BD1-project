window.onload = function(){
  pokazPrzepisy();
}

var xmlHttp;
function getRequestObject() {
  if ( window.ActiveXObject) {
    return ( new ActiveXObject("Microsoft.XMLHTTP")) ;
  }
  else if (window.XMLHttpRequest) {
    return (new XMLHttpRequest());
  }
  else {
    return (null);
  }
}

function pokazPrzepisy(){
    var rodzaj = document.getElementById("rodzaj").value;
    var kategoria = document.getElementById("kategoria").value;
    var sortowanie = document.getElementById("sortowanie").value;
    przepisyRequest(rodzaj,kategoria,sortowanie);
}

function przejdzDoPrzepisu(id){
  var win = window.open("../szczegoly_przepisu/jedenPrzepis.php?id="+id, '_blank');
  win.focus();
}



function przepisyRequest(rodzaj, kategoria, sortowanie)      {
    xmlHttp = getRequestObject() ;
    if (xmlHttp) {
      try {
        var url = "./getPrzepisyAjax.php?rodzaj="+rodzaj+"&kategoria="+kategoria+"&sortowanie="+sortowanie;
        xmlHttp.onreadystatechange = handleResponsePrzepisy ;
        xmlHttp.open("GET", url, true);
        xmlHttp.send(null);
      }
      catch (e) {
        alert ("Nie mozna polaczyc sie z serwerem: " + e.toString()) ;
      }
    } else {
      alert ("Blad") ;
    }
}
function handleResponsePrzepisy()      {
 myDiv = document.getElementById("myDiv");
 if (xmlHttp.readyState == 4) {
      if ( xmlHttp.status == 200 )  {
        response = xmlHttp.responseText;
        var input = response;
        myDiv.innerHTML = input;
      }
 }  
}