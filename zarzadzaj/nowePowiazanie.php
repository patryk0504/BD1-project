<?php
    session_start();
    $idskladnik = $_REQUEST["idskladnik"];
    $idpartner = $_REQUEST["idpartner"];
    include("../config_bd/login_bd.php");
    $zapytanie = "update proj_v1.skladnik set iddostawca = ".$idpartner." where idskladnik = ".$idskladnik;
    $wynik = pg_query($db,$zapytanie);
    $cmdtuples = pg_affected_rows($wynik);
    
    if($cmdtuples > 0){
        echo "<h3 class = \"center\">Pomyślnie zapisano nowe powiązanie.</h3>";
    }else{
        echo "<h3 class = \"center\">Powiązanie nie zostało zapisane!".pg_last_error()."</h3>";
    }

    pg_close($db);
?>