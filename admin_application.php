<?php require_once 'frontend/bower_components/phpti-master/src/ti.php'; ?>

<?php include 'base_template.php'; ?>

<?php startblock('title'); ?>
  Application
<?php endblock('title'); ?>

<?php startblock('content'); ?>
  <?php include('views/application/index.php'); ?>
<?php endblock(); ?>
