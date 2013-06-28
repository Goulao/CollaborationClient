<h2>Registrieren</h2>
<div style="background-color:#CCCCCC; width:50%">
<?php
// mehrere ifs für die Fehlermeldungen, pro feld eine Fehlermeldung zB. wenn der name schon existiert, sagen bitte neuen namen angeben
if (!$loginFunctions->isLoggedIn()) {
    } else {
    print '<span>Seite nicht verfügbar </span>'; 
    return;
} 

        if (isset($_POST['name']) 
        && isset($_POST['vorname'])
        && isset($_POST['nachname'])
        && isset($_POST['e_mail_adresse'])
        && isset($_POST['passwort'])
    ){
        $result = $userService->createUser_register(
            $_POST['name'],
            $_POST['passwort'], 
            $_POST['vorname'],
            $_POST['nachname'],
            $_POST['e_mail_adresse']
            
            );
    if ($result->status == 'created') {
            print '<span class="erfolgsmeldung">Benutzer erfolgreich hinzugefügt</span>';
        } else {
            foreach ($result->reason as $reason) {
                print '<span class="Fehlermeldung">' . $reason . '</span><br />';
            }
        } 
    }



?> 

<form method="post" action="?section=registrieren">
<?php  
if (isset($_POST['name'])
    && isset($_POST['vorname'])
    && isset($_POST['nachname'])
    && isset ($_POST['e_mail_adresse'])
    ){
    print '<div class="Eingabefläche_register"> benutzername: <input type="text" name="name" value="'. htmlspecialchars($_POST['name']).'"/><br/></div>'; 
    print '<div class="Eingabefläche_register"> passwort: <input type="password" name="passwort"/><br/></div>';
    print '<div class="Eingabefläche_register"> vorname: <input type="text" name="vorname" value="'. htmlspecialchars($_POST['vorname']).'"/><br/></div>'; 
    print '<div class="Eingabefläche_register"> nachname: <input type="text" name="nachname" value="'. htmlspecialchars($_POST['nachname']).'"/><br/></div>'; 
    print '<div class="Eingabefläche_register"> e-Mailadresse: <input type="text" name="e_mail_adresse" value="'. htmlspecialchars($_POST['e_mail_adresse']).'"/><br/></div>';
} else {
    print '<div class="Eingabefläche_register"> benutzername: <input type="text" name="name"/><br/></div>'; 
    print '<div class="Eingabefläche_register"> passwort: <input type="password" name="passwort"/><br/></div>';
    print '<div class="Eingabefläche_register"> vorname: <input type="text" name="vorname"/><br/></div>'; 
    print '<div class="Eingabefläche_register"> nachname: <input type="text" name="nachname"/><br/></div>'; 
    print '<div class="Eingabefläche_register"> e-Mailadresse: <input type="text" name="e_mail_adresse"/><br/></div>';
}


?>
   
    
 <input type="submit" value="ok" /> 
</form></div>