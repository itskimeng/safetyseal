<?php
session_start();
$url_array = explode('?', 'https://'.$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI']);
$url = $url_array[0];

require '../Model/Connection.php';
require '../manager/ApplicationManager.php';
require_once 'google-api-php-client/src/Google_Client.php';
require_once 'google-api-php-client/src/contrib/Google_DriveService.php';

$app = new ApplicationManager();
$conn = new Connection();

$client_id = $conn->googleClient;
$client_secret = $conn->googleSecret;

$client = getGoogleClient($client_id, $client_secret, $url);
// $client = getGoogleClient('https://safetyseal.calabarzon.dilg.gov.ph/verification_page.php');

if (isset($_GET['error'])) {
    $_SESSION['toastr'] = $app->addFlash('error', 'System needs an active google account.', 'Account Not Verified!');

    header('location:../admin_application_edit.php?appid='.$_SESSION['sss_id'].'&code=&scope=');exit;
    
} elseif (isset($_GET['code']) AND !empty($_GET['code'])) {
    $_SESSION['gcode'] = $_GET['code'];
    $_SESSION['gscope'] = $_GET['scope'];
    $_SESSION['accessToken'] = $client->authenticate($_GET['code']);
    header('location:'.$url);exit;
} elseif (!isset($_SESSION['accessToken'])) {
    $client->authenticate();
}

if (isset($_POST['token_id'])) {
    $_SESSION['sss_id'] = $_POST['token_id'];
} else {
    $_SESSION['toastr'] = $app->addFlash('success', 'You may now upload the checklist', 'Account Verified!');
}

$client->setAccessToken($_SESSION['accessToken']);



header('location:../admin_application_edit.php?appid='.$_SESSION['sss_id'].'&code=&scope=');exit;

function getGoogleClient($client_id, $client_secret, $url)
{
    $client = new Google_Client();    
    $client->setClientId($client_id);
    $client->setClientSecret($client_secret);
    $client->setRedirectUri($url);
    $client->setScopes(array('https://www.googleapis.com/auth/drive'));

    return $client;
}