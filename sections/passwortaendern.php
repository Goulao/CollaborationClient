<h2>Passwort Aendern</h2>

<?php
if (!$loginFunctions->isLoggedIn()) {
    print 'Seite nicht verfügbar.';
    return;
}

if (isset ($_POST['oldPasswort'])
    && isset($_POST['newPasswort'])
    && isset ($_POST['newPasswortRepeat'])
    && $_POST['newPasswort'] == $_POST['newPasswortRepeat']
) {
    

    $result = $userService->password_changed(
            $loginFunctions->getCurrentUser('id'),
            $_POST['oldPasswort'],
            $_POST['newPasswort']
        );
        if ($result->status == 'changed') {
            print '<span class="erfolgsmeldung">Wurde erfolgreich geaendert</span>';
        } else {
            foreach ($result->reason as $reason) {
                print '<span class="Fehlermeldung">' . $reason . '</span><br />';
            }
        }

} elseif (isset($_POST['newPasswort'])
        && isset ($_POST['newPasswortRepeat'])
        && $_POST['newPasswort'] != $_POST['newPasswortRepeat']) {
    print '<span class="Fehlermeldung" >Das neue Passowrt stimmt mit der Wiederholung des Passworts nicht überein</span>';
} 

    


      
          


?>

        <br/> 
        <form method="post" action="?section=passwortaendern">
        altes Passwort: 
                <input type="password" name="oldPasswort" />
            <br/>
       Neues Passwort: 
       
            <input type="password" name="newPasswort" />
                      <br/>
        Neues Passwort wiederholen
         <input type="password" name="newPasswortRepeat" />
<br/>
            <input type="submit" value="ok" />
        </form>
        <br/>