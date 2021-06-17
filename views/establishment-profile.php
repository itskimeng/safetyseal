<?php 
require_once 'application/config/connection.php'; 
$establishmentId = $_GET['unique_id'];

$selectApplication = ' SELECT `id`, `control_no`, `user_id`, `establishment`, `nature`, `address`, `status`, `has_consent`, `date_created`, `date_proceed`, `receiver_id`, `date_received`, `approver_id`, `date_approved`, `safety_seal_no`, `reassessed_by`, `date_reassessed`, `date_modified`, `token` FROM `tbl_app_checklist` WHERE status = "Approved" AND `id` = "'.$establishmentId.'" ';
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

$selectInspection = ' SELECT `ID`, `PROVINCE`, `LGU`, `NAME`, `EMAIL_ADDRESS`, `CONTACT_NO`, `PNP`, `BFP`, `ICT_HOTLINE`, `EMAIL_ADDRESS_COMPLAINTS` FROM `tbl_inspection_team` WHERE `PROVINCE` = "'.$province.'" AND `LGU` = "'.$lgu.'" ';
$execInspection = $conn->query($selectInspection);
$resultInspection = $execInspection->fetch_assoc();

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
          <h4 class="mt-3"><span class="text-muted">Agency:</span> <?php echo $resultAddress['GOV_AGENCY_NAME']; ?></h4>
          <h6 class="mt-3"><span class="text-muted">Establishment:</span> <?php echo $resultAddress['GOV_ESTB_NAME']; ?></h6>
          <h6 class="mt-3"><span class="text-muted">Address:</span> <?php echo $resultApplication['address']; ?></h6>
          <br>
          <h6 class="mt-3"><span class="text-muted">Name of Person In Charge:</span> <?php echo $resultApplicantDetails['CMLGOO_NAME']; ?></h6>
          <center><span class="text-muted"><?php echo $resultAddress['POSITION']; ?></span></center>
          <h6 class="mt-3"><span class="text-muted">Contact Number:</span> <?php echo $resultAddress['MOBILE_NO']; ?></h6>
          <h6 class="mt-3"><span class="text-muted">Email Address:</span> <?php echo $resultAddress['EMAIL_ADDRESS']; ?></h6>
          <h6 class="mt-3"><span class="text-muted">Operating Hours:</span> 8AM - 5PM</h6>
          <br>
          <h6 class="mt-3"> INSPECTION AND CERTIFICATION TEAMS</h6>
          <h6 class="mt-3"><span class="text-muted">DILG:</span> <?php echo $resultInspection['NAME']; ?></h6>
          <h6 class="mt-3"><span class="text-muted">PNP:</span> <?php echo $resultInspection['PNP']; ?></h6>
          <h6 class="mt-3"><span class="text-muted">BJMP:</span> <?php echo $resultInspection['BFP']; ?></h6>
        </div>
        <div class="col-md-6 place">
          <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3867.7513751493257!2d121.1518264148358!3d14.20933089005264!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd63cc09a59b29%3A0x3bc408d1f2ac59e9!2sDILG%20Region%20IV-A%20(CALABARZON)!5e0!3m2!1sen!2sph!4v1623290097945!5m2!1sen!2sph" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe> -->
          <!-- <span class="place"></span> -->

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