<?php


if (isset($_GET['delete'])
    && isset($_GET['version'])
) {
    $ftpPath = 'ftp/' . $_GET['project']. '/' . $_GET['version'];
    
    ftp_delete_recursive($ftpPath);
    
    $results = $userService->loeschen(
        $_GET['project'],
        $_GET['version']
    );
    if ($results->status == 'ok') {
        print '<span class="erfolgsmeldung">Erfolgreich erfolgreich geloescht</span>';
    }
    print'<br/>';
    print '<a href=?section=pull&project='. $_GET['project']. '>Versionen</a>';
    return;
}

