<?php
    session_start();
    $option = $_REQUEST["option"];
    include("../config_bd/login_bd.php");

    $skladniki = $_GET['skladniki'];
    $option = $_GET['option'];

    if(!isset($_GET['skladniki']) || $_GET['skladniki'] == ""){
        $str = $str . <<<HTML
            <h3 class="center">Nie podano żadnego składnika!</h3>
        HTML;
    }else{
        $wynik = pg_query_params($db, 'select * from proj_v1.proponuj($1, $2)', array($skladniki, $option))
            or die ('Unable to CALL stored procedure1: ' . pg_last_error());
        $tab = pg_fetch_all($wynik);

        if(pg_num_rows($wynik) != 0){
            $str = <<<HTML
    
            <table id="proponowaneWybrane" class = "proponowaneTab">
            <thead>
            <tr>
            <th>Nazwa Przepisu</th>
            <th>Zgodność składników [%]</th>
            <th>Opcje</th>
            </tr>
            </thead>
            HTML;
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
        $str = $str . "</table>";
        }
    

        if(pg_num_rows($wynik) == 0){
            $str = $str . <<<HTML
            <h3 class="center">Nie znaleziono żadnych pasujących przepisów :( <br> Spróbuj użyć opcji z dodatkowymi składnikami <br> lub zmniejsz ilość wymaganych składników</h3>
            HTML;
        }
    }

    echo $str;
    pg_close($db);
?>