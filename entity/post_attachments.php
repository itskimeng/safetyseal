<?php
session_start();
date_default_timezone_set('Asia/Manila');
$url_array = explode('?', 'http://'.$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI']);
$url = $url_array[0];

require_once 'google-api-php-client/src/Google_Client.php';
require_once 'google-api-php-client/src/contrib/Google_DriveService.php';


if ($_FILES['files']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['files']['tmp_name'])) { 
    
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

    $client->setAccessToken($_SESSION['accessToken']);
    $service = new Google_DriveService($client);
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $file = new Google_DriveFile();

    //Set the Parent Folder
    $parent = new Google_ParentReference(); //previously Google_ParentReference
    $parent->setId('1oh5krpb3k_8bdUNg_JOS-sSSLYlPsWqD');

	$files = $_FILES['files']['tmp_name'];

    foreach ($files as $key => $file_name) {
        // $file_path = $file_name;
        $fileTmpPath = $file_name;
		$fileName = $_FILES['files']['name'][$key];
		$fileSize = $_FILES['files']['size'][$key];
		$fileType = $_FILES['files']['type'][$key];
		$fileNameCmps = explode(".", $fileName);
		$fileExtension = strtolower(end($fileNameCmps));

		$newFileName = md5(time() . $fileName) . '.' . $fileExtension;

        $mime_type = finfo_file($finfo, $fileTmpPath);
        


        $file->setTitle($newFileName);
        $file->setDescription('This is a '.$mime_type.' document');
        $file->setMimeType($mime_type);
        $file->setParents(array($parent));
        
        $file_content = array(
                'data' => file_get_contents($fileTmpPath), 
                'mimeType' => $mime_type
            );

        $service->files->insert($file, $file_content);
    }

    finfo_close($finfo);

}


    header('location:../wbstapplication.php');


