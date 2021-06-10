<div class="panel panel-default">
  <!-- Default panel contents -->
  
  <!-- Table -->
  <div class="tab-pane active" id="a">
  <div class="col-md-12">
    <div class="row">
      <div class="form-outline mb-1 col-md-4">
        <label class="form-label" for="form1Example1">Control No.:</label><br>
        <input type="text" id="form1Example1" class="form-control" value="<?php echo ''; ?>" disabled/>
      </div>
      <div class="form-outline mb-1 col-md-4">
      </div>
      <div class="form-outline mb-1 col-md-4">
        <label class="form-label" for="form1Example1">Date:</label><br>
        <input type="text" id="form1Example1" class="form-control" value="<?php echo $userinfo['DATE_APPLICATION_CREATED']; ?>" disabled />
      </div>
    </div>
  </div>

  <div class="col-md-12">
    <div class="row">
      <div class="form-outline mb-1 col-md-12">
        <label class="form-label" for="form1Example1">Name of Government Agency/ Office:</label><br>
        <input type="text" id="form1Example1" class="form-control" value="<?php echo $userinfo['GOV_AGENCY_NAME']; ?>" disabled/>
      </div>
    </div>
  </div>

  <div class="col-md-12">
    <div class="row">
      <div class="form-outline mb-1 col-md-12">
        <label class="form-label" for="form1Example1">Name of Government Establlishment/ Department/ Office/ Unit:</label><br>
        <input type="text" id="form1Example1" class="form-control" value="<?php echo $userinfo['GOV_ESTB_NAME']; ?>" disabled/>
      </div>
    </div>
  </div>

  <div class="col-md-12">
    <div class="row">
      <div class="form-outline mb-1 col-md-12">
        <label class="form-label" for="form1Example1">Nature of Government Establlishment/ Department/ Office/ Unit:</label><br>
        <input type="text" id="form1Example1" class="form-control" value="<?php echo $userinfo['GOV_NATURE_NAME']; ?>" disabled/>
      </div>
    </div>
  </div>

  <div class="col-md-12">
    <div class="row">
      <div class="form-outline mb-1 col-md-12">
        <label class="form-label" for="form1Example1">Address:</label><br>
        <input type="text" id="form1Example1" class="form-control" value="<?php echo $userinfo['ADDRESS']; ?>" disabled/>
      </div>
    </div>
  </div>

  <div class="col-md-12">
    <div class="row">
      <div class="form-outline mb-1 col-md-6">
        <label class="form-label" for="form1Example1">Name of Person in Charge:</label><br>
        <input type="text" id="form1Example1" class="form-control" value="<?php echo $userinfo['FULLNAME']; ?>" disabled/>
      </div>

      <div class="form-outline mb-1 col-md-2">
      </div>

      <div class="form-outline mb-4 col-md-4">
        <label class="form-label" for="form1Example1">Contact Details:</label><br>
        <input type="text" id="form1Example1" class="form-control" value="<?php echo $userinfo['MOBILE_NO']; ?>" disabled/>
      </div>
    </div>
  </div>  
</div>
</div>



