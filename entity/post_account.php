<?php
session_start();
date_default_timezone_set('Asia/Manila');

require '../Model/Connection.php';
require '../manager/ApplicationManager.php';	
	
$am = new ApplicationManager();

$data = [
	'userid' 			=> $_SESSION['userid'],
	'fullname' 			=> $_POST['fullname'],
	'position' 			=> $_POST['position'],
	'mobile_no' 		=> $_POST['mobile_no'],
	'email' 			=> $_POST['email'],
	'username' 			=> $_POST['username'],
	'password' 			=> $_POST['password'],
	'confirm_password'	=> $_POST['confirm_password']
];

try {
	if (!empty($_POST['password']) OR !empty($_POST['confirm_password'])) {
		$am->passwordMatchChecker($_POST['password'], $_POST['confirm_password']);
	}

	$am->postUserAccountV2($data);
	$_SESSION['toastr'] = $am->addFlash('success', 'Account has been updated successfully!', 'Success');
} catch (Exception $e) {
	$_SESSION['toastr'] = $am->addFlash('error', $e->getMessage(), 'Error');
}

header('location:../user/account.php?');