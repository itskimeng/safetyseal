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
$checklist_id = $_POST['rtn-chklist_id'];
$remarks = $_POST['remarks'];

$application = findID($conn, $checklist_id);

$app->returnChecklist($checklist_id, ApplicationManager::STATUS_RETURNED, $today->format('Y-m-d H:i:s'), $userid, $remarks);	
$_SESSION['toastr'] = $app->addFlash('success', 'The application has been returned.', 'Returned');

$msg = 'application '.$application['control_no'].' has been returned: '.$remarks;

$shm->insert(['fid'=>$checklist_id, 'mid'=>SafetysealHistoryManager::MENU_ADMIN_APPLICATION, 'uid'=>$userid, 'action'=> SafetysealHistoryManager::ACTION_RETURN, 'message'=> $msg, 'action_date'=> $today->format('Y-m-d H:i:s')]);

header('location:../admin_application.php');

function findID($conn, $id) 
{
	$sql = "SELECT id, control_no, status FROM tbl_app_checklist WHERE id = '".$id."'";
	$query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($query);

    return $result;
}