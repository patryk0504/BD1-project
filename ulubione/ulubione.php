<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Twoje ulubione przepisy</title>
    <link rel="stylesheet" href="../style/ulubioneStyle.css">
    <script src="./filtrowanieUlubione.js"></script>


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

    <h1 class="center content">Twoje ulubione przepisy</h1>

    <div class="container">
        <div class = "filtrowanie">
        <form>
        <table>
        <tr>
            <th colspan="2">Filtrowanie</th>
        </tr>
        <tr>
            <td>Rodzaj dania:</td>
            <td>
                <select name="rodzaj" id="rodzaj">
                    <option value="sniadanie">Śniadanie</option>
                    <option value="obiad">Obiad</option>
                    <option value="kolacja">Kolacja</option>
                    <option value="przekaska">Przekąska</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Kategoria dania:</td>
            <td>
                <select name="kategoria" id="kategoria">
                    <option value="bezglutenowe">Bezglutenowe</option>
                    <option value="vege">Vege</option>
                    <option value="normal">Normal</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Sortowanie:</td>
            <td>
                <select name="sortowanie" id="sortowanie">
                    <option value="kalorie_asc">kalorie - od najmniejszych</option>
                    <option value="kalorie_dsc">kalorie - od największych</option>
                    <option value="czas_asc">czas przygotowanie - od najmniejszych</option>
                    <option value="czas_dsc">czas przygotowanie - od największych</option>
                    <option value="alfabetycznie">nazwa - alfabetycznie</option>

                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="button" onclick="filtrujPrzepisy();" name = "filtruj" value = "Filtruj">
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="button" onclick="pokazWszystkie();" name = "wszystkie" value = "Pokaż wszystkie">
            </td>
        </tr>
        </table>
        </form>
        </div>

        <div class = "przepisy">
            <div id = "myDiv"></div>
        </div>
    </div>



    <footer>
    &copy; 2021 - Patryk Śledź
    </footer>
</body>
</html>