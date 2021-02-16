<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/nowyPrzepisStyle.css">
    <script src="./nowyPrzepisFunctions.js"></script>
    <?php
        if(!isset($_SESSION['auth']) && $_SESSION['auth'] != 'OK' && !isset($_SESSION['admin']) && $_SESSION['admin'] != 'yes'){
            header("Location: ../log_rej/logowanieAdmin.php");
            exit;
        }
    ?>
    <title>Dodaj nowy przepis</title>
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
    <h1 class = "content center">Dodawanie nowego przepisu</h1>
    <h4 class = "center">Jeżeli nie znalazłeś przepisu odpowiadającego Twoim potrzebom, na poniższej stronie możesz dodać swój własny, spersonalizowany przepis. <br>
        Będzie on widoczny dla innych użytkowników serwisu.
    </h4>

    <div id="form1" class = "main">
    <h3 class = "center">Wybierz kategorię dania</h3>
    <form class = "center">
        <select name="kategoria" id="kategoriaSelect" required>
            <option value="vege">Vege</option>
            <option value="bezglutenowe">Bezglutenowe</option>
            <option value="normal">Normalne</option>
        </select>
        <h3>Wybierz rodzaj dania</h3>
        <select name="rodzaj" id="rodzajSelect">
            <option value="sniadanie">Śniadanie</option>
            <option value="obiad">Obiad</option>
            <option value="kolacja">Kolacja</option>
            <option value="przekaska">Przekąska</option>
        </select>
        <h3>Podaj wartości odżywcze przepisu</h3>
        <span>Jeżeli ich znasz wartości, zostaw domyślnie 0</span>
        <table class = "centerTable">
            <tr><td>Kalorie [kcal/100g]</td><td><input type="number" name = "kcal" id = "kcalInput" value = "0" min = "0" step = "1"></td></tr>
            <tr><td>Węglowodany [g/100g]</td><td><input type="number" name = "weglowodany" id = "weglInput" value = "0" min = "0" step = "1"></td></tr>
            <tr><td>Białko [g/100g]</td><td><input type="number" id = "bialkoInput" name = "bialko" value = "0" min = "0" step = "1"></td></tr>
            <tr><td>Tłuszcze [g/100g]</td><td><input type="number" id = "tluszczeInput" name = "tluszcze" value = "0" min = "0" step = "1"></td></tr>
        </table>

        <h3>Podaj nazwę przepisu*</h3>
        <input type="text" name = "nazwa" id = "nazwaInput" placeholder="Podaj nazwę" value = "" required>
        
        <h3>Podaj przybliżony czas wykonania*</h3>
        <input type="time" id = "czasInput" name="czas" step = "2" min = "00:00:00" required>
        <h3>Możesz dodać link do Twojego zdjęcia, które będzie wyświetlane na stronie</h3>
        <input type="text" id = "linkInput" placeholder="e.g. www.yourCloud.pl/image">
        <h3>Podaj opis wykonania przepisu</h3>
        <textarea id="opisInput" name = "opis" cols="80" rows="10"></textarea> <br> <br>
        <input type="button" onclick="pokazSkladniki();" value = "Przejdź do wyboru składników">

    </form>  
    </div>
    
    <div id="form2" style="display:none;">
        <form class="center">
        <h2>Dodaj składniki</h2>
        <h4>Wybierz kategorię składnika</h4>
        <select name="rodzajSkladnika" id="rodzajSkladnika" onchange="showButtonClick();">
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
        </select> <br> <br>
        <input type="button" onclick="pokazForm1();" value = "Wróć do poprzedniego formularza"> <br>
        <input type="button" onclick="zatwierdzSkladniki();" value="Zatwierdź składniki i zapisz przepis">

        </form>
    
        <div class="container">

        <div id="skladnikiDiv"></div>
        <div id="wybraneDiv">
        <h4>Poniżej pojawią się wybrane składniki</h4>
        <p>Chcesz wyczyścić listę? Naciśnij przycisk -> </p> <button onclick="wyczyscSkladniki();">Wyczyść</button>
        <table id="wybraneTable" class="proponowaneTab">
            <tbody>
            
            </tbody>
        </table>
        </div>
        </div>
        </div>

    <div  class="spacer"> . </div>

<footer>
    &copy; 2021 - Patryk Śledź
</footer>

</body>
</html>