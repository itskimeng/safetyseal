<?php
session_start();
date_default_timezone_set('Asia/Manila');

require '../Model/Connection.php';
require '../manager/ApplicationManager.php';
require '../manager/SafetysealHistoryManager.php';
require '../manager/ApplicationHistoryManager.php';
require '../application/config/connection.php';

$am = new ApplicationManager();
$shm = new SafetysealHistoryManager();
$ahm = new ApplicationHistoryManager();
$today = new DateTime();

$userid = $_SESSION['userid'];
$token = $_GET['ssid'];
$parent = $am->findChecklist($token);

$new_token = bin2hex(random_bytes(64));

$data = [
	'userid' 			=> $userid,
	'lgu' 				=> $parent['lgu'],
	'control_no' 		=> $parent['control_no'],
	'date_registered' 	=> $today->format('Y-m-d H:i:s'),
	'agency' 			=> $parent['agency'],
	'establishment' 	=> $parent['establishment'],
	'nature' 			=> $parent['nature'],
	'address' 			=> $parent['address'],
	'person' 			=> $parent['person'],
	'contact_details' 	=> $parent['contact_details'],
	'token' 			=> $new_token,
	'for_renewal'		=> true,
	'application_type' 	=> ApplicationManager::TYPE_ENCODED,
	'ssn' 				=> $parent['safety_seal_no']
];

$latest_id = insertDetails($conn, $data);

$sql = "UPDATE tbl_app_checklist set status = 'Expired', for_renewal = true WHERE token = '".$token."'";
$result = mysqli_query($conn, $sql);

$action = SafetysealHistoryManager::ACTION_RENEWAL;

$msg = 'Application ' .$parent['control_no'] .' applied for renewal';

$shm->insert(['fid'=>$parent['id'], 'mid'=>SafetysealHistoryManager::MENU_PUBLIC_APPLICATION, 'uid'=>$userid, 'action'=> $action, 'message'=> $msg, 'action_date'=> $today->format('Y-m-d H:i:s')]);


$shm->insert(['fid'=>$latest_id, 'mid'=>SafetysealHistoryManager::MENU_PUBLIC_APPLICATION, 'uid'=>$userid, 'action'=> $action, 'message'=> $msg, 'action_date'=> $today->format('Y-m-d H:i:s')]);

$issued_date = new DateTime($parent['date_approved']);
$validity_date = date('Y-m-d', strtotime("+6 months", strtotime($issued_date->format('Y-m-d'))));
$validity_date = new DateTime($validity_date);

$ahm->insert(['app_id'=>$parent['id'], 'issued_date'=>$issued_date->format('Y-m-d'), 'expiration_date'=>$validity_date->format('Y-m-d'), 'status'=>'Expired', 'date_created'=>$today->format('Y-m-d H:i:s')]);

$ahm->insert(['app_id'=>$parent['id'], 'issued_date'=>null, 'expiration_date'=>null, 'status'=>'For Renewal', 'date_created'=>$today->format('Y-m-d H:i:s')]);

$_SESSION['toastr'] = $am->addFlash('success', 'Successfully applied for renewal.', 'Success');

header('location:../admin_application_edit.php?appid='.$new_token);


function insertDetails($conn, $data) {
	$sql = "INSERT INTO tbl_app_checklist
			SET control_no = '".$data['control_no']."',
			user_id = ".$data['userid'].",
			agency = '".$data['agency']."',
			establishment = '".$data['establishment']."',
			nature = '".$data['nature']."',
			address = '".$data['address']."',
			person = '".$data['person']."',
			contact_details = '".$data['contact_details']."',
			status = 'For Renewal',
			has_consent = true,
			date_created = '".$data['date_registered']."',
			date_proceed = '".$data['date_registered']."',
			receiver_id = '".$data['userid']."',
			date_received = '".$data['date_registered']."',
			token = '".$data['token']."',
			application_type = 'Encoded',
			lgu = '".$data['lgu']."',
			safety_seal_no = '".$data['ssn']."',
			for_renewal = true";

	$result = mysqli_query($conn, $sql);
	$last_id = $conn->insert_id;

    return $last_id;
}