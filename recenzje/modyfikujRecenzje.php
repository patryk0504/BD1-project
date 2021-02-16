<?php
    session_start();
    include("../config_bd/login_bd.php");
    $id = $_GET["id"];
    $login = $_SESSION['user'];
    $ocena;
    $recenzja;
    if($_GET['ocena'] != -1){
        $ocena = $_GET['ocena'];
    }else{
        $ocena = -1;
    }
    if(isset($_GET['recenzja'])){
        $recenzja = $_GET['recenzja'];
    }else{
        $recenzja = 'null';
    }
    $wynik = pg_query_params($db, 'select * from proj_v1.addrecenzja($1, $2, $3, $4)', array($login, $id, $ocena, $recenzja))
        or die ('Unable to CALL stored procedure: ' . pg_last_error());
    $tab = pg_fetch_all($wynik);


    $row ;
    foreach($tab as $res)
        $row = $res['addrecenzja'];
    if($row == 't'){
        echo   "<p class=\"sign\" align=\"center\">Pomyślnie zapisano opinię</p>";
    }else{
        echo   "<p class=\"sign\" align=\"center\">Coś poszło nie tak.</p>";
    }

    pg_close($db);
?>
