<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Przeglądaj przepisy</title>
    <script src="./formFunctions.js"></script>
    <script src="./przepisyAjax.js"></script>

    <link rel="stylesheet" href="../style/przepisyStyle.css">

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
                <li><a href="../log_rej/wyloguj.php">Wyloguj się</a></li>
                <li><a href="../indexLogged.php" id = "about">About</a></li>

            </ul>
        </nav>
    </header>

    <h1 class = "content center">Wyszukiwarka przepisów</h1>

    <div class="filtrowanie">
    <form>
    <table align="center">
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
                <input type="button" onclick="pokazPrzepisy();" name = "filtruj" value = "Filtruj">
            </td>
        </tr>
    </table>
    </form>
    </div>

    <div id="ulubioneInfo" class="centerTable filtrowanie"></div>



    <div id="myDiv"></div>
    <div  class="spacer"> . </div>

    <footer>&copy; 2021 - Patryk Śledź</footer>

</body>
</html>