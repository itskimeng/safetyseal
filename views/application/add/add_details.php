<div class="row">
<input type="hidden" name="is_new" value="<?php echo $is_new; ?>">
<input type="hidden" name="token_id" value="<?php echo isset($applicant['token']) ? $applicant['token'] : ''; ?>">
  <div class="col-lg-12 col-md-6 col-sm-3">
    <div class="card">
      <div class="card-header" style="background-color: #243866; color: white;">
        <h3 class="card-title"><i class="fa fa-info-circle" aria-hidden="true"></i> <b>CHECKLIST FORM</b></h3> 
        <div class="card-tools">
          <span  class="badge bg-primary" style="font-size:13pt;"> <?php echo $is_new ? 'Draft':$applicant['status']; ?></span>
        </div>
      </div>

      <!-- /.card-header -->
      <div class="card-body card-body-details table-responsive p-0 collapse show">
        <?php if ($is_clusterhead OR $is_pfp): ?>
          <div class="col-md-12">
            <div class="row pl-2 pr-2 pt-3">
              <div class="form-group mb-2 col-md-4">
                <label>City/Municipality</label>
                <select id="cform-citymun" name="lgu" class="form-control select2bs4 select2-hidden-accessible" style="width: 100%;" data-select2-id="17" tabindex="-1" aria-hidden="true">
                  <option></option>
                  <?php foreach ($citymun_opts as $key => $opts): ?>
                    <?php if ($applicant['lgu'] == $citymun): ?>
                      <option value="<?php echo $opts['code'] ?>" data-province="<?php echo $opts['province']; ?>" data-code="<?php echo $opts['code']; ?>" selected><?php echo $opts['name']; ?></option>
                    <?php else: ?>
                      <option value="<?php echo $opts['code'] ?>" data-province="<?php echo $opts['province']; ?>" data-code="<?php echo $opts['code']; ?>"><?php echo $opts['name']; ?></option>
                    <?php endif ?>
                  <?php endforeach ?>
                </select>
              </div>  
            </div>
          </div>
        <?php endif ?>
        
        <div class="col-md-12">
          <div class="row pl-2 pr-2 pt-3">
            <div class="form-outline mb-2 col-md-4">
              <label class="form-label" for="form1Example1">Control No:</label><br>
              <?php if ($is_new): ?>
                <input type="text" id="form1Example1" name="control_no" class="form-control" value="" required/>
              <?php else: ?>  
                <input type="text" id="form1Example1" name="control_no" class="form-control" value="<?php echo $applicant['control_no']; ?>" <?php echo $applicant['status'] == 'Approved' ? 'disabled' : ''; ?>/>
              <?php endif ?>
            </div>
            <div class="form-outline mb-2 col-md-5">
              <?php //if ($applicant['status'] == 'Approved'): ?>
                <!-- <label class="form-label" for="form1Example1">Safety Seal No.</label><br> -->
                <!-- <input type="text" id="form1Example1" class="form-control" style="background-color: #008000e6; color: white; font-weight: bold;" value="<?php //echo $applicant['ss_no']; ?>" /> -->
              <?php //endif ?>
            </div>
            <div class="form-outline mb-2 col-md-3">
                <div class="form-group">
                  <label>Date:</label>
                  <div class="input-group">
                    <?php if ($is_new): ?>
                      <input type="text" id="datepicker" name="date_registered" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask required>
                    <?php else: ?>
                      <input type="text" id="datepicker" name="date_registered" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" value="<?php echo $applicant['date_created'] ?>" data-mask required  <?php echo $applicant['status'] == 'Approved' ? 'disabled' : ''; ?>>
                    <?php endif ?>
                  </div>
                  <!-- /.input group -->
                </div>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="row pl-2 pr-2">
            <div class="form-outline mb-2 col-md-12">
              <label class="form-label" for="form1Example1">Name of Government Agency/ Office:</label><br>
              <?php if ($is_new): ?>
                <input type="text" id="form1Example1" name="agency" class="form-control" value="" required/>
              <?php else: ?>
                <input type="text" id="form1Example1" name="agency" class="form-control" value="<?php echo $applicant['agency']; ?>" <?php echo $applicant['status'] == 'Approved' ? 'disabled' : ''; ?>/>
              <?php endif ?>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="row pl-2 pr-2">
            <div class="form-outline mb-2 col-md-12">
              <label class="form-label" for="form1Example1">Name of Sub-Office/Unit:</label><br>
              <?php if ($is_new): ?>
                <input type="text" id="form1Example1" name="establishment" class="form-control" value="" required/>
              <?php else: ?>
                <input type="text" id="form1Example1" name="establishment" class="form-control" value="<?php echo $applicant['establishment']; ?>" <?php echo $applicant['status'] == 'Approved' ? 'disabled' : ''; ?>/>
              <?php endif ?>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="row pl-2 pr-2">
            <div class="form-outline mb-2 col-md-12">
              <label class="form-label" for="form1Example1">Nature of Government Establishment/ Department/ Office/ Unit:</label><br>
                <!-- <input type="text" id="form1Example1" name="nature" class="form-control" value="" required/> -->
                <?php if (isset($applicant['status']) AND $applicant['status'] == 'Approved'): ?>
                  <input type="text" id="form1Example1" name="nature" class="form-control" value="<?php echo $applicant['nature']; ?>" disabled/>  
                <?php else: ?>  
                  <select class="form-control select2bs4 select2-hidden-accessible" name="nature" id="nature" tabindex="-1" aria-hidden="true" required>
                    <option></option>
                      <?php if ($is_new): ?>
                        <?php foreach ($government_nature as $key => $nature):?>
                          <option value="<?php echo $nature;?>"><?php echo $nature;?></option>
                        <?php endforeach;?>
                      <?php else: ?>
                        <?php foreach ($government_nature as $key => $nature):?>
                          <?php if ($nature == $applicant['nature']): ?>
                            <option value="<?php echo $nature;?>" selected><?php echo $nature;?></option>
                          <?php else: ?>
                            <option value="<?php echo $nature;?>"><?php echo $nature;?></option>
                          <?php endif ?>
                        <?php endforeach;?>
                      <?php endif ?>

                  </select>
                <?php endif ?>
                <!-- <input type="text" id="form1Example1" name="nature" class="form-control" value="<?php //echo $applicant['nature']; ?>"/> -->
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="row pl-2 pr-2">
            <div class="form-outline mb-2 col-md-12">
              <label class="form-label" for="form1Example1">Address:</label><br>
              <?php if ($is_new): ?>
                <input type="text" id="form1Example1" name="address" class="form-control" value="" required/>
              <?php else: ?>
                <input type="text" id="form1Example1" name="address" class="form-control" value="<?php echo $applicant['address']; ?>" <?php echo $applicant['status'] == 'Approved' ? 'disabled' : ''; ?>/>
              <?php endif ?>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="row pl-2 pr-2 pb-3">
            <div class="form-outline mb-2 col-md-6">
              <label class="form-label" for="form1Example1">Name of Person in Charge:</label><br>
              <?php if ($is_new): ?>
                <input type="text" id="form1Example1" name="person" class="form-control" value="" required/>
              <?php else: ?>
                <input type="text" id="form1Example1" name="person" class="form-control" value="<?php echo $applicant['person']; ?>" <?php echo $applicant['status'] == 'Approved' ? 'disabled' : ''; ?>/>
              <?php endif ?>
            </div>
            <div class="form-outline mb-2 col-md-2">
            </div>
            <div class="form-outline mb-2 col-md-4">
              <label class="form-label" for="form1Example1">Contact Details:</label><br>
              <?php if ($is_new): ?>
                <input type="text" id="form1Example1" name="contact_details" class="form-control" value="" required/>
              <?php else: ?>
                <input type="text" id="form1Example1" name="contact_details" class="form-control" value="<?php echo $applicant['contact_details']; ?>" <?php echo $applicant['status'] == 'Approved' ? 'disabled' : ''; ?>/>
              <?php endif ?>
            </div>
          </div>
        </div>
      </div>
      
      <!-- /.card-body -->

    </div> 

  </div>
</div>

<script type="text/javascript">

  $('#datepicker').datepicker({
            uiLibrary: 'bootstrap4'
        });

  $(".btn-tool-details").click(function(){
    $(".card-body-details").collapse('toggle');
  });

</script>