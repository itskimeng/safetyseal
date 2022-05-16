<?php
session_start();
  require 'session_checker.php';  
  require_once 'frontend/bower_components/phpti-master/src/ti.php'; 
?>

<?php include 'base_template.php'; ?>

<?php startblock('title'); ?>
  Settings
<?php endblock('title'); ?>

<?php startblock('content'); ?>  
    <?php include('views/settings/index.php'); ?>
<?php endblock(); ?>
