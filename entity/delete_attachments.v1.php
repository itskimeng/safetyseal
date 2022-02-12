<?php
session_start();
$url_array = explode('?', 'https://'.$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI']);
$url_array2 = explode('?', 'http://'.$_SERVER ['HTTP_HOST']);

$url = $url_array[0];
$url2 = $url_array2[0];

$client_id = '312607959862-4po30giaf5ft6gk4e214nadae33dp8rl.apps.googleusercontent.com';
$client_secret = 'i0aX5UG17jovoF2aPgqfoGvS';

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
    $checklist_order = $_POST['checklist_order'];
    $order = $app->getChecklistOrder($checklist_order);
    $control_no = $_POST['control_no'];
    $token = $_POST['token_id'];
    $_SESSION['token'] = $_POST['token_id'];
    $entry_id = $_POST['entry_id'];
    $chklists = $_POST['chklists'];
}

if (!empty($_POST['token_id'])) {
    $_SESSION['ssid'] = $_POST['token_id'];
}

if (isset($_GET['code'])) {
    $_SESSION['accessToken'] = $client->authenticate($_POST['code']);
    $_SESSION['toastr'] = $app->addFlash('success', 'Please try again.', 'Access Granted');
    
    $url2 = $url2.'/safetyseal/wbstapplication.php?ssid='.$_SESSION['token'].'&code='.$_SESSION['gcode'].'&scope='.$_SESSION['gscope'].'';
    header('location: '.$url2);exit;
} elseif (!isset($_SESSION['accessToken'])) {
    $client->authenticate();
}

$client->setAccessToken($_SESSION['accessToken']);
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$control_no = $_SESSION['control_no'];
$userid = $_SESSION['userid'];
$parent = findID($conn, $_SESSION['entry_id']);
$attachment_count = count($chklists);

foreach ($chklists as $key => $list) {
    $idd = $_POST['att_id'][$key];
    $ent_client = getEntryClientID($conn, $key);

    if (!empty($ent_client)) {
        $client->setClientId($ent_client['client_id']);
        $client->setClientSecret($ent_client['client_secret']);
    }

    removeFromGDrive($client, $idd);
    removeFromDB($conn, $key);
}

finfo_close($finfo);

$_SESSION['toastr'] = $app->addFlash('success', 'Selected attachment has been deleted', 'Checklist #'.$checklist_order);

$msg = 'deleted '.$attachment_count.' attachment from ' .$control_no .' for Checklist #'.$_SESSION['checklist_order'];

$shm->insert(['fid'=>$parent, 'mid'=>SafetysealHistoryManager::MENU_PUBLIC_APPLICATION, 'uid'=>$userid, 'action'=> SafetysealHistoryManager::ACTION_UPDATE, 'message'=> $msg, 'action_date'=> $today->format('Y-m-d H:i:s')]);


// header('location:../wbstapplication.php?ssid='.$token.'');exit;
header('location:../wbstapplication.php?ssid='.$token.'&code='.$_SESSION['gcode'].'&scope='.$_SESSION['gscope'].'');exit;


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

function removeFromGDrive($client, $id) 
{
    $service = new Google_DriveService($client); 
    $service->files->delete($id);

    return 0;    
}

function removeFromDB($conn, $id) 
{
    $sql = 'DELETE FROM tbl_app_checklist_attachments WHERE id = '.$id.'';

    $result = mysqli_query($conn, $sql);

    return $result;   
}

function retrieveAllFiles($service) {
  $result = array();
  $pageToken = NULL;

  do {
    try {
      $parameters = array();
      if ($pageToken) {
        $parameters['pageToken'] = $pageToken;
      }
      $files = $service->files->listFiles($parameters);
      // print_r($files);
      // die();

      // $result = array_merge($result, $files->getItems());
      $pageToken = $files->getNextPageToken();
    } catch (Exception $e) {
      print "An error occurred: " . $e->getMessage();
      $pageToken = NULL;
    }
  } while ($pageToken);
  return $result;
}

function getGoogleParentReference($order)
{
    $parent = new Google_ParentReference(); //previously Google_ParentReference
    $parent->setId($order);   

    return $parent;
}

function insertToEntry($conn, $entry, $file) 
{
    $today = new DateTime();
    $today = $today->format('Y-m-d H:i:s');

    $sql = 'INSERT INTO tbl_app_checklist_attachments (entry_id, file_id, file_name, location, date_created) VALUES ("'.$entry.'", "'.$file['id'].'", "'.$file['originalFilename'].'", "'.$file['alternateLink'].'", "'.$today.'")';

    $result = mysqli_query($conn, $sql);

    return $result;
}

function getEntryClientID($conn, $id) 
{
    $sql = "SELECT client_id, client_secret FROM tbl_app_checklist_attachments WHERE id = $id";
    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($query);

    return $row;
}

function findID($conn, $id)
{
    $sql = "SELECT parent_id FROM tbl_app_checklist_entry WHERE id = ".$id."";
    $query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($query);
        
    return $result['parent_id'];
}
