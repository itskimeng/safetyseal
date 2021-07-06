<?php
session_start();
date_default_timezone_set('Asia/Manila');

require '../application/config/connection.php';
require '../manager/ApplicationManager.php';

$am = new ApplicationManager();

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
	insertDetails($conn, $data);
	$_SESSION['toastr'] = $am->addFlash('success', 'Applicant has been successfully added.', 'Add New');

	header('location:../admin_application_edit.php?appid='.$token);
} else {
	updateDetails($conn, $data);
	$_SESSION['toastr'] = $am->addFlash('success', 'Applicant has been successfully updated.', 'Update');


	echo $token;
}




function insertDetails($conn, $data) {
	$sql = "INSERT INTO tbl_app_checklist(control_no, user_id, agency,establishment, nature, address, person,contact_details, status, has_consent, date_created, date_proceed, receiver_id, date_received, token,application_type, lgu) VALUES('".$data['control_no']."', ".$data['userid'].", '".$data['agency']."', '".$data['establishment']."', '".$data['nature']."', '".$data['address']."', '".$data['person']."', '".$data['contact_details']."', '".$data['status']."', true, '".$data['date_registered']."', '".$data['date_registered']."', '".$data['userid']."', '".$data['date_registered']."', '".$data['token']."', '".$data['application_type']."', '".$data['lgu']."')";

	$result = mysqli_query($conn, $sql);
    return $result;
}

function updateDetails($conn, $data)
{
    $sql = "UPDATE tbl_app_checklist SET control_no = '".$data['control_no']."', agency = '".$data['agency']."', establishment = '".$data['establishment']."', nature = '".$data['nature']."', address = '".$data['address']."', person = '".$data['person']."', contact_details = '".$data['contact_details']."', date_created = '".$data['date_registered']."', lgu = '".$data['lgu']."' WHERE token = '".$data['token']."'";
    $result = mysqli_query($conn, $sql);

    return $result;
}



