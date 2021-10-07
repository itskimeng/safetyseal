<?php
session_start();
date_default_timezone_set('Asia/Manila');

require '../manager/ApplicationManager.php';
require '../manager/SafetysealHistoryManager.php';
require '../application/config/connection.php';

$app = new ApplicationManager();
$shm = new SafetysealHistoryManager();
$today = new DateTime();

$userid = $_SESSION['userid'];
$uname = $_SESSION['username'];
$checklist_id = $_POST['appid'];
$defects = isset($_POST['defects']) ? $_POST['defects'] : '';
$recommendations = isset($_POST['recommendations']) ? $_POST['recommendations'] : '';

$assessments = isset($_POST['assessments']) ? $_POST['assessments'] : '';
$pnp_remarks = isset($_POST['pnp_remarks']) ? $_POST['pnp_remarks'] : '';
$bfp_remarks = isset($_POST['bfp_remarks']) ? $_POST['bfp_remarks'] : '';

$application = findID($conn, $checklist_id);

if (!empty($assessments)) {
	foreach ($assessments as $key => $assessment) {
		$entry = insertAssessment($conn, $key, $assessment);
	}
}

// if PNP
if (!empty($pnp_remarks)) {
	foreach ($pnp_remarks as $key => $remark) {
		if (!empty($remark)) {
			$entry = insertRemarks($conn, $key, 'pnp', $remark);
		}
	}
}

// if BFP
if (!empty($bfp_remarks)) {
	foreach ($bfp_remarks as $key => $remark) {
		if (!empty($remark)) {
			$entry = insertRemarks($conn, $key, 'bfp', $remark);
		}
	}
}

$notes = getValidationLists($conn, $checklist_id );
if (empty($notes)) {
	$app->insertValidationChecklist($checklist_id, $defects, $recommendations, $today->format('Y-m-d H:i:s'));	
} else {
	$app->updateValidationChecklist($checklist_id, $defects, $recommendations, $today->format('Y-m-d H:i:s'));	
}

$_SESSION['toastr'] = $app->addFlash('success', 'The application has been updated.', 'Success');

$msg = 'updated application ' .$application['control_no'];

$shm->insert(['fid'=>$checklist_id, 'mid'=>SafetysealHistoryManager::MENU_ADMIN_APPLICATION, 'uid'=>$userid, 'action'=> SafetysealHistoryManager::ACTION_UPDATE, 'message'=> $msg, 'action_date'=> $today->format('Y-m-d H:i:s')]);

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

function insertRemarks($conn, $id, $prefix, $remarks) {
	$sql = "UPDATE tbl_app_checklist_entry SET ".$prefix."_remarks = '".$remarks."' WHERE id = ".$id."";
	$query = mysqli_query($conn, $sql);
     
	return $result;	
}

function findID($conn, $id) 
{
	$sql = "SELECT id, control_no, status FROM tbl_app_checklist WHERE id = '".$id."'";
	$query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($query);

    return $result;
}


