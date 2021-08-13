<?php
session_start();
date_default_timezone_set('Asia/Manila');

require '../application/config/connection.php';
require '../manager/ApplicationManager.php';	

$am = new ApplicationManager();

// $id = $_GET['id'];
// $fullname = $_POST['fullname'];
// $position = $_POST['position'];
// $province = $_POST['province'];
// $lgu = $_POST['lgu'];
// $address = $_POST['address'];
// $mobile_no = $_POST['mobile_no'];
// $email = $_POST['email'];
// $gov_agency = $_POST['gov_agency'];
// $sub_office = $_POST['sub_office'];
// $gov_nature = $_POST['gov_nature'];
// $username = $_POST['username'];
// $password = $_POST['password'];
// $confirm_pw = $_POST['confirm_pw'];

$params = getParams($_POST);

try {
	if (!empty($params['pw1']) AND !empty($params['pw2'])) {
		pwMatchChecker($params['pw1'], $params['pw2']);
	}	

	$am->postUserAccount($params);
	$_SESSION['toastr'] = $am->addFlash('success', 'User has been updated successfully!', 'Success');
} catch (Exception $e) {
	// echo 'Message: ' .$e->getMessage();
	$_SESSION['toastr'] = $am->addFlash('error', $e->getMessage(), 'Error');
}

header('location:../uac_edit.php?id='.$_GET['id']);


function pwMatchChecker($pw1, $pw2) 
{
	if ($pw1 != $pw2) {
		throw new Exception('Password does not match!');
	}

	if (strlen($pw1) < 6) {
		throw new Exception('Password must be at least 6 characters.');
	}

	return true;
}

function getParams($data) 
{
	if (isset($_POST['user_status'])) {
		$status = true;
	} else {
		$status = false;
	}

	$params = ['fullname'=>$_POST['fullname'], 'email'=>$_POST['email'], 'sub_office'=>$_POST['sub_office'], 'status'=>$status, 'id'=>$_GET['id'], 'address'=>$_POST['address'], 'position'=>$_POST['position'], 'mobile_no'=>$_POST['mobile_no'], 'gov_agency'=>$_POST['gov_agency'], 'gov_nature'=>$_POST['gov_nature'], 'province'=>$_POST['province'], 'lgu'=>$_POST['lgu'], 'username'=>$_POST['username'], 'pw1'=>$_POST['password'], 'pw2'=>$_POST['confirm_pw'], 'role'=>$_POST['role']];

	return $params;
}






