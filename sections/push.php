<?php
if (!is_dir($_POST['ordner']) || stripos($_POST['ordner'], 'C:\xampp\htdocs') === false) {
    print 'ich gehe da nicht hinein';
    return;
}

if (in_array(substr($_POST['ordner'], -1), array('/', '\\'))) {
    $_POST['ordner'] = substr($_POST['ordner'], 0, -1);
}

// Holen der Größe
$groesse = array();
foreach (glob_recursive($_POST['ordner']. '/*') as $file) {
     $groesse[] .= filesize($file);
}
$gesamtGroesse = 0;
foreach($groesse as $row) {
   $gesamtGroesse += $row;
}

// Holen der ID fürs Pushen und Holen der zu löschenden Versionen
$result = $userService->push(
    $loginFunctions->getCurrentUser('id'),
    $_GET['project'],
    $gesamtGroesse
);

if ($result->status != 'ok') {
    foreach ($result->reason as $reason) {
        print '<span class="Fehlermeldung">' . $reason . '</span><br />';
    }       
    return;
}

$ftpServer = ftp_connect('localhost');
ftp_login($ftpServer, 'newuser', 'wampp');

foreach ($result->delete as $version2Delete) {
    $path = '/ftp/' . $_GET['project'] . '/' . $version2Delete;
    ftp_delete_recursive($path, $ftpServer);
}

$version = $result->version;

// ftp upload begin


ftp_mkdir($ftpServer, 'ftp/'. $_GET['project'] . '/' . $version);

foreach (glob_recursive($_POST['ordner']. '/*') as $file) {
    $filePath = str_replace($_POST['ordner'], '', $file);
    if (is_dir($file)) {
        ftp_mkdir($ftpServer, '/ftp/'. $_GET['project'] . '/' . $version . $filePath);
    } else {
        ftp_put($ftpServer, 'ftp/'. $_GET['project'] . '/' . $version . $filePath, $file, FTP_ASCII );
    }
}
ftp_close($ftpServer);
// ftp upload end



print '<span class="erfolgsmeldung">Projekt zugriff</span>';

function glob_recursive($pattern, $flags = 0)
{
    $files = glob($pattern, $flags);

    foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir)
    {
        $files = array_merge($files, glob_recursive($dir.'/'.basename($pattern), $flags));
    }

    return $files;
}