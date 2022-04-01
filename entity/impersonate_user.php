<?php
session_start();
date_default_timezone_set('Asia/Manila');

require '../Model/Connection.php';
require '../application/config/connection.php';
require '../manager/UserManager.php';	

$um = new UserManager;

$id = $_GET['id'];

$data = $um->getUserInfo($id);
$uname = $data['username'];
$pword = $data['password'];

if($data['is_verified']) {
    if ($data['roles'] == 'admin') {
		$_SESSION = [
			'username'			=> $data['username'],
			'province'			=> $data['province'],
			'city_mun'			=> $data['city_mun'],
			'userid'			=> $id,
			'nature'			=> $data['nature'],
			'is_clusterhead'	=> $data['is_clusterhead'],
			'ch_id'				=> $data['ch_id'],
			'is_pfp'		    => $data['is_pfp'],
			'position'			=> $data['position']
		];

      header("location: ../dashboard.v2.php?username=" . md5($data['username']) . "");
    } else if ($data['roles'] == 'user') {
        $_SESSION = [
			'name'				=> $data['name'],
			'username'			=> $data['username'],
			'province'			=> $data['province'],
			'city_mun'			=> $data['city_mun'],
			'userid'			=> $id,
			'email'				=> $data['email']
		];

        header("location:../dashboard_user.php?username=" . md5($data['username']) . "");
    }
}

