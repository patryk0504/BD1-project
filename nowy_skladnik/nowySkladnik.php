<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/nowyPrzepisStyle.css">
    <script src="./nowySkladnikFunctions.js"></script>
    <?php
        if(!isset($_SESSION['auth']) && $_SESSION['auth'] != 'OK' && !isset($_SESSION['admin']) && $_SESSION['admin'] != 'yes'){
            header("Location: ../log_rej/logowanieAdmin.php");
            exit;
        }
    ?>
    <title>Dodaj nowy składnik</title>
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
    <h1 class = "content center">Dodawanie nowego składnika</h1>
    <h4 class = "center">Jeżeli brakuje Ci któregoś z ulubionych składników dodaj go tutaj. <br> Składnik zobaczą również pozostali użytkownicy.</h4>
    
    <div id="form1" class="main" style = "height:350px; width:400px;">
        <h3 class="center">Wybierz kategorię składnika</h3>
        <form class="center">
        <select name="kategoria" id="kategoriaSelect" onchange="getJednostka();" required>
            <option value="warzywa">Warzywa</option>
            <option value="nabial">Nabiał</option>
            <option value="mieso">Mięso</option>
            <option value="ryby">Ryby</option>
            <option value="owoce">Owoce</option>
            <option value="rosliny">Rośliny</option>
            <option value="przyprawy">Przyprawy</option>
            <option value="zboze">Produkty zbożowe</option>
            <option value="orzechy">Orzechy</option>
            <option value="nasiona">Nasiona</option>
            <option value="olej">Olej</option>
            <option value="pieczywo">Pieczywo</option>
        </select>

        <div id="jednostkaDiv"></div>

        <h3 class="center">Podaj nazwę składnika</h3>
        <input type="text" id = "nazwaInput" placeholder="Podaj nazwę" value = "" required> <br>

        <h3 class="center">[Opcjonalnie] Wybierz dostawcę składnika</h3>
        <?php
        include("../config_bd/login_bd.php");
        $zapytanie = "select d.nazwa from proj_v1.dostawca d";
        $wynik = pg_query($db,$zapytanie);
        $tab = pg_fetch_all($wynik);
        $str = <<<HTML
            <select name="dostawca" id="dostawcaSelect">
            <option value="">Nie wybieram</option>
        HTML;
        foreach($tab as $res){
            $nazwa = $res['nazwa'];
            $str = $str . <<<HTML
            <option value="{$nazwa}">$nazwa</option>
            HTML;
        }
        $str = $str . <<<HTML
            </select>
        HTML;
        echo $str;
        pg_close($db);
        ?>
        <br>
        <br>

        <input type="button" onclick="zapiszSkladnik();" value = "Zapisz składnik">

        </form>

        <div id="resultDiv"></div>
    </div>

    <div id="container" class="main" style = "height: 550px;">
        <h3 class="center">Chcesz wyświetlić wszystkie składniki? Wybierz kategorię.</h3>
        <select name="rodzajSkladnika" id="rodzajSkladnika" onchange = "showButtonClick();">
        <option value="warzywa">warzywa</option>
        <option value="owoce">owoce</option>
        <option value="mieso">mięso</option>
        <option value="ryby">ryby</option>
        <option value="nabial">nabiał</option>
        <option value="orzechy">orzechy</option>
        <option value="nasiona">nasiona</option>
        <option value="olej">olej</option>
        <option value="przyprawy">przyprawy</option>
        <option value="rosliny">rośliny</option>
        <option value="zboze">zboże</option>
        <option value="pieczywo">pieczywo</option>
        </select>
       <div id="wszystkieSkladniki"></div> 
       <div id="partnerskieSklepyDiv" style="display:none;"></div>

    </div>
    
    

    <div  class="spacer"> . </div>
<footer>
    &copy; 2021 - Patryk Śledź
</footer>
</body>
</html>