<?php
date_default_timezone_set('Asia/Manila');

require 'application/config/connection.php';
require 'manager/ApplicationManager.php';

$app = new ApplicationManager();

$province = $_SESSION['province'];
$citymun = $_SESSION['city_mun'];
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
$applicants = $app->getApplicationLists($province, $citymun, ApplicationManager::STATUS_DRAFT);
