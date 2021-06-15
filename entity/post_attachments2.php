<?php
session_start();
$url_array = explode('?', 'https://'.$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI']);
$url = $url_array[0];

require '../manager/ApplicationManager.php';
require_once 'google-api-php-client/src/Google_Client.php';
require_once 'google-api-php-client/src/contrib/Google_DriveService.php';

$app = new ApplicationManager();
$client = getGoogleClient($url);

$checklist_order = $_POST['checklist_order'];
$order = $app->getChecklistOrder($checklist_order);
$control_no = $_POST['control_no'];
$token = $_POST['token_id'];

if (isset($_GET['code'])) {
    $_SESSION['accessToken'] = $client->authenticate($_GET['code']);
    header('location:'.$url);exit;
} elseif (!isset($_SESSION['accessToken'])) {
    $client->authenticate();
}

$client->setAccessToken($_SESSION['accessToken']);
$finfo = finfo_open(FILEINFO_MIME_TYPE);

//Set the Parent Folder
$parent = new Google_ParentReference(); //previously Google_ParentReference
$parent->setId($order);

$files = $_FILES['files']['tmp_name'];

foreach ($files as $key => $file_name) {
    $fileTmpPath = $file_name;
    $fileName = $_FILES['files']['name'][$key];
    $fileSize = $_FILES['files']['size'][$key];
    $fileType = $_FILES['files']['type'][$key];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));

    $newFileName = $control_no.'-'.md5(time() . $fileName) . '.' . $fileExtension;
    $mime_type = finfo_file($finfo, $fileTmpPath);

    uploadFileToDrive($client, $fileTmpPath, $parent, $newFileName, $mime_type);
    
}

finfo_close($finfo);

$_SESSION['toastr'] = $app->addFlash('success', 'Attachments has been successfully uploaded.', 'Checklist #'.$checklist_order);

header('location:../wbstapplication.php?ssid='.$token.'');exit;


function getGoogleClient($url)
{
    $client = new Google_Client();    
    $client->setClientId('312607959862-4po30giaf5ft6gk4e214nadae33dp8rl.apps.googleusercontent.com');
    $client->setClientSecret('i0aX5UG17jovoF2aPgqfoGvS');
    $client->setRedirectUri($url);
    $client->setScopes(array('https://www.googleapis.com/auth/drive'));

    return $client;
}

function uploadFileToDrive($client, $path, $parent, $filename, $mime_type)
{
    $service = new Google_DriveService($client);  
    $file = new Google_DriveFile();

    $file->setTitle($filename);
    $file->setDescription('This is a '.$mime_type.' document');
    $file->setMimeType($mime_type);
    $file->setParents(array($parent));
    $file->setAlternateLink('adadadadadasdasdasdasdasdasd');

    $file_content = array(
        'data' => file_get_contents($path), 
        'mimeType' => $mime_type
    );

    $service->files->insert($file, $file_content);    
}

function get_files_and_folders($client)
{
    $service = new Google_DriveService($client);

    $parameters['q'] = "mimeType='application/vnd.google-apps.folder' and 'root' in parents and trashed=false";
    print_r($service->files->get('1ZzfOg9Lhem47BDEr8VdfL07hlfmEok9F'));
    die();
    $files = $service->files->listFiles($parameters);
    
    foreach( $files as $k => $file ) {
        print_r($file);
        // foreach($file as $ii => $ff) {
        //     echo $ff['title'];
        //     echo "<br>";
        //     echo $ff['alternateLink'];
        //     echo "<br>";
        // }   
    }

    die();
    
}
