<?php

require '../Model/Connection.php';
require '../application/config/connection.php';
require '../manager/UserManager.php';
require '../manager/ApplicationManager.php';
require '../manager/ComponentsManager.php';

$app = new UserManager();
$am = new ApplicationManager();
$cm = new ComponentsManager();

$id = $_SESSION['userid'];
$province = $_SESSION['province'];
$lgu = $_SESSION['city_mun'];
$alert_level = $am->getLGULevel($province, $lgu);

if (isset($_GET['form'])|| isset($_GET['create_new'])) {
	if($_GET['form'] == 'create_new' || $_GET['form'] == 1)
	{
		$count_entries = $alert_level >= 2 ? 14 : 9;
	}else{
		$count_entries = $alert_level <= 1 ? 42 : 42;
	}
}else{
	if(isset($_GET['form']))
	{
		$count_entries = $alert_level >= 2 ? 14 : 9;
	}else{
		$count_entries = $alert_level <= 2 ? 42 : 42;
	}
}
echo $count_entries;

$token = isset($_GET['ssid']) ? $_GET['ssid'] : ''; 
$user_est = $app->fetchEstablishments($id, $token);
$user_ssno = '';
if (!empty($user_est[0]['ss_no'])) {
	$user_ssno = $user_est[0]['ss_no'];
}

$has_renewal_entry = $app->getRenewalEntry($user_ssno);	
$application_history = array();
$other_tool = '';
$count_answeredyes = 0;
$is_complete_asessment = $is_complete_attachments = false;

if (isset($user_est[0]['acid'])) {
	$answered_checklist = $am->getAnsweredChecklist($user_est[0]['acid'],$alert_level);
	$count_answeredyes = $am->getAnsweredChecklistYes($user_est[0]['acid']);
	
	$is_complete_asessment = count($answered_checklist) == $count_entries ? true : false;
	$complete_percentage = 0;
	foreach ($answered_checklist as $key => $answer) {
		if ($answer != null) {
			$complete_percentage += 1; 
		}
	}

	$approval_history = $am->getApprovalHistory($user_est[0]['acid']);
	$application_history = $am->getApplicationHistory($user_est[0]['acid']);

	$attachments = $am->getUserChecklistsAttachments($token, false);
	$upload_count = count($am->getUserChecklistsAttachmentsYES($user_est[0]['acid']));

	// $is_complete_attachments = count($attachments) == $count_entries ? true : false;
	$is_complete_attachments = $upload_count == $count_answeredyes ? true : false;

	$complete_percentage = ($complete_percentage / $count_entries) * 100;
	$complete_percentage = number_format($complete_percentage, 0, ',', ' ');

	$other_tool = $am->getContactTracingTool($user_est[0]['acid']);
}

$gcode = isset($_SESSION['gcode']) ? $_SESSION['gcode'] : '';
$gscope = isset($_SESSION['gscope']) ? $_SESSION['gscope'] : '';
$user_info = $app->getUserInfo($id);
$province_opts = $am->getProvinces();
$lgu_opts = $am->getCityMuns($user_info['province_id']);
$government_nature = $cm->getGovtNature();

$has_applied = false;
if (count($user_est) > 0) {
	$has_applied = true;
}

// 1. Application
?>
