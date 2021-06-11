<?php
session_start();
date_default_timezone_set('Asia/Manila');

require '../manager/ApplicationManager.php';

$app = new ApplicationManager();
$today = new DateTime();

$userid = $_SESSION['userid'];
$uname = $_SESSION['username'];

$checklists = $_POST['chklist_id'];
$is_new = $_POST['is_new'];


if ($is_new) {
	$app->insertChecklist($userid, $today->format('Y-m-d H:i:s'));
} else {
	$app->updateChecklist($userid, $today->format('Y-m-d H:i:s'));			
}

$parent_id = $app->findChecklist($userid);

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
		$app->insertChecklistEntry($data);			
	} else {
		$app->updateChecklistEntry($data);			
	}
}

$app->setUserApplicationDate($uid , $today->format('Y-m-d H:i:s'));

$_SESSION['toastr'] = addFlash('success', 'Successfully updated the checklist.', 'Checklist');

header('location:../wbstapplication.php');


function addFlash($type, $message, $title) {
	$data = [
        'type'		=> $type, // or 'success' or 'info' or 'warning'
        'title'     => $title,
        'message'	=> $message
    ];

    return $data;
}

