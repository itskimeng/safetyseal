<?php
session_start();
date_default_timezone_set('Asia/Manila');

require '../manager/ApplicationManager.php';

$app = new ApplicationManager();
$today = new DateTime();

$userid = $_SESSION['userid'];
$uname = $_SESSION['username'];
$checklist_id = $_POST['rtn-chklist_id'];
$remarks = $_POST['remarks'];

$app->returnChecklist($checklist_id, ApplicationManager::STATUS_RETURNED, $today->format('Y-m-d H:i:s'), $userid, $remarks);	
$_SESSION['toastr'] = $app->addFlash('success', 'The application has been returned.', 'Returned');

header('location:../admin_application.php');


