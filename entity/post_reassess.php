<?php
session_start();
date_default_timezone_set('Asia/Manila');

require '../Model/Connection.php';
require '../manager/ApplicationManager.php';
require '../manager/SafetysealHistoryManager.php';
require '../application/config/connection.php';

$app = new ApplicationManager();
$shm = new SafetysealHistoryManager();
$today = new DateTime();

$userid = $_SESSION['userid'];
$uname = $_SESSION['username'];
$act_stat = SafetysealHistoryManager::ACTION_REASSESS;

$token = $_GET['ssid'];
$status = $_GET['stt'] == 'FA' ? ApplicationManager::STATUS_FOR_REASSESSMENT: $_GET['stt'];

$application = findID($conn, $token);
$app->reassessChecklist($userid, $token, $status, $today->format('Y-m-d H:i:s'));			
$_SESSION['toastr'] = $app->addFlash('success', 'The application is now being assess.', 'For Reassessment');

if ($application['status'] == ApplicationManager::STATUS_REASSESS) {
	$msg = 'application '.$application['control_no'].' submitted ' .ApplicationManager::STATUS_FOR_REASSESSMENT;
	$act_stat = 'submitted';
} else {
	$msg = 'reassesed application ' .$application['control_no'];
}

$shm->insert(['fid'=>$application['id'], 'mid'=>SafetysealHistoryManager::MENU_PUBLIC_APPLICATION, 'uid'=>$userid, 'action'=> $act_stat, 'message'=> $msg, 'action_date'=> $today->format('Y-m-d H:i:s')]);

header('location:../wbstapplication.php?ssid='.$token.'&code='.$_SESSION['gcode'].'&scope='.$_SESSION['gscope'].'');


function findID($conn, $id) 
{
	$sql = "SELECT id, control_no, status FROM tbl_app_checklist WHERE token = '".$id."'";
	$query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($query);

    return $result;
}