<?php
session_start();
require '../manager/ApplicationManager.php';
require_once 'google-api-php-client/src/Google_Client.php';
require_once 'google-api-php-client/src/contrib/Google_DriveService.php';

$client = new Google_Client();
$client->setClientId('764156499113-l6peicrrmg9kn0p2bm5u5hhq148fr3bn.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('https://localhost:8080/safetyseal/verification_page.php');
$client->setScopes(array('https://www.googleapis.com/auth/drive.file', 'https://www.googleapis.com/auth/drive.appdata'));

if (isset($_POST['token_id'])) {
    $_SESSION['ss_id'] = $_POST['token_id'];
}

if (!isset($_GET['code'])) {
    $auth_url = $client->createAuthUrl();
    header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
} else {
    $client->authenticate($_GET['code']);
    $_SESSION['access_token'] = $client->getAccessToken();
    $redirect_uri = '../verification_page.php';
    header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}
