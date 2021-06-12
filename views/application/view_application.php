<?php require_once 'controller/AdminViewApplicationController.php'; ?>

<div class="content-header">
  <div class="container">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h5 class="m-0"> Application View</h5>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="dashboard.v2.php">Home</a></li>
          <li class="breadcrumb-item"><a href="admin_application.php">Application</a></li>
          <li class="breadcrumb-item active"> View</li>
        </ol>
      </div>
    </div>
    <hr>
  </div>
</div>
    
<!-- Main content -->
<div class="content">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-md-6 col-sm-3">
          <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title"><i class="fa fa-info-circle" aria-hidden="true"></i> <b>APPLICATION DETAILS</b></h3>
                <div class="card-tools">
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
      
    <div class="row mb-4">
      <form method="POST" action="entity/post_assessment.php">
        <input type="hidden" name="appid" value="<?php echo $applicant['appid']; ?>">
        <div class="col-lg-12 col-md-6 col-sm-3">
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title"><i class="fa fa-tasks"></i> <b>ANSWERED CHECKLISTS</b></h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                  <table class="table table-hover table-bordered table-striped" style="font-size:10pt;">
                    <thead class="text-center" style="background-color: #1da6da; color: white;">
                      <tr>
                        <th width="3%">#</th>
                        <th width="18%">REQUIREMENTS</th>
                        <th width="25%">MOVs to be Produced/ Uploaded</th>
                        <th class="text-center" width="8%">ANSWER</th>
                        <th width="12%">REASON WHY N/A</th>
                        <th width="10%">ATTACHMENTS</th>
                        <?php if ($applicant['status'] <> 'For Receiving' AND $applicant['status'] <> 'Draft'): ?>
                          <th>ASSESSMENT</th>
                        <?php endif ?> 
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($applicants_data as $key => $list): ?>
                        <tr>
                          <td><b><?php echo $key+1; ?>.</b></td>
                          <td><?php echo $list['requirement']; ?></td>
                          <td>
                            <ul>
                            <?php foreach ($list['description'] as $description): ?>
                              <li><?php echo $description ?></li>
                            <?php endforeach ?>
                            </ul>    
                          </td>
                          <td class="text-center" style="font-size: 15pt;">
                            <span class="badge bg-<?php echo $list['badge']; ?>"><?php echo $list['answer']; ?></span>
                          </td>
                          <td><?php echo $list['reason']; ?></td>
                          <td>
                            <div class="col-md-12">
                              <a href="https://www.google.com/" class="btn btn-block btn-warning btn-sm">
                                <i class="fa fa-link"></i> Visit  
                              </a>
                            </div>
                          </td>
                          <?php if ($applicant['status'] <> 'For Receiving' AND $applicant['status'] <> 'Draft'): ?>
                          <td class="text-center">
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                              <label class="btn bg-success btn-sm" style="background-color: #00800099">
                                <input type="radio" name="options" id="option_b1" autocomplete="off"><i class="fa fa-check"></i> Pass
                              </label>
                              <label class="btn bg-danger btn-sm" style="background-color: #bd21308c">
                                <input type="radio" name="options" id="option_b2" autocomplete="off"><i class="fa fa-times"></i> Failed
                              </label>
                            </div>
                          </td>
                          <?php endif ?> 
                        </tr>  
                      <?php endforeach ?>
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div> 
        </div>

        <div class="col-lg-12 col-md-6 col-sm-3">
          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title"><i class="fa fa-search" aria-hidden="true"></i> <b>FOR ONSITE VALIDATION/ INSPECTION</b></h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Defects/Defeciencies noted during inspection:</label>
                    <textarea class="form-control" rows="3" name="defects" placeholder="Enter ..." value="?php echo isset($app_notes['defects']) ? $app_notes['defects'] : ''; ?>"><?php echo isset($app_notes['defects']) ? $app_notes['defects'] : ''; ?></textarea>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12" style="margin-bottom:-1%;">
                  <div class="form-group">
                    <label>Recommendations</label>
                    <textarea class="form-control" name="recommendations" rows="3" placeholder="Enter ..." value="<?php echo isset($app_notes['recommendations']) ? $app_notes['recommendations'] : ''; ?>"><?php echo isset($app_notes['recommendations']) ? $app_notes['recommendations'] : ''; ?></textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-12 col-md-6 col-sm-3">
            <!-- <div class="card"> -->
                
              <div class="panel panel-default">
                      <div class="row">
                        <?php if ($applicant['status'] == 'For Receiving' AND $applicant['status'] <> 'Draft'): ?>
                            <div class="col-md-12">
                          <form action="entity/post_received.php" method="POST">
                            <input type="hidden" name="appid" value="<?php echo $applicant['appid']; ?>">
                              <button type = "submit" class="btn btn-primary btn-block" name="login" style="width: 100%;"><i class="fa fa-pen-alt"></i> 
                                Receive  
                              </button>
                          </form>
                            </div>
                        <?php else: ?>
                          <div class="<?php echo $is_new ? 'col-md-12' : 'col-md-6' ;?> pull-right">
                            <button type = "submit" class="btn btn-primary btn-block" name="login" style="width: 100%;"><i class="fa fa-pen-alt"></i> 
                              Update  
                            </button>
                          </div>
                          <div class="col-md-6">
                            <button type="button" class="btn btn-success btn-block" name="login" data-bs-toggle="modal" data-bs-target="#modall_proceed" style="width: 100%;"><i class="fa fa-share"></i> Submit</button>
                          </div>
                        <?php endif ?> 
                      </div>
                    </div> 
            </div> 
        </div>
      </form>
    </div>
  </div>
        
</div>

<style type="text/css">
  .dlk-radio input[type="radio"]
{
  margin-left:-99999px;
  display:none;
}
/*.dlk-radio input[type="radio"] + .fa {
     opacity:0.15
}
.dlk-radio input[type="radio"]:checked + .fa {
    opacity:1
}*/
</style>

<script>
  $(function () {
    // $('select').select2();

    <?php
      // toastr output & session reset
      // session_start();
      if (isset($_SESSION['toastr'])) {
        echo 'tata.'.$_SESSION['toastr']['type'].'("'.$_SESSION['toastr']['title'].'", "'.$_SESSION['toastr']['message'].'", {
          duration: 5000
        })';
        unset($_SESSION['toastr']);
      }
    ?> 

    $("#example1").DataTable({
      // "responsive": true, "lengthChange": false, "autoWidth": false,
      // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>