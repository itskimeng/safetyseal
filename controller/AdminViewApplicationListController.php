<?php
date_default_timezone_set('Asia/Manila');

require 'Model/Connection.php';
require 'application/config/connection.php';
require 'manager/ApplicationManager.php';
require 'manager/UserManager.php';

$app = new ApplicationManager();
$user = new UserManager();

$userid = isset($_GET['userid']) ? $_GET['userid'] : $_GET['person'];
$type = $_GET['type'];

if ($type == 'Applied') {
	$user = $user->getUserInfo($userid);
	$data = $app->getAllChecklist($userid);
} else {
	$user = $app->getAllChecklist(null,$userid);
	$user = $user[0];
	$data = $app->getAllChecklist(null,$userid);
}