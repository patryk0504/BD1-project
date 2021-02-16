<?php
session_start();
$login = $_SESSION['user'];
include("../config_bd/login_bd.php");
$idprzepis = $_GET['id'];


$wynik = pg_query_params($db, 'select * from proj_v1.czymogewykonac ($1, $2)', array($login, $idprzepis))
                or die ('Unable to CALL stored procedure: ' . pg_last_error());
$tab = pg_fetch_all($wynik);
    
$str = <<<HTML
    <table id = "sprawdzSkladniki">
        <thead>
        <tr>
        <th>Nazwa składnika</th>
        <th>Ilość w spiżarni</th>
        <th>Wymagana ilość</th>
        <th>Jednostka</th>
        <th>Rodzaj składnika</th>
        <th>Informacja</th>
        <th>Szybkie dodanie do spiżarni</th>
        <th>Szybkie usunięcie ze spiżarni</th>
        <th>Info</th>
        </tr>  
        </thead>
        <tbody>
HTML;
$k=0;
foreach($tab as $res){
    $idskladnika = $res['idskladnik'];
    $str = $str . <<<HTML
    <tr>
        <td class = "idskladnik" style = "display:none;">{$idskladnika}</td>
        <td>{$res['nazwaskladnika']}</td>
        <td id = "iloscAktualna{$k}">{$res['aktualnailosc']}</td>
        <td id = "iloscWymagana{$k}">{$res['wymaganailosc']}</td>
        <td>{$res['jednostka']}</td>
        <td>{$res['rodzaj']}</td>
        <td>{$res['info']}</td>
        <td><input id = "inputSkladnik{$k}" class = "inputValue" type="number" value = "0" min = "0" step = "0.01"><div style="display:none;">{$idskladnika}</div></td>
        <td><button onclick = "usunSkladnikiButton($k, {$res['idskladnik']});">Usuń składniki</button></td>
        <td><div class = "myDiv" id = {$k}></div></td>
        </tr>
    HTML;
    $k++;
}

$tmp = json_encode($idArray);
$str = $str . <<<HTML
    <tr>
        <td colspan = "2"><button onclick = "usunWszystkieButton();">Usuń wszystkie wymagane w przepisie</button></td>
        <td colspan = "4"><div id="wszystkieDiv"></div></td>
        <td><button name="dodajSkladniki" onclick="dodajSkladnikiButton();">Dodaj składniki</button></td>
        <td></td>
        <td></td>
    </tr>
    </tbody>
    </table>
    
HTML;
echo $str;
pg_close($db);
?>