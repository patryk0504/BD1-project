<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie</title>
    <link rel="stylesheet" href="../style/logowanieStyle.css">

</head>
<body>

    <header>
        <nav class = "topnav">
            <ul>
                <li><a href="../panel_uzytkownika/zalogowanyHome.php">Panel użytkownika</a></li>
                <!-- <li><a href="przepisy.php">Szukaj przepisów - bez dodatkowych funkcjonalności</a></li> -->
                <li><a href="./logowanie.php">Logowanie</a></li>
                <li><a href="./logowanieAdmin.php">Logowanie Administrator</a></li>
                <li><a href="./rejestracja.php">Rejestracja</a></li>
                <li><a href="../indexLogged.php" id = "about">About</a></li>

            </ul>
        </nav>
    </header>

    <div class = "content"><h2 class="center">Zaloguj się jako Administrator!</h2></div>

    <h2 class="center" style="color:red;">Do celów testowych dane logowania administratora: <br>
    login: admin <br>
    hasło: admin
    </h2>

    <div class="main">
        <p class="sign" align="center">Zaloguj się</p>
        <form action="./logowanieAdmin.php" method = "POST" class="form1">
        <input name = "login" class="un " type="text" align="center" placeholder="Login">
        <input name = "haslo" class="pass" type="password" align="center" placeholder="Password">
        <input class="submit" type="submit" value="Zaloguj">
        <?php

        if(isset($_POST['login']) and isset($_POST['haslo'])){

        session_start();
        $login = $_POST['login'];
        $haslo = $_POST['haslo'];
        $access = false;

        include("../config_bd/login_bd.php");

        //check if login exist in db
        $zapytanie = "select count(1) from proj_v1.uzytkownik u where u.login = '$login';";
        $result = pg_query($db,$zapytanie);
        $table = pg_fetch_all($result);
        $row;
        foreach($table as $count){
            $row = $count['count'];
        }
        if($row == 0){
            echo "<p align=\"center\" style=\"color:red;\">Użytkownik o loginie: $login nie istnieje!<p>";
        }else{
            //check if pass is ok
            $zapytanie2 = "select count(1) from proj_v1.uzytkownik u where u.login = '$login' and u.pass = '$haslo';";
            $result2 = pg_query($db,$zapytanie2);
            $table2 = pg_fetch_all($result2);
            foreach($table2 as $count){
                $row = $count['count'];
            }
            if($row == 0){
                echo "<p align=\"center\" style=\"color:red;\">Błędne hasło dla użytkownika $login !<p>";  
            }else{
                $zapytanie3 = "select u.isadmin from proj_v1.uzytkownik u where u.login = '$login' and u.pass = '$haslo'";
                $result3 = pg_query($db,$zapytanie3);
                $table3 = pg_fetch_all($result3);
                foreach($table3 as $verify){
                    $row = $verify['isadmin'];
                }
                if($row == 't'){
                    $_SESSION['auth'] = 'OK';
                    $_SESSION['user'] = $login;
                    $_SESSION['admin'] = 'yes';
                    $access = true;  
                    header("Location: ../panel_uzytkownika/zalogowanyAdminHome.php");
                }else{
                    echo "<p align=\"center\" style=\"color:red;\">Nie masz prawa dostępu, nie jesteś administratorem!<p>";  
                }
            }
        }
        pg_close($db);
    }
    ?>
    </form>
    </div>
        


    <div  class="spacer"> . </div>

    <footer>
        &copy; 2020 - Patryk Śledź
    </footer>
    
</body>
</html>