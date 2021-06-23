<?php 

$pdfFile = $_GET['filename'];
$pdfFile = str_replace(' ', '+', $pdfFile);
$file_url = 'C:/xampp/htdocs/safetyseal/files/guidelines/'.$pdfFile ;
header('Content-Type: application/pdf');
header("Content-Transfer-Encoding: Binary"); 
header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\""); 
readfile($file_url); 
