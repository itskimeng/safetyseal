<?php
session_start();
date_default_timezone_set('Asia/Manila');

require '../manager/ApplicationManager.php';

$app = new ApplicationManager();
$today = new DateTime();

$userid = $_SESSION['userid'];
$uname = $_SESSION['username'];

$checklist_id = $_POST['appid'];

$app->receiveChecklist($checklist_id, ApplicationManager::STATUS_RECEIVED, $today->format('Y-m-d H:i:s'), $userid);	

$_SESSION['toastr'] = $app->addFlash('success', 'The application has been received.', 'Received');

header('location:../admin_application_view.php?appid='.$checklist_id.''.'&ussir='.$userid.'');


