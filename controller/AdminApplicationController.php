<?php
session_start();
date_default_timezone_set('Asia/Manila');

require 'application/config/connection.php';
require 'manager/ApplicationManager.php';

$app = new ApplicationManager();

$province_opts = $app->getProvinces();
$citymun_opts = $app->getCityMuns();
$applicants = $app->getApplicationLists(ApplicationManager::STATUS_FOR_APPROVAL);

// $applicants_data = $app->getUserChecklists($user); 
