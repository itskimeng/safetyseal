<?php

require 'application/config/connection.php';
require 'manager/DashboardManager.php';

$app = new DashboardManager();

$province = $_SESSION['province'];
$citymun = $_SESSION['city_mun'];


$count_status = $app->countStatus($province, $citymun);

// $provinces_title = $app->setBarChartLabel();
// ============
$receiving = $app->getdataForReceived($province);
$approved = $app->getdataApproved($province);


// $province = $_SESSION['province'];
// $count_status = $app->count();
// $lgu = $app->setLGU($province);
// $receiving = $app->getdataForReceived($province);
// $approved = $app->getdataApproved($province);

?>
