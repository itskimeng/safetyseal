<?php
session_start();
  require 'session_checker.php';  
  require_once 'frontend/bower_components/phpti-master/src/ti.php'; 
?>

<?php include 'base_template.php'; ?>

<?php startblock('title'); ?>
  Dashboard
<?php endblock('title'); ?>

<?php startblock('content'); ?>
  <?php if (isset($_GET['province']) AND $_GET['province'] == 'cavite'): ?>
    <?php include('views/dashboard/cavite.php'); ?>
  <?php elseif (isset($_GET['province']) AND $_GET['province'] == 'laguna'): ?>  
    <?php include('views/dashboard/laguna.php'); ?>
  <?php elseif (isset($_GET['province']) AND $_GET['province'] == 'batangas'): ?>  
    <?php include('views/dashboard/batangas.php'); ?>
  <?php elseif (isset($_GET['province']) AND $_GET['province'] == 'rizal'): ?>  
    <?php include('views/dashboard/rizal.php'); ?>
  <?php elseif (isset($_GET['province']) AND $_GET['province'] == 'quezon'): ?>  
    <?php include('views/dashboard/quezon.php'); ?>
  <?php else: ?>
    <?php include('views/dashboard/index.php'); ?>
  <?php endif ?>
<?php endblock(); ?>
