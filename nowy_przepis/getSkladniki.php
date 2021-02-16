<?php
    session_start();
    $option = $_REQUEST["option"];
    include("../config_bd/login_bd.php");
    $zapytanie = "select s.idskladnik,s.nazwa,k.jednostka, k.rodzaj from proj_v1.skladnik s join proj_v1.kategoriaskladnik k on s.idkategoriaskladnik = k.idkategoriaskladnik where k.rodzaj = '$option' order by s.nazwa;";
    $wynik = pg_query($db,$zapytanie);
    $tab = pg_fetch_all($wynik);
    $str = "";
    $k = 0;
    $str = $str . "<tbody>";
    foreach($tab as $skladniki){
        $str = $str . <<< HTML
        <tr>
            <td>{$skladniki['nazwa']}</td>
            <td>{$skladniki['jednostka']}</td>
            <td>{$skladniki['rodzaj']}</td>
            <td><input id = "inputSkladnik{$k}" type="number" value = "0" min = "0" step = "0.01">
            <br><button name="dodajSkladniki" onclick="dodajSkladnikiButton({$k},{$skladniki['idskladnik']}, '{$skladniki['nazwa']} ');">Dodaj składnik</button>
            </td>
        </tr>
        HTML;
        $k++;
    }
    $str = $str . "</tbody>";
    pg_close($db);
    echo $str;
?>