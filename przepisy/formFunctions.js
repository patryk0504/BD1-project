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

//przycisk ulubione
function zapiszDoUlubionych(id){
    ulubioneRequest(id);
}

function napiszRecenzje(id){
  checkRecenzjaRequest(id);
}

function zapiszRecenzje(id){
  var ocena = document.getElementById("ocena").value;
  var recenzja = document.getElementById("recenzja").value;
  recenzjaRequest(id, ocena, recenzja);
}

function checkRecenzjaRequest(id){
  xmlHttp = getRequestObject() ;
  if (xmlHttp) {
    try {
      var url = "./addRecenzja.php?id="+id;
      xmlHttp.onreadystatechange = recenzjaResponse ;
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


function recenzjaRequest(id, ocena, recenzja){
  xmlHttp = getRequestObject() ;
  if (xmlHttp) {
    try {
      var url = "./addRecenzja.php?id="+id+"&ocena="+ocena+"&recenzja="+recenzja;
      xmlHttp.onreadystatechange = recenzjaResponse ;
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

function recenzjaResponse()      {
  myDiv = document.getElementById("ulubioneInfo");
  myDiv.style = "display:block;";
  if (xmlHttp.readyState == 4) {
       if ( xmlHttp.status == 200 )  {
         response = xmlHttp.responseText;
           var input = "<p>";
         input += response;
         input += "</p>";
         myDiv.innerHTML = input;
       }
  }  
 }


function ulubioneRequest(id)      {
    xmlHttp = getRequestObject() ;
    if (xmlHttp) {
      try {
        var url = "./addUlubione.php?id="+id;//+"&ocena="+ocena+"&recenzja="+recenzja;
        xmlHttp.onreadystatechange = handleResponse ;
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
function handleResponse()      {
 myDiv = document.getElementById("ulubioneInfo");
myDiv.style = "display:block;";
 if (xmlHttp.readyState == 4) {
      if ( xmlHttp.status == 200 )  {
        response = xmlHttp.responseText;
          var input = "<p>";
        input += response;
        input += "</p>";
        myDiv.innerHTML = input;
      }
 }  
}

/////////////////////////////////


function hideUlubione(){
    var element = document.getElementById('ulubioneInfo');
    element.style = "display:none;";
}
