<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Twoja spiżarnia</title>
    <link rel="stylesheet" href="../style/zarzadzajUzytkownikamiStyle.css">
    <script src="./zarzadzanieFunctions.js"></script>
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

    <h1 class="content center">Sklepy powiązane ze składnikami</h1>
    
    <div class="container">
        <div id= "skladniki">
            <h2>Składniki w bazie danych</h2>
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
            <div id="myDiv" style="margin-top:1em;"></div>
        </div>
    </div>
    <div id="nowyPartnerDiv" style = "width:400px;margin-left:60%;margin-top:2em;">
        <h2>Chcesz dodać nowego partnera?</h2>
        <form>
            <input type="text" id="nazwaPartnera" placeholder="Podaj nazwe">
            <input type="text" id="adresPartnera" placeholder="Podaj adres www">
            <input type="button" value="Zatwierdź" onclick = "dodajPartnera();">
        </form>
    </div>
    <div id="partnerzyDiv" style = "width:400px;margin-left:60%;margin-top:2em;"></div>

    <div  class="spacer"> . </div>
    <footer>
        &copy; 2021 - Patryk Śledź
    </footer>
</body>
</html>