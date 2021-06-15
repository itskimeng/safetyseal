<?php

require 'application/config/connection.php';
require 'manager/ComponentsManager.php';

$app = new ComponentsManager();

$provinces = $app->getProvinces();
$city_mun = json_encode(convertToString($app->getCityMuns()));

function convertToString ($data) {
	return json_encode(array_map(function($x) { return $x; }, $data));
}
