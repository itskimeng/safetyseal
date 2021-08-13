<?php

require 'application/config/connection.php';
require 'manager/DashboardManager.php';
require 'manager/ApplicationManager.php';


$app = new DashboardManager();
$am = new ApplicationManager();


$province = $_SESSION['province'];
$citymun = $_SESSION['city_mun'];
$is_clusterhead = $_SESSION['is_clusterhead'];
$clusterhead_id = $_SESSION['clusterhead_id'];
$is_pfp = $_SESSION['is_pfp'];
$is_rofp = (($province == 0) && ($citymun == 00));
$hlbl = ""; 

if ($is_rofp) {
    $hlbl = '(REGIONAL OFFICE FOCAL PERSON)';
}

if ($is_clusterhead) {
	$hlbl = '(CLUSTERHEAD)';
} 

if ($is_pfp) {
	$hlbl = '(PROVINCIAL FOCAL PERSON)';
} 


if ($is_rofp) {
    $citymun_opts = $app->getCityMuns($province);
    $province_opts = getProvinces($conn);
    $est_safety_seal = getEstablishmentSSCRO($conn, 3);
    $asof_date = new DateTime();
    $timestamp = $asof_date->format('Y-m-d H:i:s');

    $lgu = [];

    $count_status = countStatusRO($conn, $province_opts);

    $total_count['For Receiving'] = $count_status['For Receiving'];
    $total_count['Received'] = $count_status['Received'];
    $total_count['Approved'] = $count_status['Approved'];
    $total_count['Disapproved'] = $count_status['Disapproved'];

    $receiving = getdataForReceivedRO($conn, $province_opts);
    $approved = getdataApprovedRO1($conn, $province_opts);

    $reports['cavite'] = $am->showAllApplications(1,$timestamp,ApplicationManager::STATUS_APPROVED);
    $reports['laguna'] = $am->showAllApplications(2,$timestamp,ApplicationManager::STATUS_APPROVED);
    $reports['batangas'] = $am->showAllApplications(3,$timestamp,ApplicationManager::STATUS_APPROVED);
    $reports['rizal'] = $am->showAllApplications(4,$timestamp,ApplicationManager::STATUS_APPROVED);
    $reports['quezon'] = $am->showAllApplications('huc',$timestamp,ApplicationManager::STATUS_APPROVED);

    $batangas_muns = getProvinceCityMuns($conn, 3);

} elseif ($is_pfp) {
	$citymun_opts = $app->getCityMuns($province);
	$lgu = $app->getCityMuns($province);
	$est_safety_seal = getEstablishmentSSC($conn, $province, $citymun);

	$count_status = countStatus($conn, $province, $citymun_opts);
	$count_status2 = countStatus2($conn, $province, $citymun_opts);
	$count_status3 = countStatus3($conn, $province, $citymun_opts);

	// $approved = $app->getdataApproved($province, $citymun);

	$total_count['For Receiving'] = $count_status['For Receiving'];
	$total_count['Received'] = $count_status['Received'];
	$total_count['Approved'] = $count_status['Approved'];
	$total_count['Disapproved'] = $count_status['Disapproved'];
	
	$receiving = getdataForReceived($conn,$province,$citymun);
	$approved = getdataApproved($conn,$province,$citymun);
} elseif ($is_clusterhead) {
	$citymun_opts = getget($conn, $clusterhead_id);
	// $lgu = $app->getCityMuns($province);
    $lgu = $citymun_opts;

	$count_status = getApprovedEncodedAC($conn, $province, $citymun_opts);
	$count_status2 = getApprovedAppliedAI($conn, $province, $citymun_opts);
	$count_status3 = getApprovedEncodedAI($conn, $province, $citymun_opts);

	$total_count['For Receiving'] = $count_status['For Receiving'] + $count_status2['For Receiving'] + $count_status3['For Receiving'];
	$total_count['Received'] = $count_status['Received'] + $count_status2['Received'] + $count_status3['Received'];
	$total_count['Approved'] = $count_status['Approved'] + $count_status2['Approved'] + $count_status3['Approved'];
	$total_count['Disapproved'] = $count_status['Disapproved'] + $count_status2['Disapproved'] + $count_status3['Disapproved'];

	$receiving1 = getdataForReceived1($conn,$province,$citymun_opts);
	$receiving2 = getdataForReceived2($conn,$province,$citymun_opts);
	$receiving3 = getdataForReceived3($conn,$province,$citymun_opts);


    foreach ($receiving1 as $key => $received) {
        $receiving[$key] = $received + $receiving2[$key] + $receiving3[$key];
    }

	$approved1 = getdataApproved1($conn,$province,$citymun_opts);
    $approved2 = getdataApproved2($conn,$province,$citymun_opts);
    $approved3 = getdataApproved3($conn,$province,$citymun_opts);

    foreach ($approved1 as $key => $appr) {
        $approved[$key] = $appr + $approved2[$key] + $approved3[$key];
    }


} else {
	$total_count = $app->countStatus($province, $citymun);
	$lgu = $app->getCityMuns($province);
	$est_safety_seal = $app->getEstablishmentSSC($province, $citymun);

	$receiving = $app->getdataForReceived($province,$citymun);
	$approved = $app->getdataApproved($province,$citymun);
}

