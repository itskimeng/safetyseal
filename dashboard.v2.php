<?php
session_start();
require_once 'frontend/bower_components/phpti-master/src/ti.php'; 
require_once 'controller/DashboardController.php';
?>

<?php include 'base_template.php'; ?>

<?php startblock('title'); ?>
  Dashboard
<?php endblock('title'); ?>

<?php startblock('content'); ?>
  <?php include('views/dashboard/index.php'); ?>
<?php endblock(); ?>
