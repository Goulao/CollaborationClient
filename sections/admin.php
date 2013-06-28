<h2> Adminverwaltung </h2>
<div style="background-color: #62A0BA; width:50%"> 
<?php
//CCCCCC
if (!$loginFunctions->isLoggedIn() || $loginFunctions->getCurrentUser('rolle') != 'admin') {
    print 'Seite nicht verfügbar.';
    return;
}

//print '<a href="?section=login_daten&id=1">logindaten</a>';
//$loginFunctions->find($_GET['id']);
//$statement = $pdo->query('SELECT id, benutzername From login_daten');
$userlist = array();
$userlist = $userService->getUsers($loginFunctions->getCurrentUser('id'));

        
foreach ($userlist as $row) {
    print '<div class="project clearfix">';
        print '<div class="adminUser">';
            print $row->id . '-' . $row->user ;
        print'</div>';
        print '<div class="userActionsVerticalBox">';
            print' <a href="?section=benutzer_Bearbeiten&id='. $row->id . '">bearbeiten</a>';
        print '</div>';

    print '</div>';
 }

print '<br/>';

 
 if ( isset($_POST['name']) 
        && isset($_POST['vorname'])
        && isset($_POST['nachname'])
        && isset($_POST['e_mail_adresse'])
        && isset($_POST['rolle'])
        && isset($_POST['passwort'])
    ){
        $result = $userService->createUser(
            $loginFunctions->getCurrentUser('id'),
            $_POST['name'],
            $_POST['passwort'], 
            $_POST['vorname'],
            $_POST['nachname'],
            $_POST['e_mail_adresse'],
            $_POST['rolle']
        );
        
        //var_dump($result);
                
        if ($result->status == 'created') {
            print ' <span class="erfolgsmeldung" >Benutzer erfolgreich hinzugefügt </span>';
        } else {
            foreach ($result->reason as $reason) {
                print '<span class="Fehlermeldung">' . $reason . '</span><br />';
            }
        }
    }
     



?>
<form method="post" action="?section=admin">
<div class="Eingabefläche"> Benutzername:
    <input type="text" name="name" />
</div>
 <div class="Eingabefläche"> Vorname
    <input type="text" name="vorname" />
 </div>
<div class="Eingabefläche"> Nachname:
    <input type="text" name="nachname" />
</div>
<div class="Eingabefläche"> e_mail_adresse
   <input type="text" name="e_mail_adresse" />
</div>
<div class="Eingabefläche"> Passwort: 
    <input type="password" name="passwort" />
</div>
<div class="Eingabefläche_admin"> Rolle: <br/>
   Admin: <input type="radio" name="rolle" value="admin"/><br/>
   Member: <input type="radio" name="rolle" value="member"/><br/>
   locked: <input type="radio" name="rolle" value="locked" checked="checked"/><br/>
</div>
    
    <input type="submit" value="ok" />
</form>
</div>