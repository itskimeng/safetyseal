<?php
session_start();
date_default_timezone_set('Asia/Manila');

require '../manager/ApplicationManager.php';
require '../application/config/connection.php';


$app = new ApplicationManager();
$today = new DateTime();

$userid = $_SESSION['userid'];
$uname = $_SESSION['username'];

$checklists = $_POST['chklist_id'];
$is_new = $_POST['is_new'];

$code = generateCode($conn, $userid);

if ($is_new) {
	$app->insertChecklist($code, $userid, $today->format('Y-m-d H:i:s'));
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

function generateCode($conn, $user) 
{
	$sql = "SELECT p.code as pcode, m.code as mcode
	FROM tbl_admin_info u
	LEFT JOIN tbl_province p on p.id = u.PROVINCE
	LEFT JOIN tbl_citymun m on m.id = u.LGU
	WHERE u.ID = ".$user."";

	$query = mysqli_query($conn, $sql);
	$result1 = mysqli_fetch_array($query);

	$ccode = 'R4A-'.$result1['pcode'].'-'.$result1['mcode'];

	$sql = "SELECT counter, id FROM tbl_config WHERE code = '".$ccode."'";
	$query = mysqli_query($conn, $sql);
	$result2 = mysqli_fetch_array($query);

	$cc = $result2['counter'] + 1;

	if ($cc > 999) {
		$new_counter = $cc;
	} elseif ($cc > 99) {
		$new_counter = '00'.$cc;
	} elseif ($cc < 10) {
		$new_counter = '000'.$cc;
	}

	$sql = "UPDATE tbl_config SET counter = '".$new_counter."' WHERE id = ".$result2['id']."";
    $result = mysqli_query($conn, $sql);

    $control_no = $ccode.'-'.$new_counter;
   
	return $control_no;
}

