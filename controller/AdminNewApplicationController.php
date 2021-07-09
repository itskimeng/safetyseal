<?php
date_default_timezone_set('Asia/Manila');

require 'application/config/connection.php';
require 'manager/ApplicationManager.php';
require 'manager/ComponentsManager.php';


$appid = $_GET['appid'] == 'new' ? '' : $_GET['appid'];

$am = new ApplicationManager();
$cm = new ComponentsManager();

$province = $_SESSION['province'];
$citymun = $_SESSION['city_mun'];
$is_pfp = $_SESSION['is_pfp'];
$is_clusterhead = $_SESSION['is_clusterhead'];
$clusterhead_id = $_SESSION['clusterhead_id'];

if ($is_clusterhead) {
    $citymun_opts = getget($conn, $clusterhead_id);
} else {
    $citymun_opts = $am->getCityMuns($province);
}

$is_new = true;
$government_nature = $cm->getGovtNature();

// $province_opts = $app->getProvinces();
// $applicants = $app->getApplicationLists($province,$citymun,ApplicationManager::STATUS_DRAFT);

$check_allpass = false;
$check_allfail = false;

if (empty($appid)) {
    $cert_details = $am->getChecklists();
} else {
    $is_new = false;
    $applicant = getUserChecklists($conn, $appid); 
    $cert_details = $am->getUserChecklistsEntry($appid);
    $check_allpass = checkAssessmentPass($cert_details);
    $check_allfail = checkAssessmentFail($cert_details);
    $check_allfail = checkAssessmentFail($cert_details);
    $attachments = getUserEncodedList($conn, $appid);
}

function checkAssessmentPass($data) {
    $counter = 0;
    foreach ($data as $key => $dd) {
        if ($dd['assessment'] == 'pass') {
            $counter++;
        }
    }

    if ($counter == 14) {
        return true;
    } else {
        return false;
    }
}

function checkAssessmentFail($data) {
    $counter = 0;
    foreach ($data as $key => $dd) {
        if ($dd['assessment'] == 'fail') {
            $counter++;
        }
    }

    if ($counter == 14) {
        return true;
    } else {
        return false;
    }
}

function getUserEncodedList($conn, $id)
{
    $sql = "SELECT 
        acea.id as attid,
        acea.file_id as file_id,
        acea.file_name as file_name,
        acea.location as location
        FROM tbl_app_checklist_encoded_attachments acea
        LEFT JOIN tbl_app_checklist ac on ac.token = acea.parent_id
        WHERE ac.token = '".$id."'";

    $query = mysqli_query($conn, $sql);
    $data = mysqli_fetch_array($query);

    return $data;
}

function getUserChecklists($conn, $id)
{
    $sql = "SELECT 
        ac.control_no as control_no, 
        ac.agency as agency,
        ac.establishment as establishment, 
        ac.nature as nature,
        ac.address as address,
        ac.person as person, 
        ac.contact_details as contact_details,
        ac.status as status,
        ac.token as token,
        ac.safety_seal_no as ss_no,
        ac.lgu as lgu,
        DATE_FORMAT(ac.date_created, '%m/%d/%Y') as date_created
        FROM tbl_app_checklist ac
        LEFT JOIN tbl_admin_info ai on ai.id = ac.user_id
        LEFT JOIN tbl_userinfo ui on ui.user_id = ai.id
        WHERE ac.token = '".$id."'";

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

function getget($conn, $id)
{
    $sql = "SELECT * FROM tbl_cluster_head where id = $id"; 
    $query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_array($query);

    $rr = json_decode($result['citymun']);
    $rr = implode(',', $rr);

    $sql2 = "SELECT * FROM tbl_citymun where id IN ($rr)";
    $result2 = mysqli_query($conn, $sql2);

    $data = [];
        
    while ($row = mysqli_fetch_assoc($result2)) {
        $data[$row['id']] = [
            'province' => $row['province'],
            'code' => $row['code'],
            'name' => $row['name']
        ];    
       
    }

    return $data;
}

