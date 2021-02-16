<?php
    session_start();
    $idskladnik = $_REQUEST["idskladnik"];
    include("../config_bd/login_bd.php");
    $zapytanie = "select * from proj_v1.dostawcySkladnika ds where ds.idskladnik = $idskladnik";
    $wynik = pg_query($db,$zapytanie);
    $tab = pg_fetch_all($wynik);
    $str = "";
    if(pg_num_rows($wynik) < 1){
        $str = $str . <<<HTML
            <h3>Jeszcze nie posiadamy informacji o dostawcach tego składnika.</h3>
        HTML;
    }else{
        $str= $str . <<<HTML
        <table class="centerTable">
            <tr>
                <th>Nazwa dostawcy</th>
                <th>Link do strony dostawcy</th>
            </tr>
    HTML;
    foreach($tab as $res){
        $link = $res['adres_link'];
        $str = $str . <<< HTML
        <tr>
            <td>{$res['nazwa']}</td>
            <td><a href="{$link}">Kliknij tutaj</a></td>
        </tr>
        HTML;
    }
    $str = $str . "</table>";
    }
    
    pg_close($db);
    echo $str;
?>