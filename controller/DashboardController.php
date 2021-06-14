<?php

require 'application/config/connection.php';
require 'manager/DashboardManager.php';

$app = new DashboardManager();
$province = $_SESSION['province'];
$count_status = $app->count();
$lgu = $app->setLGU($province);
$receiving = $app->getdataForReceived($province);
$approved = $app->getdataApproved($province);





?>
