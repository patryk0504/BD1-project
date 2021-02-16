<?php
session_start();
    
if(!isset($_SESSION['auth']) && $_SESSION['auth'] != 'OK' && !isset($_SESSION['admin']) && $_SESSION['admin'] != 'yes'){
    header("Location: ./log_rej/logowanieAdmin.php");
    exit;
}
$idprzepis = $_POST['idprzepis'];
include("../config_bd/login_bd.php");
$wynik = pg_query_params($db, 'delete from proj_v1.przepis where idprzepis = $1', array($idprzepis))
                or die ('Unable to CALL stored procedure: ' . pg_last_error());
$cmdtuples = pg_affected_rows($wynik);
if (!$wynik) {
    $errormessage = pg_last_error();
    echo "Error with query: " . $errormessage;
    exit();
}else{
    echo "Pomyślnie usunięto przepis";
}

pg_close($db);
?>