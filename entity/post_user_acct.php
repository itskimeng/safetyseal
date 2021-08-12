<?php
session_start();
date_default_timezone_set('Asia/Manila');

require '../application/config/connection.php';
require '../manager/ApplicationManager.php';

$id = $_GET['id'];
// $status = $_POST['user_status'];
$fullname = $_POST['fullname'];
$position = $_POST['position'];
$province = $_POST['province'];
$lgu = $_POST['lgu'];
$address = $_POST['address'];
$mobile_no = $_POST['mobile_no'];
$email = $_POST['email'];
$gov_agency = $_POST['gov_agency'];
$sub_office = $_POST['sub_office'];
$establishment = $_POST['establishment'];

if (isset($_POST['user_status'])) {
	$status = true;
} else {
	$status = false;
}

$sql = "UPDATE tbl_admin_info SET CMLGOO_NAME = '".$fullname."', CMLGOO_NAME = '".$fullname."', EMAIL = '".$email."', OFFICE = '".$sub_office."', IS_VERIFIED = '".$status."' WHERE id = $id";
$query = mysqli_query($conn, $sql);

$sql = "UPDATE tbl_userinfo SET ADDRESS = '".$address."', POSITION = '".$position."', MOBILE_NO = '".$mobile_no."', EMAIL_ADDRESS = '".$email."', GOV_AGENCY_NAME = '".$gov_agency."', GOV_ESTB_NAME = '".$establishment."' WHERE id = $id";
$query = mysqli_query($conn, $sql);


header('location:../uac_edit.php?id='.$id);






