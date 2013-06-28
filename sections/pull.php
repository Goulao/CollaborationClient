<div style="background-color: #99cc00; width:45%">  
<?php
// Liste der Versionen ausspucken
if (empty($_GET['version'])) {
    $result = $userService->pull(
        $loginFunctions->getCurrentUser('id'),
        $_GET['project']
    );
  
    print '<br/>';
    foreach ($result as $row) {
        print'<div class="project clearfix">';
            print'<div class="Versionen">';
                print 'Versionsnummern: '. $row->version . ' ('. round($row->groesse/1024) .' MB) </div><div class="VersionenBox">'
                      . '<div><a href="?section=loeschen&delete=1&project='. $_GET['project'].  '&version=' .$row->version .'">[loeschen]</a></div> '
                      . '<div><a href="?section=browse&project=' . $_GET['project'] . '&version=' .$row->version .'">[browse]</a></div></div>';
                print '<div class="versionenActions"> <form action="?section=pull&project=' . $_GET['project'] . '&version=' . $row->version . '" method="post"><input type="submit" value="Pull to" /> <input type="text" value="" name="ordner" /></form>';
        print '</div></div><br/>';
    }
    return; 
}

// Loeschen einer Version
if (isset($_GET['delete'])
    && isset($_GET['version'])
) { 
    $results = $userService->loeschen(
        $_GET['project'],
        $_GET['version']
    );
    if ($results->status == 'ok') {
        print '<span class="erfolgsmeldung">Erfolgreich erfolgreich geloescht</span>';
    }
    return;
}

// Pull einer Version
if (in_array(substr($_POST['ordner'], -1), array('/', '\\'))) {
    $_POST['ordner'] = substr($_POST['ordner'], 0, -1);
}

if (stripos($_POST['ordner'], 'C:\\xampp') !== 0) {
    die(sprintf('security: %s is not in %s', $_POST['ordner'], 'C:\\xampp'));
}

// is_dir mkdir begin
if (!is_dir($_POST['ordner'])) {
    mkdir($_POST['ordner']);
}
// is_dir mkdir ende

// clear folder begin: unlink rmdir
$files = glob($_POST['ordner'] . '/*');
foreach ($files as $file) {
    print $file;
    print '<br/>';
    continue;
    if (is_dir($file)) {
        unlinkRecursive($file, true);
    } else {
        unlink($file);
    }
}
// clear folder ende

$version = $_GET['version'];
// begin ftp

$ftpServer = ftp_connect('localhost');
ftp_login($ftpServer, 'newuser', 'wampp');

foreach (ftp_nlist_recursive($ftpServer, '/ftp/'. $_GET['project'] . '/'. $version) as $file) {
    $target = $_POST['ordner'] . str_replace('/ftp/'. $_GET['project'] . '/'. $version, '', $file);
    printf('Downloading %s to %s<br />', $file, $target);
    if (!is_dir(dirname($target))) {
        mkdir(dirname($target));
    }
    ftp_get($ftpServer, $target, $file, FTP_ASCII);
}

// end ftp

function ftp_nlist_recursive($ftp_stream, $path)
{
    $resultFiles   = array();
    $files       = ftp_nlist($ftp_stream, $path);
   
    while(count($files) > 0) {
        
        $file = array_shift($files);
        
        $files2 = ftp_nlist($ftp_stream, $file);
        
        // Datei?
        if (count($files2) == 1
            && $files2[0] == $file
        ) {
            $resultFiles[] = $file;
            continue;
        }
        
        // Ordner!
        $files           = array_unique(array_merge($files, $files2));
        
    }
    return $resultFiles;
}

/**
 * Recursively delete a directory
 *
 * @param string $dir Directory name
 * @param boolean $deleteRootToo Delete specified top-level directory as well
 */
function unlinkRecursive($dir, $deleteRootToo)
{
    if(!$dh = @opendir($dir))
    {
        return;
    }
    while (false !== ($obj = readdir($dh)))
    {
        if($obj == '.' || $obj == '..')
        {
            continue;
        }

        if (!@unlink($dir . '/' . $obj))
        {
            unlinkRecursive($dir.'/'.$obj, true);
        }
    }

    closedir($dh);
   
    if ($deleteRootToo)
    {
        @rmdir($dir);
    }
   
    return;
} 

?>
</div>