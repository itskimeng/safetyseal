<?php	
date_default_timezone_set('Asia/Manila');

require_once '../entity/aws-api-php-client/aws-api-setting.php';
require_once '../entity/aws-api-php-client/aws-uploads-data.php';
require_once '../manager/ApplicationManager.php';
require_once '../vendor/autoload.php';

$config = new BucketUploads();
$app = new ApplicationManager();

$aws_client = new Aws\S3\S3Client([
    'region'  => $config->BUCKET_REGION, 
	'version' => $config->BUCKET_VERSION, 
	'credentials' => [
		'key' => $config->BUCKET_ID, 
		'secret' => $config->BUCKET_SECRET
	]
]);

$bucket = 'safetyseal';
$files = $_POST['filename'];
$list_order = preg_replace('/[^0-9.]+/', '', $_POST['checklist_order']);
$token = $_POST['token_id'];
$msg = 'Attachments has been successfully deleted.';

foreach ($files as $key => $file) {
	try {
	    $result = $aws_client->deleteObject([
	        'Bucket' => $bucket,
	        'Key'    => $file
	    ]);
	}
	catch (S3Exception $e) {
		$msg = $e->getMessage();
		exit;
	}
}

$_SESSION['toastr'] = $app->addFlash('success', $msg, 'Checklist #'.$list_order);

header('location:../wbstapplication.php?ssid='.$token);exit;
