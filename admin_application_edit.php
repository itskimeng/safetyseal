<?php 
session_start();
require_once 'frontend/bower_components/phpti-master/src/ti.php'; ?>

<?php include 'base_template.php'; ?>

<?php startblock('title'); ?>
  Application Edit
<?php endblock('title'); ?>

<?php startblock('content'); ?>
  <?php include('views/application/edit_application.php'); ?>
<?php endblock(); ?>
