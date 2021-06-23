<?php 

$pdfFile = $_GET['filename'];
$pdfFile = str_replace(' ', '+', $pdfFile);
$file_url = 'C:/xampp/htdocs/safetyseal/files/guidelines/'.$pdfFile ;
header('Content-Type: application/pdf');
header("Content-Transfer-Encoding: Binary"); 
header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\""); 
readfile($file_url); 


// $pdfFile = str_replace(' ', '+', $_GET['filename']);

// $pdfFile = 'C:/xampp/htdocs/safetyseal/files/guidelines/'.$pdfFile ;
// // echo "<br>";
// // echo $pdfFile = 'C:/xampp/htdocs/safetyseal/files/guidelines/IA+Safety+Seal+Toolkit.pdf';
// // echo "<br>";
// // echo $pdfFile = 'C:/xampp/htdocs/safetyseal/files/guidelines/Joint+Memorandum+Circular+No+.21-01.pdf';
// // // echo $pdfFile = 'safetyseal/'.$_GET['filename'];

// //Set the Content-Type to application/pdf
// header('Content-Type: application/pdf');

// //Set the Content-Length header.
// header('Content-Length: ' . filesize($pdfFile));

// //Set the Content-Transfer-Encoding to "Binary"
// header('Content-Transfer-Encoding: Binary');


// //Set the Content-Disposition to attachment and specify
// //the name of the file.
// header('Content-Disposition: attachment; filename=' . $pdfFile);

// //Read the PDF file data and exit the script.
// readfile($pdfFile);
// exit;