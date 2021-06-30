<?php
session_start();
date_default_timezone_set('Asia/Manila');

require '../manager/ApplicationManager.php';
require '../application/config/connection.php';

$am = new ApplicationManager();
$today = new DateTime();

$userid = $_SESSION['userid'];
$uname = $_SESSION['username'];
$province = $_POST['province'];
$lgu = $_POST['city_mun'];
$checklists = isset($_POST['chklist_id']) ? $_POST['chklist_id'] : $am->getCertChecklists();
$is_new = $_POST['is_new'];
$establishment = $_POST['establishment'];
$nature = $_POST['nature'];
$address = $_POST['address'];

if ($is_new) {
	$code = $am->generateControlNumber($userid);
	$token = bin2hex(random_bytes(64));
	$res = $am->insertChecklist($code, $establishment, $nature, $address, $userid, $today->format('Y-m-d H:i:s'), $token);
} else {
	$token = $_POST['token'];
	$am->updateChecklist($token, $establishment, $nature, $address, $today->format('Y-m-d H:i:s'));
}

$parent_id = $am->findChecklist($token);
foreach ($checklists as $key => $id) {
	$check_val = $reason = '';
	$ulist_id = isset($_POST['ulist_id'][$key]) ? $_POST['ulist_id'][$key] : '';
	if (isset($_POST['chklist_yes'][$key])) {
		$check_val = 'yes';
	} elseif (isset($_POST['chklist_no'][$key])) {
		$check_val = 'no';
	} elseif (isset($_POST['chklist_na'][$key])) {
		$check_val = 'n/a';
		$reason = $_POST['chklist_reason'][$key];
	}

	$data = [
		'parent_id' => $parent_id,
		'chklist_id' => $is_new ? $key : $ulist_id,
		'user_id' => $userid,
		'answer' => $check_val,
		'reason' => $reason,
		'date_created' => $today->format('Y-m-d H:i:s')
	];

	if ($is_new) {
		$am->insertChecklistEntry($data);
	} else {
		$am->updateChecklistEntry($data);
	}
}

$_SESSION['toastr'] = $am->addFlash('success', 'Successfully updated the checklist.', 'Checklist');

header('location:../wbstapplication.php?ssid='.$token.'&code='.$_SESSION['gcode'].'&scope='.$_SESSION['gscope'].'');
