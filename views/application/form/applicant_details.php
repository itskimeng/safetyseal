<div class="row">
  <div class="col-lg-12 col-md-6 col-sm-3">
  <div class="card card-default">
      <div class="card-header">
        <h3 class="card-title"><i class="fa fa-info-circle" aria-hidden="true"></i> <b>APPLICATION DETAILS</b></h3>
        <div class="card-tools">
          <span  class="badge bg-primary" style="font-size:13pt;"><?php echo $applicant['status']; ?></span>
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
          
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body table-responsive p-0">
        
        <div class="col-md-12">
          <div class="row pl-2 pr-2 pt-3">
            <div class="form-outline mb-2 col-md-4">
              <label class="form-label" for="form1Example1">Control No:</label><br>
              <input type="text" id="form1Example1" class="form-control" value="<?php echo $applicant['control_no']; ?>" disabled/>
            </div>
            <div class="form-outline mb-2 col-md-5">
            </div>
            <div class="form-outline mb-2 col-md-3">
              <label class="form-label" for="form1Example1">Date:</label><br>
              <input type="text" id="form1Example1" class="form-control" value="<?php echo $applicant['date_created']; ?>" disabled />
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="row pl-2 pr-2">
            <div class="form-outline mb-2 col-md-12">
              <label class="form-label" for="form1Example1">Name of Government Agency/ Office:</label><br>
              <input type="text" id="form1Example1" class="form-control" value="<?php echo $applicant['agency']; ?>" disabled/>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="row pl-2 pr-2">
            <div class="form-outline mb-2 col-md-12">
              <label class="form-label" for="form1Example1">Name of Government Establlishment/ Department/ Office/ Unit:</label><br>
              <input type="text" id="form1Example1" class="form-control" value="<?php echo $applicant['establishment']; ?>" disabled/>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="row pl-2 pr-2">
            <div class="form-outline mb-2 col-md-12">
              <label class="form-label" for="form1Example1">Nature of Government Establlishment/ Department/ Office/ Unit:</label><br>
              <input type="text" id="form1Example1" class="form-control" value="<?php echo $applicant['nature']; ?>" disabled/>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="row pl-2 pr-2">
            <div class="form-outline mb-2 col-md-12">
              <label class="form-label" for="form1Example1">Address:</label><br>
              <input type="text" id="form1Example1" class="form-control" value="<?php echo $applicant['address']; ?>" disabled/>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="row pl-2 pr-2 pb-3">
            <div class="form-outline mb-2 col-md-6">
              <label class="form-label" for="form1Example1">Name of Person in Charge:</label><br>
              <input type="text" id="form1Example1" class="form-control" value="<?php echo $applicant['fname']; ?>" disabled/>
            </div>
            <div class="form-outline mb-2 col-md-2">
            </div>
            <div class="form-outline mb-2 col-md-4">
              <label class="form-label" for="form1Example1">Contact Details:</label><br>
              <input type="text" id="form1Example1" class="form-control" value="<?php echo $applicant['contact_details']; ?>" disabled />
            </div>
          </div>
        </div>
      
      </div>
      <!-- /.card-body -->
    </div> 
  </div>
</div>