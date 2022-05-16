<?php require_once 'controller/AdminViewApplicationController.php'; ?>

<div class="content-header">
  <div class="container">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h5 class="m-0">Checklist Edit</h5>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="dashboard.v2.php">Home</a></li>
          <li class="breadcrumb-item"><a href="admin_application.php">Application List</a></li>
          <li class="breadcrumb-item"><a href="admin_view_application.php?userid=<?= $applicant['user_id']; ?>&type=<?= $applicant['application_type'];?>&_view">Application View</a></li>
          <li class="breadcrumb-item"><a href="admin_application_summary.php?appid=<?= $_GET['appid']; ?>&ussir=<?= $_GET['ussir']; ?>">Application Summary</a></li>
          <li class="breadcrumb-item active">Checklist Edit</li>
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
      <div class="col-md-12 mb-2">
        <div class="row">
          <div class="col-md-6">  
            <div class="btn-group">
              <a href="admin_application_summary.php?appid=<?= $_GET['appid']; ?>&ussir=<?= $_GET['ussir']; ?>" class="btn btn-secondary btn-sm">
                <i class="fa fa-arrow-circle-left"></i> Back
              </a>
            </div>
          </div>

          <div class="col-md-6">
            <div class="row text-right">
              <div class="col-md-12">
                <div class="btn-group">
                  <?php if ($applicant['status'] == 'Approved'): ?>
                    <button type="button" id="btn-revoke_modal" class="btn btn-danger btn-sm btn-revoke_modal">
                      <i class="fa fa-ban"></i> Revoke
                    </button>
                  <?php endif ?>
                  
                </div>
              </div>
            </div>    
          </div>
        </div>

      </div>
    </div>

    <?php include 'form/applicant_details.php'; ?>

    <div class="row mb-4">
      <?php if ($applicant['status'] <> 'For Receiving' and $applicant['status'] <> 'Draft') : ?>
        <form method="POST" action="entity/post_assessment.php" id="form-evaluation">
        <?php endif ?>
        <input type="hidden" name="appid" value="<?= $applicant['appid']; ?>">
        <input type="hidden" name="email" value="<?= $applicant['email']; ?>">
        <input type="hidden" name="id" value="<?= $applicant['user_id']; ?>">
        <input type="hidden" name="control_no" value="<?= $applicant['control_no']; ?>">
        <div class="col-lg-12 col-md-6 col-sm-3">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"><i class="fa fa-tasks"></i> <b>ANSWERED CHECKLISTS</b></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
              <table class="table table-hover table-striped" style="font-size:9.5pt;">
                <thead class="text-center" style="background-color: #1da6da; color: white;">
                  <tr>
                    <th width="3%">#</th>
                    <th width="15%">REQUIREMENTS</th>
                    <th width="20%">MOVs to be<br>Produced/ Uploaded</th>
                    <th class="text-center" width="5%">ANSWER</th>
                    <th width="11%">REASON WHY N/A</th>
                    <th width="5%">ATTACHMENTS</th>
                    <th width="13%">REMARKS <br>FROM PNP</th>
                    <th width="13%">REMARKS <br>FROM BFP</th>
                    <?php if ($applicant['status'] <> 'For Receiving' and $applicant['status'] <> 'Draft') : ?>
                      <?php //if ($useraccess['nature'] != 'PNP' AND $useraccess['position'] != 'PNP' AND $useraccess['nature'] != 'BFP' AND $useraccess['position'] != 'BFP'): ?>
                          <th>ASSESSMENT</th>
                        <?php //endif ?>
                    <?php endif ?>
                  </tr>
                </thead>
                <tbody id="checklist_form">
                  <?php foreach ($applicants_data as $key => $list) : ?>

                    <tr>
                      <td>
                        <b><?= $key + 1; ?>.</b>
                        <input type="hidden" id="cform-hidden_entid" name="hidden_entid" value="<?= $list['ulist_id']; ?>" />
                      </td>
                      <td>
                        <?= $list['requirement']; ?>
                        <?php if ($key == 0 AND $alert_level >= 2) : ?>
                          <br><br>Other contact tracing tool:<br>
                          <span class="badge badge-info right" style="font-size:10pt;"><?= $list['other_tool']; ?></span>
                        <?php endif ?>
                      </td>
                      <td>
                        <ul>
                          <?php foreach ($list['description'] as $description) : ?>
                            <li><?= $description ?></li>
                          <?php endforeach ?>
                        </ul>
                      </td>
                      <td class="text-center" style="font-size: 15pt;">
                        <span class="badge bg-<?= $list['badge']; ?>"><?= $list['answer']; ?></span>
                      </td>
                      <td><?= $list['reason']; ?></td>
                      <td class="text-center">
                        <div class="col-md-12">
                          <?php if (!empty($appchecklists_attchmnt[$list['ulist_id']])) : ?>
                            <input type="hidden" id="cform-ulist_id" name="ulist_id[<?= $list['ulist_id']; ?>]" value="<?= $list['ulist_id']; ?>">
                            <button type="button" class="btn btn-warning btn-sm btn-attachments_view" data-bs-toggle="modal" style="font-size: 9.5pt;">
                              <i class="fa fa-link"></i> View
                            </button>
                          <?php else : ?>
                            <p>No Attachments Available</p>
                          <?php endif ?>
                        </div>
                      </td>
                      <td>
                        <div class="col-md-12">
                          <div class="form-group">
                            <?php if ($useraccess['nature'] == 'PNP' OR $useraccess['position'] == 'PNP') : ?>
                              <textarea class="form-control" rows="3" name="pnp_remarks[<?= $list['ulist_id']; ?>]" placeholder="Enter ..." style="font-size: 9.5pt;" <?= $is_readonly ? 'disabled' : ''; ?> value="<?= isset($list['pnp_remarks']) ? $list['pnp_remarks'] : ''; ?>"><?= isset($list['pnp_remarks']) ? $list['pnp_remarks'] : ''; ?></textarea>
                            <?php else : ?>
                              <?= isset($list['pnp_remarks']) ? $list['pnp_remarks'] : ''; ?>
                            <?php endif ?>
                          </div>
                        </div>
                      </td>
                      <td>
                        <div class="col-md-12">
                          <div class="form-group">
                            <?php if ($useraccess['nature'] == 'BFP' OR $useraccess['position'] == 'BFP') : ?>
                              <textarea class="form-control" rows="3" name="bfp_remarks[<?= $list['ulist_id']; ?>]" placeholder="Enter ..." style="font-size: 9.5pt;" <?= $is_readonly ? 'disabled' : ''; ?> value="<?= isset($list['bfp_remarks']) ? $list['bfp_remarks'] : ''; ?>"><?= isset($list['bfp_remarks']) ? $list['bfp_remarks'] : ''; ?></textarea>
                            <?php else : ?>
                              <?= isset($list['bfp_remarks']) ? $list['bfp_remarks'] : ''; ?>
                            <?php endif ?>

                          </div>
                        </div>
                      </td>
                      <?php if ($applicant['status'] <> 'For Receiving' and $applicant['status'] <> 'Draft') : ?>
                        <?php //if ($useraccess['nature'] != 'PNP' AND $useraccess['position'] != 'PNP' AND $useraccess['nature'] != 'BFP' AND $useraccess['position'] != 'BFP'): ?>
                          
                        
                        <td class="text-center">
                          <?php if ($is_readonly) : ?>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                              <?php if ($list['assessment'] == 'pass') : ?>
                                <label class="assessments btn bg-success btn-sm bg-success_btn active pass" style="background-color: #00800099; font-size: 9.5pt;">
                                  <input type="radio" name="assessments[<?= $list['ulist_id']; ?>]" value="passed" id="option_b1" autocomplete="off" checked><i class="fa fa-check"></i> Passed
                                </label>
                              <?php else : ?>
                                <label class="assessments btn bg-danger btn-sm bg-danger_btn active fail" style="background-color: #bd21308c; font-size: 9.5pt;">
                                  <input type="radio" name="assessments[<?= $list['ulist_id']; ?>]" value="failed" id="option_b2" autocomplete="off" checked><i class="fa fa-times"></i> Failed
                                </label>
                              <?php endif ?>
                            </div>

                          <?php elseif ($useraccess['nature'] == 'PNP' OR $useraccess['position'] == 'PNP' OR $useraccess['nature'] == 'BFP' OR $useraccess['position'] == 'BFP') : ?>

                            <?php if ($list['assessment'] == 'pass') : ?>
                              <span class="right badge badge-success" style="font-size:12pt;">Passed</span>
                            <?php elseif ($list['assessment'] == 'fail') : ?>
                              <span class="right badge badge-danger" style="font-size:12pt;">Failed</span>
                            <?php endif ?>
                            
                          <?php else : ?>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">

                              <label class="assessments btn bg-success btn-sm bg-success_btn pass <?= $list['assessment'] == 'pass' ? 'active' : ''; ?>" style="background-color: #00800099; font-size: 9.5pt;">
                                <input type="radio" name="assessments[<?= $list['ulist_id']; ?>]" value="pass" id="option_b1" autocomplete="off" <?= $list['assessment'] == 'pass' ? 'checked' : ''; ?>><i class="fa fa-check"></i> <?= $list['assessment'] == 'pass' ? 'Passed' : 'Pass'; ?>
                              </label>

                              <label class="assessments btn bg-danger btn-sm bg-danger_btn fail <?= $list['assessment'] == 'failed' ? 'active' : ''; ?>" style="background-color: #bd21308c; font-size: 9.5pt;">
                                <input type="radio" name="assessments[<?= $list['ulist_id']; ?>]" value="fail" id="option_b2" autocomplete="off" <?= $list['assessment'] == 'fail' ? 'checked' : ''; ?>><i class="fa fa-times"></i> <?= $list['assessment'] == 'fail' ? 'Failed' : 'Fail'; ?>
                              </label>
                            </div>
                          <?php endif ?>

                        </td>
                        <?php //endif ?>
                      <?php endif ?>

                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
        </div>

        <?php if ($applicant['status'] <> 'For Receiving' and $applicant['status'] <> 'Draft') : ?>
          <?php if ($useraccess['nature'] != 'PNP' AND $useraccess['position'] != 'PNP' AND $useraccess['nature'] != 'BFP' AND $useraccess['position'] != 'BFP'): ?>
            <div class="col-lg-12 col-md-6 col-sm-3">
              <div class="card card-default">
                <div class="card-header">
                  <h3 class="card-title"><i class="fa fa-search" aria-hidden="true"></i> <b>FOR ONSITE VALIDATION/ INSPECTION</b></h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool btn-tool-onsite" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body card-body-onsite collapse show">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Defects/Defeciencies noted during inspection:</label>
                        <textarea class="form-control" rows="3" name="defects" placeholder="Enter ..." <?= $is_readonly ? 'disabled' : ''; ?> value="<?= isset($app_notes['defects']) ? $app_notes['defects'] : ''; ?>"><?= isset($app_notes['defects']) ? $app_notes['defects'] : ''; ?></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12" style="margin-bottom:-1%;">
                      <div class="form-group">
                        <label>Recommendations</label>
                        <textarea class="form-control" name="recommendations" rows="3" placeholder="Enter ..." <?= $is_readonly ? 'disabled' : ''; ?> value="<?= isset($app_notes['recommendations']) ? $app_notes['recommendations'] : ''; ?>"><?= isset($app_notes['recommendations']) ? $app_notes['recommendations'] : ''; ?></textarea>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php endif ?>
        <?php endif ?>

        <?php if (!$is_readonly) : ?>
          <div class="row">
            
            <div class="col-lg-12 col-md-6 col-sm-3">
            <!-- <div class="card"> -->

            <div class="panel panel-default">
              <div class="row">
                <?php if ($applicant['status'] == 'For Receiving' and $applicant['status'] <> 'Draft') : ?>
                  <div class="col-md-12">
                    <form action="entity/post_received.php" method="POST">
                      <input type="hidden" name="appid" value="<?= $applicant['appid']; ?>">
                      <button type="submit" class="btn btn-primary btn-block" name="login" style="width: 100%;"><i class="fa fa-pen-alt"></i>
                        Receive
                      </button>
                    </form>
                  </div>
                <?php else : ?>

                  <div class="<?= $is_new ? 'col-md-12' : 'col-md-12'; ?> pull-right">
                    <?php if ($is_nature == 'BFP' || $is_nature == 'PNP') : ?>
                      <div class="col-md-12">
                        <button type="submit" class="btn btn-primary btn-block" name="login" style="width: 100%;"><i class="fa fa-pen-alt"></i>
                          Save as Draft
                        </button>
                      </div>

                    <?php else : ?>
                      <div class="row">
                        <div class="col-md-6">
                          <button type="submit" class="btn btn-primary btn-block" name="login" style="width: 100%;"><i class="fa fa-pen-alt"></i>
                            Save as Draft
                          </button>
                        </div>
                        <div class="col-md-6">
                          <button type="button" class="btn btn-success btn-block btn-proceed" data-toggle="modal" style="width: 100%;"><i class="fa fa-share"></i>
                            Submit
                          </button>
                          </button>
                        </div>
                      <?php endif; ?>




                    <?php endif ?>
                      </div>
                  </div>
              </div>

            </div>
          </div>


          <?php endif ?>
          <?php if ($applicant['status'] <> 'For Receiving' and $applicant['status'] <> 'Draft') : ?>
        </form>
      <?php endif ?>
    </div>
  </div>

  <?php include 'modal_evaluation.php'; ?>
  <?php include 'modal_revoked.php'; ?>
  <?php include 'modal_view_attachments.php'; ?>

