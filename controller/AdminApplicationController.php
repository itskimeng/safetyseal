<?php
date_default_timezone_set('Asia/Manila');

require 'application/config/connection.php';
require 'manager/ApplicationManager.php';

$app = new ApplicationManager();

$province_opts = $app->getProvinces();
$citymun_opts = $app->getCityMuns();
$applicants = $app->getApplicationLists(ApplicationManager::STATUS_DRAFT);

// $applicants_data = $app->getUserChecklists($user); 
