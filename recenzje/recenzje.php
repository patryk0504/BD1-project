<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Twoje recenzje</title>
    <link rel="stylesheet" href="../style/recenzjeStyle.css">
    <script src="./filtrowanieRecenzje.js"></script>


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

    <h1 class="center content">Twoje recenzje</h1>

    <div class="filtrowanie">
    <form>
    <table align="center">
        <tr>
            <th colspan="2">Sortowanie</th>
        </tr>
        <tr>
            <td>Sortowanie:</td>
            <td>
                <select name="sortowanie" id="sortowanie">
                    <option value="ocena_asc">ocena - od najniższej</option>
                    <option value="ocena_dsc">ocena - od największej</option>
                    <option value="data_dsc">data dodania - od najnowszych</option>
                    <option value="data_asc">data dodania - od najstarszych</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="button" onclick="filtrujRecenzje();" name = "filtruj" value = "Filtruj">
            </td>
        </tr>
    </table>
    </form>
    </div>
    

    <div id = "myDiv"></div>
    <div id = "recenzjaForm" style = "display:none;"></div>

    <div  class="spacer"> . </div>

    <footer>
    &copy; 2021 - Patryk Śledź
    </footer>
    </body>
</html>