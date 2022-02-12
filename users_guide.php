<?php
session_start();
require 'session_checker.php';
require_once 'frontend/bower_components/phpti-master/src/ti.php'; 
?>

<?php include 'base_template.php'; ?>

<?php startblock('title'); ?>
  User's Guide
<?php endblock('title'); ?>

<?php startblock('content'); ?>
  <?php include('users_guide/index.php'); ?>
<?php endblock(); ?>
