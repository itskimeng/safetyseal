<?php
require 'application/config/connection.php';
require 'manager/ApplicationManager.php';
require 'manager/ComponentsManager.php';

$am = new ApplicationManager();
$cm = new ComponentsManager();

$id = $_GET['id'];
$province = $_SESSION['province'];
$citymun = $_SESSION['city_mun'];
$is_clusterhead = $_SESSION['is_clusterhead'];
$clusterhead_id = $_SESSION['clusterhead_id'];
$is_pfp = $_SESSION['is_pfp'];
$is_rofp = (($province == 0) && ($citymun == 00));
$hlbl = ""; 
$user = $am->getUserData($id);
$province_opts = $am->getProvinces();
$lgu_opts = $am->getCityMuns($user['province_id']);
$govnature_opts = $cm->getGovtNature();
// $lgu_opts2 = $am->getCityMuns2();
$lgu_opts2 = convertToString($am->getCityMuns2());
$role_opts = ['admin', 'user'];

if ($is_rofp) {
    $hlbl = '(REGIONAL OFFICE FOCAL PERSON)';
}

if ($is_clusterhead) {
	$hlbl = '(CLUSTERHEAD)';
} 

if ($is_pfp) {
    $hlbl = '(PROVINCIAL FOCAL PERSON)';
} 

function convertToString ($data) {
    return json_encode(array_map(function($x) { return json_encode($x); }, $data));
}