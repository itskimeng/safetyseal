<?php
session_start();
date_default_timezone_set('Asia/Manila');

require '../Model/Connection.php';    
require '../manager/ApplicationManager.php';
require '../application/config/connection.php';

$am = new ApplicationManager();

$entry_id = $_GET['id'];
$for_renewal = $_GET['for_renewal'];

$lists = $am->getUploadedMOVS($entry_id, $for_renewal);

echo $lists;

