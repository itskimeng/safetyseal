<?php
session_start();
date_default_timezone_set('Asia/Manila');

require '../manager/ApplicationManager.php';
require '../application/config/connection.php';

$am = new ApplicationManager();

$current_month = $_GET['asof_date'];
$asof_date = new DateTime($current_month);
$timestamp = $asof_date->format('Y-m-d H:i:s');

$reports['total_application'] = $am->getTotalApplications('',$timestamp);
$reports['total_received'] = $am->getTotalReceivedApplications('',$timestamp);
$reports['total_approved'] = $am->getTotalApprovedApplications('',$timestamp);
$reports['total_disapproved'] = $am->getTotalDisapprovedApplications('',$timestamp);

$reports['batangas_application'] = $am->getTotalApplications(3,$timestamp);
$reports['batangas_received'] = $am->getTotalReceivedApplications(3,$timestamp);
$reports['batangas_approved'] = $am->getTotalApprovedApplications(3,$timestamp);
$reports['batangas_disapproved'] = $am->getTotalDisapprovedApplications(3,$timestamp);

$reports['cavite_application'] = $am->getTotalApplications(1,$timestamp);
$reports['cavite_received'] = $am->getTotalReceivedApplications(1,$timestamp);
$reports['cavite_approved'] = $am->getTotalApprovedApplications(1,$timestamp);
$reports['cavite_disapproved'] = $am->getTotalDisapprovedApplications(1,$timestamp);

$reports['laguna_application'] = $am->getTotalApplications(2,$timestamp);
$reports['laguna_received'] = $am->getTotalReceivedApplications(2,$timestamp);
$reports['laguna_approved'] = $am->getTotalApprovedApplications(2,$timestamp);
$reports['laguna_disapproved'] = $am->getTotalDisapprovedApplications(2,$timestamp);

$reports['rizal_application'] = $am->getTotalApplications(4,$timestamp);
$reports['rizal_received'] = $am->getTotalReceivedApplications(4,$timestamp);
$reports['rizal_approved'] = $am->getTotalApprovedApplications(4,$timestamp);
$reports['rizal_disapproved'] = $am->getTotalDisapprovedApplications(4,$timestamp);

$reports['huc_application'] = $am->getTotalApplications('huc',$timestamp);
$reports['huc_received'] = $am->getTotalReceivedApplications('huc',$timestamp);
$reports['huc_approved'] = $am->getTotalApprovedApplications('huc',$timestamp);
$reports['huc_disapproved'] = $am->getTotalDisapprovedApplications('huc',$timestamp);

echo json_encode($reports);
