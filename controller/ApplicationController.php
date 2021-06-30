<?php
date_default_timezone_set('Asia/Manila');

if (!empty($_SESSION['userid'])) {
	require 'application/config/connection.php';
	require 'manager/ApplicationManager.php';

	$userid = $_SESSION['userid'];
	$province = $_SESSION['province'];
	$lgu = $_SESSION['city_mun'];

	$app = new ApplicationManager();
	$today = new DateTime();
	
	$is_new = true;
	$today = $today->format('m-d-Y');

	if (isset($_GET['create_new'])) {
		$userinfo = $app->getApplicantDetails($userid);

		$admininfo = $app->getApproverDetails($province,$lgu);

		$notificationInfo = $app->getMessageInfoStatus($userid);
	
	
		$appchecklists = $app->getChecklists();
	} else {
		$token = $_GET['ssid'];
		$is_new = false;
		$userinfo = $app->getUsers($userid, $token);
		$admininfo = $app->getApproverDetails($province,$lgu);

		$appchecklists = $app->getUserChecklistsEntry($token);

		$appchecklists_attchmnt = $app->getUserChecklistsAttachments($token);

	}
	
} else {
	header('location:../registration.php');
}
