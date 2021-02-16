<?php
    session_start();
    $option = $_REQUEST["option"];
    include("../config_bd/login_bd.php");
    $zapytanie = "select s.idskladnik,s.nazwa,k.jednostka, k.rodzaj from proj_v1.skladnik s join proj_v1.kategoriaskladnik k on s.idkategoriaskladnik = k.idkategoriaskladnik where k.rodzaj = '$option' order by s.nazwa;";
    $wynik = pg_query($db,$zapytanie);
    $tab = pg_fetch_all($wynik);
    $str = "";
    $k = 0;
    $str = <<<HTML
    <table class="skladnikiTable" style="margin-left:4.5em; margin-top:1em;">
        <thead>
        <tr>
            <th>Nazwa</th>
            <th>Jednostka</th>
            <th>Rodzaj</th>
            <th>Gdzie kupić?</th>
        </tr>
        </thead>
        <tbody>
    HTML;
    foreach($tab as $skladniki){
        $str = $str . <<< HTML
        <tr>
            <td>{$skladniki['nazwa']}</td>
            <td>{$skladniki['jednostka']}</td>
            <td>{$skladniki['rodzaj']}</td>
            <td>
                <input type="image" src="../images/cart-check-fill.svg" onclick="gdzieKupic({$skladniki['idskladnik']});"/>
                <input type="image" src="../images/cart-dash.svg" onclick="gdzieKupicOff();"/>
            </td>
        </tr>
        HTML;
        $k++;
    }
    $str = $str . <<<HTML
        </tbody>
        </table>
    HTML;
    pg_close($db);
    echo $str;
?>