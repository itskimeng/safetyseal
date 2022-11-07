<?php
session_start();
date_default_timezone_set('Asia/Manila');

require '../Model/Connection.php';
require '../manager/ApplicationManager.php';
require '../application/config/connection.php';

$app = new ApplicationManager();
$today = new DateTime();

$userid = $_SESSION['userid'];
$uname = $_SESSION['username'];
$gcode = $_SESSION['gcode'];
$gscope = $_SESSION['gscope'];

$token = $_GET['token'];
$dd = deleteApplication($conn, $token);

$_SESSION['toastr'] = $app->addFlash('error', 'Application <b>'.$dd['cn'].'</b> has been successfully deleted.', 'Remove');

header('location:../admin_application.php');
if ($dd['type'] == 'Applied') {
	header('location:../admin_view_application.php?userid='.$dd['user'].'&type=Applied&_view');
} else {
	header('location:../admin_view_application.php?person='.$dd['person'].'&type=Encoded&_view');
}

function deleteApplication($conn, $id) 
{
	$sql = "SELECT id, user_id, person, control_no, application_type FROM tbl_app_checklist WHERE token = '".$id."'";
	$query = mysqli_query($conn, $sql);
    $result1 = mysqli_fetch_assoc($query);

    $data = [
    	'cn'		=>	$result1['control_no'], 
    	'user'		=>	$result1['user_id'], 
    	'person'	=>	$result1['person'], 
    	'type'		=>	$result1['application_type']
    ];
	$sql = "SELECT id FROM tbl_app_checklist_entry WHERE parent_id = '".$result1['id']."'";
	$query = mysqli_query($conn, $sql);
    $rows = mysqli_fetch_assoc($query);
	$res = [];
	while ($row = mysqli_fetch_assoc($query)) {
        $res[] = $row['id'];
    }
    $ss = implode(', ', $res);



    $sql1 = "DELETE FROM tbl_app_checklist_attachments WHERE entry_id IN (".$ss.")";
	$result = mysqli_query($conn, $sql1);

    $sql2 = "DELETE FROM tbl_app_checklist_encoded_attachments WHERE parent_id = '".$result1['id']."'";
	$result = mysqli_query($conn, $sql2);

	$sql3 = "DELETE FROM tbl_app_checklist WHERE token = '".$id."'";
	$query = mysqli_query($conn, $sql3);


	return $data;
}
