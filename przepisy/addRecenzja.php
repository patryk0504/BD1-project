<?php
session_start();
include("../config_bd/login_bd.php");
$id = $_GET["id"];
$login = $_SESSION['user'];
if(!isset($_GET['ocena'], $_GET['recenzja'])){
    $wynik = pg_query_params($db, 'select * from proj_v1.isRecenzja($1, $2)', array($login, $id))
        or die ('Unable to CALL stored procedure: ' . pg_last_error());
    $tab = pg_fetch_all($wynik);
    
    foreach($tab as $res){
        $ulubione;
        $ocena_t;
        $recenzja_t;
        if ($res['ulubione'] == 't' )
            $ulubione = "Przepis znajduje się w ulubionych";
        else
            $ulubione = "Przepis nie znajduje się w ulubionych";   
        $ocena = $res['ocena'];
        if($res['ocena'] == null){
            $ocena_t = "Nie oceniłeś jeszcze tego przepisu";
        }else{
            $ocena_t = "Już oceniłeś ten przepis! Aktualna ocena: " . $ocena;
        }
        $recenzja = $res['recenzja'];
        if($res['recenzja'] == ""){
            $recenzja_t = "Nie napisałeś jeszcze recenzji tego przepisu";
        }else{
            $recenzja_t = "Już napisałeś recenzję!";
        }
        $str = <<<HTML
        <table class="centerTable">
            <tr style="text-align: center; "><td>$ulubione</td></tr>
            <tr style="text-align: center; "><td>$ocena_t</td></tr>
            <tr style="text-align: center; "><td>$recenzja_t</td></tr>
        </table>
        <h4>Chcesz zmienić opinię? Wypełnij poniższe pola i zatwierdź!</h4>
        <form>
        <select name="ocena" id="ocena">
            <option value="-1" disabled selected>Jak oceniasz przepis 0-5?</option>
            <option value="0">0</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select> <br>
        <textarea name="recenzja" id = "recenzja" rows="4" cols="45" placeholder="Twoja opinia...">{$recenzja}</textarea> <br>
        <button type = "button" onclick="zapiszRecenzje(${id});">Zapisz</button>
        </form>
        HTML;
        echo $str;
    }    
}else{
    $ocena;
    $recenzja;
    if($_GET['ocena'] != -1){
        $ocena = $_GET['ocena'];
    }else{
        $ocena = -1;
    }
    if(isset($_GET['recenzja'])){
        $recenzja = $_GET['recenzja'];
    }else{
        $recenzja = 'null';
    }
    $wynik = pg_query_params($db, 'select * from proj_v1.addrecenzja($1, $2, $3, $4)', array($login, $id, $ocena, $recenzja))
        or die ('Unable to CALL stored procedure: ' . pg_last_error());
    $tab = pg_fetch_all($wynik);
    $row ;
    foreach($tab as $res)
        $row = $res['addrecenzja'];
    if($row == 't'){
        echo "Pomyślnie zapisano recenzje!";
    }else{
        echo "Nie zapisano recenzji";
    }
}
pg_close($db);

?>