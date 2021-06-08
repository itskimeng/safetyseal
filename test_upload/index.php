<?php
session_start();
$url_array = explode('?', 'http://'.$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI']);
$url = $url_array[0];

require_once 'google-api-php-client/src/Google_Client.php';
require_once 'google-api-php-client/src/contrib/Google_DriveService.php';

$client = new Google_Client();
$client->setClientId('312607959862-4po30giaf5ft6gk4e214nadae33dp8rl.apps.googleusercontent.com');
$client->setClientSecret('i0aX5UG17jovoF2aPgqfoGvS');
$client->setRedirectUri($url);
$client->setScopes(array('https://www.googleapis.com/auth/drive'));

if (isset($_GET['code'])) {
    $_SESSION['accessToken'] = $client->authenticate($_GET['code']);
    header('location:'.$url);exit;
} elseif (!isset($_SESSION['accessToken'])) {
    $client->authenticate();
}
$files= array();
$dir = dir('files');
while ($file = $dir->read()) {
    if ($file != '.' && $file != '..') {
        $files[] = $file;
    }
}

$dir->close();
if (!empty($_POST)) {
    $client->setAccessToken($_SESSION['accessToken']);
    $service = new Google_DriveService($client);
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $file = new Google_DriveFile();

    //Set the Parent Folder
    $parent = new Google_ParentReference(); //previously Google_ParentReference
    $parent->setId('1oh5krpb3k_8bdUNg_JOS-sSSLYlPsWqD');


    foreach ($files as $file_name) {
        $file_path = 'files/'.$file_name;
        $mime_type = finfo_file($finfo, $file_path);
        $file->setTitle($file_name);
        $file->setDescription('This is a '.$mime_type.' document');
        $file->setMimeType($mime_type);
        $file->setParents(array($parent));
        
        $file_content = array(
                'data' => file_get_contents($file_path), 
                'mimeType' => $mime_type
            );

        $service->files->insert($file, $file_content);
    }
    // die();
    finfo_close($finfo);
    header('location:'.$url);exit;
}

include 'index.phtml';
