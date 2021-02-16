<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zarejestrowani użytkownicy</title>
    <link rel="stylesheet" href="../style/zarzadzajUzytkownikamiStyle.css">
    <?php
        if(!isset($_SESSION['auth']) && $_SESSION['auth'] != 'OK' && !isset($_SESSION['admin']) && $_SESSION['admin'] != 'yes'){
            header("Location: ../log_rej/logowanieAdmin.php");
            exit;
        }
    ?>

    <script>
    var xmlHttp;
    function getRequestObject() {
        if ( window.ActiveXObject) {
            return ( new ActiveXObject("Microsoft.XMLHTTP")) ;
        }else if (window.XMLHttpRequest) {
            return (new XMLHttpRequest());
        }else {
            return (null);
        }
    }

    function usunUzytkownika(id){
        xmlHttp = getRequestObject() ;
        var formData = new FormData(); 
        formData.append('iduzytkownika', id);
        if (xmlHttp) {
            try {
            var url = "./deleteUzytkownik.php";//?amount="+amountWymagana + "&idSkladnik=" + idSkladnik;
            xmlHttp.onreadystatechange = () => {
            if (xmlHttp.readyState == 4) {
                if ( xmlHttp.status == 200 )  {
                response = xmlHttp.responseText;
                var input = response;
                alert(input);
                setTimeout(location.reload.bind(location), 600);
                }
            }  
        };
        xmlHttp.open("POST", url, true);
        xmlHttp.send(formData);
      }
      catch (e) {
        alert ("Nie mozna polaczyc sie z serwerem: " + e.toString()) ;
      }
    }else {
      alert ("Blad") ;
    }
    }
    </script>
</head>
<body>
    <header>
        <nav class = "topnav">
            <ul>
                <li><a href="../panel_uzytkownika/zalogowanyAdminHome.php">Panel użytkownika</a></li>
                <li><a href="../przepisy/przepisy.php">Szukaj przepisów</a></li>
                <li><a href="../log_rej/wyloguj.php">Wyloguj się</a></li>
                <li><a href="../indexLogged.php" id = "about">About</a></li>

            </ul>
        </nav>
    </header>

    <h1 class="content center">Zarejestrowani użytkownicy ze zwykłymi prawami dostępu</h1>

    <h4 class="center">Każdego użytkownika nie będącego administratorem można usunąć. Proszę pamiętać, że usunięcie użytkownika usuwa wszelkie jego oceny/recenzje, polubione przepisy jak i spiżarnię. <br> 
        Operacja jest nieodwracalna.
    </h4>
    <?php
        include("../config_bd/login_bd.php");

        $login = $_SESSION['user'];

        //check if user has spizarnia
        $zapytanie0 = 'select u.iduzytkownik, u.login, u.imie, u.nazwisko from proj_v1.uzytkownik u where u.isadmin = false';
        $result0 = pg_query($db,$zapytanie0);
        $table0 = pg_fetch_all($result0);

        $zapytanie = "select * from proj_v1.liczba_opini_uzytkownika";
        $result = pg_query($db,$zapytanie);
        $table = pg_fetch_all($result);

        $zapytanie2 = 'select * from proj_v1.liczba_polubien_uzytkownika';
        $result2 = pg_query($db, $zapytanie2);
        $table2 = pg_fetch_all($result2);

        $zapytanie3 = 'select u.iduzytkownik, u.login, u.imie, u.nazwisko, s.nazwa from proj_v1.uzytkownik u join proj_v1.spizarnia s on u.iduzytkownik = s.iduzytkownik';
        $result3 = pg_query($db, $zapytanie3);
        $table3 = pg_fetch_all($result3);
        $str = <<<HTML
        <table class="lista centerTable">
        <tr>
            <th>ID</th>
            <th>Login</th>
            <th>Imie</th>
            <th>Nazwisko</th>
            <th>Liczba wystawionych opinii</th>
            <th>Liczba polubień</th>
            <th>Czy użytkownik posiada spiżarnie</th>
            <th>Usuń</th>
        </tr>
        HTML;
        $l_polubien = array();
        foreach($table2 as $row){
            $l_polubien[$row['iduzytkownik']] = $row['liczba_polubien'];
        }
        $l_opinii = array();
        foreach($table as $row){
            $l_opinii[$row['iduzytkownik']] = $row['liczba_opinii'];
        }
        $isSpizarnia = array();
        foreach($table3 as $row){
            $isSpizarnia[$row['iduzytkownik']] = $row['nazwa'];
        }
        foreach($table0 as $row){
            $l_opinii_var = 0;
            $l_polubien_var = 0;
            $isSpizarnia_var = 'Brak';
            if(isset( $l_polubien[$row['iduzytkownik']] )){
                $l_polubien_var = $l_polubien[$row['iduzytkownik']];
            }
            if(isset( $l_opinii[$row['iduzytkownik']] )){
                $l_opinii_var = $l_opinii[$row['iduzytkownik']];
            }
            if(isset( $isSpizarnia[$row['iduzytkownik']] )){
                $isSpizarnia_var = 'Tak posiada o nazwie: '. $isSpizarnia[$row['iduzytkownik']];
            }
            $id = $row['iduzytkownik'];
            $str = $str . <<<HTML
            <tr>
                <td>{$row['iduzytkownik']}</td>
                <td>{$row['login']}</td>
                <td>{$row['imie']}</td>
                <td>{$row['nazwisko']}</td>
                <td>{$l_opinii_var}</td>
                <td>{$l_polubien_var}</td>
                <td>{$isSpizarnia_var}</td>
                <td><input type="button" value="Usuń użytkownika" onclick = "usunUzytkownika({$id});"></td>
            </tr>
            HTML; 
        }

        echo $str;
        pg_close($db);
        ?>
    
    <div  class="spacer"> . </div>

    <footer>
        &copy; 2021 - Patryk Śledź
    </footer>
</body>
</html>