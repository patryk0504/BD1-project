<?php
    session_start();
    $option = $_REQUEST["option"];
    include("../config_bd/login_bd.php");
    $zapytanie = "select distinct on (s.nazwa) nazwa,k.jednostka, k.rodzaj, s.idskladnik from proj_v1.skladnik s
    join proj_v1.kategoriaskladnik k on s.idkategoriaskladnik = k.idkategoriaskladnik where k.rodzaj = '$option' order by s.nazwa;";
    $wynik = pg_query($db,$zapytanie);
    $tab = pg_fetch_all($wynik);
    $str = "";
    $k = 0;
    foreach($tab as $skladniki){
        $str = $str . <<<HTML
            <tr>
                <td>{$skladniki['nazwa']}</td>
                <td>{$skladniki['rodzaj']}</td>
                <td><button name = "dodajSkladnik"  onclick = "dodajSkladnik({$k}, {$skladniki['idskladnik']}, '{$skladniki['nazwa']}');">Dodaj składnik</button></td>
            </tr>
        HTML;
        $k++;
    }
    pg_close($db);
    echo $str;
?>