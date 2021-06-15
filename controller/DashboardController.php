<?php

require 'application/config/connection.php';
require 'manager/DashboardManager.php';

$app = new DashboardManager();

$province = $_SESSION['province'];
$citymun = $_SESSION['city_mun'];


$count_status = $app->countStatus($province, $citymun);
$receiving = $app->getdataForReceived($province);
$approved = $app->getdataApproved($province);
$lgu = $app->getCityMuns($province);

?>
