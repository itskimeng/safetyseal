<?php

require 'application/config/connection.php';
require 'manager/DashboardManager.php';

$app = new DashboardManager();


$province = $_SESSION['province'];
$citymun = $_SESSION['city_mun'];


$count_status = $app->countStatus($province, $citymun);
$provinces_title = $app->setBarChartLabel();
$receiving = $app->getdataForReceived();
$approved = $app->getdataApproved();



?>
