<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strona domowa</title>
    <link rel="stylesheet" href="./style/indexLogged.css">

</head>
<body>
    <header>
        <nav class = "topnav">
            <ul>
                <li><a href="./panel_uzytkownika/zalogowanyHome.php">Panel użytkownika</a></li>
                <li><a href="./log_rej/logowanie.php">Logowanie</a></li>
                <li><a href="./log_rej/logowanieAdmin.php">Logowanie Administrator</a></li>
                <li><a href="./log_rej/rejestracja.php">Rejestracja</a></li>
                <li><a href="#" id = "about" onclick="loadArticle(this);">About</a></li>

            </ul>
        </nav>
      </header>

      <div class="bg">
        <article id = "aboutArticle" class="vertical-center" style = "display: none;">
        <h1 class = "center" style = "font-size:40px;">Kuchenny pomocnik</h1>
        <h3 class = "center" style = "font-size:22px;">Witaj na stronie umożliwiającej zarządzanie produktami spożywczymi lub ulubionymi przepisami.</h3>
        
        <p class="center" style = "font-size:20px;">Jesteś teraz wylogowany. Aby korzystać z funkcjonalności serwisu zaloguj się bądź zarejestruj. <br>
            Możesz to zrobić wybierając odpowiednią opcję w górnym menu.
        </p>

        <p class="center" style = "font-size:18px;"> <strong>Jako standardowy użytkownik masz dostęp do większości funkcjonalności tj. przeglądanie przepisów, zarządzanie spiżarnią czy ocenami. <br>
        Jako administrator poza standardowymi funkcjami masz prawa do dodawania m.in. nowych przepisów bądź składników.</strong>
        </p>
        <p class="center" style = "margin-top:10%;"><a href="./dokumentacja/BD1_Patryk_Sledz_doc.pdf" download="BD1_doc.pdf" style = "font-size : 20px;">Link do dokumentacji</a></p>

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