<?php
    session_start();
    $id = $_GET["id"];
    $ocena = -1;
    $recenzja = 'null';
    $login = $_SESSION['user'];
    include("../config_bd/login_bd.php");

    $wynik = pg_query_params($db, 'select * from proj_v1.addulubione($1, $2)', array($login, $id))
            or die ('Unable to CALL stored procedure: ' . pg_last_error());
    $tab = pg_fetch_all($wynik);
    $row ;
    foreach($tab as $res)
        $row = $res['addulubione'];
        
    echo $row;
    pg_close($db);
?>