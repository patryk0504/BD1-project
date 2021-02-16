<?php
    session_start();
    $amount = $_REQUEST["amount"];
    $idSkladnik = $_REQUEST["idSkladnik"];
    include("../config_bd/login_bd.php");
    $login = $_SESSION['user'];

    $wynik = pg_query_params($db, 'select insertskladnikspizarnia as status from proj_v1.insertSkladnikSpizarnia($1, $2, $3)', array($login, $idSkladnik, $amount))
                or die ('Unable to CALL stored procedure: ' . pg_last_error());
    $table = pg_fetch_all($wynik);
    $row;
    foreach($table as $count){
        $row = $count['status'];
    }
    
    if($row == 't'){
        echo "<h3>Pomyślnie uzupełniono spiżarnie!</h3>";
    }else{
        echo "<h3>Coś poszło nie tak! Czy masz stworzoną spiżarnie?</h3>";
    }

    
?>