function getProvinces($conn)
    {
        $sql = "SELECT id, code, name FROM tbl_province WHERE id = 3";
        
        $query = mysqli_query($conn, $sql);
        $data = [];
        
        while ($row = mysqli_fetch_assoc($query)) {
            $data[$row['id']] = [
                'code' => $row['code'],
                'name' => $row['name']
            ];    
        }

        return $data;
    }

function getProvinceCityMuns($conn, $province)
    {
        $sql1 = "SELECT cm.id as lgu, COUNT(ai.LGU) as no FROM tbl_app_checklist ac
            LEFT JOIN tbl_admin_info ai on ai.id = ac.user_id
            LEFT JOIN tbl_citymun cm on cm.province = ai.PROVINCE AND cm.code = ai.LGU
            WHERE ai.PROVINCE = '$province' AND ac.status = 'Approved' GROUP 
            BY ai.lgu";

        $sql2 = "SELECT id, name FROM tbl_citymun
            WHERE province = '$province' ORDER BY code";

        $query2 = mysqli_query($conn, $sql2);
        $dd = $ds = [];
        while ($row = mysqli_fetch_assoc($query2)) {
            $dd[$row['id']] = [
                'name' => $row['name']
            ];
        }

        $data = [];
        $query1 = mysqli_query($conn, $sql1);
        
        while ($row = mysqli_fetch_assoc($query1)) {
            $ds[$row['lgu']] = $row['no'];
        }

        foreach ($dd as $key => $ddd) {
            if (isset($ds[$key])) {
                $data[$key] = $ddd['name'] .' - '. $ds[$key];
            } else {
                $data[$key] = $ddd['name'] .' - 0';
            }
        }


        return $data;
    }


function getCityMuns($conn, $province)
{
    $sql = "SELECT id, province, code, name FROM tbl_citymun where province  = $province";
    
    $query = mysqli_query($conn, $sql);
    $data = [];
    
    while ($row = mysqli_fetch_assoc($query)) {
        $data[$row['id']] = [
            'province' => $row['province'],
            'code' => $row['code'],
            'name' => $row['name']
        ];    
       
    }

    return $data;
}

function countStatusRO($conn, $province_opts)
{
    $val = ['For Receiving', 'Received', 'Approved', 'Disapproved'];
    
    $citymun_opts = [];

    $data1 = array();
    foreach ($val as $cc => $stat) {
        $total = 0;
        foreach ($province_opts as $key => $province) {
            // $sql = "SELECT count(*) as 'status' FROM `tbl_app_checklist` WHERE status = '$stat' ";
            $sql = "SELECT 
                    count(*) as count
                    FROM tbl_app_checklist ac
                    JOIN tbl_admin_info ai on ai.id = ac.user_id
                    JOIN tbl_province p on p.id = ai.PROVINCE
                    JOIN tbl_citymun cm on cm.province = ai.PROVINCE AND cm.code = ai.LGU";
            if ($stat == 'Disapproved') {
                $sql .= " WHERE p.id = '$key' AND ac.status IN ('Disapproved', 'Returned', 'Reassess', 'For Reassessment') AND ai.id IS NOT NULL AND p.id IS NOT NULL";
            } else {
                $sql .= " WHERE p.id = '$key' AND ac.status = '$stat' AND ai.id IS NOT NULL AND p.id IS NOT NULL";
            }

            $query = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($query);
            $total+= $row['count'];
        }

        $data1[$stat] = $total;
    }

    return $data1;
}

function countStatus($conn, $province, $lgus)
{
    $val = ['For Receiving', 'Received', 'Approved', 'Disapproved'];

    foreach ($lgus as $key => $lgu) {
        $codes[] = $lgu['code']; 
    }

    $codes = implode(',', $codes);

    $data1 = array();
    foreach ($val as $key => $stat) {
        // $sql = "SELECT count(*) as 'status' FROM `tbl_app_checklist` WHERE status = '$stat' ";
        $sql = "SELECT 
                count(*) as count
                FROM tbl_app_checklist ac
                LEFT JOIN tbl_admin_info ai on ai.id = ac.user_id
                LEFT JOIN tbl_province p on p.id = ai.PROVINCE
                LEFT JOIN tbl_citymun cm on cm.id = ai.LGU
                WHERE p.id = '$province' AND status = '$stat' ";

        $query = mysqli_query($conn, $sql);
        $result = $row = mysqli_fetch_assoc($query);
        $data1[$stat] = $row['count'];
    }

    return $data1;
}

