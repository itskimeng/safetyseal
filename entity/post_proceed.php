<?php
session_start();
date_default_timezone_set('Asia/Manila');

require '../manager/ApplicationManager.php';

$app = new ApplicationManager();
$today = new DateTime();

$userid = $_SESSION['userid'];
$uname = $_SESSION['username'];

$checklist_id = $_POST['chklist_id'];
$has_consent = isset($_POST['consent']) ? true : false;

$app->proceedChecklist($checklist_id, $has_consent, ApplicationManager::STATUS_FOR_APPROVAL, $today->format('Y-m-d H:i:s'));			
$_SESSION['toastr'] = $app->addFlash('success', 'The application is now being assess.', 'For Approval');

header('location:../wbstapplication.php');


