<?php

require 'application/config/connection.php';
require 'manager/DashboardManager.php';

$app = new DashboardManager();

$province = $_SESSION['province'];
$citymun = $_SESSION['city_mun'];
$is_clusterhead = $_SESSION['is_clusterhead'];
$clusterhead_id = $_SESSION['clusterhead_id'];
$is_pfp = $_SESSION['is_pfp'];
$hlbl = ""; 

if ($is_clusterhead) {
	$hlbl = '(CLUSTERHEAD)';
} 

if ($is_pfp) {
	$hlbl = '(PROVINCIAL FOCAL PERSON)';
} 


if ($is_pfp) {
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
	$lgu = $app->getCityMuns($province);

	$count_status = cc1($conn, $province, $citymun_opts);
	$count_status2 = cc2($conn, $province, $citymun_opts);
	$count_status3 = cc3($conn, $province, $citymun_opts);

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
        // ai.PROVINCE= '$province' and 
        $query = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($query);
        $data[$months[$i]] = $row['count'];
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
        // ai.PROVINCE= '$province' and 
        $query = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($query);
        $data[$months[$i]] = $row['count'];
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
        // ai.PROVINCE= '$province' and 
        $query = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($query);
        $data[$months[$i]] = $row['count'];
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

function cc1($conn, $province, $lgus)
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
	            WHERE p.id = '$province' AND ac.lgu IN (".$codes.") AND ac.application_type = 'Encoded' AND status = '$status' ";

	    $query = mysqli_query($conn, $sql2);
		$row = mysqli_fetch_assoc($query);
	    $data[$status] = $row['count'];
	}

	return $data;
}

function cc2($conn, $province, $lgus)
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

function cc3($conn, $province, $lgus)
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
                WHERE p.id = '$province' AND ai.LGU IN (".$codes.") AND ac.application_type = 'Encoded' AND status = '$status' ";

        $query = mysqli_query($conn, $sql2);
		$row = mysqli_fetch_assoc($query);
        $data[$status] = $row['count'];
	}

	return $data;
}