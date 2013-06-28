<?php
function ftp_delete_recursive($path, $ftpServer = null)
{
    $mustClose = false;
    
    if (!is_resource($ftpServer)) {
        $mustClose = true;
        $ftpServer = ftp_connect('localhost');
        ftp_login($ftpServer, 'newuser', 'wampp');
    }
    
    if (ftp_nlist($ftpServer, $path) !== false) {
        foreach (ftp_nlist_recursive_files($ftpServer, $path) as $file) {
            // lösche datei
            ftp_delete($ftpServer, $file);
            print $file . ' gelöscht<br />';
        }
        foreach (ftp_nlist_recursive_folders($ftpServer, $path) as $file) {
            // lösche ordner
            ftp_rmdir($ftpServer, $file);
            print $file . ' gelöscht<br />';
        }
        if (!ftp_rmdir($ftpServer, $path)) {
            ftp_close($ftpServer);
            die('Konnte nicht löschen');
        }
    }
    
    if ($mustClose) {
        ftp_close($ftpServer);
    }
}

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