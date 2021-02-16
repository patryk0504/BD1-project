<?php
    session_start();
    
    if(!isset($_SESSION['auth']) && $_SESSION['auth'] != 'OK'){
        header("Location: ../log_rej/logowanie.php");
        exit;
    }

    $nazwa = $_POST['nazwa'];
    $login = $_SESSION['user'];
    include("../config_bd/login_bd.php");
    $result = pg_query_params($db, 'select * from proj_v1.createSpizarnia($1, $2)', array($nazwa, $login))
                or die ('Unable to CALL stored procedure: ' . pg_last_error());
    $table = pg_fetch_all($result);
    $row;
    foreach($table as $count){
        $row = $count['createspizarnia'];
    }
    if($row == 't'){
        echo "<h2>Pomyślnie stworzono spiżarnię!</h2>";
        echo "<p>Za 2s nastąpi przekierowanie...";
        echo "Jeżeli tak się na stało kliknij tutaj: <a href=\"./spizarnia.php\">Link bezpośredni</a> </p>";
        header( "Refresh:2; url=./spizarnia.php", true, 303);
    }else{
        echo "Błąd tworzenia spiżarni";
    }
    pg_close($db);
?>