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

$token = $_GET['ssid'];
$application = deleteApplication($conn, $token);

$_SESSION['toastr'] = $app->addFlash('error', 'Application <b>'.$application['control_no'].'</b> has been successfully deleted.', 'Remove');

$msg = 'deleted application ' .$application['control_no'];

$shm->insert(['fid'=>$application['id'], 'mid'=>SafetysealHistoryManager::MENU_PUBLIC_APPLICATION, 'uid'=>$userid, 'action'=> SafetysealHistoryManager::ACTION_DELETE, 'message'=> $msg, 'action_date'=> $today->format('Y-m-d H:i:s')]);

header('location:../user/application_list.php');

function deleteApplication($conn, $id) 
{
	$sql = "SELECT id, control_no FROM tbl_app_checklist WHERE token = '".$id."'";
	$query = mysqli_query($conn, $sql);
    $result1 = mysqli_fetch_assoc($query);

    $control_no = $result1['control_no'];

    $sql = "SELECT id FROM tbl_app_checklist_entry WHERE parent_id = '".$result1['id']."'";
	$query = mysqli_query($conn, $sql);
    $rows = mysqli_fetch_assoc($query);
	$res = [];
	while ($row = mysqli_fetch_assoc($query)) {
        $res[] = $row['id'];
    }
    
    $ss = implode(', ', $res);

    $sql = "DELETE FROM tbl_app_checklist_attachments WHERE entry_id IN (".$ss.")";
	$result = mysqli_query($conn, $sql);

	$sql = "DELETE FROM tbl_app_checklist_entry WHERE parent_id = '".$result1['id']."'";
	$result = mysqli_query($conn, $sql);

	$sql = "DELETE FROM tbl_app_checklist WHERE token = '".$id."'";
	$query = mysqli_query($conn, $sql);

	return $result1;
}
