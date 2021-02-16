<?php
    session_start();
    $option = $_REQUEST["option"];
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
            echo "<p>Nie posiadasz żadnej spiżarni!<p>"; 
        }else{
            $wynik = pg_query_params($db, 'select * from proj_v1.getspizarnia($1, $2)', array($row, $login))
                or die ('Unable to CALL stored procedure: ' . pg_last_error());
            $tab = pg_fetch_all($wynik);
        
            if(pg_num_rows($wynik) < 1){
                echo "<p>Nie posiadasz żadnych składników w spiżarni!<p>"; 
            }else{
               $str = "";
                $k = 0;
                echo "<table id=\"skladnikiSpizarnia\" class = \"proponowaneTab\">";
                echo "<tr><th>Twoje składniki w spiżarni</th></tr>";
                foreach($tab as $skladniki){
                    echo <<<HTML
                    <tr>
                    <td>{$skladniki['nazwaskladnika']}</td>
                    </tr>
                    HTML;
                    $str = $str . $skladniki['nazwaskladnika'];
                    if($k < count($tab)-1)
                        $str = $str . ",";
                    $k++;
                }

                $wynik = pg_query_params($db, 'select * from proj_v1.proponuj($1, $2)', array($str, $option))
                    or die ('Unable to CALL stored procedure1: ' . pg_last_error());
                $tab = pg_fetch_all($wynik);

                $str = <<<HTML
                <table id ="proponowaneSpizarnia" class = "proponowaneTab">
                <thead>
                <tr>
                <th>Nazwa Przepisu</th>
                <th>Zgodność składników [%]</th>
                <th>Opcje</th>
                </tr>
                </thead>
                HTML;
                if(pg_num_rows($wynik) == 0){
                    $str = $str . <<<HTML
                        <tr><td></td><td>Nie znaleziono żadnych pasujących przepisów :(</td><td></td></tr>
                    HTML;
                }else{
                    foreach($tab as $res){
                        $zgodnosc = round($res['zgodnosc'],2);
                        $str = $str . <<<HTML
                        <tr>
                        <td>{$res['nazwa']}</td>
                        <td>{$zgodnosc}</td>
                        <td><button id = "przejdzDoPrzepisu" onclick="przejdzDoPrzepisu({$res['idprzepis']})">Przejdź do przepisu</button> <br></td>
                        </tr>
                        HTML;
                    } 
                }
            $str = $str . "</table>";
            echo $str; 
            } 
        }
        
    pg_close($db);

?>