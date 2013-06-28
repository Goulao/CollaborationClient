<h2>Projekt Bearbeiten</h2>
<?php

// vllt. als zusastz Befehl noch Projekt loeschen hier rein schieben da loeschen auch eine form der Bearbeitung ist
// oder ähnlich wie das löschen von versionen schieben
if (!$loginFunctions->isLoggedIn() || $loginFunctions->getCurrentUser('rolle') == 'locked') {
    print 'Seite nicht verfügbar.';
    return;
}
$result = $userService->get_project(
            $loginFunctions->getCurrentUser('id'),
            $_GET['id']
);


$projektDetails = array();
foreach ($result as $test) {
    $projektDetails[] = $test;
   
}

$projekt = array ();
$projekt['name'] = $projektDetails['1'];


if (isset($_POST['name'])
    && isset($_POST['status']) 
    && isset($_GET['id'])    
    ){
    $result = $userService->edit_project(
        $loginFunctions->getCurrentUser('id'),
        $_GET['id'],
        $_POST['name'],
        $_POST['status']
        );
      
    if ($result->status == 'ok') {
            print '<u style="color:#006600">Projekt erfolgreich geändert</u>';
        } else {
           
            foreach ($result->reason as $reason) {
                print '<span class="Fehlermeldung">' . $reason . '</span><br />';
            } 
        } 
} 


print '<form method="post" action="?section=project_bearbeiten&id=' . $_GET['id']. '">';
if (isset($_POST['name'])) {
    print 'Name des Projekts: <input type="text" name="name" value="'.$_POST['name'] . '"/>'; 
} else {
print 'Name des Projekts: <input type="text" name="name" value="'.$projektDetails[1] . '"/>'; 
}
print '<br/>';
print 'open:   <input type="radio" name="status" value="open"/>';
print '<br/>';
print 'closed: <input type="radio" name="status" value="closed"/>';
print '<br/>';
print '<input type="submit" value="ok" />';
print '</form>';