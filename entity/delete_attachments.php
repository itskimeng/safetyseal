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

$checklist_order = $_POST['checklist_order'];
$order = $app->getChecklistOrder($checklist_order);
$control_no = $_POST['control_no'];
$token = $_POST['token_id'];
$entry_id = $_POST['entry_id'];
$chklists = $_POST['chklists'];

if (!empty($_POST['token_id'])) {
    $_SESSION['ssid'] = $_POST['token_id'];
}

if (isset($_POST['code'])) {
    $_SESSION['accessToken'] = $client->authenticate($_POST['code']);
    $_SESSION['toastr'] = $app->addFlash('warning', 'There seems to be a problem in uploading the file.', 'Checklist #'.$checklist_order);
    header('location:../wbstapplication.php?ssid='.$_SESSION['ssid'].'');exit;
} elseif (!isset($_SESSION['accessToken'])) {
    $client->authenticate();
}

$client->setAccessToken($_SESSION['accessToken']);
$finfo = finfo_open(FILEINFO_MIME_TYPE);


foreach ($chklists as $key => $list) {
    $idd = $_POST['att_id'][$key];
    removeFromGDrive($client, $idd);
    removeFromDB($conn, $key);
}

finfo_close($finfo);

$_SESSION['toastr'] = $app->addFlash('success', 'Selected attachment has been deleted', 'Checklist #'.$checklist_order);

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
