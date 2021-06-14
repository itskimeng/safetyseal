<?php
date_default_timezone_set('Asia/Manila');

require 'application/config/connection.php';
require 'manager/ApplicationManager.php';

$appid = $_GET['appid'];

$app = new ApplicationManager();

$province = $_SESSION['province'];
$citymun = $_SESSION['city_mun'];

$province_opts = $app->getProvinces();
$citymun_opts = $app->getCityMuns();
$applicants = $app->getApplicationLists($province,$citymun,ApplicationManager::STATUS_DRAFT);


$applicant = getUserChecklists($conn, $appid); 
$is_readonly = false;
if ($applicant['status'] == 'Approved' OR $applicant['status'] == 'Disapproved') {
    $is_readonly = true;
}
$applicants_data = getUserChecklistsEntry($conn, $appid); 
$app_notes = getUserChecklistsValidations($conn, $appid);

function getUserChecklists($conn, $id)
{
    $sql = "SELECT 
       	ui.GOV_AGENCY_NAME as agency,
       	ui.GOV_ESTB_NAME as establishment,
       	ui.GOV_NATURE_NAME as nature,
       	ui.ADDRESS as address,
        ai.CMLGOO_NAME as fname,
       	ui.ADDRESS as address,
       	ui.MOBILE_NO as contact_details,
        ac.control_no as control_no,
        ac.status as status,
        ac.id as appid,
       	DATE_FORMAT(ac.date_created, '%M %d, %Y') as date_created
        FROM tbl_app_checklist ac
        LEFT JOIN tbl_admin_info ai on ai.id = ac.user_id
        LEFT JOIN tbl_userinfo ui on ui.user_id = ai.id
        WHERE ac.id = $id";

    $query = mysqli_query($conn, $sql);
    $data = mysqli_fetch_array($query);

    return $data;
}

function getUserChecklistsEntry($conn, $id)
{
    $sql = "SELECT 
        c.id as clist_id,  
        c.requirement as requirement,
        c.description as description,
        e.id as ulist_id,
        e.answer as answer,
        e.reason as reason,
        e.assessment as assessment
        FROM tbl_app_checklist_entry e
        LEFT JOIN tbl_app_checklist ac on ac.id = e.parent_id
        LEFT JOIN tbl_app_certchecklist c on c.id = e.chklist_id
        LEFT JOIN tbl_admin_info ai on ai.id = ac.user_id
        WHERE ac.id = $id";

    $query = mysqli_query($conn, $sql);
    $data = [];

    while ($row = mysqli_fetch_assoc($query)) {
    	$badge = 'secondary';
    	if ($row['answer'] == 'yes') {
    		$badge = 'success';
    	} 

    	if ($row['answer'] == 'no') {
    		$badge = 'danger';
    	}

        $data[] = [
            'clist_id' => $row['clist_id'],
            'requirement' => $row['requirement'],
            'description' => explode('~ ', $row['description']),
            'ulist_id' => $row['ulist_id'],
            'badge' => $badge,
            'answer' => strtoupper($row['answer']),
            'reason' => $row['reason'],
            'assessment' => $row['assessment']
        ];    
    }

    return $data;
}

function getUserChecklistsValidations($conn, $id)
{
    $sql = "SELECT 
        v.defects as defects,
        v.recommendations as recommendations
        FROM tbl_app_checklist_onsitevalidations v
        LEFT JOIN tbl_app_checklist a on a.id = v.chklist_id
        WHERE a.id = $id";

    $query = mysqli_query($conn, $sql);
    $data = [];

    while ($row = mysqli_fetch_assoc($query)) {
        $data = [
            'defects' => utf8_decode($row['defects']),
            'recommendations' => utf8_decode($row['recommendations'])
        ];    
    }

    return $data;
}
