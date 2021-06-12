<?php

require 'application/config/connection.php';
require 'manager/ComponentsManager.php';

$app = new ComponentsManager();

$provinces = $app->getProvinces();
$city_mun = $app->getCityMuns();

?>
