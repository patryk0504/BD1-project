<?php
    session_start();
    $idskladnik = $_REQUEST["idskladnik"];
    include("../config_bd/login_bd.php");
    $zapytanie = "select * from proj_v1.dostawcyskladnika ds where ds.idskladnik=".$idskladnik;
    $wynik = pg_query($db,$zapytanie);
    $tab = pg_fetch_all($wynik);
    $str = "";

    $zapytanie2 = "select d.nazwa, d.iddostawca from proj_v1.dostawca d";
    $wynik2 = pg_query($db,$zapytanie2);
    $tab2 = pg_fetch_all($wynik2);
    $str2 = <<<HTML
        <select name="dostawca" id="dostawcaSelect">
    HTML;
    foreach($tab2 as $res){
        $iddostawca = $res['iddostawca'];
        $nazwa = $res['nazwa'];
        $str2 = $str2 . <<<HTML
        <option value="{$iddostawca}">$nazwa</option>
        HTML;
    }
    $str2 = $str2 . <<<HTML
        </select>
        <input type="button" onclick = "zatwierdzPartnera({$idskladnik});" value = "Zatwierdź">
    HTML;

    if(pg_num_rows($wynik) == 0){
        $str = $str . <<<HTML
            <h3>Nie znaleziono powiązania</h3>
            <h4>Chcesz utworzyć nowe? Wybierz dostawce.</h4>
        HTML;
        $str = $str . $str2;
    }else{
        $powiazany;
        foreach($tab as $res)
            $powiazany = $res['nazwa'];
        $str = $str . <<<HTML
        <h3>Aktualnie powiązano z {$powiazany}</h3>
        <h4>Chcesz zmienić powiązanie? Wybierz nowego dostawcę z listy</h4>
        <select name="dostawca" id="dostawcaSelect">
            <option value = null>Usuń powiązanie</option>
        HTML;
        foreach($tab2 as $res){
            $nazwa = $res['nazwa'];
            $iddostawca = $res['iddostawca'];
            $str = $str . <<<HTML
            <option value="{$iddostawca}">{$nazwa}</option>
            HTML;
        }
        $str = $str . <<<HTML
        </select>
        <input type="button" onclick = "zatwierdzPartnera({$idskladnik});" value = "Zatwierdź">
        HTML;
        
    }
   
    pg_close($db);
    echo $str;
?>