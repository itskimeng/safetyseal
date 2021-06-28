<?php
session_start();
date_default_timezone_set('Asia/Manila');

require '../manager/ApplicationManager.php';

$app = new ApplicationManager();

$today = new DateTime();    

$userid = $_SESSION['userid'];
$uname = $_SESSION['username'];


$checklist_id = $_POST['chklist_id'];
$token = $_POST['token'];
$has_consent = isset($_POST['consent']) ? true : false;



$app->proceedChecklist($checklist_id, $has_consent, ApplicationManager::STATUS_FOR_RECEIVING, $today->format('Y-m-d H:i:s'));			
$_SESSION['toastr'] = $app->addFlash('success', 'The application is now being assess.', 'For Approval');

$notify = $app->notifyApprover($_SESSION['province'], $_SESSION['city_mun']);
$userinfo = $app->getApplicantDetails($userid);

$name = $_POST['name'];
$establishment =$userinfo['establishment'];
$email = $_POST['email'];
require 'email_notification.php';
header('location:../wbstapplication.php?ssid='.$token.'');


