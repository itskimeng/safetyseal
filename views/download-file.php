<?php 

$pdfFile = str_replace(' ', '+', $_GET['filename']);

// $pdfFile = 'http://safetyseal.calabarzon.dilg.gov.ph/files/guidelines/'.$pdfFile;
$pdfFile = 'C:/xampp/htdocs/safetyseal/files/guidelines/'.$pdfFile; 

//Set the Content-Type to application/pdf
header('Content-Type: application/pdf');

//Set the Content-Length header.
header('Content-Length: ' . filesize($pdfFile));

//Set the Content-Transfer-Encoding to "Binary"
header('Content-Transfer-Encoding: Binary');


//Set the Content-Disposition to attachment and specify
//the name of the file.
header('Content-Disposition: attachment; filename=' . $_GET['filename']);

//Read the PDF file data and exit the script.
readfile($pdfFile);
exit;