<?php

$province = $_SESSION['province'];
$citymun = $_SESSION['city_mun'];
$is_clusterhead = $_SESSION['is_clusterhead'];
$clusterhead_id = $_SESSION['clusterhead_id'];
$is_pfp = $_SESSION['is_pfp'];
$is_rofp = (($province == 0) && ($citymun == 00));
$hlbl = ""; 

if ($is_rofp) {
    $hlbl = '(REGIONAL OFFICE FOCAL PERSON)';
}

if ($is_clusterhead) {
    $hlbl = '(CLUSTERHEAD)';
} 

if ($is_pfp) {
    $hlbl = '(PROVINCIAL FOCAL PERSON)';
} 