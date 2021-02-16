window.onload = function(){
  filtrujRecenzje();
}
function filtrujRecenzje(){
    hideRecenzjaForm();
    var sortowanie = document.getElementById("sortowanie").value;
    document.getElementById("myDiv").style = "";
    document.getElementById("recenzjaForm").style = "display:none;";
    getRecenzjeRequest(sortowanie);
}

function przejdzDoPrzepisu(id){
  var win = window.open("../szczegoly_przepisu/jedenPrzepis.php?id="+id, '_blank');
  win.focus();
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

function getRecenzjeRequest(sortowanie)      {
    xmlHttp = getRequestObject() ;
    if (xmlHttp) {
      try {
        var url = "./getRecenzje.php?sortowanie="+sortowanie;
        xmlHttp.onreadystatechange = handleResponseGetRecenzje ;
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

function handleResponseGetRecenzje()      {
 myDiv = document.getElementById("myDiv");
 if (xmlHttp.readyState == 4) {
      if ( xmlHttp.status == 200 )  {
        response = xmlHttp.responseText;
        // alert(response);
        var input = response;
        myDiv.innerHTML = input;
    }
 }  
}

function wrocDoPrzepisow(){
  document.getElementById("myDiv").style = "";
  document.getElementById("recenzjaForm").style = "display:none;";
}

function modyfikujRecenzje(id){
  document.getElementById("myDiv").style = "display:none;";
  var myDiv = document.getElementById("recenzjaForm");
  myDiv.style = "display:block;";
  var temp = `
  <p class="sign" align="center">Twoja opinia</p>
  <form>
        <span>Jak oceniasz przepis?</span>
        <select name="ocena" id="ocena">
            <option value="0">0</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select> <br>
        <textarea name="recenzja" id = "recenzja" rows="14" cols="40" placeholder="Twoja opinia..."></textarea> <br>
        <button type = "button" onclick="recenzjaRequest(${id});">Zapisz</button>
        <button type = "button" onclick="wrocDoPrzepisow();">Wróć do przepisów</button>

  </form>
  `
  myDiv.innerHTML = temp;
}

function usunRecenzje(id){
  hideRecenzjaForm();
  xmlHttp = getRequestObject() ;
  if (xmlHttp) {
    try {
      var url = "./deleteRecenzja.php?id="+id;
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

function recenzjaRequest(id){
  var ocena = document.getElementById("ocena").value;
  var recenzja = document.getElementById("recenzja").value;
  xmlHttp = getRequestObject() ;
  if (xmlHttp) {
    try {
      var url = "./modyfikujRecenzje.php?id="+id+"&ocena="+ocena+"&recenzja="+recenzja;
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
  myDiv = document.getElementById("recenzjaForm");
  myDiv.style = "display:block;";
  if (xmlHttp.readyState == 4) {
       if ( xmlHttp.status == 200 )  {
         response = xmlHttp.responseText;
           var input = "<p>";
         input += response;
         input += "</p>";
         myDiv.innerHTML = input;
         setTimeout(location.reload.bind(location), 1000);

       }
  }  
 }

 function hideRecenzjaForm(){
   document.getElementById("recenzjaForm").style = "display:none;";
 }