</div>


<style type="text/css">
  .dlk-radio input[type="radio"] {
    margin-left: -99999px;
    display: none;
  }

  .bg-success_btn {
    background-color: #28a745a6 !important;
  }

  /*.bg-success_btn:active {
  background-color: #04b52c !important;
}*/

  .bg-danger_btn {
    background-color: #dc3545b3 !important;
  }

  /*.dlk-radio input[type="radio"] + .fa {
     opacity:0.15
}
.dlk-radio input[type="radio"]:checked + .fa {
    opacity:1
}*/
  .card-img,
  .card-img-top {
    border-top-left-radius: calc(-7.75rem - 1px);
    border-top-right-radius: calc(1.25rem - 24px);
  }
</style>

<script>
  $(function() {
    // $('select').select2();

    <?php
    // toastr output & session reset
    // session_start();
    if (isset($_SESSION['toastr'])) {
      echo 'tata.' . $_SESSION['toastr']['type'] . '("' . $_SESSION['toastr']['title'] . '", "' . $_SESSION['toastr']['message'] . '", {
          duration: 5000
        })';
      unset($_SESSION['toastr']);
    }
    ?>

    $(".btn-tool-onsite").click(function() {
      $(".card-body-onsite").collapse('toggle');
    });

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

    $(document).on('click', '.btn-proceed', function() {
      let tbody = $('#checklist_form tr');
      $counter = 0;
      let count_entries = '<?= $count_entries;?>';

      $.each(tbody, function() {
        let tr = $(this);
        let asmnt = tr.find('.assessments');
        if (asmnt.hasClass('active')) {
          $counter++;
        }
      });

      if ($counter < count_entries) {
        tata.warn('Warning', 'All items in the checklist must be assess.');
      } else {
        $('#modal_evaluation').modal('show');
      }
    })

    $(document).on('click', '.btn-save_application', function() {
      let form = $('#form-evaluation').serialize();
      let path = 'entity/post_evaluation.php';

      let $this = $(this);

      $this.html('<i class="fa fa-circle-notch fa-spin"></i> Processing...');

      let btn_close = $("#modal_evaluation .btn-close");
      btn_close.css('display', 'none');
      $("#modal_evaluation").modal({
        backdrop: 'static',
        keyboard: false
      });


      postTask(path, form);
    })

    $(document).on('click', '.btn-attachments_view', function() {
      let tr = $(this).closest('tr');
      let id = tr.find('#cform-ulist_id');
      let $modal = $("#modal-view_attachments");
      let form_id = $modal.find('#cform-entry_id');
      let path = 'entity/get_attachments.php?id='+id.val()+'&for_renewal=<?= $applicant['for_renewal']; ?>';

      $.get(path, function(data, key) {
        let dd = JSON.parse(data);
        $('#tbody-view_attchmnt').empty();
        generateAttachments(dd, $('#tbody-view_attchmnt'));
      })

      form_id.val(id.val());
      $modal.modal('show');
    });

    $(document).on('click', '.assessments', function() {
      let $this = $(this);
      let tr = $this.closest('tr');
      let id = tr.find('#cform-hidden_entid');
      $this.addClass('active')

      if ($this.hasClass('pass')) {
        let el = '<input type="radio" name="assessments[' + id.val() + ']" class="opt_assmnt" value="pass" id="option_b1" autocomplete="off" checked><i class="fa fa-check"></i> Passed';
        $(this).html(el);


        let btn_fail = tr.find('.bg-danger_btn');
        btn_fail.removeClass('active');
        btn_fail.html('<input type="radio" name="assessments[' + id.val() + ']" class="opt_assmnt" value="fail" id="option_b2" autocomplete="off"><i class="fa fa-times"></i> Fail');
      } else {
        let btn_pass = tr.find('.bg-success_btn');
        btn_pass.removeClass('active');
        btn_pass.html('<input type="radio" name="assessments[' + id.val() + ']" class="opt_assmnt" value="pass" id="option_b1" autocomplete="off"><i class="fa fa-check"></i> Pass');

        let el = '<input type="radio" name="assessments[' + id.val() + ']" class="opt_assmnt" value="fail" id="option_b2" autocomplete="off" checked><i class="fa fa-times"></i> Failed';
        $(this).html(el);
      }

      // checker_pass = assessmentCheckerPass();
      // checker_fail = assessmentCheckerFail();

      // if (checker_pass) {
      //   // console.log('pass all');
      //   $('#btn-pass_all').addClass('active');
      //   $('#btn-fail_all').removeClass('active');

      // } else if (checker_fail) {
      //   $('#btn-fail_all').addClass('active');
      //   $('#btn-pass_all').removeClass('active');
      // } else {
      //   $('#btn-fail_all').removeClass('active');
      //   $('#btn-pass_all').removeClass('active');
      // }
    });

    $(document).on('click', '.btn-open-exlink', function(e){ 
      e.preventDefault(); 
      var url = $(this).attr('href'); 
      window.open(url);
    });

    $(document).on('click', '.btn-revoke_modal', function(){
      let $modal = $("#modal_revoke");
      $modal.modal('show');
    });

    // function generateAttachments($data, $element) {
    //   let tr = '';
    //   $element.empty();
    //   tr += '<div class="col-md-12">';
    //   tr += '<div class="row">';
    //   $.each($data, function(key, item) {
    //     tr += '<div class="col-md-3 mb-1">';
    //     tr += '<div class="card" style="width: 15rem;">';
    //     tr += '<div class="pic-holder" style="padding-top: 5%;height: 12rem;">';
    //     tr += '<img src="https://drive.google.com/uc?export=view&id=' + item['file_id'] + '" class="card-img-top" alt="..." style="max-width: 100%; max-height: 100%; object-fit: cover;">';
    //     tr += '</div>';
    //     // tr+= '<iframe src="https://drive.google.com/uc?export=view&id='+item['file_id']+'" class="card-img-top"></iframe>';
    //     tr += '<div class="card-body" style="text-overflow: ellipsis;white-space: nowrap;overflow: hidden;height: 3.5rem;padding: 0.3rem 0.3rem;">';
    //     tr += '<a href="' + item['location'] + '" class="">';
    //     tr += item['file_name'];
    //     tr += '</a>';
    //     tr += '</div>';
    //     tr += '</div>';
    //     tr += '</div>';
    //   });
    //   tr += '</div>';
    //   tr += '</div>';

    //   $element.append(tr);
    // }

    function generateAttachments($data, $element) {
      let tr = '';
      $element.empty();
      tr+= '<div class="col-sm-12">';
      tr+= '<div class="row">';
      $.each($data, function(key, item){
        tr+= '<div class="col-sm-2 mb-1">';
        tr+= '<div class="card" style="/* width: 15rem; */">';
        tr+= '<div class="checkers" style="padding-left: 1.5rem;">';
        tr+= '<div class="form-group">';
        tr+= '<input type="hidden" name="att_id['+item['caid']+']" value="'+item['file_id']+'">';
        // tr+= '<input class="form-check-input chklist_na up-attachment" name="chklists['+item['caid']+']" type="checkbox" value="">';
        tr+= '</div>';
        tr+= '</div>';
        tr+= '<div class="pic-holder" style="padding-top: 5%;height: 8rem;">';

        if (item['cover_page'] != null) {
          tr+= '<img src="'+item['cover_page']+'" class="card-img-top" alt="..." style="max-width: 100%; max-height: 100%; object-fit: cover;">';  
        } else {
          tr+= '<img src="https://drive.google.com/uc?export=view&id='+item['file_id']+'" class="card-img-top" alt="..." style="max-width: 100%; max-height: 100%; object-fit: cover;">';
        }
        
        tr+= '</div>';
        tr+= '<div class="card-body" style="text-overflow: ellipsis;white-space: nowrap;overflow: hidden;height: 3.5rem;padding: 0.3rem 0.3rem;">';
        tr+= '<div class="row">';
        tr+= '<div class="col-sm-12" style="text-align:center;">';
        tr+= '<a class="btn btn-md btn-secondary btn-open-exlink" href="'+item['url']+'" style="width:100%">';
        tr+= '<i class="fa fa-eye"></i> View';
        tr+= '</a>';
        tr+= '</div>';
        tr+= '</div>';
        tr+= '</div>';
        tr+= '</div>';
        tr+= '</div>';
      });
      tr+= '</div>';
      tr+= '</div>';

      $element.append(tr);
    }

    function postTask(path, data) {
      $.post(path, data,
        function(data, status) {
          if (status == 'success') {
            setTimeout(function() { // wait for 5 secs(2)
              location.reload(); // then reload the page.(3) 
            }, 1000);
          }
        }
      );

      return data;
    }



  });
</script>