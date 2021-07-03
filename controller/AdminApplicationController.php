<?php
date_default_timezone_set('Asia/Manila');

require 'application/config/connection.php';
require 'manager/ApplicationManager.php';

$app = new ApplicationManager();

$province = $_SESSION['province'];
$citymun = $_SESSION['city_mun'];
$is_adminro = false;
$today = new DateTime();
if ($province == 0 AND $citymun == 00) {
	$is_adminro = true;
}

$_SESSION['gcode'] = isset($_GET['code']) ? $_GET['code'] : '';
$_SESSION['gscope'] = isset($_GET['scope']) ? $_GET['scope'] : '';

$status_opts = [
	ApplicationManager::STATUS_FOR_RECEIVING => ApplicationManager::STATUS_FOR_RECEIVING,
	ApplicationManager::STATUS_RECEIVED => ApplicationManager::STATUS_RECEIVED,
	ApplicationManager::STATUS_APPROVED => ApplicationManager::STATUS_APPROVED,
	ApplicationManager::STATUS_DISAPPROVED => ApplicationManager::STATUS_DISAPPROVED
];

$apptype_opts = [
	ApplicationManager::TYPE_APPLIED => ApplicationManager::TYPE_APPLIED,
	ApplicationManager::TYPE_ENCODED => ApplicationManager::TYPE_ENCODED
];

$province_opts = $app->getProvinces();
$citymun_opts = $app->getCityMuns($province);
$today1 = $today->format('m');
$current_time = $today->format('m/d/Y h:i:s a');
$month_options = month_options($today1);

$timestamp = date('Y-m-d H:i:s', time());

if (!$is_adminro) {
	$applicants = $app->getApplicationLists($province, $citymun, ApplicationManager::STATUS_DRAFT);
} else {
	$applicants = $app->getAllApplicationLists();
	$reports['total_application'] = $app->getTotalApplications('',$timestamp);
	$reports['total_received'] = $app->getTotalReceivedApplications('',$timestamp);
	$reports['total_approved'] = $app->getTotalApprovedApplications('',$timestamp);
	$reports['total_disapproved'] = $app->getTotalDisapprovedApplications('',$timestamp);

	$reports['batangas_application'] = $app->getTotalApplications(3,$timestamp);
	$reports['batangas_received'] = $app->getTotalReceivedApplications(3,$timestamp);
	$reports['batangas_approved'] = $app->getTotalApprovedApplications(3,$timestamp);
	$reports['batangas_disapproved'] = $app->getTotalDisapprovedApplications(3,$timestamp);

	$reports['cavite_application'] = $app->getTotalApplications(1,$timestamp);
	$reports['cavite_received'] = $app->getTotalReceivedApplications(1,$timestamp);
	$reports['cavite_approved'] = $app->getTotalApprovedApplications(1,$timestamp);
	$reports['cavite_disapproved'] = $app->getTotalDisapprovedApplications(1,$timestamp);

	$reports['laguna_application'] = $app->getTotalApplications(2,$timestamp);
	$reports['laguna_received'] = $app->getTotalReceivedApplications(2,$timestamp);
	$reports['laguna_approved'] = $app->getTotalApprovedApplications(2,$timestamp);
	$reports['laguna_disapproved'] = $app->getTotalDisapprovedApplications(2,$timestamp);

	$reports['rizal_application'] = $app->getTotalApplications(4,$timestamp);
	$reports['rizal_received'] = $app->getTotalReceivedApplications(4,$timestamp);
	$reports['rizal_approved'] = $app->getTotalApprovedApplications(4,$timestamp);
	$reports['rizal_disapproved'] = $app->getTotalDisapprovedApplications(4,$timestamp);

	$reports['huc_application'] = $app->getTotalApplications('huc',$timestamp);
	$reports['huc_received'] = $app->getTotalReceivedApplications('huc',$timestamp);
	$reports['huc_approved'] = $app->getTotalApprovedApplications('huc',$timestamp);
	$reports['huc_disapproved'] = $app->getTotalDisapprovedApplications('huc',$timestamp);

}


function month_options($today) {
	$options = [
		'01' => 'January',
		'02' => 'February',
		'03' => 'March',
		'04' => 'April',
		'05' => 'May',
		'06' => 'June',
		'07' => 'July',
		'08' => 'August',
		'09' => 'September',
		'10' => 'October',
		'11' => 'November',
		'12' => 'December'
	];

	$dd = [];

	foreach ($options as $key => $opt) {
		if ($key <= $today) {
			$dd[$key] = $opt;
		}
	}

	return $dd;
}
