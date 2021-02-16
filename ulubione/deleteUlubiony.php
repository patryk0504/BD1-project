<?php
    session_start();
    $login = $_SESSION['user'];
    include("../config_bd/login_bd.php");
    $idprzepis = $_GET['id'];
    
    if($_GET['wszystko']=='false'){
        $wynik = pg_query_params($db, 'select * from proj_v1.deleteulubione($1, $2, false)', array($login, $idprzepis))
                or die ('Unable to CALL stored procedure: ' . pg_last_error());
        $tab = pg_fetch_all($wynik);
        $row ;
        foreach($tab as $res)
        $row = $res['deleteulubione'];
        if($row == 't'){
            echo "<p>Pomyślnie usunięto z ulubionych!</p>";
        }else{
            echo "Nie usunięto z ulubionych";
        }
    }else{
        $wynik = pg_query_params($db, 'select * from proj_v1.deleteulubione($1, $2, true)', array($login, $idprzepis))
                or die ('Unable to CALL stored procedure: ' . pg_last_error());
        $tab = pg_fetch_all($wynik);
        $row ;
        foreach($tab as $res)
        $row = $res['deleteulubione'];
        if($row == 't'){
            echo "<p>Pomyślnie usunięto z ulubionych!</p>";
        }else{
            echo "Nie usunięto z ulubionych";
        }
    }

    pg_close($db);

?>