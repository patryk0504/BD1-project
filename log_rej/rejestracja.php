<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejestracja</title>
    <link rel="stylesheet" href="../style/rejestracjaStyle.css">

</head>
<body>

<header>
        <nav class = "topnav">
            <ul>
                <li><a href="../panel_uzytkownika/zalogowanyHome.php">Panel użytkownika</a></li>
                <li><a href="./logowanie.php">Logowanie</a></li>
                <li><a href="./logowanieAdmin.php">Logowanie Administrator</a></li>
                <li><a href="./rejestracja.php">Rejestracja</a></li>
                <li><a href="../indexLogged.php" id = "about">About</a></li>

            </ul>
        </nav>
      </header>

    <div class = "content">

    <div class="main">
        <p class="sign" align="center">Zarejestruj się</p>
        <form action="./rejestracja.php" method = "POST" class="form1">
            <input type="text" name = "imie" class="un " type="text" align="center" placeholder="Imię" required>
            <input type="text" name = "nazwisko" class="un " type="text" align="center" placeholder="Nazwisko" required>
            <input name = "login" class="un " type="text" align="center" placeholder="Login (4 - 16 liter/cyfr)" maxlength="16" minlength="4">
            <input name = "haslo" class="pass" type="password" align="center" placeholder="Hasło (4 - 16 liter/cyfr)" maxlength="16" minlength="4">
            <input class="submit" type="submit" value="Zarejestruj się">
        </form>

        <?php
        $data = array();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $login = $_POST['login'];
            $haslo = $_POST['haslo'];
            $imie = $_POST['imie'];
            $nazwisko = $_POST['nazwisko'];

            include("../config_bd/login_bd.php");
            $zapytanie = "insert into proj_v1.uzytkownik (login, pass, imie, nazwisko) values ('$login', '$haslo', '$imie', '$nazwisko');";
            $result = pg_query($db,$zapytanie); 
            $cmdtuples = pg_affected_rows($result);
    
            if($cmdtuples > 0){
                echo "<p align=\"center\" style=\"color:red;\">Pomyślnie zarejestrowano użytkownika. Możesz się teraz zalogować.<span>";
            }else{
                echo "<p align=\"center\" style=\"color:red;\">Użytkownik o podanym loginie juz istnieje!<span>";
            }
            pg_close($db);
        }
    
        ?>
    </div>
    </div>

    <div  class="spacer"> . </div>

    <footer>
        &copy; 2020 - Patryk Śledź
    </footer>
    
</body>
</html>