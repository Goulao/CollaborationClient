<?php session_start(); ob_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>        
        <link rel="stylesheet" type="text/css" href="styles.css" />
    </head>
    <body>
        <header class="clearfix">
            <h1 class="box">Title</h1>
            <?php
            $pdo = new pdo('mysql:host=localhost;dbname=auftrag', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            include 'functions/functions.include.php';
            include 'functions/loginFunctions.php';
            include 'functions/UrlWrapper.php';
            include 'services/UserService.php';
            $loginFunctions = new loginFunctions($pdo);
            $userService = new UserService();
            include 'sections/menuNeu.php';
            ?>
        </header>
        <div class="content">
            <?php
            $lookupTable = array(
                 'registrieren' => 'sections/registrieren.php',
                 'passwortaendern' => 'sections/passwortaendern.php',
                 'willkommen_user' => 'sections/willkommen_user.php',
                 'admin' => 'sections/admin.php',
                 'benutzer_Bearbeiten' => 'sections/benutzer_Bearbeiten.php',
                 'projekte' => 'sections/projekte.php',
                 'logout' => 'sections/logout.php',
                 'project_bearbeiten' => 'sections/project_bearbeiten.php',
                 'pull' => 'sections/pull.php',
                 'push' => 'sections/push.php',
                 'loeschen' => 'sections/loeschen.php',
                 'project_loeschen' => 'sections/project_loeschen.php',
                 'browse' => 'sections/browse.php'

            );
            if (isset($_GET['section'])
                && isset($lookupTable[$_GET['section']])
            ) {
                include $lookupTable[$_GET['section']];
            } else {
                //include 'sections/menuNeu.php';
                include 'sections/login.php';
            }
            ?>
        </div>
    </body>
</html>
<?= ob_get_clean(); ?>