<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wyświetl przepis</title>
    <link rel="stylesheet" href="../style/jedenPrzepisStyle.css">
    <script src="./jedenPrzepisFunctions.js"></script>

    <?php
        if(!isset($_SESSION['auth']) && $_SESSION['auth'] != 'OK'){
            header("Location: ../log_rej/logowanie.php");
            exit;
        }
    ?>
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

    <?php
        include("../config_bd/login_bd.php");

        $wynik = pg_query_params($db, 'select * from proj_v1.przepis_szczegoly ps where ps.idprzepis = $1', array($_GET['id']))
            or die ('Unable to CALL stored procedure: ' . pg_last_error());
        $tab = pg_fetch_all($wynik);

        $idprzepis;
        $nazwa;
        $czaswykonania;
        $opis;
        $kcal;
        $rodzaj;
        $kategoria;
        $img_link;

        foreach($tab as $res){
            $idprzepis = $res['idprzepis'];
            $nazwa = $res['nazwa'];
            $czaswykonania = $res['czaswykonania'];
            $opis = $res['opis'];
            $kcal = $res['kcal'];
            $rodzaj = $res['rodzaj'];
            $kategoria = $res['kategoria'];
            $img_link = $res['image_link'];
        }

        // skladniki
        $skladnikiNazwaArray = array();
        $skladnikiIloscArray = array();
        $skladnikiJednostkaArray = array();
        $skladnikiRodzajArray = array();
        // wartosci odzywczne
        $wartosciKcal;
        $wartosciWegl;
        $wartosciBialko;
        $wartosciTluszcze;
        // zapytanie o skladniki do BD
        $wynik2 = pg_query_params($db, 'select * from proj_v1.getskladniki($1)', array($_GET['id']))
            or die ('Unable to CALL stored procedure: ' . pg_last_error());
        $tab2 = pg_fetch_all($wynik2);
        foreach ($tab2 as $skladniki){
            array_push($skladnikiNazwaArray,$skladniki['nazwa']);
            array_push($skladnikiIloscArray,$skladniki['iloscdodana']);
            array_push($skladnikiJednostkaArray,$skladniki['jednostka']);
            array_push($skladnikiRodzajArray,$skladniki['rodzaj']);
        }

        //zapytanie o wartosci odzywcze do BD
        $wynik3 = pg_query_params($db, 'select * from proj_v1.getwartosci($1)', array($_GET['id']))
            or die ('Unable to CALL stored procedure: ' . pg_last_error());
        $tab3 = pg_fetch_all($wynik3);
        foreach ($tab3 as $wartosci){
            $wartosciKcal=$wartosci['kcal'];
            $wartosciWegl=$wartosci['weglowodany'];
            $wartosciBialko=$wartosci['bialko'];
            $wartosciTluszcze=$wartosci['tluszcze'];
        }

        pg_close($db);
    ?>

    <style>
        #imgDiv { background-image: url(<?php echo $img_link;?>); }
    </style>    
    <div id="imgDiv" class="img">
    <div class = "title">
    <h1 class="center content"><?php echo $nazwa ?></h1>

    <table class = "jedenPrzepis centerTable">
        <tr>
            <th>Kaloryczność [kcal]</th>
            <th>Czas wykonania</th>
            <th>Rodzaj</th>
            <th>Kategoria</th>
        </tr>
        <tr>
            <?php
                echo <<<HTML
                    <td>$kcal</td>
                    <td>$czaswykonania</td>
                    <td>$rodzaj</td>
                    <td>$kategoria</td>
                HTML;
            ?>
        </tr>
    </table></div>
    

    </div>
    
    <div class="container">

    <table class = "skladniki">
        <thead>
        <tr><th colspan = "4">Składniki</th></tr>
        </thead>
        <tbody>
        <?php
        for($i = 0; $i<count($skladnikiNazwaArray); $i++){
            echo <<<HTML
            <tr>
                <td>{$skladnikiNazwaArray[$i]}</td>
                <td>{$skladnikiIloscArray[$i]}</td>
                <td>{$skladnikiJednostkaArray[$i]}</td>
                <td>{$skladnikiRodzajArray[$i]}</td>
            </tr>
            HTML;
        }
        ?>
        </tbody>
    </table>

    <div class="opis"><h4>Opis</h4><?php echo $opis ?></div>
    
    <table id="wartosci">
        <thead>
        <tr>
            <th>Kaloryczność [kcal/100g]</th>
            <th>Węglowodany [g/100g]</th>
            <th>Białko [g/100g]</th>
            <th>Tłuszcze [g/100g]</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <?php
            echo <<<HTML
            <td>{$wartosciKcal}</td>
            <td>{$wartosciWegl}</td>
            <td>{$wartosciBialko}</td>
            <td>{$wartosciTluszcze}</td>
            HTML;
            ?>
        </tr>
        </tbody>
    </table>

    </div>

    <div class="center" style = "margin-bottom: 2em;">
    <h3 class = "center">Chcesz sprawdzić czy masz odpowiednią ilość składników w spiżarni do wykonania tego przepisu?</h3>
    <button id = "sprawdzskladniki" onclick="sprawdzSkladnikiSpizarnia(<?php echo $idprzepis ?>);" >Czy mam odpowiednią ilość składników?</button>
    </div>
    
    <div id = "sprawdzSkladnikiDiv"></div>


    <div  class="spacer"> . </div>

<footer>
    &copy; 2021 - Patryk Śledź
</footer>
</body>
</html>