<?php
session_start();
date_default_timezone_set('Asia/Manila');

require '../Model/Connection.php';
require '../manager/ApplicationManager.php';
require '../manager/SafetysealHistoryManager.php';
require '../manager/ApplicationHistoryManager.php';
require '../application/config/connection.php';

$am = new ApplicationManager();
$shm = new SafetysealHistoryManager();
$ahm = new ApplicationHistoryManager();
$today = new DateTime();

$userid = $_SESSION['userid'];
$token = $_GET['ssid'];
$parent = $am->findChecklist($token);

$checklists = $am->getCertChecklists();
// $renew_count = 1 + $parent['renew_count'];

$code = $am->generateControlNumber($userid);
$new_token = bin2hex(random_bytes(64));

$last_id = $am->insertChecklist2($code, $parent['establishment'], $parent['nature'], $parent['address'], $userid, $today->format('Y-m-d H:i:s'), $new_token, $parent['safety_seal_no']);

foreach ($checklists as $key => $id) {
	$sql = "INSERT INTO tbl_app_checklist_entry SET parent_id = ".$last_id.", chklist_id = ".$id.", date_created = '".$today->format('Y-m-d H:i:s')."'";
	$result = mysqli_query($conn, $sql);
}

$sql = "UPDATE tbl_app_checklist set status = 'Expired' WHERE token = '".$token."'";
$result = mysqli_query($conn, $sql);

$action = SafetysealHistoryManager::ACTION_RENEWAL;

$msg = 'Application ' .$parent['control_no'] .' applied for renewal';

$shm->insert(['fid'=>$parent['id'], 'mid'=>SafetysealHistoryManager::MENU_PUBLIC_APPLICATION, 'uid'=>$userid, 'action'=> $action, 'message'=> $msg, 'action_date'=> $today->format('Y-m-d H:i:s')]);



$shm->insert(['fid'=>$last_id, 'mid'=>SafetysealHistoryManager::MENU_PUBLIC_APPLICATION, 'uid'=>$userid, 'action'=> $action, 'message'=> $msg, 'action_date'=> $today->format('Y-m-d H:i:s')]);


// if (in_array($status, ['Approved', 'Revoked'])) {
	$issued_date = new DateTime($parent['date_approved']);
	$validity_date = date('Y-m-d', strtotime("+6 months", strtotime($issued_date->format('Y-m-d'))));
	$validity_date = new DateTime($validity_date);

	$ahm->insert(['app_id'=>$parent['id'], 'issued_date'=>$issued_date->format('Y-m-d'), 'expiration_date'=>$validity_date->format('Y-m-d'), 'status'=>'Expired', 'date_created'=>$today->format('Y-m-d H:i:s')]);

	$ahm->insert(['app_id'=>$parent['id'], 'issued_date'=>null, 'expiration_date'=>null, 'status'=>'For Renewal', 'date_created'=>$today->format('Y-m-d H:i:s')]);
// }	


$_SESSION['toastr'] = $am->addFlash('success', 'Successfully applied for renewal.', 'Success');

header('location:../wbstapplication.php?ssid='.$new_token.'&code='.$_SESSION['gcode'].'&scope='.$_SESSION['gscope'].'');
