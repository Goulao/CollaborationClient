<?php

   //übersetzung zum loeschen für die Versionen 
if (isset($_GET['delete'])
    
) { 
    $results = $userService->project_loeschen(
        $_GET['project']
    );
    if ($results->status == 'ok') {
        print '<u style="color:#006600">Erfolgreich erfolgreich geloescht</u>';
    }
    $ftpPath = 'ftp/' . $_GET['project'];
    
    $ftpServer = ftp_connect('localhost');
    ftp_login($ftpServer, 'newuser', 'wampp');
    foreach (ftp_nlist_recursive_files($ftpServer, $ftpPath) as $file) {
        // lösche datei
        ftp_delete($ftpServer, $file);
        print $file . ' gelöscht<br />';
    }
    foreach (ftp_nlist_recursive_folders($ftpServer, $ftpPath) as $file) {
        // lösche ordner
        ftp_rmdir($ftpServer, $file);
        print $file . ' gelöscht<br />';
    }
    if (!ftp_rmdir($ftpServer, $ftpPath)) {
        ftp_close($ftpServer);
        die('Konnte nicht löschen');
    }
    ftp_close($ftpServer);
    
    $results = $userService->loeschen_test(
        $_GET['project']
       
    );
    if ($results->status == 'ok') {
        print '<u style="color:#006600">Erfolgreich erfolgreich geloescht</u>';
    }
    print'<br/>';
    print '<a href=?section=pull&project='. $_GET['project']. '>Versionen</a>';
    return;
}
/*
function ftp_nlist_recursive_files($ftp_stream, $path)
{
    $resultFiles = array();
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
        $files = array_unique(array_merge($files, $files2));        
    }
    return $resultFiles;
}
function ftp_nlist_recursive_folders($ftp_stream, $path)
{
    $resultFiles = array();
    $files       = ftp_nlist($ftp_stream, $path);
    
    while(count($files) > 0) {
        
        $file = array_shift($files);
        
        $files2 = ftp_nlist($ftp_stream, $file);
        
        // Datei?
        if (count($files2) == 1
            && $files2[0] == $file
        ) {
            continue;
        }
        
        // Ordner!        
        $resultFiles[] = $file;
        $files = array_unique(array_merge($files, $files2));        
    }
    return array_reverse($resultFiles);
}

    */


?>
