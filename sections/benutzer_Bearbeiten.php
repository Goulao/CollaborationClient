<h2>Benutzer Bearbeiten</h2>
<div style="background-color: #CCCCCC; width:50%"> 
<?php
if (!isset($_GET['id'])) {
    return;
}

if ($loginFunctions->isLoggedIn()) {
   } else {
    print 'seite nicht verfügbar';
    return;
} 
 $result = $userService->getuser(
            $loginFunctions->getCurrentUser('id'),
            $_GET['id']
);
$getuser=array();
foreach ($result as $test) {
    $getuser[] = $test;
}
$user = array();
$user['user'] = $getuser[1];
$user['vorname'] = $getuser[2];
$user['nachname'] = $getuser[3];
$user['email'] = $getuser[4];
$user['rolle'] = $getuser[5];

 
 
    
    if (isset($_POST['name']) 
        && isset($_POST['vorname'])
        && isset($_POST['nachname'])
        && isset($_POST['e_mail_adresse'])
        && isset($_POST['rolle'])
     
    ){
   
        $result = $userService->work_user(
            $loginFunctions->getCurrentUser('id'),
            $_GET['id'],
            $_POST['rolle'],
            $_POST['name'],
            $_POST['vorname'],
            $_POST['nachname'],
            $_POST['e_mail_adresse']
            
           
        );
      //  var_dump($result);
                
       if ($result->status == 'changed') {
            print '<span class="erfolgsmeldung">Benutzer erfolgreich geändert</span>';
        } else {
            
            foreach ($result->reason as $reason) {
                print '<span class="Fehlermeldung">' . $reason . '</span><br />';
            } 
        } 
    } 
   
    

?>
<form method="post" action="?section=benutzer_Bearbeiten&id=<?= $_GET['id']?>">
<?php    

print '<div class="project clearfix"><div class="Eingabefläche">';

if (isset($_POST['rolle'])
    && $_POST['rolle'] == 'member') {
    print 'admin: <input type="radio" name="rolle" value="admin"/><br/>';
    print 'member: <input type="radio" checked="checked" name="rolle" value="member"/><br/>';
    print 'locked: <input type="radio" name="rolle" value="locked"/><br/>';
} else if (isset($_POST['rolle'])
    && $_POST['rolle'] == 'admin') {
    print 'admin: <input type="radio" checked="checked" name="rolle" value="admin"/><br/>';
    print 'member: <input type="radio"  name="rolle" value="member"/><br/>';
    print 'locked: <input type="radio" name="rolle" value="locked"/><br/>'; 
} elseif ($user['rolle'] == 'member') {
    print 'admin: <input type="radio" name="rolle" value="admin"/><br/>';
    print 'member: <input type="radio" checked="checked" name="rolle" value="member"/><br/>';
    print 'locked: <input type="radio" name="rolle" value="locked"/><br/>';
} else if ($user['rolle'] == 'admin') {
    print 'admin: <input type="radio" checked="checked" name="rolle" value="admin"/><br/>';
    print 'member: <input type="radio"  name="rolle" value="member"/><br/>';
    print 'locked: <input type="radio" name="rolle" value="locked"/><br/>'; 

}else {
    print 'admin: <input type="radio" name="rolle" value="admin"/><br/>';
    print 'member: <input type="radio" name="rolle" value="member"/><br/>';
    print 'locked: <input type="radio" checked="checked" name="rolle" value="locked"/><br/>';
} 
print'</div>';
//print'<div class="Eingabefläche">';

if (isset($_POST['name']) 
    && isset($_POST['vorname'])
    && isset($_POST['nachname'])
    && isset($_POST['e_mail_adresse']) 
    ){
    print '<div class="Eingabefläche"> benutzername: <input type="text" name="name" value="'. htmlspecialchars($_POST['name']).'"/><br/></div>'; 
    print '<div class="Eingabefläche"> vorname: <input type="text" name="vorname" value="'. htmlspecialchars($_POST['vorname']).'"/><br/></div>'; 
    print '<div class="Eingabefläche"> nachname: <input type="text" name="nachname" value="'. htmlspecialchars($_POST['nachname']).'"/><br/>'; 
    print '<div class="Eingabefläche"> e-Mailadresse: <input type="text" name="e_mail_adresse" value="'. htmlspecialchars($_POST['e_mail_adresse']).'"/><br/></div>';
} else {
print '<div class="Eingabefläche"> benutzername: <input type="text" name="name" value="'. htmlspecialchars($user['user']).'"/><br/></div>'; 
print '<div class="Eingabefläche"> vorname: <input type="text" name="vorname" value="'.htmlspecialchars($user['vorname']).'"/><br/></div>'; 
print '<div class="Eingabefläche"> nachname: <input type="text" name="nachname" value="'. htmlspecialchars($user['nachname']).'"/><br/></div>'; 
print '<div class="Eingabefläche"> e-Mailadresse: <input type="text" name="e_mail_adresse" value="'. htmlspecialchars($user['email']).'"/><br/></div>'; 
}



?>

<input type="submit" value="ok" />
</form></div></div>
