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

$token = !empty($_POST['ttid']) ? $_POST['ttid'] : $_SESSION['ss_id'];
if (!empty($_POST['ttid'])) {
    $_SESSION['ttid'] = $_POST['ttid'];
}

$gcode = isset($_SESSION['gcode']) ? $_SESSION['gcode'] : '';
$gscope = isset($_SESSION['gsncope']) ? $_SESSION['gsncope'] : '';

if (!empty($_GET['code'])) {
    $_SESSION['accessToken'] = $client->authenticate($_GET['code']);
    $token = $_SESSION['ttid'];
    $_SESSION['ttid'] = '';
    $_SESSION['toastr'] = $app->addFlash('success', 'Session has been configured. Please try to reupload the file.', 'Success');
    header('location:../admin_application_edit.php?appid='.$token.'&code='.$gcode.'&scope='.$gscope.'');exit;
} elseif (!isset($_SESSION['accessToken'])) {
    $client->authenticate();
}

$client->setAccessToken($_SESSION['accessToken']);
$finfo = finfo_open(FILEINFO_MIME_TYPE);

//Set the Parent Folder
$parent = new Google_ParentReference(); //previously Google_ParentReference
$parent->setId('1HkrulaOmeSwmWuAEgyyt82nq_6IcKMf1');

$file = $_FILES['file'];

$fileTmpPath = $file['tmp_name'];
$fileName = $file['name'];
$fileSize = $file['size'];
$fileType = $file['type'];
$fileNameCmps = explode(".", $fileName);
$fileExtension = strtolower(end($fileNameCmps));

$newFileName = md5(time() . $fileName) . '.' . $fileExtension;
$mime_type = finfo_file($finfo, $fileTmpPath);

// upload file to drive
$upFile = uploadFileToDrive($client, $fileTmpPath, $parent, $newFileName, $mime_type);

// create entry to db
insertToEntry($conn, $token, $upFile);

finfo_close($finfo);

$_SESSION['toastr'] = $app->addFlash('success', 'Checklist has been uploaded successfully.', 'Success');

header('location:../admin_application_edit.php?appid='.$token.'&code='.$gcode.'&scope='.$gscope.'');

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

function insertToEntry($conn, $token, $file) 
{
    $today = new DateTime();
    $today = $today->format('Y-m-d H:i:s');

    $sql = 'INSERT INTO tbl_app_checklist_encoded_attachments (parent_id, file_id, file_name, location, date_created) VALUES ("'.$token.'", "'.$file['id'].'", "'.$file['originalFilename'].'", "'.$file['alternateLink'].'", "'.$today.'")';

    $result = mysqli_query($conn, $sql);

    return $result;
}