<?php
    session_start();
    $login = $_SESSION['user'];
    $sortowanie = $_GET['sortowanie'];
    include("../config_bd/login_bd.php");

    $wynik = pg_query_params($db, 'select * from proj_v1.getrecenzja($1, $2)', array($login, $sortowanie))
        or die ('Unable to CALL stored procedure1: ' . pg_last_error());
    $tab = pg_fetch_all($wynik);

    $str = "";
    if(pg_num_rows($wynik) < 1){
        $str =<<< HTML
        <h3 style = "margin-left: 25%;margin-top: -8%;">Nie napisałeś jeszcze żadnej recenzji. Możesz je dodawać przeglądając przepisy.</h3>
        HTML;
    }else{
        $str =<<<HTML
        <table class="przepisy">
            <tr>
                <th>Nazwa przepisu</th>
                <th>Twoja ocena (0-5)</th>
                <th>Twoja recenzja</th>
                <th>Data aktualizacji</th>
                <th colspan="3">Opcje</th>
            </tr>
        
        HTML;

        foreach($tab as $res){
        $ocena = $res['ocena'] == null ? 'Nie podano' : $res['ocena'];
        $recenzja = $res['recenzja'] == "" ? "Nie napisano" : $res['recenzja'];
        $id = $res['idprzepis'];
        $tmp = <<<HTML
            <tr>
                <td>{$res['nazwa']}</td>
                <td>{$ocena}</td>
                <td>{$recenzja}</td>
                <td>{$res['data']}</td>
                <td><button id = "przejdzDoPrzepisu" onclick="przejdzDoPrzepisu({$id})">Przejdź do przepisu</button> <br></td>
                <td><button id = "modyfikuj" onclick="modyfikujRecenzje({$id})">Modyfikuj</button> <br></td>
                <td><button id = "usun" onclick="usunRecenzje({$id})">Usuń</button> <br></td>
            </tr>
        HTML;

        $str = $str . $tmp;
        }

        $str = $str . '</table>';
    }

    echo $str;
    pg_close($db);

?>