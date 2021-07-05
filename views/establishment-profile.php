<?php 
require_once 'application/config/connection.php'; 
$establishmentId = $_GET['unique_id'];

$selectApplication = ' SELECT `id`, `control_no`, `user_id`, agency, `establishment`, `nature`, `address`, person, contact_details, `status`, `has_consent`, `date_created`, `date_proceed`, `receiver_id`, `date_received`, `approver_id`, `date_approved`, `safety_seal_no`, `reassessed_by`, `date_reassessed`, `date_modified`, `token` FROM `tbl_app_checklist` WHERE status = "Approved" AND `id` = "'.$establishmentId.'" ';
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




?>
<img src="frontend/images/banner_calabarzon.png" height="10%" width="100%" alt="">
 <hr>
  <div class="row mt-5 mb-5">
    <div class="col-lg-12">
      <div class="row">
        <div class="col-md-4">
          <center>
            <img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=http%3A%2F%2Fsafetyseal.calabarzon.dilg.gov.ph/establishment-profile.php?unique_id=<?php echo $establishmentId; ?>%2F&choe=UTF-8" title="Link to Google.com" />
          </center>
        </div>
        <div class="col-md-8 justify-content-center align-self-center">
          <h1 class="align-middle text-success">CERTIFIED</h1>
          <h3 class="align-middle"><span class="text-muted">Safety Seal No :</span> <?php echo $resultApplication['safety_seal_no']; ?></h3>
          <h3 class="align-middle"><span class="text-muted">Issued On :</span> <?php echo date('F d, Y',strtotime($resultApplication['date_approved'])); ?></h3>
          <h3 class="align-middle"><span class="text-muted">Valid Until :</span> <?php echo date('F d, Y', strtotime("+6 months", strtotime($resultApplication['date_approved']))); ?></h3>
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-5">
          <h4 class="mt-3"><span class="text-muted">Agency:</span> <?php echo $agency; ?></h4>
          <h6 class="mt-3"><span class="text-muted">Establishment:</span> <?php echo $resultApplication['establishment']; ?></h6>
          <h6 class="mt-3"><span class="text-muted">Address:</span> <?php echo $resultApplication['address']; ?></h6>
          <br>
          <h6 class="mt-3"><span class="text-muted">Name of Person In Charge:</span> <?php echo $resultApplication['person']; ?></h6>
          <center><span class="text-muted">Person-in-charge</span></center>
          <h6 class="mt-3"><span class="text-muted">Contact Number:</span> <?php echo $resultApplication['contact_details']; ?></h6>
          <!-- <h6 class="mt-3"><span class="text-muted">Email Address:</span> <?php echo $resultApplicantDetails['EMAIL']; ?></h6> -->
          <h6 class="mt-3"><span class="text-muted">Operating Hours:</span> 8AM - 5PM</h6>
          <br>
          <h6 class="mt-3"> INSPECTION AND CERTIFICATION TEAMS</h6>
          <h6 class="mt-3"><span class="text-muted">DILG:</span> <?php echo $resultInspection['NAME']; ?></h6>
          <h6 class="mt-3"><span class="text-muted">PNP:</span> <?php echo $resultInspection['PNP']; ?></h6>
          <h6 class="mt-3"><span class="text-muted">BJMP:</span> <?php echo $resultInspection['BFP']; ?></h6>
        </div>
        <div class="col-md-6 place">
          <!-- map output -->

        </div>
      </div>

      <div class="row mt-5">
        <div class="col-md-1"></div>
        <div class="col-md-11">
          <h6><i>For any complaints, please contact the following</i></h6>
          <h6><i>Hotline: <?php echo $resultInspection['ICT_HOTLINE']; ?></i></h6>
          <h6><i>Email Address: <?php echo $resultInspection['EMAIL_ADDRESS_COMPLAINTS']; ?></i></h6>
        </div>
      </div>


    </div><!-- <div class="col-md-12"> -->
  </div>

  <script>
    $(document).ready( function(){
      var addr = '<?php echo $resultApplication['address']; ?>';
      
      var embed= "<iframe width='600' height='450' frameborder='0' scrolling='no' marginheight='0' marginwidth='0' src='https://maps.google.com/maps?&amp;q="+ encodeURIComponent( addr ) + "&amp;output=embed'></iframe>";  

      $('.place').html(embed);
    });
  </script>