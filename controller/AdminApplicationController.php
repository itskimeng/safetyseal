<?php
date_default_timezone_set('Asia/Manila');

require 'application/config/connection.php';
require 'manager/ApplicationManager.php';

$app = new ApplicationManager();

$province = $_SESSION['province'];
$citymun = $_SESSION['city_mun'];

$status_opts = [
	ApplicationManager::STATUS_FOR_RECEIVING => ApplicationManager::STATUS_FOR_RECEIVING,
	ApplicationManager::STATUS_RECEIVED => ApplicationManager::STATUS_RECEIVED,
	ApplicationManager::STATUS_APPROVED => ApplicationManager::STATUS_APPROVED,
	ApplicationManager::STATUS_DISAPPROVED => ApplicationManager::STATUS_DISAPPROVED
];

$province_opts = $app->getProvinces();
$citymun_opts = $app->getCityMuns($province);
$applicants = $app->getApplicationLists($province, $citymun, ApplicationManager::STATUS_DRAFT);
