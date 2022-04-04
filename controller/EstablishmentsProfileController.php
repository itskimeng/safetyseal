<?php
date_default_timezone_set('Asia/Manila');

require_once 'application/config/connection.php';  
require_once 'Model/Connection.php';  
require_once 'manager/ApplicationManager.php';

$am = new ApplicationManager;


$establishmentId = $_GET['id'];

$selectApplication = ' SELECT `id`, `control_no`, `user_id`, agency, `establishment`, `nature`, `address`, person, contact_details, `status`, `has_consent`, `date_created`, `date_proceed`, `receiver_id`, `date_received`, `approver_id`, `date_approved`, `safety_seal_no`, `reassessed_by`, `date_reassessed`, `date_modified`, `token` FROM `tbl_app_checklist` WHERE status IN ("Approved", "Renewed", "Expired") AND `id` = "'.$establishmentId.'" ';
$execSelectApplication = $conn->query($selectApplication);
$resultApplication = $execSelectApplication->fetch_assoc();

$selectApplicantDetails = ' SELECT `ID`, `REGION`, `PROVINCE`, `LGU`, `OFFICE`, `CMLGOO_NAME`, `UNAME`, `PASSWORD`, `VERIFICATION_CODE`, `IS_APPROVED`, `IS_VERIFIED`, `ROLES`, `EMAIL` FROM `tbl_admin_info` WHERE `ID` = "'.$resultApplication['user_id'].'" ';
$execApplicantDetails = $conn->query($selectApplicantDetails);
$resultApplicantDetails = $execApplicantDetails->fetch_assoc();

$selectAddress = ' SELECT `ID`, `USER_ID`, `ADDRESS`, `POSITION`, `MOBILE_NO`, `EMAIL_ADDRESS`, `GOV_AGENCY_NAME`, `GOV_ESTB_NAME`, `DATE_REGISTERED`, `GOV_NATURE_NAME` FROM `tbl_userinfo` WHERE `USER_ID` = "'.$resultApplication['user_id'].'" ';
$execAddress = $conn->query($selectAddress);
$resultAddress = $execAddress->fetch_assoc();


$selectProvince = ' SELECT `id`, `code`, `name`, `date_created` FROM `tbl_province` WHERE `id` = "'.$resultApplicantDetails['PROVINCE'].'" ';
$execProvince = $conn->query($selectProvince);
$resultProvince = $execProvince->fetch_assoc();
$province = strtoupper($resultProvince['name']);


$selectLgu = ' SELECT `id`, `province`, `code`, `name`, `date_created` FROM `tbl_citymun` WHERE `id` = "'.$resultApplicantDetails['LGU'].'" AND `province` = "'.$resultApplicantDetails['PROVINCE'].'" ';
$execLgu = $conn->query($selectLgu);
$resultLgu = $execLgu->fetch_assoc();
$lgu = strtoupper($resultLgu['name']);

$selectInspection = ' SELECT `ID`, `PROVINCE`, `LGU`, `NAME`, `EMAIL_ADDRESS`, `CONTACT_NO`, `PNP`, `BFP`, `ICT_HOTLINE`, `EMAIL_ADDRESS_COMPLAINTS` FROM `tbl_inspection_team` WHERE `PROVINCE_ID` = "'.$resultApplicantDetails['PROVINCE'].'" AND `LGU_ID` = "'.$resultApplicantDetails['LGU'].'" ';

$execInspection = $conn->query($selectInspection);
$resultInspection = $execInspection->fetch_assoc();



if ($resultApplication['agency'] == '') 
{
  $agency = $resultApplicantDetails['OFFICE'];
}
else
{
  $agency = $resultApplication['agency'];
}
