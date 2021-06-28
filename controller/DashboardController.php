<?php

require 'application/config/connection.php';
require 'manager/DashboardManager.php';

$app = new DashboardManager();

$province = $_SESSION['province'];
$citymun = $_SESSION['city_mun'];


$count_status = $app->countStatus($province, $citymun);
$receiving = $app->getdataForReceived($province,$citymun);
$approved = $app->getdataApproved($province,$citymun);
$lgu = $app->getCityMuns($province);
$est_safety_seal = $app->getEstablishmentSSC($province,$citymun);

?>
