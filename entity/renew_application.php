<?php
session_start();
date_default_timezone_set('Asia/Manila');

require '../manager/ApplicationManager.php';
require '../manager/SafetysealHistoryManager.php';
require '../application/config/connection.php';

$am = new ApplicationManager();
$shm = new SafetysealHistoryManager();
$today = new DateTime();

$userid = $_SESSION['userid'];
$token = $_GET['ssid'];
$parent = $am->findChecklist($token);

$checklists = $am->getCertChecklists();

foreach ($checklists as $key => $id) {
	$sql = 'INSERT INTO tbl_app_checklist_renewal_entry (parent_id, chklist_id, date_created) VALUES ("'.$parent['id'].'", "'.$id.'", "'.$today->format('Y-m-d H:i:s').'")';
	$result = mysqli_query($conn, $sql);
}

$sql = "UPDATE tbl_app_checklist set for_renewal = true, status = '".ApplicationManager::STATUS_FOR_RENEWAL."' WHERE token = '".$token."'";

$result = mysqli_query($conn, $sql);

$action = SafetysealHistoryManager::ACTION_RENEWAL;

$msg = 'Application ' .$parent['control_no'] .' applied for renewal';

$shm->insert(['fid'=>$parent['id'], 'mid'=>SafetysealHistoryManager::MENU_PUBLIC_APPLICATION, 'uid'=>$userid, 'action'=> $action, 'message'=> $msg, 'action_date'=> $today->format('Y-m-d H:i:s')]);

$_SESSION['toastr'] = $am->addFlash('success', 'Successfully applied for renewal.', 'Success');

header('location:../wbstapplication.php?ssid='.$token.'&code='.$_SESSION['gcode'].'&scope='.$_SESSION['gscope'].'');
