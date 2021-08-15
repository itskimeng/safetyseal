<!-- <div class="card card-info">
  <div class="card-header">
    <h3 class="card-title"><i class="fa fa-key" aria-hidden="true"></i> Credentials</h3>
  </div>
  <div class="card-body">
    

  </div>
</div> -->

<div class="row">
  <div class="col-sm-5">
    <label class="form-control2" for="exampleInputEmail1">Username</label>
  </div>
  <div class="col-sm-7 text-secondary">
    <div class="form-group">
      <input type="text" name="username" class="form-control" id="exampleInputEmail1" placeholder="Enter fullname" value="<?php echo $user['username']; ?>">
    </div>
  </div>
</div>

<div class="row">
  <div class="col-sm-5">
    <label class="form-control2" for="exampleInputEmail1">Password</label>
  </div>
  <div class="col-sm-7 text-secondary">
    <div class="form-group">
      <input type="password" name="password" class="form-control" id="exampleInputEmail1" placeholder="Enter Password" value="">
    </div>
  </div>
</div>

<div class="row">
  <div class="col-sm-5">
    <label class="form-control2" for="exampleInputEmail1">Confirm Password</label>
  </div>
  <div class="col-sm-7 text-secondary">
    <div class="form-group">
      <input type="password" name="confirm_pw" class="form-control" id="exampleInputEmail1" placeholder="Retype Password" value="">
    </div>
  </div>
</div>