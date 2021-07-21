<?php
date_default_timezone_set('Asia/Manila');

require 'application/config/connection.php';
require 'manager/ApplicationManager.php';

$appid = $_GET['appid'];

$app = new ApplicationManager();

$province = $_SESSION['province'];
$citymun = $_SESSION['city_mun'];
$nature = $_SESSION['nature'];
$userid = $_SESSION['userid'];

$province_opts = $app->getProvinces();
$citymun_opts = $app->getCityMuns($province);
$applicants = $app->getApplicationLists($province,$citymun,ApplicationManager::STATUS_DRAFT);
$is_nature = getNature($nature);

$useraccess = getUserAccess($conn, $userid); 
$applicant = getUserChecklists($conn, $appid); 

if (strstr($_SERVER['REQUEST_URI'], '/admin_application_open.php')) {
    if ($applicant['status'] == 'Received') {
        header('location:admin_application_view.php?appid='.$_GET['appid'].'&ussir='.$_GET['ussir'].'');
    } elseif ($applicant['status'] == 'Returned') {
        header('location:../admin_application.php');
    }
}

$is_readonly = false;
if ($applicant['status'] == 'Approved' OR $applicant['status'] == 'Disapproved') {
    $is_readonly = true;
}
$applicants_data = getUserChecklistsEntry($conn, $appid); 
$appchecklists_attchmnt = $app->getUserChecklistsAttachments($applicant['ssid']);
$app_notes = getUserChecklistsValidations($conn, $appid);

function getUserAccess($conn, $id)
{
    $sql = "SELECT
        ai.id as id, 
        ui.GOV_AGENCY_NAME as agency,
        ui.GOV_ESTB_NAME as establishment,
        ui.GOV_NATURE_NAME as nature,
        ui.ADDRESS as address,
        ai.CMLGOO_NAME as fname,
        ai.EMAIL as email,
        ai.id as user_id,
        ui.ADDRESS as address,
        ui.MOBILE_NO as contact_details,
        ui.POSITION as position
        FROM tbl_admin_info ai
        LEFT JOIN tbl_userinfo ui on ui.user_id = ai.id
        WHERE ai.id = $id";
    

    $query = mysqli_query($conn, $sql);
    $data = mysqli_fetch_array($query);

    return $data;
}

function getUserChecklists($conn, $id)
{
    $sql = "SELECT
        ai.id as id, 
       	ui.GOV_AGENCY_NAME as agency,
       	ui.GOV_ESTB_NAME as establishment,
       	ui.GOV_NATURE_NAME as nature,
       	ui.ADDRESS as address,
        ai.CMLGOO_NAME as fname,
        ai.EMAIL as email,
        ai.id as user_id,
       	ui.ADDRESS as address,
       	ui.MOBILE_NO as contact_details,
        ac.control_no as control_no,
        ac.status as status,
        ac.id as appid,
        ac.safety_seal_no as ss_no,
        ac.establishment as ac_establishment,
        ac.nature as ac_nature,
        ac.address as ac_address,
        ac.token as ssid,
        ui.POSITION as position,
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
        e.other_tool as other_tool,
        e.assessment as assessment,
        e.pnp_remarks as pnp_remarks,
        e.bfp_remarks as bfp_remarks,
        ui.GOV_NATURE_NAME as nature,
        ui.POSITION as position
        FROM tbl_app_checklist_entry e
        LEFT JOIN tbl_app_checklist ac on ac.id = e.parent_id
        LEFT JOIN tbl_app_certchecklist c on c.id = e.chklist_id
        LEFT JOIN tbl_admin_info ai on ai.id = ac.user_id
        LEFT JOIN tbl_userinfo ui on ui.id = ai.id
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

        if (strpos($row['nature'], 'BFP')) {
            $nature = 'bfp';    
        } elseif (strpos($row['nature'], 'PNP')) {
            $nature = 'pnp';    
        } else {
            $nature = 'lgoo';    
        }

        $data[] = [
            'clist_id' => $row['clist_id'],
            'requirement' => $row['requirement'],
            'description' => explode('~ ', $row['description']),
            'ulist_id' => $row['ulist_id'],
            'badge' => $badge,
            'answer' => strtoupper($row['answer']),
            'reason' => $row['reason'],
            'assessment' => $row['assessment'],
            'other_tool' => $row['other_tool'],
            'pnp_remarks' => $row['pnp_remarks'],
            'bfp_remarks' => $row['bfp_remarks'],
            'nature' => $nature,
            'position' => $row['position']
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


function getNature($nature)
{
    
    if (strpos($nature, 'BFP') !== false){
        $flag = 'BFP';
    }elseif (strpos($nature, 'PNP') !== false) {
        $flag = 'PNP';
     }else{
         $flag= 'LGOO';
     }

      return $nature;
}


