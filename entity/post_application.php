<?php
session_start();
date_default_timezone_set('Asia/Manila');

require '../manager/ApplicationManager.php';
require '../application/config/connection.php';

$app = new ApplicationManager();
$today = new DateTime();

$userid = $_SESSION['userid'];
$uname = $_SESSION['username'];

$province = $_POST['province'];
$lgu = $_POST['city_mun'];
$name = $_POST['name'];



$checklists = isset($_POST['chklist_id']) ? $_POST['chklist_id'] : $app->getCertChecklists();

$is_new = $_POST['is_new'];
$establishment = $_POST['establishment'];
$nature = $_POST['nature'];
$address = $_POST['address'];


if ($is_new) {
	$code = generateCode($conn, $userid);
	$token = bin2hex(random_bytes(64));
	$res = $app->insertChecklist($code, $establishment, $nature, $address, $userid, $today->format('Y-m-d H:i:s'), $token);
} else {
	$token = $_POST['token'];
	$app->updateChecklist($token, $establishment, $nature, $address, $today->format('Y-m-d H:i:s'));
}

// if (!$is_new) {

$parent_id = $app->findChecklist($token);
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
// }

// $app->setUserApplicationDate($userid , $today->format('Y-m-d H:i:s'));

$_SESSION['toastr'] = addFlash('success', 'Successfully updated the checklist.', 'Checklist');
$notify = $app->notifyApprover($province, $lgu);

foreach ($notify as $key => $data) {
	notifyUser($data['email'], $establishment ,$applicant_name);
}
// header('location:../wbstapplication.php?ssid='.$token.'');
header('location:../wbstapplication.php?ssid=' . $token . '&code=' . $_SESSION['gcode'] . '&scope=' . $_SESSION['gscope'] . '');



// header('location:../wbstapplication.php');

function notifyUser($emailAddress, $est,$applicant_name)
{

	$to = $emailAddress;
	$subject = "Safety Seal Portal";
	$message = '<html><body>';
	$message .= '
			<div class="container>
				<div class="card shadow" style="width:30rem">
					<div class="card-header" style="background-color: #009688; color:#fff;">
						<img src="http://safetyseal.calabarzon.dilg.gov.ph/frontend/images/logo.png" style="width:50px;height:auto;"/>
						<img src="http://safetyseal.calabarzon.dilg.gov.ph/frontend/images/calabarzon.png" style="width:10px;height:auto;/>
					</div>
					<div class="card-body"><br><br>
						<br> Good day Sir/Maam, Mr. '.$applicant_name.' of ' . $est . '</br> submitted an application for safety seal certification
					</div>
				</div>
			</div>
';
	$message .= '</html></body>';
	$headers = "From: safetyseal@calabarzon.dilg.gov.ph \r\n";
	$headers .= "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-800" . "\r\n";
	mail($to, $subject, $message, $headers);
}
function addFlash($type, $message, $title)
{
	$data = [
		'type'		=> $type, // or 'success' or 'info' or 'warning'
		'title'     => $title,
		'message'	=> $message
	];

	return $data;
}

function generateCode($conn, $user)
{
	$ccode = '2021';
	$sql = "SELECT counter, id FROM tbl_config WHERE code = '" . $ccode . "'";
	$query = mysqli_query($conn, $sql);
	$result = mysqli_fetch_array($query);

	// if ($result['counter'] == 0) {
	// 	$cc = $result['counter'] + 1;
	// } else {
	$cc = $result['counter'];
	// }

	if ($cc > 9999) {
		$new_counter = $cc;
	} elseif ($cc > 999) {
		$new_counter = '0' . $cc;
	} elseif ($cc < 10) {
		$new_counter = '0000' . $cc;
	} elseif ($cc < 99) {
		$new_counter = '000' . $cc;
	} elseif ($cc > 99 and $cc <= 999) {
		$new_counter = '00' . $cc;
	}

	$cc = $cc + 1;

	$sql = "UPDATE tbl_config SET counter = '" . $cc . "' WHERE id = " . $result['id'] . "";
	$result = mysqli_query($conn, $sql);

	$control_no = $ccode . '-' . $new_counter;

	return $control_no;
}
