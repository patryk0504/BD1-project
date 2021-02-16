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
    
    function skladnikiRequest(option)      {
        xmlHttp = getRequestObject() ;
        if (xmlHttp) {
            try {
                var url = "./getSkladniki.php?option="+option;
                xmlHttp.onreadystatechange = handleResponse ;
                xmlHttp.open("GET", url, true);
                xmlHttp.send(null);
            }catch (e) {
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
                <table class="skladnikiTable" style = "margin-left: 15%;">
                <thead>
                <tr>
                <th>Nazwa</th>
                <th>Jednostka</th>
                <th>Rodzaj</th>
                <th>Opcje</th>
                </tr>
                </thead>
                `;
                input += response;
                input += "</table>";
                myDiv.innerHTML = input;
            }
        }  
    }


function pokazPowiazania(idskladnik){
    xmlHttp = getRequestObject() ;
        if (xmlHttp) {
            try {
                var url = "./getPowiazania.php?idskladnik="+idskladnik;
                xmlHttp.onreadystatechange = ()=>{
                    myDiv = document.getElementById("partnerzyDiv");
                    if (xmlHttp.readyState == 4) {
                        if ( xmlHttp.status == 200 )  {
                            response = xmlHttp.responseText;
                            myDiv.innerHTML = response;
                        }
                    }  
                } ;
                xmlHttp.open("GET", url, true);
                xmlHttp.send(null);
            }catch (e) {
                alert ("Nie mozna polaczyc sie z serwerem: " + e.toString()) ;
            }
        } else {
            alert ("Blad") ;
        }
}

function zatwierdzPartnera(idskladnik){
    var idpartner = document.getElementById("dostawcaSelect").value;
    xmlHttp = getRequestObject() ;
    if (xmlHttp) {
        try {
            var url = "./nowePowiazanie.php?idskladnik="+idskladnik+"&idpartner="+idpartner;
            xmlHttp.onreadystatechange = ()=>{
                myDiv = document.getElementById("partnerzyDiv");
                if (xmlHttp.readyState == 4) {
                    if ( xmlHttp.status == 200 )  {
                        response = xmlHttp.responseText;
                        myDiv.innerHTML = response;
                    }
                }  
            } ;
            xmlHttp.open("GET", url, true);
            xmlHttp.send(null);
        }catch (e) {
            alert ("Nie mozna polaczyc sie z serwerem: " + e.toString()) ;
        }
    } else {
        alert ("Blad") ;
    }
}

function dodajPartnera(){
    var nazwa = document.getElementById("nazwaPartnera").value;
    var adres = document.getElementById("adresPartnera").value;
    xmlHttp = getRequestObject() ;
    if (xmlHttp) {
        try {
            var url = "./dodajPartnera.php?nazwa="+nazwa+"&adres="+adres;
            xmlHttp.onreadystatechange = ()=>{
                myDiv = document.getElementById("nowyPartnerDiv");
                if (xmlHttp.readyState == 4) {
                    if ( xmlHttp.status == 200 )  {
                        response = xmlHttp.responseText;
                        myDiv.innerHTML = response;
                    }
                }  
            } ;
            xmlHttp.open("GET", url, true);
            xmlHttp.send(null);
        }catch (e) {
            alert ("Nie mozna polaczyc sie z serwerem: " + e.toString()) ;
        }
    } else {
        alert ("Blad") ;
    }
}