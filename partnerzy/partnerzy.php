<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partnerskie sklepy</title>
    <link rel="stylesheet" href="../style/przepisyStyle.css">
    <?php
        if(!isset($_SESSION['auth']) && $_SESSION['auth'] != 'OK'){
            header("Location: ../log_rej/logowanie.php");
            exit;
        }
    ?>
</script>
</head>
<body>
    <header>
        <nav class = "topnav">
            <ul>
                <li><a href="../panel_uzytkownika/zalogowanyHome.php">Panel użytkownika</a></li>
                <li><a href="../przepisy/przepisy.php">Szukaj przepisów</a></li>
                <li><a href="../log_rej/wyloguj.php">Wyloguj się</a></li>
                <li><a href="../indexLogged.php" id = "about">About</a></li>

            </ul>
        </nav>
    </header>

    <h1 class = "content center">Partnerskie sklepy</h1>

    <table class = "listaPrzepisow centerTable" style = "margin-top:10%;margin-left: auto;margin-right: auto;">
        <tr>
            <th>Nazwa</th>
            <th>Link do strony dostawcy</th>
            <th>Liczba powiązanych składników</th>
        </tr>
        <?php
            include("../config_bd/login_bd.php");
            $zapytanie = "select count(ds.iddostawca), ds.nazwa, ds.adres_link from proj_v1.dostawcyskladnika ds group by ds.iddostawca, ds.nazwa, ds.adres_link";
            $wynik = pg_query($db,$zapytanie);
            $tab = pg_fetch_all($wynik);
            $str = "";
            foreach($tab as $res){
                $link = $res['adres_link'];
                $str = $str . <<<HTML
                <tr>
                    <td>{$res['nazwa']}</td>
                    <td><a href="{$link}">{$link}</a></td>
                    <td>{$res['count']}</td>
                </tr>
                HTML;
            }
            echo $str;
        ?>
    </table>
    
    <div  class="spacer"> . </div>

<footer>
    &copy; 2021 - Patryk Śledź
</footer>
    
</body>
</html>