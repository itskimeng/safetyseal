<?php
session_start();
date_default_timezone_set('Asia/Manila');

require '../Model/Connection.php';
require '../application/config/connection.php';
require '../manager/SafetysealHistoryManager.php';
require '../manager/ApplicationHistoryManager.php';
require '../manager/ApplicationManager.php';

$am = new ApplicationManager();
$shm = new SafetysealHistoryManager();
$ahm = new ApplicationHistoryManager();

$userid = $_SESSION['userid'];
$control_no = $_POST['control_no'];
$date_registered = $_POST['date_registered'];
$agency = $_POST['agency'];
$establishment = $_POST['establishment'];
$nature = $_POST['nature'];
$address = $_POST['address'];
$person = $_POST['person'];
$contact_details = $_POST['contact_details'];
$token = !empty($_POST['token_id']) ? $_POST['token_id'] : bin2hex(random_bytes(64));
$today = new DateTime();
$is_new = $_POST['is_new'];
$dd = new DateTime($date_registered);
$lgu = isset($_POST['lgu']) ? $_POST['lgu'] : $_SESSION['city_mun'];
$ssid = isset($_POST['issid']) ? $_POST['issid'] : ''; 

$data = [
	'userid' => $userid,
	'lgu' => $lgu,
	'control_no' => $control_no,
	'date_registered' => $dd->format('Y-m-d H:i:s'),
	'agency' => $agency,
	'establishment' => $establishment,
	'nature' => $nature,
	'address' => $address,
	'person' => $person,
	'contact_details' => $contact_details,
	'token' => $token,
	'status' => ApplicationManager::STATUS_DRAFT,
	'application_type' => ApplicationManager::TYPE_ENCODED
];

if ($is_new) {
	$latest_id = insertDetails($conn, $data);
	$_SESSION['toastr'] = $am->addFlash('success', 'Applicant has been successfully added.', 'Add New');

	$msg = 'created new application '.$data['control_no'];
	
	$shm->insert(['fid'=>$latest_id, 'mid'=>SafetysealHistoryManager::MENU_PUBLIC_APPLICATION, 'uid'=>$userid, 'action'=> $action, 'message'=> $msg, 'action_date'=> $today->format('Y-m-d H:i:s')]);

	header('location:../admin_application_edit.php?appid='.$token);
} else {
	updateDetails($conn, $data);
	$_SESSION['toastr'] = $am->addFlash('success', 'Applicant has been successfully updated.', 'Update');

	$msg = 'updated application '.$data['control_no'];
	
	$shm->insert(['fid'=>$ssid, 'mid'=>SafetysealHistoryManager::MENU_PUBLIC_APPLICATION, 'uid'=>$userid, 'action'=> 'update', 'message'=> $msg, 'action_date'=> $today->format('Y-m-d H:i:s')]);

	echo $token;
}




function insertDetails($conn, $data) {
	$sql = "INSERT INTO tbl_app_checklist(control_no, user_id, agency,establishment, nature, address, person,contact_details, status, has_consent, date_created, date_proceed, receiver_id, date_received, token,application_type, lgu) VALUES('".$data['control_no']."', ".$data['userid'].", '".$data['agency']."', '".$data['establishment']."', '".$data['nature']."', '".$data['address']."', '".$data['person']."', '".$data['contact_details']."', '".$data['status']."', true, '".$data['date_registered']."', '".$data['date_registered']."', '".$data['userid']."', '".$data['date_registered']."', '".$data['token']."', '".$data['application_type']."', '".$data['lgu']."')";

	$result = mysqli_query($conn, $sql);
	$last_id = $conn->insert_id;
    return $last_id;
}

function updateDetails($conn, $data)
{
    $sql = "UPDATE tbl_app_checklist SET control_no = '".$data['control_no']."', agency = '".$data['agency']."', establishment = '".$data['establishment']."', nature = '".$data['nature']."', address = '".$data['address']."', person = '".$data['person']."', contact_details = '".$data['contact_details']."', date_created = '".$data['date_registered']."', lgu = '".$data['lgu']."' WHERE token = '".$data['token']."'";
    $result = mysqli_query($conn, $sql);

    return $result;
}



