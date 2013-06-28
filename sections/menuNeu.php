<nav>
    <ul>
        <?php
        if ($loginFunctions->isLoggedIn()){
            print '<li><a class="li" href="?section=menuNeu">Logout</a></li>';
            print '<li><a class="li" href="?section=passwortaendern">Passwort ändern</a></li>';
            print '<li><a class="li" href="?section=admin">admin</a></li>';
            print '<li><a class="li" href="?section=projekte">projekte</a></li>';   
        } else {
            print '<li><a class="li" href="?section=registrieren">Registrieren</a></li>';
            print '<li><a class="li" href="?section=login">Login</a></li>';

        }
        ?>
    </ul>
</nav>