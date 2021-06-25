<?php
session_start();
date_default_timezone_set('Asia/Manila');

require '../manager/ApplicationManager.php';
require '../application/config/connection.php';

$app = new ApplicationManager();
$today = new DateTime();

$userid = $_SESSION['userid'];
$token = $_POST['id'];
$checklist_id = findID($conn, $token);
$status = ApplicationManager::STATUS_APPROVED;

$ss_no = $app->generateCode($userid);

$app->evaluateChecklist($checklist_id, $status, $ss_no, $today->format('Y-m-d H:i:s'), $userid);


$_SESSION['toastr'] = $app->addFlash('success', 'The application has been set to '.$status.'.', 'Success');


function findID($conn, $id) {
	$sql = 'SELECT id FROM tbl_app_checklist where token = "'.$id.'"';
    $query = mysqli_query($conn, $sql);
	$result = mysqli_fetch_array($query);
        
    return $result['id']; 
}


