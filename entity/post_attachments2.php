<?php
session_start();
$url_array = explode('?', 'https://'.$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI']);
$url = $url_array[0];

require '../manager/ApplicationManager.php';
require '../application/config/connection.php';

require_once 'google-api-php-client/src/Google_Client.php';
require_once 'google-api-php-client/src/contrib/Google_DriveService.php';


$app = new ApplicationManager();
$client = getGoogleClient($url);

if (isset($_POST['checklist_order'])) {
    $_SESSION['checklist_order'] = $_POST['checklist_order'];    
    $_SESSION['order'] = $app->getChecklistOrder($_SESSION['checklist_order']);    
    $_SESSION['control_no'] = $_POST['control_no'];
    $_SESSION['token'] = $_POST['token_id'];
    $_SESSION['entry_id'] = $_POST['entry_id'];

}
// $checklist_order = $_POST['checklist_order'];
// $order = $app->getChecklistOrder($checklist_order);
// $control_no = $_POST['control_no'];
// $token = $_POST['token_id'];

if (isset($_GET['code'])) {
    $_SESSION['accessToken'] = $client->authenticate($_GET['code']);
    // print_r($_SESSION['accessToken']);
    // die();
    // header('location:'.$url);exit;
    // header('location:../wbstapplication.php?ssid='.$token.'');exit;
} elseif (!isset($_SESSION['accessToken'])) {
    $client->authenticate();
}

$client->setAccessToken($_SESSION['accessToken']);
$finfo = finfo_open(FILEINFO_MIME_TYPE);

//Set the Parent Folder
$parent = new Google_ParentReference(); //previously Google_ParentReference
$parent->setId($_SESSION['order']);

$files = $_FILES['files']['tmp_name'];

foreach ($files as $key => $file_name) {
    $fileTmpPath = $file_name;
    $fileName = $_FILES['files']['name'][$key];
    $fileSize = $_FILES['files']['size'][$key];
    $fileType = $_FILES['files']['type'][$key];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));

    $newFileName = $_SESSION['control_no'].'-'.md5(time() . $fileName) . '.' . $fileExtension;
    $mime_type = finfo_file($finfo, $fileTmpPath);

    // upload file to drive
    $upFile = uploadFileToDrive($client, $fileTmpPath, $parent, $newFileName, $mime_type);
    
    // create entry to db
    insertToEntry($conn, $_SESSION['entry_id'], $upFile);
}

finfo_close($finfo);

$_SESSION['toastr'] = $app->addFlash('success', 'Attachments has been successfully uploaded.', 'Checklist #'.$_SESSION['checklist_order']);

header('location:../wbstapplication.php?ssid='.$_SESSION['token'].'&code='.$_GET['code'].'&scope='.$_GET['scope'].'');exit;


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

    $file_content = array(
        'data' => file_get_contents($path), 
        'mimeType' => $mime_type
    );

    $data = $service->files->insert($file, $file_content);

    return $data;
}

function insertToEntry($conn, $entry, $file) 
{
    $today = new DateTime();
    $today = $today->format('Y-m-d H:i:s');

    $sql = 'INSERT INTO tbl_app_checklist_attachments (entry_id, file_id, file_name, location, date_created) VALUES ("'.$entry.'", "'.$file['id'].'", "'.$file['originalFilename'].'", "'.$file['alternateLink'].'", "'.$today.'")';

    $result = mysqli_query($conn, $sql);

    return $result;
}