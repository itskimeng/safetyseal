<?php
session_start();
date_default_timezone_set('Asia/Manila');

require '../manager/ApplicationManager.php';
require '../application/config/connection.php';

$app = new ApplicationManager();
$today = new DateTime();

$userid = $_SESSION['userid'];
$uname = $_SESSION['username'];

$token = $_GET['ssid'];
$control_no = deleteApplication($conn, $token);

$_SESSION['toastr'] = $app->addFlash('error', 'Application '.$control_no.' has been successfully deleted.', 'Remove');


header('location:../user/users_establishments.php');

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

	return $control_no;
}
