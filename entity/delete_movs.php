<?php
session_start();
$url_array = explode('?', 'https://'.$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI']);
$url = $url_array[0];

require '../Model/Connection.php';    
require '../manager/ApplicationManager.php';
require '../manager/SafetysealHistoryManager.php';

require_once 'google-api-php-client/src/Google_Client.php';
require_once 'google-api-php-client/src/contrib/Google_DriveService.php';

$conn = new Connection();
$client_id = $conn->googleClient;
$client_secret = $conn->googleSecret;

$am = new ApplicationManager();
$shm = new SafetysealHistoryManager();
$today = new DateTime();

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
    $checklist_order = $_POST['checklist_order'];
    $order = $am->getChecklistOrder($checklist_order);
    $control_no = $_POST['control_no'];
    $ssid = $_POST['token_id'];
    $_SESSION['token'] = $_POST['token_id'];
    $entid = $_POST['entry_id'];
    $chklists = $_POST['filename'];
    $userid = $_SESSION['userid'];
    $fid = $am->getParentID($entid);

    $client->setAccessToken($_SESSION['accessToken']);
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $parent = $am->getParentID($entid);
    $attachment_count = count($chklists);

    foreach ($chklists as $key => $list) {
        $caid = $key;
        $entry = $am->getEntryClientID($caid);

        if (!empty($entry)) {
            $client->setClientId($entry['client_id']);
            $client->setClientSecret($entry['client_secret']);
        }

        removeFromGDrive($client, $list);
        $am->removeAttachment($caid);
    }

    finfo_close($finfo);

    $_SESSION['toastr'] = $am->addFlash('success', 'Selected MOVS has been deleted', 'Checklist #'.$checklist_order);

    $msg = 'deleted '.$attachment_count.' attachment from ' .$control_no .' for Checklist #'.$checklist_order;

    $shm->insert(['fid'=>$fid, 'mid'=>SafetysealHistoryManager::MENU_PUBLIC_APPLICATION, 'uid'=>$userid, 'action'=> SafetysealHistoryManager::ACTION_UPDATE, 'message'=> $msg, 'action_date'=> $today->format('Y-m-d H:i:s')]);

    header('location:../wbstapplication.php?form='.$_POST['form'].'&ssid='.$ssid.'&code='.$_SESSION['gcode'].'&scope='.$_SESSION['gscope'].'');exit;
} else {
    $_SESSION['toastr'] = $am->addFlash('success', 'Please try to reupload the movs.', 'Account Verified!');
    header('location:../wbstapplication.php?form='.$_POST['form'].'&ssid='.$_SESSION['ssid'].'&code='.$_SESSION['gcode'].'&scope='.$_SESSION['gscope'].'');exit;
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

function removeFromGDrive($client, $id) 
{
    $service = new Google_DriveService($client); 
    $service->files->delete($id);

    return 0;    
}

