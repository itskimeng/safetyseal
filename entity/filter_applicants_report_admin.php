<?php
session_start();
date_default_timezone_set('Asia/Manila');

// require '../manager/ApplicationManager.php';
require '../application/config/connection.php';

// $am = new ApplicationManager();
// $province = $_GET['province'];
$current_month = $_GET['asof_date'];
$asof_date = new DateTime($current_month);
$timestamp = $asof_date->format('Y-m-d H:i:s');

$reports['total_application'] = showAllApplications($conn,'',$timestamp);
$reports['total_renewed'] = showAllApplications($conn,'',$timestamp,'Renewed');
$reports['total_received'] = showAllApplications($conn,'',$timestamp,'Received');
$reports['total_approved'] = showAllApplications($conn,'',$timestamp,'Approved');
$reports['total_disapproved'] = showAllApplications($conn,'',$timestamp,'Disapproved');
$reports['total_returned'] = showAllApplications($conn,'',$timestamp,'Returned');
// $reports['total_disapproved'] = $reports['total_disapproved'] + $reports['total_returned'];

$reports['batangas_application'] = showAllApplications($conn,3,$timestamp);
$reports['batangas_received'] = showAllApplications($conn,3,$timestamp,'Received');
$reports['batangas_renewed'] = showAllApplications($conn,3,$timestamp,'Renewed');
$reports['batangas_approved'] = showAllApplications($conn,3,$timestamp,'Approved');
$reports['batangas_disapproved'] = showAllApplications($conn,3,$timestamp,'Disapproved');
$reports['batangas_returned'] = showAllApplications($conn,3,$timestamp,'Returned');
// $reports['batangas_disapproved'] = $reports['batangas_disapproved'] + $reports['batangas_returned'];

$reports['cavite_application'] = showAllApplications($conn,1,$timestamp);
$reports['cavite_received'] = showAllApplications($conn,1,$timestamp,'Received');
$reports['cavite_renewed'] = showAllApplications($conn,1,$timestamp,'Renewed');
$reports['cavite_approved'] = showAllApplications($conn,1,$timestamp,'Approved');
$reports['cavite_disapproved'] = showAllApplications($conn,1,$timestamp,'Disapproved');
$reports['cavite_returned'] = showAllApplications($conn,1,$timestamp,'Returned');
// $reports['cavite_disapproved'] = $reports['cavite_disapproved'] + $reports['cavite_returned'];

$reports['laguna_application'] = showAllApplications($conn,2,$timestamp);
$reports['laguna_received'] = showAllApplications($conn,2,$timestamp,'Received');
$reports['laguna_renewed'] = showAllApplications($conn,2,$timestamp,'Renewed');
$reports['laguna_approved'] = showAllApplications($conn,2,$timestamp,'Approved');
$reports['laguna_disapproved'] = showAllApplications($conn,2,$timestamp,'Disapproved');
$reports['laguna_returned'] = showAllApplications($conn,2,$timestamp,'Returned');
// $reports['laguna_disapproved'] = $reports['laguna_disapproved'] + $reports['laguna_returned'];

$reports['rizal_application'] = showAllApplications($conn,4,$timestamp);
$reports['rizal_received'] = showAllApplications($conn,4,$timestamp,'Received');
$reports['rizal_renewed'] = showAllApplications($conn,4,$timestamp,'Renewed');
$reports['rizal_approved'] = showAllApplications($conn,4,$timestamp,'Approved');
$reports['rizal_disapproved'] = showAllApplications($conn,4,$timestamp,'Disapproved');
$reports['rizal_returned'] = showAllApplications($conn,4,$timestamp,'Returned');
// $reports['rizal_disapproved'] = $reports['rizal_disapproved'] + $reports['rizal_returned'];

$reports['huc_application'] = showAllApplications($conn,'huc',$timestamp);
$reports['huc_received'] = showAllApplications($conn,'huc',$timestamp,'Received');
$reports['huc_renewed'] = showAllApplications($conn,'huc',$timestamp,'Renewed');
$reports['huc_approved'] = showAllApplications($conn,'huc',$timestamp,'Approved');
$reports['huc_disapproved'] = showAllApplications($conn,'huc',$timestamp,'Disapproved');
$reports['huc_returned'] = showAllApplications($conn,'huc',$timestamp,'Returned');
// $reports['huc_disapproved'] = $reports['huc_disapproved'] + $reports['huc_returned'];


 function showAllApplications($conn,$province='',$timestamp, $status='')
{
    $sql = "SELECT count(*) as total FROM tbl_app_checklist ac 
            JOIN tbl_admin_info ai on ai.id = ac.user_id
            JOIN tbl_province tp on tp.id = ai.PROVINCE 
            JOIN tbl_citymun cm on cm.province = ai.PROVINCE AND cm.code = ai.LGU
            WHERE ac.date_created <= '".$timestamp."' AND ai.id IS NOT NULL AND tp.id IS NOT NULL";

    if (!empty($status)) {
        if ($status == 'Disapproved') {
            $sql.= " AND ac.status IN ('Reassess', 'Disapproved', 'Returned', 'For Reassessment')";
        } elseif ($status == 'Approved') {
            $sql.= " AND ac.status IN ('Approved')";
        } elseif ($status == 'Received') {
            $sql.= " AND ac.status IN ('Received', 'For Renewal')";
        } else {
            $sql.= " AND ac.status = '".$status."'";
        }
    } else {
        $sql.= " AND ac.status IN ('Received', 'Approved', 'Returned', 'For Reassessment', 'Reassess', 'Disapproved', 'Renewed', 'For Renewal')";
    }

    if ($province == 'huc') {
        $sql.= " AND tp.id IN (5, 8)";
    } elseif (!empty($province)) {
        $sql.= " AND tp.id = $province";
    }

	$query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($query);

    return number_format($row['total']);
}
echo json_encode($reports);
