<?php
session_start();
$login = $_SESSION['user'];
include("../config_bd/login_bd.php");

    $rodzaj = $_GET["rodzaj"];
    $kategoria = $_GET["kategoria"];
    $sortowanie = $_GET["sortowanie"];

    $wynik = pg_query_params($db, 'select * from proj_v1.getprzepis($1, $2, $3)', array($sortowanie, $rodzaj, $kategoria))
                or die ('Unable to CALL stored procedure: ' . pg_last_error());
    $tab = pg_fetch_all($wynik);
    

    $str = <<<HTML
        <table class = "listaPrzepisow centerTable">
        <tr>
            <th>Nazwa</th>
            <th>Kaloryczność [kcal]</th>
            <th>Czas wykonania</th>
            <th>Rodzaj</th>
            <th>Kategoria</th>
            <th>Opcje</th>
        </tr>
        HTML;

            $opisArray = array();
            $idPrzepis = array();
            foreach ($tab as $przepis){
                
                $id =  $przepis['id'];
                $str = $str . <<< HTML
                <tr>
                <td>{$przepis['nazwa']}</td>
                <td>{$przepis['kcal']}</td>
                <td>{$przepis['czaswykonania']}</td>
                <td>{$przepis['rodzaj']}</td>
                <td>{$przepis['kategoria']}</td>
                <td>
                    
                    <button id = "przejdzDoPrzepisu" onclick="przejdzDoPrzepisu({$id});">Przejdź do przepisu</button> <br>
                    <button id = "dodajDoUlubionych" name = "dodajDoUlubionych" onclick="zapiszDoUlubionych({$id});" >Dodaj do ulubionych</button> <br>
                    <button id = "napiszRecenzje" onclick="napiszRecenzje({$id});" >Dodaj recenzje</button> <br>

                </td>
                </tr>
                HTML;
        
            }
    
            $str = $str . "</table>";

    pg_close($db);
    echo $str;

?>