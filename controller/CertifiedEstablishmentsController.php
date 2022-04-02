<?php
date_default_timezone_set('Asia/Manila');

require_once 'Model/Connection.php';	
require_once 'manager/ApplicationManager.php';

$am = new ApplicationManager;

$applied_establishments = $am->fetchAppliedCertifiedEstablishments();
$encoded_establishments = $am->fetchEncodedCertifiedEstablishments();

$establishments = array_merge($applied_establishments, $encoded_establishments);



