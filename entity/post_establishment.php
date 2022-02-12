<?php
session_start();
date_default_timezone_set('Asia/Manila');

require '../Model/Connection.php';
require '../manager/ApplicationManager.php';	
	
$am = new ApplicationManager();

$data = [
	'userid' 		=> $_SESSION['userid'],
	'gov_agency' 	=> $_POST['gov_agency'],
	'sub_office' 	=> $_POST['sub_office'],
	'gov_nature' 	=> $_POST['gov_nature'],
	'gov_address' 	=> $_POST['address'],
	'gov_province' 	=> $_POST['province'],
	'gov_lgu' 		=> $_POST['lgu']
];

try {
	$am->postUserEstablishment($data);
	$_SESSION['toastr'] = $am->addFlash('success', 'Establishment has been updated successfully!', 'Success');
} catch (Exception $e) {
	$_SESSION['toastr'] = $am->addFlash('error', $e->getMessage(), 'Error');
}

header('location:../user/establishment.php?');