function countStatus2($conn, $province, $lgus)
{
    $val = ['For Receiving', 'Received', 'Approved', 'Disapproved'];

    foreach ($lgus as $key => $lgu) {
        $codes[] = $lgu['code']; 
    }

    $codes = implode(',', $codes);

    $data1 = array();
    foreach ($val as $key => $stat) {
        // $sql = "SELECT count(*) as 'status' FROM `tbl_app_checklist` WHERE status = '$stat' ";
        $sql = "SELECT 
                count(*) as count
                FROM tbl_app_checklist ac
                LEFT JOIN tbl_admin_info ai on ai.id = ac.user_id
                LEFT JOIN tbl_province p on p.id = ai.PROVINCE
                LEFT JOIN tbl_citymun cm on cm.id = ai.LGU
                WHERE p.id = '$province' AND ai.LGU IN (".$codes.") AND ac.application_type = 'Encoded' AND status = '$stat' ";

        $query = mysqli_query($conn, $sql);
        $result = $row = mysqli_fetch_assoc($query);
        $data1[$stat] = $row['count'];
    }

    return $data1;
}

function countStatus3($conn, $province, $lgus)
{
    $val = ['For Receiving', 'Received', 'Approved', 'Disapproved'];

    foreach ($lgus as $key => $lgu) {
        $codes[] = $lgu['code']; 
    }

    $codes = implode(',', $codes);

    $data1 = array();
    foreach ($val as $key => $stat) {
        // $sql = "SELECT count(*) as 'status' FROM `tbl_app_checklist` WHERE status = '$stat' ";
        $sql = "SELECT 
                count(*) as count
                FROM tbl_app_checklist ac
                LEFT JOIN tbl_admin_info ai on ai.id = ac.user_id
                LEFT JOIN tbl_province p on p.id = ai.PROVINCE
                LEFT JOIN tbl_citymun cm on cm.id = ai.LGU
                WHERE p.id = '$province' AND ac.lgu IN (".$codes.") AND ac.application_type = 'Encoded' AND status = '$stat' ";

        $query = mysqli_query($conn, $sql);
        $result = $row = mysqli_fetch_assoc($query);
        $data1[$stat] = $row['count'];
    }

    return $data1;
}

function getEstablishmentSSCRO($conn, $province)
{
    $sql = "SELECT chkl.id as id, chkl.establishment as est, ui.GOV_ESTB_NAME as est2, chkl.safety_seal_no as 'ss_no' 
        FROM `tbl_app_checklist` chkl 
        LEFT JOIN tbl_admin_info ai on chkl.user_id = ai.id
        LEFT JOIN tbl_userinfo ui on ui.USER_ID = ai.id
        LEFT JOIN tbl_province pro on ai.PROVINCE = pro.id 
        WHERE ai.PROVINCE = $province AND chkl.status='Approved' ORDER BY pro.id, chkl.safety_seal_no";

    $query = mysqli_query($conn, $sql);
    $data = [];
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            $data[$row['id']] = [
                'est' => !empty($row['est']) ? $row['est'] : $row['est2'],
                'ss_no' => !empty($row['ss_no']) ? $row['ss_no'] : 'NO SSC'
            ];
        }
    }

    return $data;
}

function getEstablishmentSSC($conn, $province, $lgu)
{
    $sql = "SELECT chkl.id as id, chkl.establishment as 'est', chkl.safety_seal_no as 'ss_no' 
    FROM `tbl_app_checklist` chkl 
    LEFT JOIN tbl_admin_info ai on chkl.user_id = ai.id
    LEFT JOIN tbl_province pro on ai.PROVINCE = pro.id 
    WHERE ai.PROVINCE = '$province' AND status='Approved'";

    $query = mysqli_query($conn, $sql);
    $data = [];
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            $data[$row['id']] = [
                'est' => $row['est'],
                'ss_no' => $row['ss_no']
            ];
        }
    } else {
    }

    return $data;
}

