<?php
session_start();
date_default_timezone_set('Asia/Manila');

require '../Model/Connection.php';
require '../manager/ApplicationManager.php';
require '../manager/SafetysealHistoryManager.php';
require '../application/config/connection.php';

$am = new ApplicationManager();
$shm = new SafetysealHistoryManager();
$today = new DateTime();

$userid = $_SESSION['userid'];
$uname = $_SESSION['username'];
$province = $_POST['province'];
$checklist_form = $_POST['checklist'];
$lgu = $_POST['city_mun'];
$alert_level = $am->getLGULevel($province, $lgu);
$checklists = isset($_POST['chklist_id']) ? $_POST['chklist_id'] : $am->getCertChecklists($alert_level,$checklist_form);
$is_new = $_POST['is_new'];
$establishment = $_POST['establishment'];
$nature = $_POST['nature'];
$address = $_POST['address'];
$code = '';

if ($is_new) {
	$code = $am->generateControlNumber($userid);
	$token = bin2hex(random_bytes(64));
	$res = $am->insertChecklist($code, $establishment, $nature, $address, $userid, $today->format('Y-m-d H:i:s'), $token);
} else {
	$token = $_POST['token'];
	$am->updateChecklist($token, $establishment, $nature, $address, $today->format('Y-m-d H:i:s'));
}

$parent = $am->findChecklist($token);
$table = 'tbl_app_checklist_entry';

foreach ($checklists as $key => $id) {
	$check_val = $reason = $other_tool = '';
	$ulist_id = isset($_POST['ulist_id'][$key]) ? $_POST['ulist_id'][$key] : '';
	$other_tool = isset($_POST['other_tool'][$key]) ? $_POST['other_tool'][$key] : '';
	$tracing_tool = isset($_POST['tracing_tool'][$key]) ? $_POST['tracing_tool'][$key] : '';

	if (isset($_POST['chklist_yes'][$key])) {
		$check_val = 'yes';
	} elseif (isset($_POST['chklist_no'][$key])) {
		$check_val = 'no';
	} elseif (isset($_POST['chklist_na'][$key])) {
		$check_val = 'n/a';
		$reason = $_POST['chklist_reason'][$key];
	} elseif (!empty($other_tool)) {
		$check_val = 'other';
	}

	$data = [
		'parent_id' 	=> $parent['id'],
		'chklist_id' 	=> $is_new ? $key : $ulist_id,
		'user_id' 		=> $userid,
		'answer' 		=> $check_val,
		'reason' 		=> $reason,
		'date_created' 	=> $today->format('Y-m-d H:i:s'),
		'other_tool' 	=> $other_tool,
		'tracing_tool' 	=> $tracing_tool
	];

	if ($is_new) {
		$am->insertChecklistEntry($data);
	} else {
		$am->updateChecklistEntry($data, $table);
	}
}

$msg = $is_new ? 'created ' : 'updated ';
$action = $is_new ? SafetysealHistoryManager::ACTION_POST : SafetysealHistoryManager::ACTION_UPDATE;

$msg = $msg .' application ' .$parent['control_no'];

$shm->insert(['fid'=>$parent['id'], 'mid'=>SafetysealHistoryManager::MENU_PUBLIC_APPLICATION, 'uid'=>$userid, 'action'=> $action, 'message'=> $msg, 'action_date'=> $today->format('Y-m-d H:i:s')]);

$_SESSION['toastr'] = $am->addFlash('success', 'Successfully updated the checklist.', 'Checklist');

header('location:../wbstapplication.php?form='.$checklist_form.'&ssid='.$token.'&code=&scope=');
