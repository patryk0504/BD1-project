<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wylogowano</title>
</head>
<body>
    <?php

        session_start();
        unset($_SESSION);
        session_destroy();
        session_write_close();
        header('Location: ../indexLoggedOut.php');
        die;
    ?>
</body>
</html>