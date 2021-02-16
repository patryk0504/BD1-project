<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/proponujStyle.css">
    <script src="./filtrowanieProponuj.js"></script>

    <?php
    if(!isset($_SESSION['auth']) && $_SESSION['auth'] != 'OK'){
        header("Location: ../log_rej/logowanie.php");
        exit;
    }
    ?>

    <title>Proponowanie przepisów</title>
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
    <h2 class="content center">Proponowanie przepisów</h2>
    <p class="center">Strona pomoże Ci wyszukać przepis po podaniu dowolnej ilości składników.</p>

    <div class="container">
        <!-- proponuj ze spizarni button -->
    <div class="proponujSpizarniaDiv">
    <h3>Proponuj ze składników w spiżarni</h3>
    <select name="stopienFiltrowania" id="stopienFiltrowaniaSpizarnia">
        <option value="max">dopasowanie 100%</option>
        <option value="greater">składniki spiżarnia + dodatkowe spoza</option>
        <option value="less">składniki spiżarnia (nie wszystkie użyte + dodatkowe spoza)</option>
    </select>
    <button id = "proponujSpizarnia" onclick="proponujSpizarnia()">Proponuj ze składników w spiżarni</button>
    </div>
    <!-- proponuj z wybranych skladnikow button -->
    <div class="proponujWybraneDiv proponujSpizarniaDiv">
        <h3>Proponuj z dowolnych składników</h3>
        <button onclick="pokazWyborSkladnikow()">Przejdź do wyboru składników</button>

        <!-- pokaz skladniki button-->
        <div id="wyborSkladnikow" class="pokazSkladnikiDiv" style = "display:none;">
        <select name="rodzajSkladnika" id="rodzajSkladnika">
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
        <button id = "pokazSkladniki" name = "pokazSkladniki" onclick = "showButtonClick();">Pokaż składniki</button>
        </div>
    </div>
    </div>
    
    <div class="container">

        <!-- wyswietlenie skladnikow -->
        <div id="myDiv" class="center" style="display:none;"></div>

        <!-- proponowanie powybranych skladnikach + miejsce na wybrane skladniki -->
        <div id ="wybraneDiv" class="center" style = "display:none;">
        <h4>Podaj stopień filtracji przepisów</h4>
        <select name="stopienFiltrowania" id="stopienFiltrowania">
        <option value="max">dopasowanie 100%</option>
        <option value="greater">wybrane składniki + dodatkowe spoza wybranych</option>
        <option value="less">wybrane składniki (nie wszystkie użyte + dodatkowe spoza wybranych)</option>

        </select>
        <button id = "proponujButton" onclick = "proponujButton()">Proponuj</button>
        <h4>Poniżej pojawią się wybrane składniki</h4>
        <p style="color:red;">Domyślne składniki dają 100% dopasowania</p>
        <p>Chcesz wyczyścić listę? Naciśnij przycisk -> </p> <button onclick="wyczyscSkladniki();">Wyczyść</button>
        <table id="wybraneTable" class="proponowaneTab">
            <tbody>
            <tr><td>ciecierzyca</td></tr>
            <tr><td>burak</td></tr>
            <tr><td>chrzan</td></tr>
            <tr><td>czosnek</td></tr>
            <tr><td>tahini</td></tr>
            <tr><td>kmin rzymski</td></tr>
            </tbody>
        </table>
        </div>

    
    <!-- wynik proponowania -->
    <div id = "proponowaneDiv" class="container"></div>
    </div>
    <div  class="spacer"> . </div>

    <footer>
        &copy; 2021 - Patryk Śledź
    </footer>
    

</body>
</html>