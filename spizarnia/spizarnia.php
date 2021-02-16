<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Twoja spiżarnia</title>
    <link rel="stylesheet" href="../style/spizarniaStyle.css">
    <script src="./filtrowanieSkladnikow.js"></script>

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

    <h1 class="content center">Twoja spiżarnia</h1>

    <?php
        include("../config_bd/login_bd.php");
        $login = $_SESSION['user'];

        //check if user has spizarnia
        $zapytanie = "select s.nazwa from proj_v1.uzytkownik u join proj_v1.spizarnia s on u.iduzytkownik = s.iduzytkownik where u.login = '$login';";
        $result = pg_query($db,$zapytanie);
        $table = pg_fetch_all($result);
        $row;
        foreach($table as $count){
            $row = $count['nazwa'];
        }
        if($row == null){
            echo "<h3 class = \"center\">Nie posiadasz żadnej spiżarni! <br> 
                    Możesz stworzyć ją wypełniając poniższy formularz. Podaj wymagane dane i zatwierdź.
                </h3>"; 
            $str = <<<'EOD'
                <form class="center" action="./stworzSpizarnie.php" method = "POST">
                Nazwa: <input type="text" name="nazwa" maxlength="32" minlength="1"> <br> <br>
                <input type="submit" value="Stwórz">
                </form>
            EOD;
            echo $str;
        }else{
            echo "<h3 class = \"center\">Znaleziono spiżarnie o nazwie <span style=\"color:red\">$row</span></h3>";
            $wynik = pg_query_params($db, 'select * from proj_v1.getspizarnia($1, $2)', array($row, $login))
                or die ('Unable to CALL stored procedure: ' . pg_last_error());
            $tab = pg_fetch_all($wynik);
        }
        pg_close($db);
    ?>
    <div id="textTrue" class="center"></div>

    <div class="container">
    <p>Jeżeli chcesz <strong>usunąć</strong> spiżarnię wpisz poniżej jej nazwę i potwierdź. <br> Pamiętaj, że danych nie będzie można odzyskać!</p>
        <form action="./usunSpizarnie.php" method = "POST">
            Nazwa: <input type="text" name="nazwa" maxlength="32" minlength="1"> 
            <input type="submit" value="Usun">
        </form>
        <?php
            $str = <<<HTML
               <div id = "zawartoscSpizarni" style="margin-top:1em;">
                <h2>Zawartość twojej spiżarni</h2>
                <table class="skladnikiTable centerTable">
                    <thead>
                    <tr>
                        <th>Nazwa</th>
                        <th>Ilość</th>
                        <th>Jednostka</th>
                        <th>Rodzaj</th>
                        <th>Ile chcesz usunąć?</th>
                    </tr>  
                    </thead>
                    
            HTML;
            if(pg_num_rows($wynik) == 0){
                echo <<<HTML
                <div id = "zawartoscSpizarni" >
                    <h3 class="center">Spiżarnia jest pusta. Dodaj jakieś składniki.</h3>
                </div>
                HTML;
            }
            $k=0;
                $str = $str . "<tbody>";
            foreach($tab as $skladniki){
                $str = $str . <<<HTML
                    <tr>
                        <td>{$skladniki['nazwaskladnika']}</td>
                        <td>{$skladniki['ilosc']}</td>
                        <td>{$skladniki['jednostka']}</td>
                        <td>{$skladniki['rodzaj']}</td>
                        <td><input id = "deleteSkladnik{$k}" type="number" value = "0" min = "0" max = {$skladniki['ilosc']} step = "0.01"> <br>
                        <button name="usunSkladniki" onclick="usunSkladnikiButton({$k}, {$skladniki['idskladnik']});">Usuń składnik</button></td>
                    </tr>
                HTML;
                $k++;
            }

            if(pg_num_rows($wynik) != 0){
                $str = $str . "</tbody></table></div>";
                echo $str;
            }
        ?>
        
        <div id="partnerskieSklepyDiv" style="display:none;"></div>
        
        <div id= "skladniki" >

        <h2>Dodaj składniki</h2>
        <p>Chcesz uzupełnić spiżarnię? Wybierz rodzaj składnika!</p>
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

        <div id="myDiv" style="margin-top:1em; margin-left:2em;"></div>
        </div>
        
    </div>
    
    <div  class="spacer"> . </div>

    <footer>
        &copy; 2021 - Patryk Śledź
    </footer>
</body>
</html>