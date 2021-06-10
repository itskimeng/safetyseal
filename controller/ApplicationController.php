<?php
session_start();
date_default_timezone_set('Asia/Manila');

require 'application/config/connection.php';
require 'manager/ApplicationManager.php';

$userid = $_SESSION['userid'];
$app = new ApplicationManager();
$userinfo = $app->getUsers($userid);

$appchecklists_edit = $app->getUserChecklists($userid);
$is_new = true;

if (!empty($appchecklists_edit)) {
	$appchecklists = $appchecklists_edit;	
	$is_new = false;
} else {
	$appchecklists = $app->getChecklists();
}
