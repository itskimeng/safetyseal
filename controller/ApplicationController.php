<?php
date_default_timezone_set('Asia/Manila');

if (!empty($_SESSION['userid'])) {
	require 'application/config/connection.php';
	require 'manager/ApplicationManager.php';

	$userid = $_SESSION['userid'];
	$app = new ApplicationManager();
	$today = new DateTime();

	$userinfo = $app->getUsers($userid);
	$appchecklists_edit = $app->getUserChecklistsEntry($userid);
	$is_new = true;
	$today = $today->format('m-d-Y');

	if (!empty($appchecklists_edit)) {
		$appchecklists = $appchecklists_edit;	
		$is_new = false;
	} else {
		$appchecklists = $app->getChecklists();
	}
	
} else {
	header('location:../registration.php');
}
