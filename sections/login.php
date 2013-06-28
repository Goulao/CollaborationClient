<h2 style="color: #00CC00;">Login</h2>
<div style="background-color:#CCCCCC">

<?php
//$loginFunctions = new loginFunctions($pdo);


if ($loginFunctions->isLoggedIn()) {
    $loginFunctions->logOut();
    print '<span>Erfolgreich abgemeldet :-)</span>';
    return;
}


if (isset ($_POST['name'])
    && isset ($_POST['passwort'])
 ){
  
    if ($loginFunctions->logIn($_POST['name'], $_POST['passwort'])) {
      print '<span class="erfolgsmeldung">Login erfolgreich.</span><br/>';
     
      $host  = $_SERVER['HTTP_HOST'];
      $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
      $extra = 'index.php?section=projekte';
      header("Location: http://$host$uri/$extra");
      //('Location:ttp://www.http://localhost/Auftrag/projekte.de ');
    }  else {
        print '<span class="Fehlermeldung">login fehlgeschlagen</span>';
       
    }
   //   http://www.google.de/
    
}


?>
<br/>
<br/>
<br/>
<form method="post" action="">
    
    Name:
    <input type="text" name="name" />
    <br/>
    Passwort: 
    <input type="password" name="passwort" />

    <input type="submit" value="ok" />
</form><br /><br /></div>