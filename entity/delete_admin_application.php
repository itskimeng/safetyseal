<?php
session_start();
date_default_timezone_set('Asia/Manila');

require '../manager/ApplicationManager.php';
require '../application/config/connection.php';

$app = new ApplicationManager();
$today = new DateTime();

$userid = $_SESSION['userid'];
$uname = $_SESSION['username'];
$gcode = $_SESSION['gcode'];
$gscope = $_SESSION['gscope'];

$token = $_GET['token'];
$control_no = deleteApplication($conn, $token);

$_SESSION['toastr'] = $app->addFlash('error', 'Application <b>'.$control_no.'</b> has been successfully deleted.', 'Remove');

header('location:../admin_application.php');

function deleteApplication($conn, $id) 
{
	$sql = "SELECT id, control_no FROM tbl_app_checklist WHERE token = '".$id."'";
	$query = mysqli_query($conn, $sql);
    $result1 = mysqli_fetch_assoc($query);

    $control_no = $result1['control_no'];
    
    $sql = "DELETE FROM tbl_app_checklist_encoded_attachments WHERE parent_id = '".$result1['id']."'";
	$result = mysqli_query($conn, $sql);

	$sql = "DELETE FROM tbl_app_checklist WHERE token = '".$id."'";
	$query = mysqli_query($conn, $sql);

	return $control_no;
}
