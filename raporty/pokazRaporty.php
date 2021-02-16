<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raporty</title>
    <link rel="stylesheet" href="../style/raportyStyle.css">
    <?php
        if(!isset($_SESSION['auth']) && $_SESSION['auth'] != 'OK' && !isset($_SESSION['admin']) && $_SESSION['admin'] != 'yes'){
            header("Location: ../log_rej/logowanieAdmin.php");
            exit;
        }
    ?>
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

    <h1 class="content center">Raporty dla tabel</h1>
    <?php
        include("../config_bd/login_bd.php");

        $str = <<<HTML
        <h3 class="center">Tabela użytkownik</h3>
        HTML;
        $wynikUzytkownik = pg_query_params($db, 'select * from proj_v1.uzytkownik;', array())
                or die ('Unable to CALL stored procedure: ' . pg_last_error());
        $tabUzytkownik = pg_fetch_all($wynikUzytkownik);       
        $str = $str . <<<HTML
        <table class="centerTable">
            <tr>
                <th>iduzytkownik</th>
                <th>login</th>
                <th>imie</th>
                <th>nazwisko</th>
                <th>isadmin</th>
            </tr>
        HTML;
        foreach($tabUzytkownik as $res){
            $str = $str . <<<HTML
            <tr>
                <td>{$res['iduzytkownik']}</td>
                <td>{$res['login']}</td>
                <td>{$res['imie']}</td>
                <td>{$res['nazwisko']}</td>
                <td>{$res['isadmin']}</td>
            </tr>
            HTML;
        }
        $str = $str . <<<HTML
        </table>

        <h3 class="center">Tabela ocena</h3>
        <table class="centerTable">
            <tr>
                <th>idocena</th>
                <th>iduzytkownik</th>
                <th>loin</th>
                <th>ocena</th>
                <th>recenzja</th>
                <th>ulubione</th>
                <th>idprzepis</th>
                <th>nazwa</th>
            </tr>
        HTML;
        $wynikOcena = pg_query_params($db, 'select u.iduzytkownik, u.login, o.idocena, o.ocenaval, o.recenzja, o.ulubione, o.idprzepis, p.nazwa
        from proj_v1.uzytkownik u join proj_v1.ocena o on u.iduzytkownik = o.iduzytkownik join proj_v1.przepis p on p.idprzepis = o.idprzepis;', array())
            or die ('Unable to CALL stored procedure: ' . pg_last_error());
        $tabOcena = pg_fetch_all($wynikOcena);

        foreach($tabOcena as $res){
            $str = $str . <<<HTML
            <tr>
                <td>{$res['idocena']}</td>
                <td>{$res['iduzytkownik']}</td>
                <td>{$res['login']}</td>
                <td>{$res['ocenaval']}</td>
                <td>{$res['recenzja']}</td>
                <td>{$res['ulubione']}</td>
                <td>{$res['idprzepis']}</td>
                <td>{$res['nazwa']}</td>
            </tr>
            HTML;
        }
        $str = $str . <<<HTML
        </table>
        <h3 class="center">Tabela spiżarnia</h3>
        <table class="centerTable">
            <tr>
                <th>idspizarnia</th>
                <th>iduzytkownik</th>
                <th>login</th>
                <th>nazwa</th>
            </tr>
        HTML;
        $wynikSpizarnia = pg_query_params($db, 'select u.iduzytkownik, u.login, s.idspizarnia, s.nazwa from proj_v1.uzytkownik u join proj_v1.spizarnia s on u.iduzytkownik = s.iduzytkownik;', array())
            or die ('Unable to CALL stored procedure: ' . pg_last_error());
        $tabSpizarnia = pg_fetch_all($wynikSpizarnia);

        foreach($tabSpizarnia as $res){
            $str = $str . <<<HTML
            <tr>
                <td>{$res['idspizarnia']}</td>
                <td>{$res['iduzytkownik']}</td>
                <td>{$res['login']}</td>
                <td>{$res['nazwa']}</td>
            </tr>
            HTML;
        }

        $str = $str . <<<HTML
        </table>
        <h3 class="center">Tabela skladnikispizarnia</h3>
        <table class="centerTable">
            <tr>
                <th>idskladnik</th>
                <th>Nazwa skladnika</th>
                <th>Ilość</th>
                <th>Jednostka</th>
                <th>Rodzaj</th>
                <th>iduzytkownik</th>
                <th>idspizarnia</th>
            </tr>
        HTML;
        $wynikSkladnikiSpizarnia = pg_query_params($db, 'select * from proj_v1.skladniki_w_spizarni', array())
            or die ('Unable to CALL stored procedure: ' . pg_last_error());
        $tabSkladnikiSpizarnia = pg_fetch_all($wynikSkladnikiSpizarnia);

        foreach($tabSkladnikiSpizarnia as $res){
            $str = $str . <<<HTML
            <tr>
                <td>{$res['idskladnik']}</td>
                <td>{$res['nazwa']}</td>
                <td>{$res['amount']}</td>
                <td>{$res['jednostka']}</td>
                <td>{$res['rodzaj']}</td>
                <td>{$res['iduzytkownik']}</td>
                <td>{$res['idspizarnia']}</td>
            </tr>
            HTML;
        }
        $str = $str . <<<HTML
        </table>
        <h3 class="center">Tabela przepis</h3>
        <table class="centerTable">
            <tr>
                <th>idprzepis</th>
                <th>nazwa</th>
                <th>czas wykonania</th>
                <th>idkategoriadania</th>
                <th>rodzaj</th>
                <th>kategoria</th>
                <th>idwartosci</th>
            </tr>
        HTML;
        $wynikPrzepis = pg_query_params($db, 'select p.idprzepis, p.nazwa, p.czaswykonania, p.idkategoriadania, k.rodzaj, k.kategoria, p.idwartosci
        from proj_v1.przepis p join proj_v1.kategoriadania k on p.idkategoriadania = k.idkategoriadania order by p.idprzepis;', array())
            or die ('Unable to CALL stored procedure: ' . pg_last_error());
        $tabPrzepis = pg_fetch_all($wynikPrzepis);

        foreach($tabPrzepis as $res){
            $str = $str . <<<HTML
            <tr>
                <td>{$res['idprzepis']}</td>
                <td>{$res['nazwa']}</td>
                <td>{$res['czaswykonania']}</td>
                <td>{$res['idkategoriadania']}</td>
                <td>{$res['rodzaj']}</td>
                <td>{$res['kategoria']}</td>
                <td>{$res['idwartosci']}</td>
            </tr>
            HTML;
        }

        $str = $str . <<<HTML
        </table>
        <h3 class = "center">Tabela wartosciodzywcze</h3>
        <table class = "centerTable">
            <tr>
                <th>idwartosci</th>
                <th>kcal</th>
                <th>weglowodany</th>
                <th>bialko</th>
                <th>tluszcze</th>
            </tr>
        HTML;
        $wynikWartosci = pg_query_params($db, 'select *  from proj_v1.wartosciodzywcze w;', array())
            or die ('Unable to CALL stored procedure: ' . pg_last_error());
        $tabWartosci = pg_fetch_all($wynikWartosci);
        foreach($tabWartosci as $res){
            $str = $str . <<<HTML
            <tr>
                <td>{$res['idwartosci']}</td>
                <td>{$res['kcal']}</td>
                <td>{$res['weglowodany']}</td>
                <td>{$res['bialko']}</td>
                <td>{$res['tluszcze']}</td>
            </tr>
            HTML;
        }

        $str = $str . <<<HTML
        </table>
        <h3 class="center">Tabela danie</h3>
        <table class="centerTable">
            <tr>
                <th>iddanie</th>
                <th>idprzepis</th>
                <th>nazwa</th>
                <th>idskladnik</th>
                <th>iloscdodana</th>
                <th>nazwa</th>
            </tr>
        HTML;
        $wynikDanie = pg_query_params($db, 'select d.iddanie, d.idprzepis, p.nazwa as nazwadania, d.idskladnik, d.iloscdodana, s.nazwa from proj_v1.danie d
        join proj_v1.przepis p on d.idprzepis = p.idprzepis
        join proj_v1.skladnik s on d.idskladnik = s.idskladnik order by iddanie;', array())
        or die ('Unable to CALL stored procedure: ' . pg_last_error());
        $tabDanie = pg_fetch_all($wynikDanie);

        foreach($tabDanie as $res){
            $str = $str . <<<HTML
            <tr>
                <td>{$res['iddanie']}</td>
                <td>{$res['idprzepis']}</td>
                <td>{$res['nazwadania']}</td>
                <td>{$res['idskladnik']}</td>
                <td>{$res['iloscdodana']}</td>
                <td>{$res['nazwa']}</td>
            </tr>
            HTML;
        }


        $str = $str . <<<HTML
        </table>
        <h3 class="center">Tabela skladnik</h3>
        <table class="centerTable">
            <tr>
                <th>idskladnik</th>
                <th>nazwa</th>
                <th>idkategoriaskladnik</th>
                <th>rodzaj</th>
                <th>jednostka</th>
                <th>iddostawca</th>
                <th>nazwa</th>
            </tr>
        HTML;
        $wynikSkladnik= pg_query_params($db, 'select s.idskladnik, s.nazwa as nazwaskladnika, s.idkategoriaskladnik, k.rodzaj, k.jednostka, s.iddostawca, d.nazwa
        from proj_v1.skladnik s join proj_v1.kategoriaskladnik k on s.idkategoriaskladnik = k.idkategoriaskladnik
            left join proj_v1.dostawca d on d.iddostawca = s.iddostawca order by s.idskladnik;', array())
            or die ('Unable to CALL stored procedure: ' . pg_last_error());
        $tabSkladnik = pg_fetch_all($wynikSkladnik);

        foreach($tabSkladnik as $res){
            $str = $str . <<<HTML
            <tr>
                <td>{$res['idskladnik']}</td>
                <td>{$res['nazwaskladnika']}</td>
                <td>{$res['idkategoriaskladnik']}</td>
                <td>{$res['rodzaj']}</td>
                <td>{$res['jednostka']}</td>
                <td>{$res['iddostawca']}</td>
                <td>{$res['nazwa']}</td>
            </tr>
            HTML;
        }
        $str = $str . <<<HTML
        </table>
        HTML;
        echo $str;
        pg_close($db);
        ?>
    
    <div  class="spacer"> . </div>

    <footer>
        &copy; 2021 - Patryk Śledź
    </footer>
</body>
</html>