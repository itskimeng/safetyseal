<?php
session_start();
date_default_timezone_set('Asia/Manila');

require '../Model/Connection.php';
require '../manager/ApplicationManager.php';
require '../manager/SafetysealHistoryManager.php';
require '../manager/ApplicationHistoryManager.php';
require '../application/config/connection.php';

$app = new ApplicationManager();
$shm = new SafetysealHistoryManager();
$ahm = new ApplicationHistoryManager();
$today = new DateTime();

$userid = $_SESSION['userid'];
$uname = $_SESSION['username'];
$checklist_id = $_POST['rtn-chklist_id'];
$remarks = $_POST['remarks'];

$application = findID($conn, $checklist_id);

$app->returnChecklist($checklist_id, ApplicationManager::STATUS_REVOKED, $today->format('Y-m-d H:i:s'), $userid, $remarks);	
$_SESSION['toastr'] = $app->addFlash('danger', 'The application has been revoked.', 'Revoked');

$msg = 'application '.$application['control_no'].' has been returned.';

$msg = $msg.'<br><br><b>Reason:</b> '.$remarks;

$shm->insert(['fid'=>$checklist_id, 'mid'=>SafetysealHistoryManager::MENU_ADMIN_APPLICATION, 'uid'=>$userid, 'action'=> SafetysealHistoryManager::ACTION_REVOKE, 'message'=> $msg, 'action_date'=> $today->format('Y-m-d H:i:s')]);

$valid_until = date('Y-m-d', strtotime("+6 months", strtotime($application['date_approved'])));

$ahm->insert(['app_id'=>$checklist_id, 'issued_date'=>$application['date_approved'], 'expiration_date'=>$valid_until, 'status'=>ApplicationManager::STATUS_REVOKED, 'date_created'=>$today->format('Y-m-d H:i:s')]);

header('location:../admin_application.php');

function findID($conn, $id) 
{
	$sql = "SELECT 
			control_no,
			DATE_FORMAT(date_approved, '%Y-%m-%d') as date_approved
			FROM tbl_app_checklist WHERE id = $id";

	$query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($query);

    return $result;
}