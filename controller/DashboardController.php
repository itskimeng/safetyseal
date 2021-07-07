<?php

require 'application/config/connection.php';
require 'manager/DashboardManager.php';

$app = new DashboardManager();

$province = $_SESSION['province'];
$citymun = $_SESSION['city_mun'];
$is_clusterhead = $_SESSION['is_clusterhead'];
$is_pfp = $_SESSION['is_pfp'];

if ($is_clusterhead) {
	$hlbl = 'CLUSTERHEAD';
} 

if ($is_pfp) {
	$hlbl = 'PROVINCIAL FOCAL PERSON';
} 

$count_status = $app->countStatus($province, $citymun);
$receiving = $app->getdataForReceived($province,$citymun);
$approved = $app->getdataApproved($province,$citymun);
$lgu = $app->getCityMuns($province);
$est_safety_seal = $app->getEstablishmentSSC($province,$citymun);
