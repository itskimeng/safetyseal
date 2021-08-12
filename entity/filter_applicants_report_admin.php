<?php
session_start();
date_default_timezone_set('Asia/Manila');

require '../manager/ApplicationManager.php';
require '../application/config/connection.php';

$am = new ApplicationManager();

// $province = $_GET['province'];
$current_month = $_GET['asof_date'];
$asof_date = new DateTime($current_month);
$timestamp = $asof_date->format('Y-m-d H:i:s');

$reports['total_application'] = $am->showAllApplications('',$timestamp);
$reports['total_received'] = $am->showAllApplications('',$timestamp,ApplicationManager::STATUS_RECEIVED);
$reports['total_approved'] = $am->showAllApplications('',$timestamp,ApplicationManager::STATUS_APPROVED);
$reports['total_disapproved'] = $am->showAllApplications('',$timestamp,ApplicationManager::STATUS_DISAPPROVED);
$reports['total_returned'] = $am->showAllApplications('',$timestamp,ApplicationManager::STATUS_RETURNED);
// $reports['total_disapproved'] = $reports['total_disapproved'] + $reports['total_returned'];

$reports['batangas_application'] = $am->showAllApplications(3,$timestamp);
$reports['batangas_received'] = $am->showAllApplications(3,$timestamp,ApplicationManager::STATUS_RECEIVED);
$reports['batangas_approved'] = $am->showAllApplications(3,$timestamp,ApplicationManager::STATUS_APPROVED);
$reports['batangas_disapproved'] = $am->showAllApplications(3,$timestamp,ApplicationManager::STATUS_DISAPPROVED);
// $reports['batangas_returned'] = $am->showAllApplications(3,$timestamp,ApplicationManager::STATUS_RETURNED);
// $reports['batangas_disapproved'] = $reports['batangas_disapproved'] + $reports['batangas_returned'];

$reports['cavite_application'] = $am->showAllApplications(1,$timestamp);
$reports['cavite_received'] = $am->showAllApplications(1,$timestamp,ApplicationManager::STATUS_RECEIVED);
$reports['cavite_approved'] = $am->showAllApplications(1,$timestamp,ApplicationManager::STATUS_APPROVED);
$reports['cavite_disapproved'] = $am->showAllApplications(1,$timestamp,ApplicationManager::STATUS_DISAPPROVED);
// $reports['cavite_returned'] = $am->showAllApplications(1,$timestamp,ApplicationManager::STATUS_RETURNED);
// $reports['cavite_disapproved'] = $reports['cavite_disapproved'] + $reports['cavite_returned'];

$reports['laguna_application'] = $am->showAllApplications(2,$timestamp);
$reports['laguna_received'] = $am->showAllApplications(2,$timestamp,ApplicationManager::STATUS_RECEIVED);
$reports['laguna_approved'] = $am->showAllApplications(2,$timestamp,ApplicationManager::STATUS_APPROVED);
$reports['laguna_disapproved'] = $am->showAllApplications(2,$timestamp,ApplicationManager::STATUS_DISAPPROVED);
// $reports['laguna_returned'] = $am->showAllApplications(2,$timestamp,ApplicationManager::STATUS_RETURNED);
// $reports['laguna_disapproved'] = $reports['laguna_disapproved'] + $reports['laguna_returned'];

$reports['rizal_application'] = $am->showAllApplications(4,$timestamp);
$reports['rizal_received'] = $am->showAllApplications(4,$timestamp,ApplicationManager::STATUS_RECEIVED);
$reports['rizal_approved'] = $am->showAllApplications(4,$timestamp,ApplicationManager::STATUS_APPROVED);
$reports['rizal_disapproved'] = $am->showAllApplications(4,$timestamp,ApplicationManager::STATUS_DISAPPROVED);
// $reports['rizal_returned'] = $am->showAllApplications(4,$timestamp,ApplicationManager::STATUS_RETURNED);
// $reports['rizal_disapproved'] = $reports['rizal_disapproved'] + $reports['rizal_returned'];

$reports['huc_application'] = $am->showAllApplications('huc',$timestamp);
$reports['huc_received'] = $am->showAllApplications('huc',$timestamp,ApplicationManager::STATUS_RECEIVED);
$reports['huc_approved'] = $am->showAllApplications('huc',$timestamp,ApplicationManager::STATUS_APPROVED);
$reports['huc_disapproved'] = $am->showAllApplications('huc',$timestamp,ApplicationManager::STATUS_DISAPPROVED);
// $reports['huc_returned'] = $am->showAllApplications('huc',$timestamp,ApplicationManager::STATUS_RETURNED);
// $reports['huc_disapproved'] = $reports['huc_disapproved'] + $reports['huc_returned'];

echo json_encode($reports);
