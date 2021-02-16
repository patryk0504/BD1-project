<?php
    session_start();
    $kategoria = $_REQUEST["kategoria"];
    include("../config_bd/login_bd.php");
    $wynik = pg_query_params($db, 'select ks.jednostka from proj_v1.kategoriaskladnik ks where ks.rodzaj =  $1', array($kategoria))
            or die ('Unable to CALL stored procedure: ' . pg_last_error());
    $tab = pg_fetch_all($wynik);

    $str = <<<HTML
    <h3 class="center">Wybierz jednostkę składnika</h3>
    <select id="jednostkaSelect" required>

    HTML;
    foreach ($tab as $res){
        $jednostka = $res['jednostka'];
        $str = $str . <<< HTML
        <option value='{$jednostka}'>{$jednostka}</option>
        HTML;
    }
    $str = $str . "</select>";
    echo $str;
    pg_close($db);
?>