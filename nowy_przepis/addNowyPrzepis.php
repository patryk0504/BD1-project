<?php
    session_start();
    include("../config_bd/login_bd.php");
    

    $data = json_decode(stripslashes($_POST['data']));

    $options = json_decode(stripslashes($_POST['options']));

    $paramArray = array();
    foreach($options as $key => $value){
        array_push($paramArray, $value);
    }

    $ids = "";
    $amount = "";
    $k=0;
    foreach($data as $key => $value){
       $ids = $ids . $key;
       $amount = $amount . $value;
        $ids = $ids . ",";
        $amount = $amount . ",";
    }
    $ids = substr_replace($ids ,"",-1);
    $amount = substr_replace($amount ,"",-1);

    array_push($paramArray, $ids);
    array_push($paramArray, $amount);

    $wynik = pg_query_params($db, 'select * from proj_v1.createprzepis($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12)', 
                            $paramArray)
                or die ('Unable to CALL stored procedure: ' . pg_last_error());
    $tab = pg_fetch_all($wynik);
    $row;
    foreach($tab as $res){
        $row = $res['createprzepis'];
    }
    if(pg_num_rows($wynik) != 0){
        if (is_numeric($row)) {
            $id = (int) $row;
            echo <<<HTML
            <h3>Pomyślnie zapisano przepis! <br> Możesz do niego przejść za pomocą poniższego przycisku lub możesz stworzyć następny.</h3>
            <button id = "przejdzDoPrzepisu" onclick="przejdzDoPrzepisu({$id});">Przejdź do przepisu</button> <br>
            <button id = "stworznastepny" onclick="stworzKolejny();">Stwórz kolejny przepis</button> <br>
            HTML;
        }else{
            echo <<< HTML
            <h3>{$row}</h3>
            <button id = "stworznastepny" onclick="stworzKolejny();">Spróbuj ponownie</button> <br>
            HTML;  
        }
        
    }

    pg_close($db);

?>