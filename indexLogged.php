<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strona domowa</title>
    <link rel="stylesheet" href="./style/indexLogged.css">
    <?php
        if(!isset($_SESSION['auth']) && $_SESSION['auth'] != 'OK'){
            header("Location: indexLoggedOut.php");
            exit;
        }
    ?>
</head>
<body>
    <header>
        <nav class = "topnav">
            <ul>
                <li><a href="./panel_uzytkownika/zalogowanyHome.php">Panel użytkownika</a></li>
                <li><a href="./przepisy/przepisy.php">Szukaj przepisów</a></li>
                <li><a href="./log_rej/wyloguj.php">Wyloguj się</a></li>
                <li><a href="#" id = "about" onclick="loadArticle(this);">About</a></li>

            </ul>
        </nav>
      </header>

      <div class="bg">
        <article id = "aboutArticle" class="vertical-center" style = "display: none;">
        <h1 class = "center" style = "font-size:40px;">Kuchenny pomocnik</h1>
        <h3 class = "center" style = "font-size:22px;">Witaj na stronie umożliwiającej zarządzanie produktami spożywczymi lub ulubionymi przepisami.</h3>
        
        <p class="center" style = "font-size:18px;">Jesteś zalogowany, masz dostęp do funkcjonalności odpowiednich dla typu Twojego konta.</p>

        </article>
 
      </div>

<script>
    window.onload = function(){
    el = document.getElementById("aboutArticle").style = "block";
    }
    function loadArticle(elem){
    var elements = document.getElementsByClassName("content");
    for(var i = 0; i<elements.length; i++)
        elements[i].style = "display : none;";
    switch(elem.id){
        case "about":
            document.getElementById("aboutArticle").style = "block";
            break;
    }
}
</script>

    <footer>
        &copy; 2021 - Patryk Śledź
    </footer>
</body>
</html>