<?php
    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['pokazOpis'])){
        func($_POST['opis']);
    }
    
    function func($opis){
        echo $opis;
    }
?>
