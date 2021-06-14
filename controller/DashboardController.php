<?php

require 'application/config/connection.php';
require 'manager/DashboardManager.php';

$app = new DashboardManager();

$count_status = $app->count();
$provinces_title = $app->setBarChartLabel();





?>
