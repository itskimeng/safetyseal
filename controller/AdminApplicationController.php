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
	$client_details = $app->getNotifDetailsClients(ApplicationManager::STATUS_APPROVED);

} else {
	$applicants = $app->getAllApplicationLists();
	$reports['total_application'] = $app->showAllApplications('',$timestamp);
	$reports['total_received'] = $app->showAllApplications('',$timestamp,ApplicationManager::STATUS_RECEIVED);
	$reports['total_approved'] = $app->showAllApplications('',$timestamp,ApplicationManager::STATUS_APPROVED);
	$reports['total_disapproved'] = $app->showAllApplications('',$timestamp,ApplicationManager::STATUS_DISAPPROVED);

	$reports['batangas_application'] = $app->showAllApplications(3,$timestamp);
	$reports['batangas_received'] = $app->showAllApplications(3,$timestamp,ApplicationManager::STATUS_RECEIVED);
	$reports['batangas_approved'] = $app->showAllApplications(3,$timestamp,ApplicationManager::STATUS_APPROVED);
	$reports['batangas_disapproved'] = $app->showAllApplications(3,$timestamp,ApplicationManager::STATUS_DISAPPROVED);

	$reports['cavite_application'] = $app->showAllApplications(1,$timestamp);
	$reports['cavite_received'] = $app->showAllApplications(1,$timestamp,ApplicationManager::STATUS_RECEIVED);
	$reports['cavite_approved'] = $app->showAllApplications(1,$timestamp,ApplicationManager::STATUS_APPROVED);
	$reports['cavite_disapproved'] = $app->showAllApplications(1,$timestamp,ApplicationManager::STATUS_DISAPPROVED);

	$reports['laguna_application'] = $app->showAllApplications(2,$timestamp);
	$reports['laguna_received'] = $app->showAllApplications(2,$timestamp,ApplicationManager::STATUS_RECEIVED);
	$reports['laguna_approved'] = $app->showAllApplications(2,$timestamp,ApplicationManager::STATUS_APPROVED);
	$reports['laguna_disapproved'] = $app->showAllApplications(2,$timestamp,ApplicationManager::STATUS_DISAPPROVED);

	$reports['rizal_application'] = $app->showAllApplications(4,$timestamp);
	$reports['rizal_received'] = $app->showAllApplications(4,$timestamp,ApplicationManager::STATUS_RECEIVED);
	$reports['rizal_approved'] = $app->showAllApplications(4,$timestamp,ApplicationManager::STATUS_APPROVED);
	$reports['rizal_disapproved'] = $app->showAllApplications(4,$timestamp,ApplicationManager::STATUS_DISAPPROVED);

	$reports['huc_application'] = $app->showAllApplications('huc',$timestamp);
	$reports['huc_received'] = $app->showAllApplications('huc',$timestamp,ApplicationManager::STATUS_RECEIVED);
	$reports['huc_approved'] = $app->showAllApplications('huc',$timestamp,ApplicationManager::STATUS_APPROVED);
	$reports['huc_disapproved'] = $app->showAllApplications('huc',$timestamp,ApplicationManager::STATUS_DISAPPROVED);

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
