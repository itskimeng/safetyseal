<?php
session_start();
date_default_timezone_set('Asia/Manila');

require '../Model/Connection.php';
require '../manager/ApplicationManager.php';

$am = new ApplicationManager();
$lgu_opts = $am->getCityMuns($_GET['id']);

echo json_encode($lgu_opts);