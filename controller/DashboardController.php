<?php

require 'application/config/connection.php';
require 'manager/DashboardManager.php';

$app = new DashboardManager();

$province = $_SESSION['province'];
$citymun = $_SESSION['city_mun'];


$count_status = $app->countStatus($province, $citymun);

// basic principle ng OOP and best coding practices
// 'set' is used kapag nagseset ka ng value papunta ng entity/db
// never gagamitin as prefix ng function
// palitan mo to
$provinces_title = $app->setBarChartLabel();
// ============
$receiving = $app->getdataForReceived();
$approved = $app->getdataApproved();


// $province = $_SESSION['province'];
// $count_status = $app->count();
// $lgu = $app->setLGU($province);
// $receiving = $app->getdataForReceived($province);
// $approved = $app->getdataApproved($province);

?>
