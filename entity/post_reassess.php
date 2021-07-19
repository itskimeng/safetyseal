<?php
session_start();
date_default_timezone_set('Asia/Manila');

require '../manager/ApplicationManager.php';

$app = new ApplicationManager();
$today = new DateTime();

$userid = $_SESSION['userid'];
$uname = $_SESSION['username'];

$token = $_GET['ssid'];
$status = $_GET['stt'] == 'FA' ? ApplicationManager::STATUS_FOR_REASSESSMENT: $_GET['stt'];

$app->reassessChecklist($userid, $token, $status, $today->format('Y-m-d H:i:s'));			
$_SESSION['toastr'] = $app->addFlash('success', 'The application is now being assess.', 'For Reassessment');


// header('location:../wbstapplication.php?ssid='.$token.'');
header('location:../wbstapplication.php?ssid='.$token.'&code='.$_SESSION['gcode'].'&scope='.$_SESSION['gscope'].'');
