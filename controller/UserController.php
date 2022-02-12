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
	$answered_checklist = $am->getAnsweredChecklist($user_est[0]['acid']);
	$count_answeredyes = $am->getAnsweredChecklistYes($user_est[0]['acid']);
	
	$is_complete_asessment = count($answered_checklist) == 14 ? true : false;
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

	// $is_complete_attachments = count($attachments) == 14 ? true : false;
	$is_complete_attachments = $upload_count == $count_answeredyes ? true : false;

	$complete_percentage = ($complete_percentage / 14) * 100;
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
?>
