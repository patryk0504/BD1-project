<?php
    session_start();
    
    if(!isset($_SESSION['auth']) && $_SESSION['auth'] != 'OK'){
        header("Location: ./log_rej/logowanie.php");
        exit;
    }

    $nazwa = $_POST['nazwa'];
    $login = $_SESSION['user'];
    include("../config_bd/login_bd.php");
    $zapytanie = "select * from proj_v1.deletespizarnia('$nazwa','$login');";
    $result = pg_query($db,$zapytanie); 
    $tab = pg_fetch_object($result);
    
        if($tab->deletespizarnia == 't'){
            echo "<h2>Pomyślnie usunięto spiżarnie!</h2>";
            echo "<p>Za 2s nastąpi przekierowanie...";
            echo "Jeżeli tak się na stało kliknij tutaj: <a href=\"./spizarnia.php\">Link bezpośredni</a></p>";
            header( "Refresh:2; url=./spizarnia.php", true, 303);
        }else{
            echo "<h2>Coś poszło nie tak!</h2><p>Sprawdź czy wprowadzono poprawną nazwę bazy do usunięcia.</p>";
            echo "<p>Za 2s nastąpi przekierowanie...";
            echo "Jeżeli tak się na stało kliknij tutaj: <a href=\"./spizarnia.php\">Link bezpośredni</a></p>";
            header( "Refresh:2; url=./spizarnia.php", true, 303);
        }

        pg_close($db);

?>