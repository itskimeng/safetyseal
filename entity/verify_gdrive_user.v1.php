<?php
session_start();
$url_array = explode('?', 'https://'.$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI']);
$url = $url_array[0];

require '../manager/ApplicationManager.php';
require_once 'google-api-php-client/src/Google_Client.php';
require_once 'google-api-php-client/src/contrib/Google_DriveService.php';

$app = new ApplicationManager();
$client = getGoogleClient('https://localhost:8080/safetyseal/verification_page.php');
// $client = getGoogleClient('https://safetyseal.calabarzon.dilg.gov.ph/verification_page.php');


if (isset($_POST['token_id'])) {
	$_SESSION['ss_id'] = $_POST['token_id'];
}

if (isset($_GET['code'])) {
    $_SESSION['accessToken'] = $client->authenticate($_GET['code']);
    header('location:'.$url);exit;
    // header('location:../wbstapplication.php?ssid='.$token.'');exit;
} elseif (!isset($_SESSION['accessToken'])) {
    $client->authenticate();
}

$client->setAccessToken($_SESSION['accessToken']);

$_SESSION['toastr'] = $app->addFlash('success', 'Attachments has been successfully uploaded.', 'Checklist #');

header('location:../verification_page.php');exit;

function getGoogleClient($url)
{
    $client = new Google_Client();    
    // $client->setClientId('312607959862-4po30giaf5ft6gk4e214nadae33dp8rl.apps.googleusercontent.com');
    // $client->setClientSecret('i0aX5UG17jovoF2aPgqfoGvS');

    $client->setClientId('341602273527-imk5ch44h14llin461q3qf286p0qe3te.apps.googleusercontent.com');
    $client->setClientSecret('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');

    $client->setRedirectUri($url);
    // $client->setScopes(array('https://www.googleapis.com/auth/drive'));
    $client->setScopes(array('https://www.googleapis.com/auth/drive.file', 'https://www.googleapis.com/auth/drive.appdata'));

    return $client;
}
