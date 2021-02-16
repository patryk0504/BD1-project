
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

function usunSkladnikiButton(numer, idSkladnik, flag=true){
    if(flag){
    const elements = document.querySelectorAll('.myDiv');
    Array.from(elements).forEach((element, index) => {
        element.style = "display:none;";
    });
    }
    var div = document.getElementById(numer);

    var amountWymagana = parseFloat (document.getElementById("iloscWymagana"+numer).innerHTML );
    var amountAktualna = parseFloat (document.getElementById("iloscAktualna"+numer).innerHTML );
    if (amountAktualna < amountWymagana){
        div.innerHTML = "Zbyt mała ilość składnika w spiżarni!";
        div.style = "display:block;";
    }else{
       xmlHttp = getRequestObject() ;
        if (xmlHttp) {
      try {
        var url = "../spizarnia/deleteSkladnik.php?amount="+amountWymagana + "&idSkladnik=" + idSkladnik;
        xmlHttp.onreadystatechange = () => {
            var myDiv;
            if(flag)    myDiv = document.getElementById(numer);
            else    myDiv = document.getElementById("wszystkieDiv");
            myDiv.style = "display:block;";
            if (xmlHttp.readyState == 4) {
                if ( xmlHttp.status == 200 )  {
                response = xmlHttp.responseText;
                var input = response;
                myDiv.innerHTML = input;
                setTimeout(location.reload.bind(location), 600);
                }
            }  
        } ;
        xmlHttp.open("GET", url, true);
        xmlHttp.send(null);
      }
      catch (e) {
        alert ("Nie mozna polaczyc sie z serwerem: " + e.toString()) ;
      }
    }else {
      alert ("Blad") ;
    }}
}

function usunWszystkieButton(){
    var flag = true;
    const elements = document.querySelectorAll('.idskladnik');
    Array.from(elements).forEach((element, index) => {
        // alert(index);
        var div = document.getElementById(index);
        var amountWymagana = parseFloat (document.getElementById("iloscWymagana"+index).innerHTML);
        var amountAktualna = parseFloat (document.getElementById("iloscAktualna"+index).innerHTML);
        if (amountAktualna < amountWymagana){
            div.innerHTML = "Zbyt mała ilość składnika w spiżarni!";
            div.style = "display:block;";
            flag = false;
        }
    });

    if(flag){
        const elementsDiv = document.querySelectorAll('.myDiv');
        Array.from(elementsDiv).forEach((element, index) => {
        element.style = "display:none;";
        });
        Array.from(elements).forEach((element, index) => {
        usunSkladnikiButton(index,parseInt(element.innerHTML), false);
        });
    }
}

function dodajSkladnikiButton(){
    const elements = document.querySelectorAll('.inputValue');
    Array.from(elements).forEach((element, index) => {
        var amount = parseFloat (document.getElementById("inputSkladnik"+index).value);
        var idskladnika = parseInt (document.getElementById("inputSkladnik"+index).nextSibling.innerHTML);
        if(amount >= 0)
          dodajSkladnikiRequest(amount, idskladnika);
    });
}


function dodajSkladnikiRequest(amount,idSkladnik){
    //mamy idskladnika oraz ilosc, mozemy wprowadzic do bazy danych
    if (amount > 0){
        xmlHttp = getRequestObject() ;
        if (xmlHttp) {
            try {
                var url = "../spizarnia/insertSkladnik.php?amount="+amount + "&idSkladnik=" + idSkladnik;
                xmlHttp.onreadystatechange = () =>{
                    var myDiv = document.getElementById("wszystkieDiv");
                    myDiv.style = "display:block;";
                    if (xmlHttp.readyState == 4) {
                        if ( xmlHttp.status == 200 )  {
                            response = xmlHttp.responseText;
                            var input = response;
                            myDiv.innerHTML = input;
                            setTimeout(location.reload.bind(location), 800);
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
}

function sprawdzSkladnikiSpizarnia(idPrzepis){
    xmlHttp = getRequestObject() ;
    if (xmlHttp) {
      try {
        var url = "./sprawdzSkladniki.php?id="+idPrzepis;
        xmlHttp.onreadystatechange = skladnikiResponse ;
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

function skladnikiResponse()      {
    var myDiv = document.getElementById("sprawdzSkladnikiDiv");
    myDiv.style = "display:block;";
    if (xmlHttp.readyState == 4) {
         if ( xmlHttp.status == 200 )  {
           response = xmlHttp.responseText;
           var input = response;
           myDiv.innerHTML = input;
         }
    }  
   }