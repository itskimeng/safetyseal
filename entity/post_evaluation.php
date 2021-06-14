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
$status = ApplicationManager::STATUS_APPROVED;

if (!empty($assessments)) {
	foreach ($assessments as $key => $assess) {
		if ($assess == 'failed') {
			$status = ApplicationManager::STATUS_DISAPPROVED;
		}
		$entry = $app->insertAssessment($key, $assess);
	}
}

$notes = $app->getValidationLists($checklist_id );
if (empty($notes)) {
	$app->insertValidationChecklist($checklist_id, $defects, $recommendations, $today->format('Y-m-d H:i:s'));	
} else {
	$app->updateValidationChecklist($checklist_id, $defects, $recommendations, $today->format('Y-m-d H:i:s'));	
}

$ss_no = $app->generateCode($userid);
$app->evaluateChecklist($checklist_id, $status, $ss_no, $today->format('Y-m-d H:i:s'), $userid);


$_SESSION['toastr'] = $app->addFlash('success', 'The application has been set to '.$status.'.', 'Success');





