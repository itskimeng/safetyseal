<?php
date_default_timezone_set('Asia/Manila');

// require_once 'application/config/connection.php';
require_once 'Model/Connection.php';	
require_once 'manager/ApplicationManager.php';
	

if (!empty($_SESSION['userid'])) {
	$userid = $_SESSION['userid'];
	$province = $_SESSION['province'];
	$lgu = $_SESSION['city_mun'];

	$app = new ApplicationManager();
	$today = new DateTime();

	$alert_level = $app->getLGULevel($province, $lgu);
	$count_ent = $alert_level >= 2 ? 14 : 9;

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
		$for_renewal = isset($userinfo['for_renewal']) ? true : false;
		$userinfo = $app->getUsers($userid, $token);
		$admininfo = $app->getApproverDetails($province,$lgu);
		$table = 'tbl_app_checklist_entry';
		$valid_request = false;

		$answered_checklist = $app->getAnsweredChecklist($userinfo['acid']);
		if (count($answered_checklist) == $count_ent) {
			$valid_request = true;
		}

		$count_answeredlist = count($answered_checklist);
		$answered_checklist = json_encode($answered_checklist);
		// if (isset($userinfo['for_renewal']) AND $userinfo['for_renewal']) {
		// 	$table = 'tbl_app_checklist_renewal_entry';
		// }

		$appchecklists = $app->getUserChecklistsEntry($token, $table);
		$count_entries = count($appchecklists);
		$appchecklists_attchmnt = $app->getUserChecklistsAttachments($token, $for_renewal);
	}
} else {
	header('location:../registration.php');
}
