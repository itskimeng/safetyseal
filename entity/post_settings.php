<?php
session_start();
date_default_timezone_set('Asia/Manila');

require '../Model/Connection.php';
require '../manager/ApplicationManager.php';	
	
$am = new ApplicationManager();

$type = $_POST['type'];
$id = $_POST['idd'];
$alert_level = $_POST['alert_level'];

$data = [
	'type' 			=> $type,
	'id'			=> $id,
	'alert_level' 	=> $alert_level
];

try {
	if ($type == 'province') {
		$am->updateSettingsProvince($id, $alert_level);
	} else if ($type == 'cluster') {
		$am->updateSettingsCluster($id, $alert_level);
	} else {
		$am->updateSettingsLGU($id, $alert_level);
	}	

	$_SESSION['toastr'] = $am->addFlash('success', 'Settings has been updated successfully!', 'Success');
} catch (Exception $e) {
	$_SESSION['toastr'] = $am->addFlash('error', $e->getMessage(), 'Error');
}

header('location:../settings.php');