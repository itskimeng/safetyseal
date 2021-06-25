<?php require_once 'controller/AdminApplicationController.php'; ?>

<div class="content-header">
  <div class="container">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h5 class="m-0"> Application</h5>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="dashboard.v2.php">Home</a></li>
          <li class="breadcrumb-item active">Account Verication</li>
        </ol>
      </div>
    </div>
    <hr>
  </div>
</div>

<!-- Main content -->
<div class="content">
  <div class="container">
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-3">
          &nbsp;
        </div>
        <div class="col-md-6">
          <div class="callout callout-info">
            <h5><i class="fas fa-info"></i> Success:</h5>
            <p>Account has been verified for this session.
            <!-- <div class="form-group" style="margin-bottom: 10px;"> -->
              <a href="admin_application_edit.php?appid=<?php echo $_SESSION['ss_id']; ?>&code=<?php echo isset($_GET['code']) ? $_GET['code'] : ''; ?>&scope=<?php echo isset($_GET['scope']) ? $_GET['scope'] : ''; ?>" class="btn btn-success btn-sm" style="width:20%" id="btnContinue">Continue</a>
            </p>
          </div>
        </div>
        <div class="col-md-3">
          &nbsp;
        </div>
      </div>
    </div>
  </div>
</div>