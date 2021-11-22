<?php
date_default_timezone_set('Asia/Manila');

require_once '../entity/aws-api-php-client/aws-api-setting.php';
require_once '../entity/aws-api-php-client/aws-uploads-data.php';
require_once '../vendor/autoload.php';
require '../manager/ApplicationManager.php';

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
$id = $_GET['id'];
$list_order = $_GET['list_order'];
$prefix = 'checklist-'.$list_order;

$objects = $aws_client->getIterator('ListObjects', array(
    'Bucket' => $bucket,
    'Delimiter' => '/',
    'Prefix' => $prefix.'/'
));

$data = array();
$movs = $app->getUserMOVS($id);

foreach ($objects as $key => $object) {
	if (in_array($object['Key'], $movs)) {
		$meta = $aws_client->headObject(['Bucket'=>$bucket, 'Key'=>$object['Key']]);
		$header = $meta['@metadata']['headers'];
		if ($object['Size'] > 0) {
			$cover_page = null;
			if (strpos($header['content-type'], 'pdf')) {
	            $cover_page = 'files/certified/pdf_icon.png';
	        } elseif (strpos($header['content-type'], 'spreadsheetml.sheet')) {
	            $cover_page = 'files/certified/excel_icon.png';
	        } elseif (strpos($header['content-type'], 'msword') OR strpos($header['content-type'], 'wordprocessing')) {
	            $cover_page = 'files/certified/word_icon.png';
	        }

			$data[] = [
				'filename' 		=> $object['Key'],
				'url' 			=> $aws_client->getObjectUrl($bucket, $object['Key']), 
				'cover_page' 	=> $cover_page
			];
		}
	}
}

echo json_encode($data);