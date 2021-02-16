window.onload = function(){
    showButtonClick();
}

function showButtonClick() {
    var option = document.getElementById("rodzajSkladnika").value;
    skladnikiRequest(option);
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

function dodajSkladnik(number,idSkladnik, nazwa){
    var tbodyRef = document.getElementById('wybraneTable').getElementsByTagName('tbody')[0];
    var newRow = tbodyRef.insertRow();
    var newCell = newRow.insertCell();
    var newText = document.createTextNode(nazwa);
    newCell.appendChild(newText);
}

function wyczyscSkladniki(){
    var wybraneDiv = document.getElementById("wybraneDiv");
    wybraneDiv.innerHTML = `
    <h4>Podaj stopień filtracji przepisów</h4>
        <select name="stopienFiltrowania" id="stopienFiltrowania">
        <option value="max">dopasowanie 100%</option>
        <option value="greater">wybrane składniki + dodatkowe spoza wybranych</option>
        <option value="less">wybrane składniki (nie wszystkie użyte + dodatkowe spoza wybranych)</option>
        </select>
        <button id = "proponujButton" onclick = "proponujButton()">Proponuj</button>
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

function proponujSpizarnia(){
    var filtracja = document.getElementById("stopienFiltrowaniaSpizarnia").value;
    document.getElementById("wyborSkladnikow").style="display:none;";
    // var myDiv = document.getElementById("proponowaneDiv");
    document.getElementById("myDiv").style = "display:none;";
    document.getElementById("wybraneDiv").style = "display:none;";
    xmlHttp = getRequestObject() ;
    if (xmlHttp) {
      try {
        var url = "./getProponowaneSpizarnia.php?option="+filtracja;
        xmlHttp.onreadystatechange = handleResponseProponowane;
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

function proponujButton(){
    var wybraneDiv = document.getElementById("wybraneDiv");
    var filtracja = document.getElementById("stopienFiltrowania").value;
    var table = document.getElementById("wybraneTable");
    var input = "";
    var ind = 0;
        
      for (var i = 0, row; row = table.rows[i]; i++) {
        for (var j = 0, col; col = row.cells[j]; j++) {
            input += col.innerHTML;
            if(ind < table.rows.length - 1)
                input += ",";
            ind ++;
        }  
      }
        
        xmlHttp = getRequestObject() ;

        document.getElementById("proponowaneDiv").innerHTML = "";

        if (xmlHttp) {
          try {
            var url = "./getProponowane.php?skladniki="+input+"&option="+filtracja;
            xmlHttp.onreadystatechange = handleResponseProponowane ;
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
          <table id="skladniki" class=\"proponowaneTab\">
            <thead>
            <tr>
            <th>Nazwa</th>
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

function handleResponseProponowane()      {
    var myDiv = document.getElementById("proponowaneDiv");
    myDiv.style="";
    if (xmlHttp.readyState == 4) {
         if ( xmlHttp.status == 200 )  {
           response = xmlHttp.responseText;
           var input = response;
           myDiv.innerHTML = input;
         }
    }  
   }

function pokazWyborSkladnikow(){
  document.getElementById("proponowaneDiv").style="display:none;";
  document.getElementById("wyborSkladnikow").style="";
  document.getElementById("myDiv").style = "";
  document.getElementById("wybraneDiv").style = "";
}