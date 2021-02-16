<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usun przepis</title>
    <link rel="stylesheet" href="../style/raportyStyle.css">
    <?php
        if(!isset($_SESSION['auth']) && $_SESSION['auth'] != 'OK' && !isset($_SESSION['admin']) && $_SESSION['admin'] != 'yes'){
            header("Location: ../log_rej/logowanieAdmin.php");
            exit;
        }
    ?>

    <script>
        var xmlHttp;
        function getRequestObject() {
            if ( window.ActiveXObject) {
                return ( new ActiveXObject("Microsoft.XMLHTTP")) ;
            }else if (window.XMLHttpRequest) {
                return (new XMLHttpRequest());
            }else {
                return (null);
            }
        }

        function usunPrzepis(){
            var id = document.getElementById('idprzepis').value;
            xmlHttp = getRequestObject() ;
            var formData = new FormData(); 
            formData.append('idprzepis', id);
            if (xmlHttp) {
                try {
                var url = "./usunPrzepisFun.php";
                xmlHttp.onreadystatechange = () => {
                if (xmlHttp.readyState == 4) {
                    if ( xmlHttp.status == 200 )  {
                    response = xmlHttp.responseText;
                    var input = response;
                    alert(input);
                    setTimeout(location.reload.bind(location), 600);
                    }
                }  
                };
                xmlHttp.open("POST", url, true);
                xmlHttp.send(formData);
                }catch (e) {
                    alert ("Nie mozna polaczyc sie z serwerem: " + e.toString()) ;
                }
            }else {
                alert ("Blad") ;
            }
        }
    </script>
</head>
<body>
    <header>
        <nav class = "topnav">
            <ul>
                <li><a href="../panel_uzytkownika/zalogowanyAdminHome.php">Panel użytkownika</a></li>
                <li><a href="../przepisy/przepisy.php">Szukaj przepisów</a></li>
                <li><a href="../log_rej/wyloguj.php">Wyloguj się</a></li>
                <li><a href="../indexLogged.php" id = "about">About</a></li>

            </ul>
        </nav>
    </header>

    <h1 class="content center">Usuń przepis</h1>

    <h3 class="center">Podaj id przepisu</h3>
    <span class="center">Pamiętaj, że wraz z przepisem zostaną usunięte recenzje użytkowników.</span>
    <form class="center">
    <input type="text" class="center" id="idprzepis" style="margin-left: auto; margin-right: auto; margin-top:2em;" placeholder="ID">
    <input type="button" onclick="usunPrzepis();" value = "Usuń składnik">

    </form>

    <?php
        include("../config_bd/login_bd.php");
        $str = <<<HTML
        <h3 class="center">Tabela przepis</h3>
        <table class="centerTable">
            <tr>
                <th>idprzepis</th>
                <th>nazwa</th>
                <th>czas wykonania</th>
                <th>idkategoriadania</th>
                <th>rodzaj</th>
                <th>kategoria</th>
                <th>idwartosci</th>
            </tr>
        HTML;
        $wynikPrzepis = pg_query_params($db, 'select p.idprzepis, p.nazwa, p.czaswykonania, p.idkategoriadania, k.rodzaj, k.kategoria, p.idwartosci
                from proj_v1.przepis p join proj_v1.kategoriadania k on p.idkategoriadania = k.idkategoriadania order by p.idprzepis;', array())
            or die ('Unable to CALL stored procedure: ' . pg_last_error());
        $tabPrzepis = pg_fetch_all($wynikPrzepis);

        foreach($tabPrzepis as $res){
            $str = $str . <<<HTML
            <tr>
                <td>{$res['idprzepis']}</td>
                <td>{$res['nazwa']}</td>
                <td>{$res['czaswykonania']}</td>
                <td>{$res['idkategoriadania']}</td>
                <td>{$res['rodzaj']}</td>
                <td>{$res['kategoria']}</td>
                <td>{$res['idwartosci']}</td>
            </tr>
            HTML;
        }

        $str = $str . <<<HTML
        </table>
        HTML;
        echo $str;
        pg_close($db);

    ?>

    <div  class="spacer"> . </div>

<footer>
    &copy; 2021 - Patryk Śledź
</footer>
</body>
</html>