function getdataForReceived($conn, $province,$lgu)
{
    $months =  [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
    for ($i = 1; $i < count($months); $i++) {
        $sql = "SELECT pro.name as 'PROVINCE' , checklist.status, count(*) as 'count', checklist.date_created FROM `tbl_app_checklist` checklist
        LEFT JOIN tbl_admin_info ai on checklist.user_id = ai.ID
        LEFT JOIN tbl_province pro on ai.PROVINCE = pro.id 
        WHERE  ai.PROVINCE= '$province' and MONTH(checklist.date_created) = $i and checklist.status='For Receiving'";

        //  ai.PROVINCE= '$province' and 
        $query = mysqli_query($conn, $sql);
        $result = $row = mysqli_fetch_assoc($query);
        $data[$months[$i]] = $row['count'];
    }

    return $data;
}

function getdataForReceivedRO($conn, $province_opts)
{
    $months =  [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
    $muns = [];
    foreach ($province_opts as $key => $province) {
        $muns[$key] = getCityMuns($conn, $key);
    }
    
    for ($i = 1; $i < count($months); $i++) {
        $total = 0;
        foreach ($province_opts as $key => $province) {
            $ss = [];
            foreach ($muns[$key] as $k => $mun){
                $ss[] = $mun['code'];
            }
            
            if (count($ss) >  0) {
                $ss = implode(',', $ss);
                $sql = "SELECT pro.name as 'PROVINCE' , checklist.status, count(*) as 'count', checklist.date_created FROM `tbl_app_checklist` checklist
                LEFT JOIN tbl_admin_info ai on checklist.user_id = ai.ID
                LEFT JOIN tbl_province pro on ai.PROVINCE = pro.id 
                WHERE  ai.PROVINCE= '$key' and MONTH(checklist.date_created) = $i and checklist.status='Received'";


                $query = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($query);
                $total += $row['count'];
            }

        }
        $data[$months[$i]] = $total;
    }

    return $data;
}

function getdataForReceived1($conn, $province,$lgus)
{
    $months =  [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
    foreach ($lgus as $key => $lgu) {
		$codes[] = $lgu['code']; 
	}

	$codes = implode(',', $codes);

    for ($i = 1; $i < count($months); $i++) {
        $sql = "SELECT pro.name as 'PROVINCE' , checklist.status, count(*) as 'count', checklist.date_created FROM `tbl_app_checklist` checklist
        LEFT JOIN tbl_admin_info ai on checklist.user_id = ai.ID
        LEFT JOIN tbl_province pro on ai.PROVINCE = pro.id 
        WHERE  ai.PROVINCE= '$province' and ai.LGU IN (".$codes.") and MONTH(checklist.date_created) = $i and checklist.status='For Receiving' and checklist.application_type = 'Applied'";

        //  ai.PROVINCE= '$province' and 
        $query = mysqli_query($conn, $sql);
        $result = $row = mysqli_fetch_assoc($query);
        $data[$months[$i]] = $row['count'];
    }

    return $data;
}

function getdataForReceivedRO2($conn, $province_opts)
{
    $months =  [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
    $muns = [];
    foreach ($province_opts as $key => $province) {
        $muns[$key] = getCityMuns($conn, $key);
    }
    
    for ($i = 1; $i < count($months); $i++) {
        $total = 0;
        foreach ($province_opts as $key => $province) {
            $ss = [];
            foreach ($muns[$key] as $k => $mun){
                $ss[] = $mun['code'];
            }
            
            if (count($ss) >  0) {
                $ss = implode(',', $ss);
                $sql = "SELECT pro.name as 'PROVINCE' , checklist.status, count(*) as 'count', checklist.date_created FROM `tbl_app_checklist` checklist
                    LEFT JOIN tbl_admin_info ai on checklist.user_id = ai.ID
                    LEFT JOIN tbl_province pro on ai.PROVINCE = pro.id 
                    WHERE  ai.PROVINCE= '$key' and ai.LGU IN (".$ss.") and MONTH(checklist.date_created) = $i and checklist.status='For Receiving' and checklist.application_type = 'Encoded'";


                $query = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($query);
                $total += $row['count'];
            }

        }
        $data[$months[$i]] = $total;
    }

    return $data;
}

function getdataForReceived2($conn, $province,$lgus)
{
    $months =  [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
    foreach ($lgus as $key => $lgu) {
		$codes[] = $lgu['code']; 
	}

	$codes = implode(',', $codes);

    for ($i = 1; $i < count($months); $i++) {
        $sql = "SELECT pro.name as 'PROVINCE' , checklist.status, count(*) as 'count', checklist.date_created FROM `tbl_app_checklist` checklist
        LEFT JOIN tbl_admin_info ai on checklist.user_id = ai.ID
        LEFT JOIN tbl_province pro on ai.PROVINCE = pro.id 
        WHERE  ai.PROVINCE= '$province' and ai.LGU IN (".$codes.") and MONTH(checklist.date_created) = $i and checklist.status='For Receiving' and checklist.application_type = 'Encoded'";

        //  ai.PROVINCE= '$province' and 
        $query = mysqli_query($conn, $sql);
        $result = $row = mysqli_fetch_assoc($query);
        $data[$months[$i]] = $row['count'];
    }

    return $data;
}

function getdataForReceived3($conn, $province,$lgus)
{
    $months =  [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
    foreach ($lgus as $key => $lgu) {
		$codes[] = $lgu['code']; 
	}

	$codes = implode(',', $codes);

    for ($i = 1; $i < count($months); $i++) {
        $sql = "SELECT pro.name as 'PROVINCE' , checklist.status, count(*) as 'count', checklist.date_created FROM `tbl_app_checklist` checklist
        LEFT JOIN tbl_admin_info ai on checklist.user_id = ai.ID
        LEFT JOIN tbl_province pro on ai.PROVINCE = pro.id 
        WHERE  ai.PROVINCE= '$province' AND checklist.lgu IN (".$codes.") AND MONTH(checklist.date_created) = $i and checklist.status='For Receiving' and checklist.application_type = 'Encoded'";

        //  ai.PROVINCE= '$province' and 
        $query = mysqli_query($conn, $sql);
        $result = $row = mysqli_fetch_assoc($query);
        $data[$months[$i]] = $row['count'];
    }

    return $data;
}

function getdataForReceivedRO3($conn, $province_opts)
{
    $months =  [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
    $muns = [];
    foreach ($province_opts as $key => $province) {
        $muns[$key] = getCityMuns($conn, $key);
    }
    
    for ($i = 1; $i < count($months); $i++) {
        $total = 0;
        foreach ($province_opts as $key => $province) {
            $ss = [];
            foreach ($muns[$key] as $k => $mun){
                $ss[] = $mun['code'];
            }
            
            if (count($ss) >  0) {
                $ss = implode(',', $ss);
                $sql = "SELECT pro.name as 'PROVINCE' , checklist.status, count(*) as 'count', checklist.date_created FROM `tbl_app_checklist` checklist
                    LEFT JOIN tbl_admin_info ai on checklist.user_id = ai.ID
                    LEFT JOIN tbl_province pro on ai.PROVINCE = pro.id 
                    WHERE  ai.PROVINCE= '$key' AND checklist.lgu IN (".$ss.") AND MONTH(checklist.date_created) = $i and checklist.status='For Receiving' and checklist.application_type = 'Encoded'";


                $query = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($query);
                $total += $row['count'];
            }

        }
        $data[$months[$i]] = $total;
    }

    return $data;
}

function getdataApproved($conn, $province,$lgu)
{

    $months =  [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
    for ($i = 1; $i < count($months); $i++) {
        $sql = "SELECT pro.name as 'PROVINCE' , checklist.status, count(*) as 'count', checklist.date_created FROM `tbl_app_checklist` checklist
        LEFT JOIN tbl_admin_info ai on checklist.user_id = ai.ID
        LEFT JOIN tbl_province pro on ai.PROVINCE = pro.id 
        WHERE  ai.PROVINCE= '$province' and MONTH(checklist.date_created) = $i and checklist.status='Approved'";
        // ai.PROVINCE= '$province' and 
        $query = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($query);
        $data[$months[$i]] = $row['count'];
    }
    return $data;
}

// function getdataApproved1($conn, $province,$lgus)
// {

//     $months =  [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
//     foreach ($lgus as $key => $lgu) {
// 		$codes[] = $lgu['code']; 
// 	}

// 	$codes = implode(',', $codes);

//     for ($i = 1; $i < count($months); $i++) {
//         $sql = "SELECT pro.name as 'PROVINCE' , checklist.status, count(*) as 'count', checklist.date_created FROM `tbl_app_checklist` checklist
//         LEFT JOIN tbl_admin_info ai on checklist.user_id = ai.ID
//         LEFT JOIN tbl_province pro on ai.PROVINCE = pro.id 
//         WHERE  ai.PROVINCE= '$province' AND ai.LGU IN (".$codes.") and MONTH(checklist.date_created) = $i and checklist.status='Approved' and checklist.application_type = 'Applied'";

//         $query = mysqli_query($conn, $sql);
//         $row = mysqli_fetch_assoc($query);
//         $data[$months[$i]] = $row['count'];
//     }

//     return $data;
// }

function getdataApproved1($conn, $province,$lgus)
{
    $months =  [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
    foreach ($lgus as $key => $lgu) {
        $codes[] = $lgu['code']; 
    }

    $codes = implode(',', $codes);

    for ($i = 1; $i < count($months); $i++) {
        $sql = "SELECT pro.name as 'PROVINCE' , checklist.status, count(*) as 'count', checklist.date_created FROM `tbl_app_checklist` checklist
        LEFT JOIN tbl_admin_info ai on checklist.user_id = ai.ID
        LEFT JOIN tbl_province pro on ai.PROVINCE = pro.id 
        WHERE  ai.PROVINCE= '$province' and ai.LGU IN (".$codes.") and MONTH(checklist.date_created) = $i and checklist.status='Approved' and checklist.application_type = 'Applied'";

        //  ai.PROVINCE= '$province' and 
        $query = mysqli_query($conn, $sql);
        $result = $row = mysqli_fetch_assoc($query);
        $data[$months[$i]] = $row['count'];
    }

    return $data;
}

function getdataApprovedRO1($conn, $province_opts)
{
    $months =  [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
    $muns = [];
    foreach ($province_opts as $key => $province) {
        $muns[$key] = getCityMuns($conn, $key);
    }

    for ($i = 1; $i < count($months); $i++) {
        $total = 0;
        foreach ($province_opts as $key => $province) {
            $ss = [];
            foreach ($muns[$key] as $k => $mun){
                $ss[] = $mun['code'];
            }
            
            if (count($ss) >  0) {
                $ss = implode(',', $ss);
                $sql = "SELECT pro.name as 'PROVINCE' , checklist.status, count(*) as 'count', checklist.date_created FROM `tbl_app_checklist` checklist
                LEFT JOIN tbl_admin_info ai on checklist.user_id = ai.ID
                LEFT JOIN tbl_province pro on ai.PROVINCE = pro.id 
                WHERE  ai.PROVINCE= '$key' and MONTH(checklist.date_created) = $i and checklist.status='Approved'";

                $query = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($query);
                $total += $row['count'];
            }
        }
        $data[$months[$i]] = $total;
    }

    return $data;
}

function getdataApproved2($conn, $province,$lgus)
{
    $months =  [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
    foreach ($lgus as $key => $lgu) {
        $codes[] = $lgu['code']; 
    }

    $codes = implode(',', $codes);

    for ($i = 1; $i < count($months); $i++) {
        $sql = "SELECT pro.name as 'PROVINCE' , checklist.status, count(*) as 'count', checklist.date_created FROM `tbl_app_checklist` checklist
        LEFT JOIN tbl_admin_info ai on checklist.user_id = ai.ID
        LEFT JOIN tbl_province pro on ai.PROVINCE = pro.id 
        WHERE  ai.PROVINCE= '$province' and ai.LGU IN (".$codes.") and MONTH(checklist.date_created) = $i and checklist.status='Approved' and checklist.application_type = 'Encoded'";

        //  ai.PROVINCE= '$province' and 
        $query = mysqli_query($conn, $sql);
        $result = $row = mysqli_fetch_assoc($query);
        $data[$months[$i]] = $row['count'];
    }

    return $data;
}

function getdataApprovedRO2($conn, $province_opts)
{
    $months =  [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
    $muns = [];
    foreach ($province_opts as $key => $province) {
        $muns[$key] = getCityMuns($conn, $key);
    }

    for ($i = 1; $i < count($months); $i++) {
        $total = 0;
        foreach ($province_opts as $key => $province) {
            $ss = [];
            foreach ($muns[$key] as $k => $mun){
                $ss[] = $mun['code'];
            }
            
            if (count($ss) >  0) {
                $ss = implode(',', $ss);

                $sql = "SELECT pro.name as 'PROVINCE' , checklist.status, count(*) as 'count', checklist.date_created FROM `tbl_app_checklist` checklist
                    LEFT JOIN tbl_admin_info ai on checklist.user_id = ai.ID
                    LEFT JOIN tbl_province pro on ai.PROVINCE = pro.id 
                    WHERE  ai.PROVINCE= '$key' and MONTH(checklist.date_created) = $i and checklist.status='Approved' and checklist.application_type = 'Encoded'";

                $query = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($query);
                $total += $row['count'];
            }
        }
        $data[$months[$i]] = $total;
    }

    return $data;
}

function getdataApproved3($conn, $province,$lgus)
{
    $months =  [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
    foreach ($lgus as $key => $lgu) {
        $codes[] = $lgu['code']; 
    }

    $codes = implode(',', $codes);

    for ($i = 1; $i < count($months); $i++) {
        $sql = "SELECT pro.name as 'PROVINCE' , checklist.status, count(*) as 'count', checklist.date_created FROM `tbl_app_checklist` checklist
        LEFT JOIN tbl_admin_info ai on checklist.user_id = ai.ID
        LEFT JOIN tbl_province pro on ai.PROVINCE = pro.id 
        WHERE  ai.PROVINCE= '$province' and checklist.lgu IN (".$codes.") and MONTH(checklist.date_created) = $i and checklist.status='Approved' and checklist.application_type = 'Encoded'";

        //  ai.PROVINCE= '$province' and 
        $query = mysqli_query($conn, $sql);
        $result = $row = mysqli_fetch_assoc($query);
        $data[$months[$i]] = $row['count'];
    }

    return $data;
}

function getdataApprovedRO3($conn, $province_opts)
{
    $months =  [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
    $muns = [];
    foreach ($province_opts as $key => $province) {
        $muns[$key] = getCityMuns($conn, $key);
    }

    for ($i = 1; $i < count($months); $i++) {
        $total = 0;
        foreach ($province_opts as $key => $province) {
            $ss = [];
            foreach ($muns[$key] as $k => $mun){
                $ss[] = $mun['code'];
            }
            
            if (count($ss) >  0) {
                $ss = implode(',', $ss);

                $sql = "SELECT pro.name as 'PROVINCE' , checklist.status, count(*) as 'count', checklist.date_created FROM `tbl_app_checklist` checklist
                    LEFT JOIN tbl_admin_info ai on checklist.user_id = ai.ID
                    LEFT JOIN tbl_province pro on ai.PROVINCE = pro.id 
                    WHERE  ai.PROVINCE= '$key' and MONTH(checklist.date_created) = $i and checklist.status='Approved' and checklist.application_type = 'Encoded'";

                //  ai.PROVINCE= '$province' and 
                $query = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($query);
                $total += $row['count'];
            }
        }
        $data[$months[$i]] = $total;
    }

    return $data;
}

// function getdataApproved2($conn, $province,$lgus)
// {

//     $months =  [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
//     foreach ($lgus as $key => $lgu) {
// 		$codes[] = $lgu['code']; 
// 	}

// 	$codes = implode(',', $codes);

//     for ($i = 1; $i < count($months); $i++) {
//         $sql = "SELECT pro.name as 'PROVINCE' , checklist.status, count(*) as 'count', checklist.date_created FROM `tbl_app_checklist` checklist
//         LEFT JOIN tbl_admin_info ai on checklist.user_id = ai.ID
//         LEFT JOIN tbl_province pro on ai.PROVINCE = pro.id 
//         WHERE  ai.PROVINCE= '$province' and ai.LGU IN (".$codes.") and MONTH(checklist.date_created) = $i and checklist.status='Approved' and checklist.application_type = 'Encoded'";
//         // ai.PROVINCE= '$province' and 
//         $query = mysqli_query($conn, $sql);
//         $row = mysqli_fetch_assoc($query);
//         $data[$months[$i]] = $row['count'];
//     }

//     return $data;
// }

// function getdataApproved3($conn, $province,$lgus)
// {
//     $months =  [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
// 	foreach ($lgus as $key => $lgu) {
// 		$codes[] = $lgu['code']; 
// 	}

// 	$codes = implode(',', $codes);

//     for ($i = 1; $i < count($months); $i++) {
//         $sql = "SELECT pro.name as 'PROVINCE' , checklist.status, count(*) as 'count', checklist.date_created FROM `tbl_app_checklist` checklist
//         LEFT JOIN tbl_admin_info ai on checklist.user_id = ai.ID
//         LEFT JOIN tbl_province pro on ai.PROVINCE = pro.id 
//         WHERE  ai.PROVINCE= '$province' and checklist.lgu IN (".$codes.") and MONTH(checklist.date_created) = 6 and checklist.status='Approved' and checklist.application_type = 'Encoded'";

//         // ai.PROVINCE= '$province' and 
//         $query = mysqli_query($conn, $sql);
//         $row = mysqli_fetch_assoc($query);
//         $data[$months[$i]] = $row['count'];
//     }

//     return $data;
// }

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

function getApprovedEncodedAC($conn, $province, $lgus)
{
	$data = [];
	$val = ['For Receiving', 'Received', 'Approved', 'Disapproved'];
	foreach ($lgus as $key => $lgu) {
		$codes[] = $lgu['code']; 
	}

	$codes = implode(',', $codes);
	foreach ($val as $key => $status) {
		$sql2 = "SELECT count(*) as count
	            FROM tbl_app_checklist ac
	            LEFT JOIN tbl_admin_info ai on ai.id = ac.user_id
	            LEFT JOIN tbl_province p on p.id = ai.PROVINCE
	            LEFT JOIN tbl_citymun cm on cm.id = ai.LGU
	            WHERE p.id = '$province' AND ac.lgu IN (".$codes.") AND ac.application_type = 'Encoded' AND status = '".$status."' ";

	    $query = mysqli_query($conn, $sql2);
		$row = mysqli_fetch_assoc($query);
	    $data[$status] = $row['count'];
	}

	return $data;
}

function getApprovedAppliedAI($conn, $province, $lgus)
{
	$data = [];
	$val = ['For Receiving', 'Received', 'Approved', 'Disapproved'];
	foreach ($lgus as $key => $lgu) {
		$codes[] = $lgu['code']; 
	}

	$codes = implode(',', $codes);
	foreach ($val as $key => $status) {
		$sql = "SELECT count(*) as count
                FROM tbl_app_checklist ac
                LEFT JOIN tbl_admin_info ai on ai.id = ac.user_id
                LEFT JOIN tbl_province p on p.id = ai.PROVINCE
                LEFT JOIN tbl_citymun cm on cm.id = ai.LGU
                WHERE ai.PROVINCE = '$province' AND ai.LGU IN (".$codes.") AND ac.application_type = 'Applied' AND status = '$status' ";

	    $query = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($query);
        $data[$status] = $row['count'];
	}

	return $data;
}

function getApprovedEncodedAI($conn, $province, $lgus)
{
	$data = [];
	$val = ['For Receiving', 'Received', 'Approved', 'Disapproved'];
	foreach ($lgus as $key => $lgu) {
		$codes[] = $lgu['code']; 
	} 

	$codes = implode(',', $codes);
	foreach ($val as $key => $status) {
		$sql2 = "SELECT count(*) as count
                FROM tbl_app_checklist ac
                LEFT JOIN tbl_admin_info ai on ai.id = ac.user_id
                LEFT JOIN tbl_province p on p.id = ai.PROVINCE
                LEFT JOIN tbl_citymun cm on cm.id = ai.LGU
                WHERE p.id = '$province' AND ai.LGU IN (".$codes.") AND ac.application_type = 'Encoded' AND status = 'Approved' ";

        $query = mysqli_query($conn, $sql2);
		$row = mysqli_fetch_assoc($query);
        $data[$status] = $row['count'];
	}

	return $data;
}


function countApprovedApplied($conn, $province, $lgus) 
{
    $data = [];
    $val = ['For Receiving', 'Received', 'Approved', 'Disapproved'];
    foreach ($lgus as $key => $lgu) {
        $codes[] = $lgu['code']; 
    }

    $codes = implode(',', $codes);

    foreach ($val as $key => $status) {
        $sql = "SELECT count(*) as count
            FROM tbl_app_checklist ac
            LEFT JOIN tbl_admin_info ai on ai.id = ac.user_id
            LEFT JOIN tbl_userinfo ui on ui.user_id = ai.id
            WHERE ai.PROVINCE = ".$province." AND ai.LGU IN (".$codes.") AND ac.application_type = 'Applied' AND ac.status = '".$status."'";
        $query = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($query);
        $data[$status] = $row['count'];
    }

    return $data;
}



function getApplicationLists($conn, $province, $lgus, $status, $is_clusterhead)
{
    $data = [];

    foreach ($lgus as $key => $lgu) {
        $codes[] = $lgu['code']; 
    }

    $codes = implode(',', $codes);

    // foreach ($lgus as $key => $lgu) {
        $sql = "SELECT 
        ac.id as id,
        ai.CMLGOO_NAME as fname,
        ui.GOV_AGENCY_NAME as agency,
        ui.ADDRESS as address,
        DATE_FORMAT(ac.date_created, '%Y-%m-%d') as date_created,
        DATE_FORMAT(ac.date_approved, '%Y-%m-%d H:i:s') as date_approved,
        ui.id as userid,
        ac.control_no as control_no,
        ac.safety_seal_no as ss_no,
        ac.status as status,
        ac.address as ac_address,
        ac.application_type as app_type,
        ac.token as token
        FROM tbl_app_checklist ac
        LEFT JOIN tbl_admin_info ai on ai.id = ac.user_id
        LEFT JOIN tbl_userinfo ui on ui.user_id = ai.id
        WHERE ai.PROVINCE = ".$province." AND ai.LGU IN (".$codes.") AND ac.application_type = 'Applied' AND ac.status <> '".$status."'";
     
        $query = mysqli_query($conn, $sql);

        
        while ($row = mysqli_fetch_assoc($query)) {
            $color = 'green';
            if ($row['status'] == 'For Receiving') {
                $color = 'primary';
            } elseif ($row['status'] == 'Received') {
                $color = 'yellow';
            } elseif ($row['status'] == 'Disapproved') {
                $color = 'red';
            }

            $data[$row['id']] = [
                'id' => $row['id'],
                'userid' => $row['userid'],
                'fname' => $row['fname'],
                'agency' => $row['agency'],
                'address' => $row['address'],
                'date_created' => $row['date_created'],
                'control_no' => $row['control_no'],
                'ss_no' => $row['ss_no'],
                'status' => $row['status'],
                'color' => $color,
                'ac_address' => $row['ac_address'],
                'app_type' => $row['app_type'],
                'token' => $row['token'],
                'validity_date' => !empty($row['date_approved']) ? date('F d, Y', strtotime("+6 months", strtotime($row['date_approved']))) : ''
            ];    
        }

        $sql2 = "SELECT 
        ac.id as id,
        ai.CMLGOO_NAME as fname,
        ui.GOV_AGENCY_NAME as pagency,
        ac.agency as cagency,
        ui.ADDRESS as address,
        DATE_FORMAT(ac.date_created, '%Y-%m-%d') as date_created,
        DATE_FORMAT(ac.date_approved, '%Y-%m-%d') as date_approved,
        ui.id as userid,
        ac.control_no as control_no,
        ac.safety_seal_no as ss_no,
        ac.status as status,
        ac.address as ac_address,
        ac.application_type as app_type,
        ac.token as token
        FROM tbl_app_checklist ac
        LEFT JOIN tbl_admin_info ai on ai.id = ac.user_id
        LEFT JOIN tbl_userinfo ui on ui.user_id = ai.id
        WHERE ai.PROVINCE = ".$province." AND ac.application_type = 'Encoded'";

        if ($is_clusterhead) {
            $sql.= " AND ac.lgu IN (".$codes.")";   
        } else {
            $sql.= " AND ai.LGU IN (".$codes.")";
        }
     
        $query = mysqli_query($conn, $sql2);
        // $data = [];
        
        while ($row = mysqli_fetch_assoc($query)) {
            $color = 'green';
            if ($row['status'] == 'For Receiving') {
                $color = 'primary';
            } elseif ($row['status'] == 'Received') {
                $color = 'yellow';
            } elseif ($row['status'] == 'Disapproved') {
                $color = 'red';
            }

            $data[$row['id']] = [
                'id' => $row['id'],
                'userid' => $row['userid'],
                'fname' => $row['fname'],
                'agency' => !empty($row['cagency']) ? $row['cagency'] : $row['pagency'],
                'address' => $row['address'],
                'date_created' => $row['date_created'],
                'control_no' => $row['control_no'],
                'ss_no' => $row['ss_no'],
                'status' => $row['status'],
                'color' => $color,
                'ac_address' => $row['ac_address'],
                'app_type' => $row['app_type'],
                'token' => $row['token'],
                'validity_date' => !empty($row['date_approved']) ? date('F d, Y', strtotime("+6 months", strtotime($row['date_approved']))) : ''
            ];    
        }
    // }


    return $data;

}