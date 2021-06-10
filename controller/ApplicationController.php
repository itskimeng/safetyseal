<?php
session_start();
date_default_timezone_set('Asia/Manila');

require 'application/config/connection.php';
require 'manager/ApplicationManager.php';

$app = new ApplicationManager();

$appchecklists = $app->getChecklists();
