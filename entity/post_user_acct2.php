<?php
session_start();
date_default_timezone_set('Asia/Manila');

require '../application/config/connection.php';
require '../manager/ApplicationManager.php';	
	
$am = new ApplicationManager();

$params = getParams($_POST);

try {
	if (!empty($params['pw1']) AND !empty($params['pw2'])) {
		pwMatchChecker($params['pw1'], $params['pw2']);
	}	

	$am->postUserAccount($params);

	$_SESSION['toastr'] = $am->addFlash('success', 'User has been updated successfully!', 'Success');
} catch (Exception $e) {
	$_SESSION['toastr'] = $am->addFlash('error', $e->getMessage(), 'Error');
}

header('location:../user/user_profile.php?');


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
	$params = ['fullname'=>$_POST['fullname'], 'email'=>$_POST['email'], 'sub_office'=>$_POST['sub_office'], 'status'=>true, 'id'=>$_GET['id'], 'address'=>$_POST['address'], 'position'=>$_POST['position'], 'mobile_no'=>$_POST['mobile_no'], 'gov_agency'=>$_POST['gov_agency'], 'gov_nature'=>$_POST['gov_nature'], 'province'=>$_POST['province'], 'lgu'=>$_POST['lgu'], 'username'=>$_POST['username'], 'pw1'=>$_POST['password'], 'pw2'=>$_POST['confirm_pw'], 'role'=>'user'];

	return $params;
}






