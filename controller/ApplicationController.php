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
	if(isset($_GET['form']))
	{
		if($_GET['form'] == 'create_newv1' || isset($_GET['create_newv1']))
		{
			
			$count_ent = $alert_level >= 2 ? 42 : 35;
			$optional_chklist = $alert_level <= 1 ? json_encode(array(20,21,53,55,56,57)): 42;
			$app_id = json_encode(array(15,16,18,19,22,23,24,25,26,27,28,29,30,31,32,33,34,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,54));

			
		}else{
			$count_ent = $alert_level >= 2 ? 14 : 9;
			$optional_chklist = $alert_level <= 1 ? json_encode(array(20,21,53,55,56,57)): 42;
			$app_id = json_encode(array(15,16,18,19,22,23,24,25,26,27,28,29,30,31,32,33,34,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,54));

		}
	}

	// $checklist_id = array['']



	$is_new = true;
	$today = $today->format('m-d-Y');

	if (isset($_GET['create_new']) || isset($_GET['create_newv1'])) {
		$userinfo = $app->getApplicantDetails($userid);
		$admininfo = $app->getApproverDetails($province, $lgu);
		$notificationInfo = $app->getMessageInfoStatus($userid);
		$appchecklists = $app->getChecklists();

	
		
	} else {
		$token = $_GET['ssid'];
		$is_new = false;
		$for_renewal = isset($userinfo['for_renewal']) ? true : false;
		$userinfo = $app->getUsers($userid, $token);
		$admininfo = $app->getApproverDetails($province, $lgu);
		$table = 'tbl_app_checklist_entry';
		$valid_request = false;

		$answered_checklist = $app->getAnsweredChecklist($userinfo['acid'],$alert_level);
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
