<?php

require 'Model/Connection.php';
require 'application/config/connection.php';
require 'manager/UserManager.php';
require 'manager/ApplicationManager.php';
require 'manager/ComponentsManager.php';

$app = new UserManager();
$am = new ApplicationManager();
$cm = new ComponentsManager();

if (isset($_GET['lgu'])) {

} else {

	$provinces = $am->getProvincesList();
	// $provinces = [1 => 'Cavite', 2 => 'Laguna', 3 => 'Batangas', 4 => 'Rizal', 5 => 'Quezon', 8 => 'Lucena City (HUC)'];
	$pps = [];

	$colors = [
		1 	=> 'cavite-border',
		2 	=> 'laguna-border',
		3 	=> 'batangas-border',
		4 	=> 'rizal-border',
		5 	=> 'quezon-border',
		8 	=> 'lucena-border'
	];

	foreach ($provinces as $key => $province) {
		$clusters = $am->getClusters($key);
		$pps[$key] = [
			'province' 		=> $province['name'],
			'alert_level' 	=> $province['alert_level'],
			'clusters' 		=> $am->fetchProvinces($clusters)	
		];
	}
}


