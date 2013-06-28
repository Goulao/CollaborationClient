<?php

if ($loginFunctions->isLoggedIn()) {
    $loginFunctions->logOut();
    print '<span>Erfolgreich abgemeldet :-)</span>';
    $host  = $_SERVER['HTTP_HOST'];
      $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
      $extra = 'index.php?section=login';
      header("Location: http://$host$uri/$extra");
    return;
}
?>
