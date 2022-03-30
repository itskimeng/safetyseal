<?php
session_start();

require '../Model/Connection.php';    
require '../manager/ApplicationManager.php';
require '../manager/SafetysealHistoryManager.php';

require_once 'google-api-php-client/src/Google_Client.php';
require_once 'google-api-php-client/src/contrib/Google_DriveService.php';

$url_array = explode('?', 'https://'.$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI']);
$url_array2 = explode('?', 'http://'.$_SERVER ['HTTP_HOST']);

$url = $url_array[0];
$url2 = $url_array2[0];

$am = new ApplicationManager();
$shm = new SafetysealHistoryManager();
$conn = new Connection();

$client_id = $conn->googleClient;
$client_secret = $conn->googleSecret;

$client = getGoogleClient($client_id, $client_secret, $url);
$today = new DateTime();


if (isset($_GET['error'])) {
    $_SESSION['toastr'] = $am->addFlash('error', 'System needs an active google account.', 'Account Not Verified!');

    header('location:../wbstapplication.php?ssid='.$_SESSION['ssid'].'&code='.$_SESSION['gcode'].'&scope='.$_SESSION['gscope'].'');exit;
    
} elseif (isset($_GET['code'])) {
    $_SESSION['accessToken'] = $client->authenticate($_GET['code']);
    header('location:'.$url);exit;
} elseif (!isset($_SESSION['accessToken'])) {
    $client->authenticate();
}

if (!isset($_SESSION['ssid'])) {
    $_SESSION['ssid'] = $_POST['token_id'];
}

if (!empty($_POST)) {
    $order = $am->getChecklistOrder($_POST['checklist_order']);    
    $files = $_FILES['files']['tmp_name'];
    $control_no = $_POST['control_no'];
    $entid = $_POST['entry_id'];
    $file_invalid = false;
    $ssid = $_POST['token_id'];
    $table = 'tbl_app_checklist_entry'; //default table
    $userid = $_SESSION['userid'];
    $fid = $am->getParentID($entid);

    $client->setAccessToken($_SESSION['accessToken']);
    $finfo = finfo_open(FILEINFO_MIME_TYPE);

    //Set the Parent Folder
    $parent = new Google_ParentReference(); //previously Google_ParentReference
    $parent->setId($order);

    $attachment_count = count($files);
    $current_checklist = $am->findChecklist($ssid);

    if (isset($_FILES)) {
        foreach ($_FILES['files']['name'] as $key => $name) {
            $fileTmpPath = $_FILES['files']['tmp_name'][$key];
            $fileName = $name;
            $fileSize = $_FILES['files']['size'][$key];
            $fileType = $_FILES['files']['type'][$key];

            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            $newFileName = $_POST['checklist_order'].'-'.$control_no.'-'.md5(time() . $fileName) . '.' . $fileExtension;
            $mime_type = finfo_file($finfo, $fileTmpPath);

            $upFile = uploadFileToDrive($client, $fileTmpPath, $parent, $newFileName, $mime_type); // upload file to drive
            
            $am->insertEntry($client->getClientId(), $client->getClientSecret(), $entid, $upFile, $mime_type, $current_checklist['for_renewal']); // create entry to db
        }
    }

    finfo_close($finfo);

    $_SESSION['toastr'] = $am->addFlash('success', 'Attachments has been successfully uploaded.', 'Checklist #'.$_POST['checklist_order']);

    $msg = 'uploaded '.$attachment_count.' attachment to ' .$control_no .' for Checklist #'.$_POST['checklist_order'];
    
    $shm->insert(['fid'=>$fid, 'mid'=>SafetysealHistoryManager::MENU_PUBLIC_APPLICATION, 'uid'=>$userid, 'action'=> SafetysealHistoryManager::ACTION_UPDATE, 'message'=> $msg, 'action_date'=> $today->format('Y-m-d H:i:s')]);    
    
    header('location:../wbstapplication.php?ssid='.$ssid.'&code='.$_SESSION['gcode'].'&scope='.$_SESSION['gscope'].'');exit;
} else {
    $_SESSION['toastr'] = $am->addFlash('success', 'Please try to reupload the movs.', 'Account Verified!');

    header('location:../wbstapplication.php?ssid='.$_SESSION['ssid'].'&code='.$_SESSION['gcode'].'&scope='.$_SESSION['gscope'].'');exit;
}


function getGoogleClient($client_id, $client_secret, $url)
{
    $client = new Google_Client();    
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

