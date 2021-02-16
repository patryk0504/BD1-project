<?php
    session_start();
    $nazwa = $_REQUEST["nazwa"];
    $adres = $_REQUEST["adres"];
    include("../config_bd/login_bd.php");
    $wynik = pg_query_params($db, 'insert into proj_v1.dostawca (nazwa, adres_link) VALUES ($1, $2)', array($nazwa, $adres))
        or die ('Wykryto naruszenie: ' . pg_last_error());
    $tab = pg_fetch_all($wynik);

    $cmdtuples = pg_affected_rows($wynik);
    
    if($cmdtuples > 0){
        echo "<h3 class = \"center\">Pomyślnie zapisano nowego dostawcę. Odśwież stronę aby zobaczyć zmiany.</h3>";
    }else{
        echo "<h3 class = \"center\">Dostawca nie został zapisany! ".pg_last_error()."</h3>";
    }

    pg_close($db);
?>