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

$checklist_id = $_POST['chklist_id'];
$contact_details= $_POST['contact_details'];
$token = $_POST['token'];
$has_consent = isset($_POST['consent']) ? true : false;

$application = findID($conn, $checklist_id);

$app->proceedChecklist($checklist_id,$contact_details, $has_consent, ApplicationManager::STATUS_FOR_RECEIVING, $today->format('Y-m-d H:i:s'));			
$_SESSION['toastr'] = $app->addFlash('success', 'The application is now being assess.', 'For Approval');

$msg = 'application '.$application['control_no'].' submitted ' .ApplicationManager::STATUS_FOR_RECEIVING;

$shm->insert(['fid'=>$checklist_id, 'mid'=>SafetysealHistoryManager::MENU_PUBLIC_APPLICATION, 'uid'=>$userid, 'action'=> SafetysealHistoryManager::ACTION_UPDATE, 'message'=> $msg, 'action_date'=> $today->format('Y-m-d H:i:s')]);


header('location:../wbstapplication.php?ssid='.$token.'');

function findID($conn, $id) 
{
	$sql = "SELECT id, control_no, status FROM tbl_app_checklist WHERE id = '".$id."'";
	$query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($query);

    return $result;
}


