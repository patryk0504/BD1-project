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


function pokazSkladniki(){
    var form1 = document.getElementById("form1").style = "display:none;";
    var form2 = document.getElementById("form2").style = "";

}

function pokazForm1(){
    var form1 = document.getElementById("form1").style = "";
    var form2 = document.getElementById("form2").style = "display:none;";
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
      }
      catch (e) {
        alert ("Nie mozna polaczyc sie z serwerem: " + e.toString()) ;
      }
    } else {
      alert ("Blad") ;
    }
}
function handleResponse()      {
 myDiv = document.getElementById("skladnikiDiv");
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
            <th>Ile chcesz dodać?<th>
            </tr>
          </thead>
          `;
        input += response;
        input += "</table>";
        myDiv.innerHTML = input;
      }
 }  
}

function dodajSkladnikiButton(number,idSkladnik, nazwa){
    var value = document.getElementById("inputSkladnik"+number).value;
    var tbodyRef = document.getElementById('wybraneTable').getElementsByTagName('tbody')[0];
    var newRow = tbodyRef.insertRow();
    var newCellName = newRow.insertCell();
    var newText = document.createTextNode(nazwa);
    newCellName.appendChild(newText);
    var newCellAmount = newRow.insertCell();
    newCellAmount.appendChild(document.createTextNode(value));
    var newCellId = newRow.insertCell();
    newCellId.appendChild(document.createTextNode(idSkladnik));
    newCellId.hidden = true;
}

function wyczyscSkladniki(){
    var wybraneDiv = document.getElementById("wybraneDiv");
    wybraneDiv.innerHTML = `
    <h4>Poniżej pojawią się wybrane składniki</h4>
        <p>Chcesz wyczyścić listę? Naciśnij przycisk -> </p> <button onclick="wyczyscSkladniki();">Wyczyść</button>
        <table id="wybraneTable" class="proponowaneTab">
            <tbody>
            
            </tbody>
        </table>
    `;
}

function przejdzDoPrzepisu(id){  
    var win = window.open("../szczegoly_przepisu/jedenPrzepis.php?id="+id, '_blank');
    win.focus();
}

function stworzKolejny(){
    window.location.reload(true);
}

function zatwierdzSkladniki(){
    var table = document.getElementById("wybraneTable");

    var mapArray = {};
    for (var i = 0, row; row = table.rows[i]; i++) {
        col = row.cells;
        mapArray[col[2].innerHTML] = col[1].innerHTML;
    }
    var jsonString = JSON.stringify(mapArray);

    
    var kategoria = document.getElementById("kategoriaSelect").value;
    var rodzaj = document.getElementById("rodzajSelect").value;
    var kcal = document.getElementById("kcalInput").value;
    var wegl = document.getElementById("weglInput").value;
    var bialko = document.getElementById("bialkoInput").value;
    var tluszcze = document.getElementById("tluszczeInput").value;

    var nazwa = document.getElementById("nazwaInput").value;
    var czas = document.getElementById("czasInput").value;
    var opis = document.getElementById("opisInput").value;
    var link = document.getElementById("linkInput").value;
    var optionsArray = {
        
        "rodzaj" : rodzaj,
        "kategoria" : kategoria,
        "kcal" : kcal,
        "wegl" : wegl,
        "bialko" : bialko,
        "tluszcze" : tluszcze,
        "nazwa" : nazwa,
        "czas" : czas,
        "opis" : opis,
        "link" : link
    };

    var jsonString2 = JSON.stringify(optionsArray);

    xmlHttp = getRequestObject() ;
    if (xmlHttp) {
      try {
        var url = "./addNowyPrzepis.php";
        xmlHttp.onreadystatechange = () => {
            if (xmlHttp.readyState == 4) {
                if ( xmlHttp.status == 200 )  {
                  response = xmlHttp.responseText;
                    document.getElementById("wybraneDiv").innerHTML = response;
                }
           } 
        } ;
        xmlHttp.open("POST", url);

        xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlHttp.send('data=' + (jsonString) + "&options=" + (jsonString2));
        
      }
      catch (e) {
        alert ("Nie mozna polaczyc sie z serwerem: " + e.toString()) ;
      }
    } else {
      alert ("Blad") ;
    }
}