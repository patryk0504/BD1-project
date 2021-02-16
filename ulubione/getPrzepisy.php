<?php
session_start();
$login = $_SESSION['user'];
include("../config_bd/login_bd.php");

$tab;

if($_GET["rodzaj"]=="all" and $_GET["kategoria"] == "all" and $_GET["sortowanie"] == "all"){
    
    $wynik = pg_query_params($db, 'select * from proj_v1.ulubione_przepisy up where up.login = $1 and up.ulubione=true', array($login))
        or die ('Unable to CALL stored procedure1: ' . pg_last_error());
    $tab = pg_fetch_all($wynik);

}else{
    $rodzaj = $_GET["rodzaj"];
    $kategoria = $_GET["kategoria"];
    $sortowanie = $_GET["sortowanie"];

    $wynik = pg_query_params($db, 'select * from proj_v1.getprzepisulubione($1, $2, $3, $4)', array($sortowanie, $rodzaj, $kategoria, $login))
        or die ('Unable to CALL stored procedure: ' . pg_last_error());
    $tab = pg_fetch_all($wynik);
}


    $str = "";
    if(pg_num_rows($wynik) < 1){
        $str = <<<HTML
            <h3 class="center">Nie posiadasz żadnego przepisu w ulubionych. Możesz je dodawać gdy przeglądasz przepisy.</h3>
        HTML;
    }else{
        $str = <<<HTML
        <table class = "listaPrzepisow" style="margin-left:5em;">
        <tr>
            <th>Nazwa</th>
            <th>Kaloryczność [kcal]</th>
            <th>Czas wykonania</th>
            <th>Rodzaj</th>
            <th>Kategoria</th>
            <th>Opcje</th>
        </tr>
        HTML;

            $idPrzepis = array();
            $ocena = array();
            $recenzja = array();
            $k = 0;
            foreach ($tab as $przepis){
                $id =  $przepis['id'];

                $str = $str . <<<HTML
                <tr>
                    <td>{$przepis['nazwa']}</td>
                    <td>{$przepis['kcal']}</td>
                    <td>{$przepis['czaswykonania']}</td>
                    <td>{$przepis['rodzaj']}</td>
                    <td>{$przepis['kategoria']}</td>
                    <td>
                        <button id = "przejdzDoPrzepisu" onclick="przejdzDoPrzepisu({$id});">Przejdź do przepisu</button> <br>
                        <button id = "pokazTwojaOpinie" onclick="pokazTwojaOpinia({$k})" >Pokaż Twoją opinię</button> <br>
                        <button id = "usunZUlubionych" onclick="usunZUlubionych({$id})" >Usuń z ulubionych</button> <br>
                    </td>
                </tr>    
                HTML;

                if(count($przepis['ocena']) < 1){
                    array_push($ocena,"Nie podano oceny");
                }else{
                    array_push($ocena,$przepis['ocena']);
                }
                if($przepis['recenzja'] == ""){
                    array_push($recenzja,"Nie napisano recenzji");
                }else{
                    array_push($recenzja,$przepis['recenzja']);
                }
                
                $k = $k + 1;
            }
    
            $str = $str . "</table>";
            $str = $str . "<div id=\"ulubioneInfo\"></div>";

        for($k = 0; $k < count($ocena); $k++){
            $tableopinia = 'tableOpinia'.$k;
            //zwrocenie twojej opini
            $str = $str . <<<HTML
            <div class = "twojaOpinia" id= "{$tableopinia}" style = "display:none;">
                <h3 class="center">Twoja ocena 0-5</h3>
                <p class = "center">{$ocena[$k]}</p>
                <h3 class="center">Twoja recenzja</h3>
                <p class="center">{$recenzja[$k]}</p>
            </div>
            HTML;
        }
    }

    pg_close($db);
    echo $str;
?>