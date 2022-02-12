<div class="row">
 
  <div class="col-lg-12 col-md-6 col-sm-3">
  
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fa fa-info-circle" aria-hidden="true"></i> <b>CHECKLIST FORM</b></h3> 
        <div class="card-tools">
          <?php if ($applicant['status'] == 'Approved'): ?>
            <span class="badge bg-success" style="font-size:13pt; background-color: #00a65a!important;"><i class="fa fa-check-circle"></i> <?= $applicant['status']; ?></span>
          <?php elseif (in_array($applicant['status'], ['Disapproved', 'Revoked', 'Expired'])): ?>
            <span class="badge bg-danger" style="font-size:13pt;"><i class="fa fa-ban"></i> <?= $applicant['status']; ?></span>
          <?php else: ?>
            <span class="badge bg-info" style="font-size:13pt;"> <?= $applicant['status']; ?></span>
          <?php endif ?>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body card-body-details table-responsive p-0 collapse show">
        
        <div class="col-md-12">
          <div class="row pl-2 pr-2 pt-3">
            <div class="form-outline mb-2 col-md-4">
              <label class="form-label" for="form1Example1">Control No:</label><br>
              <input type="text" id="form1Example1" class="form-control" value="<?= $applicant['control_no']; ?>" disabled/>
            </div>
            <div class="form-outline mb-2 col-md-5">
              <?php if (in_array($applicant['status'], ['Approved', 'Renewed', 'Expired'])): ?>
                <label class="form-label" for="form1Example1">Safety Seal No.</label><br>
                <input type="text" id="form1Example1" class="form-control" style="background-color: #00a65a; color: white; font-weight: bold;" value="<?= $applicant['ss_no']; ?>" disabled />
              <?php elseif ($applicant['for_renewal']): ?>
                <label class="form-label" for="form1Example1">Safety Seal No.</label><br>
                <input type="text" id="form1Example1" class="form-control" style="background-color: #b07c06e6; color: white; font-weight: bold;" value="<?= $applicant['ss_no']; ?> (FOR RENEWAL)" disabled />
              <?php endif ?>
            </div>
            <div class="form-outline mb-2 col-md-3">
              <label class="form-label" for="form1Example1">Date:</label><br>
              <input type="text" id="form1Example1" class="form-control" value="<?= $applicant['date_created']; ?>" disabled />
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="row pl-2 pr-2">
            <div class="form-outline mb-2 col-md-12">
              <label class="form-label" for="form1Example1">Name of Government Agency/ Office:</label><br>
              <input type="text" id="form1Example1" class="form-control" value="<?= $applicant['agency']; ?>" disabled/>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="row pl-2 pr-2">
            <div class="form-outline mb-2 col-md-12">
              <label class="form-label" for="form1Example1">Name of Government Establlishment/ Department/ Office/ Unit:</label><br>
              <input type="text" id="form1Example1" class="form-control" value="<?= $applicant['ac_establishment']; ?>" disabled/>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="row pl-2 pr-2">
            <div class="form-outline mb-2 col-md-12">
              <label class="form-label" for="form1Example1">Nature of Government Establlishment/ Department/ Office/ Unit:</label><br>
              <input type="text" id="form1Example1" class="form-control" value="<?= $applicant['ac_nature']; ?>" disabled/>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="row pl-2 pr-2">
            <div class="form-outline mb-2 col-md-12">
              <label class="form-label" for="form1Example1">Address:</label><br>
              <input type="text" id="form1Example1" class="form-control" value="<?= $applicant['ac_address']; ?>" disabled/>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="row pl-2 pr-2 pb-3">
            <div class="form-outline mb-2 col-md-6">
              <label class="form-label" for="form1Example1">Name of Person in Charge:</label><br>
              <input type="text" id="form1Example1" class="form-control" value="<?= $applicant['fname']; ?>" disabled/>
            </div>
            <div class="form-outline mb-2 col-md-2">
            </div>
            <div class="form-outline mb-2 col-md-4">
              <label class="form-label" for="form1Example1">Contact Details:</label><br>
              <input type="text" id="form1Example1" class="form-control" value="<?= $applicant['contact_details']; ?>" disabled />
            </div>
          </div>
        </div>
      
      </div>
      <!-- /.card-body -->
    </div> 
  </div>
</div>

<script type="text/javascript">
  $(".btn-tool-details").click(function(){
    $(".card-body-details").collapse('toggle');
  });
</script>