<?php
session_start();
$url_array = explode('?', 'https://'.$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI']);
$url_array2 = explode('?', 'http://'.$_SERVER ['HTTP_HOST']);

$url = $url_array[0];
$url2 = $url_array2[0];

$client_id = '764156499113-l6peicrrmg9kn0p2bm5u5hhq148fr3bn.apps.googleusercontent.com';
$client_secret = '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';

require '../manager/ApplicationManager.php';
require '../manager/SafetysealHistoryManager.php';
require '../application/config/connection.php';

require_once 'google-api-php-client/src/Google_Client.php';
require_once 'google-api-php-client/src/contrib/Google_DriveService.php';

$app = new ApplicationManager();
$shm = new SafetysealHistoryManager();

$client = getGoogleClient($client_id, $client_secret, $url);
$today = new DateTime();

if (isset($_POST['checklist_order'])) {
    $_SESSION['checklist_order'] = $_POST['checklist_order'];    
    $_SESSION['order'] = $app->getChecklistOrder($_SESSION['checklist_order']);    
    $_SESSION['control_no'] = $_POST['control_no'];
    $_SESSION['token'] = $_POST['token_id'];
    $_SESSION['entry_id'] = $_POST['entry_id'];
    $_SESSION['FILES'] = $_FILES;
}

// print_r($_GET['code']);
// print_r('<br>');
// print_r($_SESSION['gcode']);
// die();

if (isset($_SESSION['access_token'])) {
    $gcode = $_SESSION['gcode'];
    $gscope = $_SESSION['gscope'];
    $_SESSION['gcode'] = '';
    $_SESSION['access_token'] = $client->authenticate($gcode);
    $_SESSION['toastr'] = $app->addFlash('success', 'Please try to reupload the file.', 'Account Verified!');

    $url2 = $url2.'/safetyseal/wbstapplication.php?ssid='.$_SESSION['token'].'&code='.$gcode.'&scope='.$gscope.'';
    // $url2 = $url2.'/wbstapplication.php?ssid='.$_SESSION['token'].'&code='.$_SESSION['gcode'].'&scope='.$_SESSION['gscope'].'';

    header('location: '.$url2);exit;
} elseif (!isset($_SESSION['access_token'])) {
    $client->authenticate();
}

$client->setAccessToken($_SESSION['access_token']);
$finfo = finfo_open(FILEINFO_MIME_TYPE);

//Set the Parent Folder
$parent = new Google_ParentReference(); //previously Google_ParentReference
$parent->setId($_SESSION['order']);

$files = $_SESSION['FILES']['files']['tmp_name'];
$control_no = $_SESSION['control_no'];
$userid = $_SESSION['userid'];
$parent = findID($conn, $_SESSION['entry_id']);
$attachment_count = count($_files);
$file_invalid = false;
$appchecklists = $app->findChecklist($_SESSION['token']);

$table = 'tbl_app_checklist_entry';

if ($appchecklists['for_renewal']) {
    $table = 'tbl_app_checklist_renewal_entry';
}

if (isset($_FILES)) {
    foreach ($_FILES['files']['name'] as $key => $name) {
        $fileTmpPath = $_FILES['files']['tmp_name'][$key];
        $fileName = $name;
        $fileSize = $_FILES['files']['size'][$key];
        $fileType = $_FILES['files']['type'][$key];

        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $newFileName = $_SESSION['checklist_order'].'-'.$_SESSION['control_no'].'-'.md5(time() . $fileName) . '.' . $fileExtension;
        $mime_type = finfo_file($finfo, $fileTmpPath);

        // upload file to drive
        $upFile = uploadFileToDrive($client, $fileTmpPath, $parent, $newFileName, $mime_type);
        
        // create entry to db
        // insertToEntry($conn, $client->getClientId(), $client->getClientSecret(), $_SESSION['entry_id'], $upFile, $mime_type, $appchecklists['for_renewal']);
    }
}

finfo_close($finfo);

$_SESSION['toastr'] = $app->addFlash('success', 'Attachments has been successfully uploaded.', 'Checklist #'.$_SESSION['checklist_order']);

$msg = 'uploaded '.$attachment_count.' attachment to ' .$control_no .' for Checklist #'.$_SESSION['checklist_order'];

$shm->insert(['fid'=>$parent, 'mid'=>SafetysealHistoryManager::MENU_PUBLIC_APPLICATION, 'uid'=>$userid, 'action'=> SafetysealHistoryManager::ACTION_UPDATE, 'message'=> $msg, 'action_date'=> $today->format('Y-m-d H:i:s')]);

header('location:../wbstapplication.php?ssid='.$_SESSION['token'].'&code='.$_SESSION['gcode'].'&scope='.$_SESSION['gscope'].'');exit;



function fileSizeChecker($size) 
{
    $is_large = false;

    if ($size > 50000000) {
        $is_large = true;
    }

    return $is_large;
}

function getGoogleClient($client_id, $client_secret, $url)
{
    $client = new Google_Client();    
    // .v1
    // $client->setClientId('312607959862-4po30giaf5ft6gk4e214nadae33dp8rl.apps.googleusercontent.com');
    // $client->setClientSecret('i0aX5UG17jovoF2aPgqfoGvS');
    // $client->setScopes(array('https://www.googleapis.com/auth/drive.file', 'https://www.googleapis.com/auth/drive.appdata'));
    // .v2
    $client->setClientId($client_id);
    $client->setClientSecret($client_secret);
    $client->setRedirectUri($url);
    $client->setScopes(array('https://www.googleapis.com/auth/drive.file', 'https://www.googleapis.com/auth/drive.appdata'));

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

function insertToEntry($conn, $client_id, $client_secret, $entry, $file, $file_type, $for_renewal) 
{
    $today = new DateTime();
    $today = $today->format('Y-m-d H:i:s');

    if ($for_renewal == 'tbl_app_checklist_attachments') {
        $sql = 'INSERT INTO tbl_app_checklist_attachments (entry_id, file_id, file_name, location, date_created, client_id, client_secret, file_type) VALUES ("'.$entry.'", "'.$file['id'].'", "'.$file['originalFilename'].'", "'.$file['alternateLink'].'", "'.$today.'", "'.$client_id.'", "'.$client_secret.'", "'.$file_type.'")';
    } else {
        $sql = 'INSERT INTO tbl_app_checklist_attachments (renewal_id, file_id, file_name, location, date_created, client_id, client_secret, file_type) VALUES ("'.$entry.'", "'.$file['id'].'", "'.$file['originalFilename'].'", "'.$file['alternateLink'].'", "'.$today.'", "'.$client_id.'", "'.$client_secret.'", "'.$file_type.'")';
    }


    $result = mysqli_query($conn, $sql);

    return $result;
}

function findID($conn, $id)
{
    $sql = "SELECT parent_id FROM tbl_app_checklist_entry WHERE id = ".$id."";
    $query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($query);
        
    return $result['parent_id'];
}