<?php
session_start();
date_default_timezone_set('Asia/Manila');

require_once '../entity/aws-api-php-client/aws-api-setting.php';
require_once '../entity/aws-api-php-client/aws-uploads-data.php';
require_once '../manager/ApplicationManager.php';
require_once '../manager/SafetysealHistoryManager.php';
require_once '../vendor/autoload.php';

$bucket = new BucketUploads();
$app = new ApplicationManager();

$aws_client = new Aws\S3\S3Client([
    'region'  => 'us-east-2', 
	'version' => 'latest', 
	'credentials' => [
		'key' => $bucket->BUCKET_ID, 
		'secret' => $bucket->BUCKET_SECRET
	]
]);
$entry_id = $_POST['entry_id'];
$list_order = preg_replace('/[^0-9.]+/', '', $_POST['checklist_order']);
$token = $_POST['token_id'];
$no_error = true;
$msg = 'Attachments has been successfully uploaded.';
$bucket = 'safetyseal';

foreach ($_FILES['files']['name'] as $key => $filename) {
	$filetmp = strtolower($_FILES['files']['tmp_name'][$key]);
	$fileType = $_FILES['files']['type'][$key];
	$key = uniqid().'-'.basename($filename);
	$path = 'checklist-'.$list_order.'/';
	$file = $path.$key;
	try {
		$result = $aws_client->putObject([
			'Bucket' => $bucket,
			'Key'    => $file,
			'Body'   => fopen($filetmp, 'r'),
			'ACL'    => 'public-read',
			'ContentType' => $fileType
		]);

		$apps = $app->insertAttachments($entry_id, $file);

	} catch (Aws\S3\Exception\S3Exception $e) {
		$msg = $e->getMessage();
		exit;
	}
}

$_SESSION['toastr'] = $app->addFlash('success', $msg, 'Checklist #'.$list_order);

header('location:../wbstapplication.php?ssid='.$token);exit;



