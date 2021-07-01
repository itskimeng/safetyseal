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



//Sending E-mail notification
// $notify = $app->notifyApprover($_SESSION['province'], $_SESSION['city_mun']);
// $userinfo = $app->getApplicantDetails($userid);
// $name = $_POST['name'];
// $establishment =$userinfo['establishment'];
// $control_no =$_POST['control_no'];
// $email = $_POST['email'];
// require 'post_notif.php';

header('location:../wbstapplication.php?ssid='.$token.'');


