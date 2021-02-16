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

window.onload = function(){
  showButtonClick();
}

function showButtonClick(){
    var option = document.getElementById("rodzajSkladnika").value;
    skladnikiRequest(option);
}

function dodajSkladnikiButton(number,idSkladnik){
    var value = document.getElementById("inputSkladnik"+number).value;
    //mamy idskladnika oraz ilosc, mozemy wprowadzic do bazy danych
    // if (value > 0)
        insertSkladnik(value,idSkladnik);
}

function usunSkladnikiButton(number,idSkladnik){
    var value = document.getElementById("deleteSkladnik"+number).value;
    var maxvalue = document.getElementById("deleteSkladnik"+number).max;
    deleteSkladnik(value, idSkladnik);
}

function deleteSkladnik(amount, idSkladnik){
    xmlHttp = getRequestObject() ;
    if (xmlHttp) {
      try {
        var url = "./deleteSkladnik.php?amount="+amount + "&idSkladnik=" + idSkladnik;
        xmlHttp.onreadystatechange = handleResponse2 ;
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

function insertSkladnik(amount, idSkladnik){
    xmlHttp = getRequestObject() ;
    if (xmlHttp) {
      try {
        var url = "./insertSkladnik.php?amount="+amount + "&idSkladnik=" + idSkladnik;
        xmlHttp.onreadystatechange = handleResponse2 ;
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

function handleResponse2()      {
    myDiv = document.getElementById("textTrue");
    if (xmlHttp.readyState == 4) {
         if ( xmlHttp.status == 200 )  {
           response = xmlHttp.responseText;
             var input = `
             <p style="color:red;">
             `;
           input += response;
           input += "</p>";
           myDiv.innerHTML = input;// + myDiv.innerHTML;
           setTimeout(location.reload.bind(location), 1200);
         }
    }  
}



function skladnikiRequest(option)      {
    xmlHttp = getRequestObject() ;
    if (xmlHttp) {
      try {
        var url = "./getSkladniki.php?option="+option;
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
 myDiv = document.getElementById("myDiv");
 if (xmlHttp.readyState == 4) {
      if ( xmlHttp.status == 200 )  {
        response = xmlHttp.responseText;
          var input = `
          <table class="skladnikiTable">
          <thead>
            <tr>
            <th>Nazwa</th>
            <th>Jednostka</th>
            <th>Rodzaj</th>
            <th>Ile chcesz dodać?</th>
            <th>Gdzie kupić?</th>
            </tr>
          </thead>
          `;
        input += response;
        input += "</table>";
        myDiv.innerHTML = input;
      }
 }  
}

function gdzieKupic(id){
  xmlHttp = getRequestObject() ;
  if (xmlHttp) {
    try {
      var url = "./getPartnerskieSklepy.php?idskladnik="+id;
      xmlHttp.onreadystatechange = ()=>{
        var myDiv = document.getElementById("partnerskieSklepyDiv");
        if (xmlHttp.readyState == 4) {
          if ( xmlHttp.status == 200 )  {
            response = xmlHttp.responseText;
            myDiv.innerHTML = response;
            document.getElementById("zawartoscSpizarni").style="display:none;";
            myDiv.style = "";
            }
        }  
      } ;
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

function gdzieKupicOff(){
  document.getElementById("partnerskieSklepyDiv").style = "display:none;";
  document.getElementById("zawartoscSpizarni").style = "";
}