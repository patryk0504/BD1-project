<?php
    session_start();
    $kategoria = $_REQUEST["kategoria"];
    $jednostka = $_REQUEST["jednostka"];
    $nazwa = $_REQUEST["nazwa"];
    $dostawca = $_REQUEST["dostawca"];

    include("../config_bd/login_bd.php");

    $wynik = pg_query_params($db, 'select ks.idkategoriaskladnik from proj_v1.kategoriaskladnik ks where ks.rodzaj =  $1 and ks.jednostka = $2', 
                            array($kategoria, $jednostka))
            or die ('Unable to CALL stored procedure: ' . pg_last_error());
    $tab = pg_fetch_all($wynik);

    $idkategoriaskladnik;
    foreach($tab as $res)
        $idkategoriaskladnik = $res['idkategoriaskladnik'];
    $iddostawca;
    if($dostawca == ""){
        $iddostawca = null;
        $wynik2 = pg_query_params($db, 'insert into proj_v1.skladnik (nazwa, iddostawca, idkategoriaskladnik) values ($1,$2,$3)', 
            array($nazwa, $iddostawca, $idkategoriaskladnik))
                or die ('Unable to CALL stored procedure: ' . pg_last_error());
            $cmdtuples = pg_affected_rows($wynik2);
    
            if($cmdtuples > 0){
                echo "<h3 class = \"center\">Pomyślnie zapisano nowy składnik</h3>";
            }else{
                echo "<h3 class = \"center\">Składnik nie został zapisany! <br> Prawdopodobnie próbujesz dodać składnik, który już istnieje.</h3>";
            }
    }else{
        $wynik2 = pg_query_params($db, 'select distinct ds.iddostawca from proj_v1.dostawcyskladnika ds where lower(ds.nazwa) = lower($1)', 
        array($dostawca)) or die ('Unable to CALL stored procedure: ' . pg_last_error());
        if(pg_num_rows($wynik2) < 1){
            echo "<h3>Nie znaleziono podanego dostawcy.</h3>";
        }else{
            $tab2 = pg_fetch_all($wynik2);
            foreach($tab2 as $res)
                $iddostawca = $res['iddostawca'];
            $wynik2 = pg_query_params($db, 'insert into proj_v1.skladnik (nazwa, iddostawca, idkategoriaskladnik) values ($1,$2,$3)', 
            array($nazwa, $iddostawca, $idkategoriaskladnik))
                or die ('Unable to CALL stored procedure: ' . pg_last_error());
            $cmdtuples = pg_affected_rows($wynik2);
    
            if($cmdtuples > 0){
                echo "<h3 class = \"center\">Pomyślnie zapisano nowy składnik</h3>";
            }else{
                echo "<h3 class = \"center\">Składnik nie został zapisany! <br> Prawdopodobnie próbujesz dodać składnik, który już istnieje.</h3>";
            }
        }
    }

    pg_close($db);
?>