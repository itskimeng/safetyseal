<?php 
session_start();
require 'session_checker.php';
require_once 'frontend/bower_components/phpti-master/src/ti.php'; ?>

<?php include 'base_template.php'; ?>

<?php startblock('title'); ?>
  Generate Report
<?php endblock('title'); ?>

<?php 
// session_start();

startblock('content'); ?>
  <?php include('layout/macro.php'); ?>
    <?php include('views/application/report/index.php'); ?>
<?php endblock(); ?>
