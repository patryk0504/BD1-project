window.onload = function(){
    pokazWszystkie();
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

function filtrujPrzepisy(){
    var rodzaj = document.getElementById("rodzaj").value;
    var kategoria = document.getElementById("kategoria").value;
    var sortowanie = document.getElementById("sortowanie").value;
    getUlubioneRequest(rodzaj, kategoria, sortowanie);
}

function przejdzDoPrzepisu(id){
    var win = window.open("../szczegoly_przepisu/jedenPrzepis.php?id="+id, '_blank');
    win.focus();
  }

function pokazWszystkie(){
    getUlubioneRequest('all','all','all');
}

function getUlubioneRequest(rodzaj, kategoria, sortowanie)      {
    xmlHttp = getRequestObject() ;
    if (xmlHttp) {
      try {
        var url = "./getPrzepisy.php?rodzaj="+rodzaj+"&kategoria="+kategoria+"&sortowanie="+sortowanie;
        xmlHttp.onreadystatechange = handleResponseGetUlubione ;
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

function usunZUlubionych(id){
    hideTwojaOpinia();
    hideUlubione();
 
    var myDiv = document.getElementById("ulubioneInfo");
    myDiv.style = "display:block;";
    myDiv.innerHTML = `
        <button id = "usunZUlubionych" onclick="usunZUlubionychRequest(${id},false)" >Tylko z ulubionych (bez usuwania recenzji)</button> <br>
        <button id = "usunZUlubionych_2" onclick="usunZUlubionychRequest(${id},true)" >Usuń wszystko (dodatkowo usuwa recenzje)</button> <br>
    `
}

function usunZUlubionychRequest(id, wszystko){
    xmlHttp = getRequestObject() ;
    if (xmlHttp) {
      try {
        var url = "./deleteUlubiony.php?id="+id+"&wszystko="+wszystko;
        xmlHttp.onreadystatechange = handleResponseGetUlubione2 ;
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

function handleResponseGetUlubione()      {
 myDiv = document.getElementById("myDiv");
 if (xmlHttp.readyState == 4) {
      if ( xmlHttp.status == 200 )  {
        response = xmlHttp.responseText;
        var input = response;
        myDiv.innerHTML = input;
    }
 }  
}

function handleResponseGetUlubione2()      {
    myDiv = document.getElementById("ulubioneInfo");
    myDiv.style = "display:block;";
    if (xmlHttp.readyState == 4) {
         if ( xmlHttp.status == 200 )  {
           response = xmlHttp.responseText;
           var input = response;
           myDiv.innerHTML = input;
           setTimeout(location.reload.bind(location), 1000);
       }
    }  
   }

/////////////////


function pokazOpisFun(numer){
    hideTwojaOpinia(); 
    hideUlubione();
    var divToShow = "divOpis" + numer;
    document.getElementById(divToShow).style = "display:block;";
}


function pokazSkladnikiFun(numer){
    hideTwojaOpinia();
    hideUlubione();
    var divToShow = "#tableSkladniki" + numer;
    const elements2 = document.querySelectorAll(divToShow);
    Array.from(elements2).forEach((element, index) => {
        element.style = "display:block;";
    });
}

function pokazWartosciFun(numer){
    hideTwojaOpinia();
    hideUlubione();
    var divToShow = "#tableWartosci" + numer;
    const elements2 = document.querySelectorAll(divToShow);
    Array.from(elements2).forEach((element, index) => {
        element.style = "display:block;";
    });
}

function pokazTwojaOpinia(numer){
    hideTwojaOpinia();
    hideUlubione();
    var divToShow = "#tableOpinia" + numer;
    const elements2 = document.querySelectorAll(divToShow);
    Array.from(elements2).forEach((element, index) => {
        element.style = "display:block;";
    });
}


function hideTwojaOpinia(){
    const elements = document.querySelectorAll('.twojaOpinia');
    Array.from(elements).forEach((element, index) => {
        element.style = "display:none;";
    });
}

function hideUlubione(){
    var element = document.getElementById('ulubioneInfo');
    element.style = "display:none;";
}