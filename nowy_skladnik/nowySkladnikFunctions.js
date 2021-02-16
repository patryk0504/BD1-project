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
    // showButtonClick();
    getJednostka();
    // showButtonClick();
}


function getJednostka(){
    var kategoria = document.getElementById("kategoriaSelect").value;
    xmlHttp = getRequestObject() ;
    if (xmlHttp) {
      try {
        var url = "./getJednostka.php?kategoria="+kategoria;
        xmlHttp.onreadystatechange = ()=>{
            myDiv = document.getElementById("jednostkaDiv");
            if (xmlHttp.readyState == 4) {
                if ( xmlHttp.status == 200 )  {
                    response = xmlHttp.responseText;
                    myDiv.innerHTML = response;
                
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

function zapiszSkladnik(){
    var kategoria = document.getElementById("kategoriaSelect").value;
    var jednostka = document.getElementById("jednostkaSelect").value;
    var nazwa = document.getElementById("nazwaInput").value;
    var dostawca = document.getElementById("dostawcaSelect").value;
    xmlHttp = getRequestObject() ;
    if (xmlHttp) {
      try {
        var url = "./zapiszSkladnik.php?kategoria="+kategoria+"&jednostka="+jednostka+"&nazwa="+nazwa+"&dostawca="+dostawca;
        xmlHttp.onreadystatechange = ()=>{
            myDiv = document.getElementById("resultDiv");
            if (xmlHttp.readyState == 4) {
                if ( xmlHttp.status == 200 )  {
                    response = xmlHttp.responseText;
                    myDiv.innerHTML = response;
                    showButtonClick();
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

function showButtonClick(){
  var option = document.getElementById("rodzajSkladnika").value;
  xmlHttp = getRequestObject() ;
    if (xmlHttp) {
      try {
        var url = "./getSkladniki.php?option="+option;
        xmlHttp.onreadystatechange = ()=>{
          var myDiv = document.getElementById("wszystkieSkladniki");
          if (xmlHttp.readyState == 4) {
            if ( xmlHttp.status == 200 )  {
              response = xmlHttp.responseText;
              myDiv.innerHTML = response;
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


function gdzieKupic(id){
  xmlHttp = getRequestObject() ;
  if (xmlHttp) {
    try {
      var url = "../spizarnia/getPartnerskieSklepy.php?idskladnik="+id;
      xmlHttp.onreadystatechange = ()=>{
        var myDiv = document.getElementById("partnerskieSklepyDiv");
        if (xmlHttp.readyState == 4) {
          if ( xmlHttp.status == 200 )  {
            response = xmlHttp.responseText;
            myDiv.innerHTML = response;
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
}