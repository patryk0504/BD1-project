<?php
    session_start();
    include("../config_bd/login_bd.php");
    $idprzepis = $_GET["id"];
    $login = $_SESSION['user'];
    
    $ocenaval = -1;
    $wynik = pg_query_params($db, 'select * from proj_v1.addrecenzja($1, $2, $3, $4)', array($login, $idprzepis, $ocenaval, ''))
        or die ('Unable to CALL stored procedure: ' . pg_last_error());
    // $wynik = pg_query_params($db, 'select * from proj_v1.deleteulubione($1, $2, true)', array($login, $idprzepis))
    // or die ('Unable to CALL stored procedure: ' . pg_last_error());
    $tab = pg_fetch_all($wynik);
    $row ;
    foreach($tab as $res)
        $row = $res['addrecenzja'];
    if($row == 't'){
        echo "<p>Pomyślnie usunięto recenzje!</p>";
    }else{
        echo "Nie usunięto recenzji";
    }

    pg_close($db);
?>
