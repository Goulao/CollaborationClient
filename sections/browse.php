<div style="background-color: #D9C40D">
<?php
$ftpServer = ftp_connect('localhost');
ftp_login($ftpServer, 'newuser', 'wampp');

if (!isset($_GET['file'])) {
    $path = '/ftp/' . $_GET['project'] . '/'. $_GET['version'] . '/*';
    $ftptest = ftp_nlist_recursive_files($ftpServer, $path);
    print '<ul>';

    foreach ($ftptest as $ftp) {
        $ftp = str_replace('/ftp/'. $_GET['project'].'/'. $_GET['version']. '/', '', $ftp);
        print '<li><a href="?section=browse&project='. $_GET['project'].  '&version=' .$_GET['version'] . '&file='. $ftp. '">'. $ftp .'</a></li> ';
    }
    print'</ul>';
    ftp_close($ftpServer);
    return;
}

ftp_get($ftpServer, __DIR__.'/tmp.tmp', '/ftp/' . $_GET['project'] . '/'. $_GET['version'] . '/' . $_GET['file'], FTP_ASCII);

$content = file_get_contents(__DIR__.'/tmp.tmp');
//$content = htmlspecialchars($content);

$content = highlight_string($content, true);
$content = explode("\r", $content);
print '<div style="font-family: Monospace" >';
foreach($content as $i => $line) {
    print '<span style="color: black">'. str_pad($i, round(count($content)/10/3), '_', STR_PAD_LEFT) . ': | </span>';
    //print '<span style="color: black">'. str_replace(' ', '&nbsp;',str_pad($i, round(count($content)/10/3)), ' ', STR_PAD_LEFT) . ': | </span>';
    print substr($line, 6) . '<br/>';
}
print '</div>';

unlink(__DIR__.'/tmp.tmp');
ftp_close($ftpServer);
?>
</div>
