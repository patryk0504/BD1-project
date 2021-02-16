<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strona domowa</title>
    <link rel="stylesheet" href="../style/zalogowanyStyle.css">
    <?php
    
        if(isset($_SESSION['auth']) && $_SESSION['auth'] == 'OK' && isset($_SESSION['admin']) && $_SESSION['admin'] == 'yes'){
            header("Location: ./zalogowanyAdminHome.php");
            exit;
        }
        if(!isset($_SESSION['auth']) && $_SESSION['auth'] != 'OK'){
            header("Location: ../log_rej/logowanie.php");
            exit;
        }
    ?>
    <script>
    function mouseOver(id){
        document.getElementById(id).style.display = "";
    }
    function mouseOut(id){
        document.getElementById(id).style.display = "none";
    }
</script>
</head>
<body>
    <header>
        <nav class = "topnav">
            <ul>
                <li><a href="./zalogowanyHome.php">Panel użytkownika</a></li>
                <li><a href="../przepisy/przepisy.php">Szukaj przepisów</a></li>
                <li><a href="../log_rej/wyloguj.php">Wyloguj się</a></li>
                <li><a href="../indexLogged.php" id = "about">About</a></li>

            </ul>
        </nav>
    </header>

    <div class="bg">

    <h1 class = "content center" style = "font-size:40px;">Panel użytkownika</h1>

    <div class="container">
        <div id="info1" class="info" style="display:none;">
            <p class = "sign" style = "font-size: 18px;">Twoja spiżarnia jest miejscem gdzie możesz zapisywać składniki spożywcze, które znajdują się aktualnie w Twojej kuchni. <br>
                Możesz nimi zarządzać: dodawać, usuwać, modyfikować ilość.
            <p>
        </div>
        <div id="info2" class="info" style="display:none;">
            <p class = "sign" style = "font-size: 18px;">Dodając znaleziony przepis do ulubionych możesz znaleźć go w każdej chwili w tej zakładce.</p>
        </div>
        <div id="info3" class="info" style="display:none;">
            <p class = "sign" style = "font-size: 18px;">W tym miejscu znajdziesz napisane przez Ciebie rezenzje. <br>
                Możesz nimi zarządzać: modyfikować, usuwać.
            </p>
        </div>
        <div id="info4" class="info" style="display:none;">
            <p class = "sign" style = "font-size: 18px;">Przeglądanie przepisów. Pamiętaj, że każdy przepis możesz oceniać i dodawać do ulubionych.</p>
        </div>
        <div id="info5" class="info" style="display:none;">
            <p class = "sign" style = "font-size: 18px;">Jeśli brakuje Ci pomysłów co zrobić ze zbędnymi składnikami w kuchni sprawdź tą opcję! <br>
                Możesz wprowadzić składniki, które Cię interesują, a program pokaże Ci najlepiej dopasowane przepisy. <br>
                Istnieje również możliwość proponowania ze składników, które aktualnie posiadasz w spiżarni.
            </p>
        </div>
        <div id="info6" class="info" style="display:none;">
            <p class = "sign" style = "font-size: 18px;">Sklepy w których możesz zakupić wybrane składniki.</p>
        </div>
    

        <div class="main" style = "height:350px;">
        <p class="sign" align="center">Wybierz opcję</p>

        <a id="link1" href="../spizarnia/spizarnia.php" onmouseover="mouseOver('info1');" onmouseout="mouseOut('info1');">Twoja spiżarnia</a>
        <a href="../ulubione/ulubione.php" onmouseover="mouseOver('info2');" onmouseout="mouseOut('info2');">Ulubione przepisy</a>
        <a href="../recenzje/recenzje.php" onmouseover="mouseOver('info3');" onmouseout="mouseOut('info3');">Twoje recenzje</a>
        <a href="../przepisy/przepisy.php" onmouseover="mouseOver('info4');" onmouseout="mouseOut('info4');">Przeglądaj przepisy</a>
        <a href="../proponuj_przepisy/proponuj.php" onmouseover="mouseOver('info5');" onmouseout="mouseOut('info5');">Proponuj przepis ze składników</a>
        <a href="../partnerzy/partnerzy.php" onmouseover="mouseOver('info8');" onmouseout="mouseOut('info6');">Partnerskie sklepy</a>
        </div>

    </div>

    </div>
    
    <div  class="spacer"> . </div>

<footer>
    &copy; 2021 - Patryk Śledź
</footer>
    
</body>
</html>