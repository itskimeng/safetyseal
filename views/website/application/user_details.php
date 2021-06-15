<div class="panel panel-default">
  <!-- Default panel contents -->
  
  <!-- Table -->
  <div class="tab-pane active" id="a">
  <div class="col-md-12">
    <div class="row">
      <div class="form-outline mb-2 col-md-4">
        <label class="form-label" for="form1Example1">Control No.:</label><br>
        <input type="text" id="form1Example1" class="form-control" value="<?php echo $userinfo['code']; ?>" placeholder="" disabled/>
      </div>
      <div class="form-outline mb-2 col-md-4">
      </div>
      <div class="form-outline mb-2 col-md-4">
        <label class="form-label" for="form1Example1">Date Registered:</label><br>
        <input type="text" id="form1Example1" class="form-control" value="<?php echo $userinfo['date_created']; ?>" disabled />
      </div>
    </div>
  </div>

  <div class="col-md-12">
    <div class="row">
      <div class="form-outline mb-2 col-md-12">
        <label class="form-label" for="form1Example1">Name of Government Agency/ Office:</label><br>
        <input type="text" id="form1Example1" class="form-control" value="<?php echo $userinfo['agency']; ?>" disabled/>
      </div>
    </div>
  </div>

  <div class="col-md-12">
    <div class="row">
      <div class="form-outline mb-2 col-md-12">
        <label class="form-label" for="form1Example1">Name of Government Establlishment/ Department/ Office/ Unit:</label><br>
        <?php if ($is_new): ?>
          <input type="text" id="form1Example1" name="establishment" class="form-control" value=""/>
        <?php else: ?>  
          <input type="text" id="form1Example1" name="establishment" class="form-control" value="<?php echo $userinfo['establishment']; ?>"/>
        <?php endif ?>
      </div>
    </div>
  </div>

  <div class="col-md-12">
    <div class="row">
      <div class="form-outline mb-2 col-md-12">
        <label class="form-label" for="form1Example1">Nature of Government Establlishment/ Department/ Office/ Unit:</label><br>
        <?php if ($is_new): ?>
          <input type="text" id="form1Example1" name="nature" class="form-control" value=""/>
        <?php else: ?>  
          <input type="text" id="form1Example1" name="nature" class="form-control" value="<?php echo $userinfo['nature']; ?>"/>
        <?php endif ?>
      </div>
    </div>
  </div>

  <div class="col-md-12">
    <div class="row">
      <div class="form-outline mb-2 col-md-12">
        <label class="form-label" for="form1Example1">Address:</label><br>
        <?php if ($is_new): ?>
          <input type="text" id="form1Example1" name="address" class="form-control" value=""/>
        <?php else: ?>  
          <input type="text" id="form1Example1" name="address" class="form-control" value="<?php echo $userinfo['address']; ?>"/>
        <?php endif ?>
      </div>
    </div>
  </div>

  <div class="col-md-12">
    <div class="row">
      <div class="form-outline mb-2 col-md-6">
        <label class="form-label" for="form1Example1">Name of Person in Charge:</label><br>
        <input type="text" id="form1Example1" class="form-control" value="<?php echo $userinfo['fname']; ?>" disabled/>
      </div>

      <div class="form-outline mb-2 col-md-2">
      </div>

      <div class="form-outline mb-4 col-md-4">
        <label class="form-label" for="form1Example1">Contact Details:</label><br>
        <input type="text" id="form1Example1" class="form-control" value="<?php echo $userinfo['contact_details']; ?>" disabled/>
      </div>
    </div>
  </div>  
</div>
</div>



