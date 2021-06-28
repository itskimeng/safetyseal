<?php
session_start();
date_default_timezone_set('Asia/Manila');

require '../manager/ApplicationManager.php';
require '../application/config/connection.php';

$app = new ApplicationManager();
$today = new DateTime();

$userid = $_SESSION['userid'];
$uname = $_SESSION['username'];
$checklist_id = $_POST['appid'];
$defects = isset($_POST['defects']) ? $_POST['defects'] : '';
$recommendations = isset($_POST['recommendations']) ? $_POST['recommendations'] : '';

$assessments = isset($_POST['assessments']) ? $_POST['assessments'] : '';

if (!empty($assessments)) {
	foreach ($assessments as $key => $assess) {
		$entry = insertAssessment($conn, $key, $assess);
	}
}

$notes = getValidationLists($conn, $checklist_id );
if (empty($notes)) {
	$app->insertValidationChecklist($checklist_id, $defects, $recommendations, $today->format('Y-m-d H:i:s'));	
} else {
	$app->updateValidationChecklist($checklist_id, $defects, $recommendations, $today->format('Y-m-d H:i:s'));	
}

$_SESSION['toastr'] = $app->addFlash('success', 'The application has been updated.', 'Success');

header('location:../admin_application_view.php?appid='.$checklist_id.''.'&ussir='.$userid.'');

function getValidationLists($conn, $appid) {
	$sql = "SELECT * FROM tbl_app_checklist_onsitevalidations where chklist_id = $appid";
	$query = mysqli_query($conn, $sql);
       
    $result = mysqli_fetch_array($query);
	
	return $result;	
}

function insertAssessment($conn, $id, $assessment) {
	$sql = "UPDATE tbl_app_checklist_entry SET assessment = '".$assessment."' WHERE id = ".$id."";
	$query = mysqli_query($conn, $sql);
     
	return $result;	
}



