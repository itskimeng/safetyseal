<div class="card card-info">
  <div class="card-header">
    <h3 class="card-title"><i class="fa fa-info-circle" aria-hidden="true"></i> General Information</h3>
  </div>
  <div class="card-body">

    <div class="row">
      <div class="col-sm-4">
        <label class="form-control2" for="exampleInputEmail1">Role</label>
      </div>
      <div class="col-sm-8 text-secondary">
        <div class="form-group">
          <select class="form-control select2bs4 select2-hidden-accessible" id="role" name="role" style="width: 100%;" data-select2-id="17" tabindex="-1" aria-hidden="true">
            <option></option>
            <?php foreach ($role_opts as $key => $opts): ?>
              <?php if ($opts == $user['role']): ?>
                <option value="<?php echo $opts; ?>" data-code="<?php echo $opts; ?>" selected><b><?php echo $opts; ?></b></option>
              <?php else: ?>
                <option value="<?php echo $opts; ?>" data-code="<?php echo $opts; ?>"><b><?php echo $opts; ?></b></option>  
              <?php endif ?>
            <?php endforeach ?>
          </select>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-4">
        <label class="form-control2" for="exampleInputEmail1">Fullname</label>
      </div>
      <div class="col-sm-8 text-secondary">
        <div class="form-group">
          <input type="text" name="fullname" class="form-control" id="exampleInputEmail1" placeholder="Enter Fullname" value="<?php echo $user['name']; ?>">
        </div>
      </div>
    </div>
    
    <div class="row">
      <div class="col-sm-4">
        <label class="form-control2" for="exampleInputEmail1">Position</label>
      </div>
      <div class="col-sm-8 text-secondary">
        <div class="form-group">
          <input type="text" name="position" class="form-control" id="exampleInputEmail1" placeholder="Enter Position" value="<?php echo $user['position']; ?>">
        </div>
      </div>
    </div>
    
    <div class="row">
      <div class="col-sm-4">
        <label class="form-control2" for="exampleInputEmail1">Province</label>
      </div>
      <div class="col-sm-8 text-secondary">

        <input type="hidden" name="citymun_opts" id="citymun_opts" value="<?php echo $lgu_opts2; ?>">
        <div class="form-group">
          <select class="form-control select2bs4 select2-hidden-accessible" id="province" name="province" style="width: 100%;" data-select2-id="17" tabindex="-1" aria-hidden="true">
            <option></option>
            <?php foreach ($province_opts as $key => $opts): ?>
              <?php if ($key == $user['province_id']): ?>
                <option value="<?php echo $key; ?>" data-code="<?php echo $opts['code']; ?>" selected><?php echo $opts['name']; ?></option>
              <?php else: ?>
                <option value="<?php echo $key; ?>" data-code="<?php echo $opts['code']; ?>"><?php echo $opts['name']; ?></option>  
              <?php endif ?>
            <?php endforeach ?>
          </select>
        </div>
      </div>
    </div>
    
    <div class="row">
      <div class="col-sm-4">
        <label class="form-control2" for="exampleInputEmail1">City/Municipality</label>
      </div>
      <div class="col-sm-8 text-secondary">
        <div class="form-group">
          <select class="form-control select_2" id="lgu" name="lgu" style="width: 100%;" data-select2-id="17" tabindex="-1" aria-hidden="true">
            <option></option>
            <?php foreach ($lgu_opts as $key => $opts): ?>
              <?php if ($key == $user['lgu_id']): ?>
                <option value="<?php echo $opts['code']; ?>" data-code="<?php echo $opts['code']; ?>" selected><?php echo $opts['name']; ?></option>
              <?php else: ?>
                <option value="<?php echo $opts['code']; ?>" data-code="<?php echo $opts['code']; ?>"><?php echo $opts['name']; ?></option>  
              <?php endif ?>
            <?php endforeach ?>
          </select>
        </div>
      </div>
    </div>
    
    <div class="row">
      <div class="col-sm-4">
        <label class="form-control2" for="exampleInputEmail1">Address</label>
      </div>
      <div class="col-sm-8 text-secondary">
        <div class="form-group">
          <textarea class="form-control" rows="3" name="address" placeholder="Enter Address" value="<?php echo $user['address']; ?>"><?php echo $user['address']; ?></textarea>
        </div>
      </div>
    </div>
    
    <div class="row">
      <div class="col-sm-4">
        <label class="form-control2" for="exampleInputEmail1">Mobile No.</label>
      </div>
      <div class="col-sm-8 text-secondary">
        <div class="form-group">
          <input type="text" name="mobile_no" class="form-control" id="exampleInputEmail1" placeholder="Enter mobile no." value="<?php echo $user['mobile_no']; ?>">
        </div>
      </div>
    </div>
    
    <div class="row">
      <div class="col-sm-4">
        <label class="form-control2" for="exampleInputEmail1">Email</label>
      </div>
      <div class="col-sm-8 text-secondary">
        <div class="form-group">
          <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email" value="<?php echo $user['email']; ?>">
        </div>
      </div>
    </div>
    <br>

    <div class="row">
      <div class="col-sm-4">
        <label class="form-control2" for="exampleInputEmail1">Name of Government Agency/Office</label>
      </div>
      <div class="col-sm-8 text-secondary">
        <div class="form-group">
          <input type="text" name="gov_agency" class="form-control" id="exampleInputEmail1" placeholder="Enter name of agency" value="<?php echo $user['gov_agency']; ?>">
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-4">
        <label class="form-control2" for="exampleInputEmail1">Name of Sub-office/Unit</label>
      </div>
      <div class="col-sm-8 text-secondary">
        <div class="form-group">
          <input type="text" name="sub_office" class="form-control" id="exampleInputEmail1" placeholder="Enter name of sub-office" value="<?php echo $user['sub_office']; ?>">
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-4">
        <label class="form-control2" for="exampleInputEmail1">Nature of Government Establishments</label>
      </div>
      <div class="col-sm-8 text-secondary">
        <div class="form-group">
          <select class="form-control select2bs4" id="gov_nature" name="gov_nature" style="width: 100%;" data-select2-id="17" tabindex="-1" aria-hidden="true">
            <option></option>
            <?php foreach ($govnature_opts as $key => $opts): ?>
              <?php if ($opts == $user['gov_nature']): ?>
                <option value="<?php echo $opts; ?>" data-code="<?php echo $opts; ?>" selected><?php echo $opts; ?></option>
              <?php else: ?>
                <option value="<?php echo $opts; ?>" data-code="<?php echo $opts; ?>"><?php echo $opts; ?></option>  
              <?php endif ?>
            <?php endforeach ?>
          </select>
        </div>
      </div>
    </div>

  </div>  
</div>