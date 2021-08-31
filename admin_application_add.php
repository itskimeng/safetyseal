<?php 
session_start();
require 'session_checker.php';
require_once 'frontend/bower_components/phpti-master/src/ti.php'; ?>

<?php include 'base_template.php'; ?>

<?php startblock('title'); ?>
  Application New
<?php endblock('title'); ?>

<?php startblock('content'); ?>
  <?php include('views/application/add_application.php'); ?>
<?php endblock(); ?>
