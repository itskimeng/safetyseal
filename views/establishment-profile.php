<?php require_once 'controller/EstablishmentsProfileController.php'; ?>

<img src="frontend/images/banner_calabarzon.png" height="10%" width="100%" alt="">
 <hr>
  <div class="row mt-5 mb-5">
    <div class="col-lg-12">
      <div class="row">
        <div class="col-md-4">
          <center>
            <img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=http%3A%2F%2Fsafetyseal.calabarzon.dilg.gov.ph/establishment-profile.php?unique_id=<?= $establishmentId; ?>%2F&choe=UTF-8" title="Link to Google.com" />
          </center>
        </div>
        <div class="col-md-8 justify-content-center align-self-center">
          <h1 class="align-middle text-success">CERTIFIED</h1>
          <table>
            <tbody>
              <tr>
                <td style="width:300px;"><span class="text-muted" style="font-size:16pt;">Safety Seal No :</span></td>
                <td class="text-right" style="width:300px; font-size: 15pt;"><?= $resultApplication['safety_seal_no']; ?></td>
              </tr>
              <tr>
                <td style="width:300px;"><span class="text-muted" style="font-size:16pt;">Issued On :</span></td>
                <td class="text-right" style="width:300px; font-size: 15pt;"><?= date('F d, Y',strtotime($resultApplication['date_approved'])); ?></td>
              </tr>
              <tr>
                <td style="width:300px;"><span class="text-muted" style="font-size:16pt;">Valid Until :</span></td>
                <td class="text-right" style="width:300px; font-size: 15pt;"><?= date('F d, Y', strtotime("+6 months", strtotime($resultApplication['date_approved']))); ?></td>
              </tr>
              <tr>
                <td style="width:300px;"><span class="text-muted" style="font-size:16pt;">Status :</span></td>
                <td class="text-right" style="width:300px; font-size: 15pt;"><?= $status; ?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-md-6">
          <h4 class="mt-3"><span class="text-muted">Agency:</span> <?= $agency; ?></h4>
          <h6 class="mt-3"><span class="text-muted">Establishment:</span> <?= $resultApplication['establishment']; ?></h6>
          <h6 class="mt-3"><span class="text-muted">Address:</span> <?= $resultApplication['address']; ?></h6>
          <hr> 
          <h6 class="mt-3"><span class="text-muted">Name of Person In Charge:</span> <?= !empty($resultApplication['person']) ? $resultApplication['person'] : 'None'; ?></h6>
          <center><span class="text-muted"><?= !empty($resultApplication['person']) ? 'Person-in-charge' : ''; ?></span></center>
          <h6 class="mt-3"><span class="text-muted">Contact Number:</span> <?= $resultApplication['contact_details']; ?></h6>
          <!-- <h6 class="mt-3"><span class="text-muted">Email Address:</span> <?= $resultApplicantDetails['EMAIL']; ?></h6> -->
          <h6 class="mt-3"><span class="text-muted">Operating Hours:</span> 8AM - 5PM</h6>
          <hr>
          <h6 class="mt-3"> INSPECTION AND CERTIFICATION TEAMS</h6>
          <h6 class="mt-3"><span class="text-muted">DILG:</span> <?= $resultInspection['NAME']; ?></h6>
          <h6 class="mt-3"><span class="text-muted">PNP:</span> <?= $resultInspection['PNP']; ?></h6>
          <h6 class="mt-3"><span class="text-muted">BFP:</span> <?= $resultInspection['BFP']; ?></h6>
        </div>
        <div class="col-md-6 place">
          <!-- map output -->

        </div>
      </div>

      <div class="row mt-5">
        <div class="col-md-12">
          <h6><i>For any complaints, please contact the following</i></h6>
          <h6><i>Hotline: <?= $resultInspection['ICT_HOTLINE']; ?></i></h6>
          <h6><i>Email Address: <?= $resultInspection['EMAIL_ADDRESS_COMPLAINTS']; ?></i></h6>
        </div>
      </div>


    </div><!-- <div class="col-md-12"> -->
  </div>

  <script>
    $(document).ready( function(){
      var addr = '<?= $resultApplication['address']; ?>';
      
      var embed= "<iframe width='600' height='450' frameborder='0' scrolling='no' marginheight='0' marginwidth='0' src='https://maps.google.com/maps?&amp;q="+ encodeURIComponent( addr ) + "&amp;output=embed'></iframe>";  

      $('.place').html(embed);
    });
  </script>