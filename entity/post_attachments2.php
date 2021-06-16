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
    
    $checklist_order = $_POST['checklist_order'];
    $order = $app->getChecklistOrder($checklist_order);
    $control_no = $_POST['control_no'];
    $token = $_POST['token_id'];
    $entry_id = $_POST['entry_id'];

    if (!empty($_POST['token_id'])) {
        $_SESSION['ssid'] = $_POST['token_id'];
    }

    if (isset($_POST['code'])) {
        $_SESSION['accessToken'] = $client->authenticate($_POST['code']);
        $_SESSION['toastr'] = $app->addFlash('warn', 'There seems to be a problem in uploading the file.', 'Checklist #'.$checklist_order);
        // header('location:../wbstapplication.php?ssid='.$_SESSION['ssid'].'');exit;
        header('location:'.$url);exit;
    } elseif (!isset($_SESSION['accessToken'])) {
        $client->authenticate();
    }

    $client->setAccessToken($_SESSION['accessToken']);
    $finfo = finfo_open(FILEINFO_MIME_TYPE);

    //Set the Parent Folder
    $parent = getGoogleParentReference($order);

    $files = $_FILES['files']['tmp_name'];

    foreach ($files as $key => $file_name) {
        $fileTmpPath = $file_name;
        $fileName = $_FILES['files']['name'][$key];
        $fileSize = $_FILES['files']['size'][$key];
        $fileType = $_FILES['files']['type'][$key];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $newFileName = $checklist_order.'-'.$control_no.'-'.md5(time() . $fileName) . '.' . $fileExtension;
        $mime_type = finfo_file($finfo, $fileTmpPath);

        // upload file to drive
        $upFile = uploadFileToDrive($client, $fileTmpPath, $parent, $newFileName, $mime_type);
        
        // create entry to db
        insertToEntry($conn, $entry_id, $upFile);
    }

    finfo_close($finfo);

    $_SESSION['toastr'] = $app->addFlash('success', 'Attachments has been successfully uploaded.', 'Checklist #'.$checklist_order);
} else {
    $_SESSION['toastr'] = $app->addFlash('warn', 'Account has been verified. Please reupload the file.', 'Alert');
}

header('location:../wbstapplication.php?ssid='.$_SESSION['ssid'].'');exit;


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

function removeFile($client, $id) 
{
    $service = new Google_DriveService($client); 
    $service->files->delete($id);

    return 0;    
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
