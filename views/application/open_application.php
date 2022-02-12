<?php require_once 'controller/AdminViewApplicationController.php'; ?>

<div class="content-header">
  <div class="container">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h5 class="m-0"> Application Summary</h5>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="dashboard.v2.php">Home</a></li>
          <li class="breadcrumb-item"><a href="admin_application.php">Application List</a></li>
          <li class="breadcrumb-item"><a href="admin_view_application.php?userid=<?= $applicant['user_id']; ?>&type=<?= $applicant['application_type'];?>&_view">Application View</a></li>
          <li class="breadcrumb-item active">Application Summary</a></li>
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
        <?php if ($applicant['application_type'] == 'Applied'): ?>
          <a href="admin_view_application.php?userid=<?= $applicant['user_id']; ?>&type=<?= $applicant['application_type'];?>&_view" class="btn btn-secondary btn-sm">
            <i class="fa fa-arrow-circle-left"></i> Back
          </a>
        <?php else: ?>
          <a href="admin_view_application.php?person=<?= $applicant['person']; ?>&type=<?= $applicant['application_type'];?>&_view" class="btn btn-secondary btn-sm">
            <i class="fa fa-arrow-circle-left"></i> Back
          </a>
        <?php endif ?>

      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="card">
          <div class="card-header bg-violet">
            <h5 class="card-title"><i class="fas fa-info-circle"></i> <b>Application</b></h5>
            <div class="card-tools">
              <div class="col-md-12">
                <?php if ($applicant['application_type'] == 'Encoded'): ?>
                  <div class="btn-group">
                    <a href="admin_application_edit.php?appid=<?= $applicant['ssid']; ?>&code=&scope=" class="btn btn-info btn-sm rounded-circle" style="margin-bottom: -2%;" title="View Checklist"><i class="fa fa-edit"></i></a>
                  </div>

                  <?php if ($is_expired AND !$applicant['for_renewal']): ?>
                    <div class="btn-group">
                      <a href="entity/renew_admin_application.php?ssid=<?= $applicant['ssid']; ?>" type="button" class="btn btn-warning btn-block btn-sm rounded-circle" title="Apply For Renewal"><i class="fas fa-retweet"></i></a>
                    </div>  
                  <?php endif ?>

                  <?php if ($is_expired AND !in_array($applicant['status'], ['Approved', 'Renewed', 'Expired'])): ?>
                    <div class="btn-group">
                      <a href="entity/delete_admin_application.php?token=<?= $applicant['ssid']; ?>" class="btn btn-danger btn-block btn-sm rounded-circle" style="margin-bottom: -2%;"><i class="fa fa-trash"></i></a>
                    </div>
                  <?php endif ?>

                <?php elseif (in_array($applicant['status'], ['For Receiving', 'For Reassessment'])): ?>
                  <a href="admin_checklist_view.php?appid=<?= $_GET['appid']; ?>&ussir=<?= $_GET['ussir']; ?>" type="button" class="btn btn-primary btn-sm rounded-circle" data-toggle="tooltip" data-placement="left" title="Edit Application"><i class="fa fa-edit"></i></a>

                  <div class="btn-group">
                    <a type="button" id="btn-return_modal" class="btn btn-danger btn-sm btn-return_modal btn-sm rounded-circle" data-toggle="tooltip" data-placement="top" title="Return Application">
                      <i class="fa fa-undo-alt"></i></a>
                  </div>

                  <a href="admin_checklist_edit.php?appid=<?= $_GET['appid']; ?>&ussir=<?= $_GET['ussir']; ?>" type="button" class="btn btn-success btn-sm rounded-circle" data-toggle="tooltip" data-placement="right" title="Receive Application"><i class="fa fa-box"></i></a>

                <?php else: ?>
                  <a href="admin_application_view.php?appid=<?= $_GET['appid']; ?>&ussir=<?= $_GET['ussir']; ?>" type="button" class="btn btn-primary btn-sm rounded-circle" data-toggle="tooltip" data-placement="left" title="Edit Application"><i class="fa fa-edit"></i></a>

                <?php endif ?>
              </div>
            </div>
          </div>
          <div class="card-body p-0">
            <div class="row">
              <div class="col-md-12">
                <table class="table table-responsive">
                  <tbody>
                    <tr>
                      <td width="25%">Control No</td>
                      <td width="45%"><label class="control-label"><?= $applicant['control_no']; ?></label></td>
                    </tr>
                    <tr>
                      <td width="25%">Date Created</td>
                      <td width="45%"><label class="control-label"><?= $applicant['date_created']; ?></label></td>
                    </tr>
                    <tr>
                      <td width="25%">Establishment</td>
                      <td width="45%"><label class="control-label"><?= $applicant['ac_establishment']; ?></label></td>
                    </tr>
                    <tr>
                      <td width="25%">Safetyseal No</td>
                      <td width="45%"><label class="control-label">
                        <?php if (in_array($applicant['status'], ['Draft', 'For Renewal'])): ?>
                          ---
                        <?php else: ?>
                          <?= $applicant['ss_no']; ?>
                        <?php endif ?>
                        </label>
                    </td>
                    </tr>
                    <tr>
                      <td width="25%">Issued On</td>
                      <td width="45%"><label class="control-label">
                        <?php if (in_array($applicant['status'], ['Draft', 'For Renewal'])): ?>
                          ---
                        <?php else: ?>
                          <?= $applicant['date_approved']; ?>
                        <?php endif ?>
                        </label>
                      </td>
                    </tr>
                    <tr>
                      <td width="25%">Valid Until</td>
                      <td width="45%"><label class="control-label"><?= $validity_date; ?></label></td>
                    </tr>

                    <?php if ($applicant['application_type'] == 'Applied'): ?>
                      <tr>
                        <td width="25%">Contact Tracing Tool</td>
                        <td width="45%"><label class="control-label"><?= $other_tool; ?></label></td>
                      </tr>
                    <?php endif ?>
                    
                    <tr>
                      <td width="25%">Status</td>
                      <td width="45%">
                        <?php if ($is_expired): ?>
                          <span class="badge badge-danger mb-1" style="background-color: #d60b0b; font-size: 13.5px;">Expired</span>
                        <?php elseif (in_array($applicant['status'], ['Approved', 'Renewed'])): ?>
                          <span class="badge badge-success mb-1" style="background-color: #00a65a; font-size: 13.5px;"><?= $applicant['status']; ?></span>
                        <?php elseif (in_array($applicant['status'], ['Revoked', 'Disapproved', 'Expired'])):?>
                          <span class="badge badge-danger mb-1" style="background-color: #d60b0b; font-size: 13.5px;"><?= $applicant['status']; ?></span>
                        <?php else: ?>
                          <span class="badge badge-info mb-1" style="background-color: #243866; font-size: 13.5px;"><?= $applicant['status']; ?></span>
                        <?php endif ?>
                        <br>

                        <?php if ($applicant['application_type'] == 'Encoded'): ?>
                          
                          <?php if ($encoded_checklist > 0): ?>
                              <label class="mb-1" style="font-size:15px;"><i class="fas fa-check-circle" style="color:#3ebe3e;"></i>  Uploaded Signed Checklist</label><br>
                          <?php else: ?>
                              <label class="mb-1" style="font-size:15px;"><i class="fas fa-times-circle" style="color:#d25555;"></i>  Uploaded Signed Checklist</label><br>
                          <?php endif ?>                        

                        <?php else: ?>
                          <?php if ($is_complete_attachments): ?>
                              <label class="mb-1" style="font-size:15px;"><i class="fas fa-check-circle" style="color:#3ebe3e;"></i> <?= $upload_count; ?>/<?= $count_answeredyes; ?> Uploaded MOVS</label><br>
                          <?php else: ?>
                              <label class="mb-1" style="font-size:15px;"><i class="fas fa-times-circle" style="color:#d25555;"></i> <?= $upload_count; ?>/<?= $count_answeredyes; ?> Uploaded MOVS</label><br>
                          <?php endif ?>

                          <?php if ($is_complete_asessment): ?>
                              <label class="mb-1" style="font-size:15px;"><i class="fas fa-check-circle" style="color:#3ebe3e;"></i> 100% Self Asessment</label><br>
                          <?php else: ?>
                              <label class="mb-1" style="font-size:15px;"><i class="fas fa-times-circle" style="color:#d25555;"></i> <?= $complete_percentage; ?>% Self Asessment</label><br>
                          <?php endif ?>

                          <?php if (in_array($applicant['status'], ['For Reassessment', 'For Receiving'])): ?>
                              <p class="text-success" style="font-size:12px;">Application is now ready for assessment.</p>
                          <?php elseif (in_array($applicant['status'], ['Approved', 'Renewed'])): ?>
                              <!-- <p class="text-success" style="font-size:10.5px;">Your application is now ready to submit.</p> -->
                          <?php elseif (in_array($applicant['status'], ['Expired', 'Received'])): ?>
                          <?php else: ?>
                              <p class="text-warning" style="font-size:11.5px; color: #fd7e14;">Application is waiting for the applicant's response.</p>
                          <?php endif ?>    
                        <?php endif ?>

                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-8">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
            <div class="card-header bg-violet">
              <h5><i class="fas fa-info-circle"></i> <b>Approval History</b></h5>
            </div>
            <div class="card-body p-0 custom-box-body" style="max-height: 500px; overflow-y: auto; overflow-x: hidden;">
              <div class="row">
                <div class="col-md-12">
                  <table class="table table-responsive" style="width: 100%;">
                    <tbody>
                      <tr>
                        <td style="color: #c0c0c0; width:23%; text-align: center;"><b>DATE</b></td>
                        <td style="color: #c0c0c0; text-align: center; width:25%;"><b>USER</b></td>
                        <td style="color: #c0c0c0; text-align: center; width:20%;"><b>ACTION</b></td>
                        <td style="color: #c0c0c0; text-align: center;"><b>REMARK</b></td>
                      </tr>
                      <?php if (!empty($approval_history)): ?>
                        <?php foreach ($approval_history as $key => $history): ?>
                          <tr>
                              <td style="vertical-align: bottom;">
                                  <small><?= $history['interval']; ?></small><br>
                                  <?= $history['action_date']; ?>
                              </td>
                              <td style="vertical-align: bottom;">
                                  <?= $history['name']; ?>
                              </td>
                              <td style="vertical-align: bottom; text-align: center;">
                                  <?= ucfirst($history['action']); ?>
                              </td>
                              <td>
                                 <?= ucfirst($history['message']); ?> 
                              </td>
                          </tr>
                        <?php endforeach ?>
                      <?php else: ?>
                        <tr>
                          <td colspan="4" style="text-align:center;">No data available</td>
                        </tr>
                      <?php endif ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="card">
            <div class="card-header bg-violet">
              <h5><i class="fas fa-info-circle"></i> <b>Application History</b></h5>
            </div>
            <div class="card-body p-0">
              <div class="row">
                <div class="col-md-12">
                  <table class="table table-responsive" style="width: 100%;">
                    <tbody>
                      <tr>
                        <td style="color: #c0c0c0; text-align: center; width: 18%;"><b>SAFETYSEAL NO</b></td>
                        <td style="color: #c0c0c0; text-align: center; width: 25%;"><b>DATE</b></td>
                        <td style="color: #c0c0c0; text-align: center; width: 25%;"><b>ISSUED DATE</b></td>
                        <td style="color: #c0c0c0; text-align: center; width: 25%;"><b>EXPIRATION DATE</b></td>
                        <td style="color: #c0c0c0; text-align: center; width: 10%;"><b>STATUS</b></td>
                      </tr>
                      <?php if (!empty($application_history)): ?>
                         <?php foreach ($application_history as $key => $history): ?>
                          <tr>
                              <td style="vertical-align: bottom; text-align: center;">
                                  <?= $applicant['ss_no']; ?>
                              </td>
                              <td style="vertical-align: bottom; text-align: center;">
                                  <?= $history['date_created']; ?>
                              </td>
                              <td style="vertical-align: bottom; text-align: center;">
                                  <?= $history['issued_date']; ?>
                              </td>
                              <td style="vertical-align: bottom; text-align: center;">
                                  <?= ucfirst($history['expiration_date']); ?>
                              </td>
                              <td>
                                 <?= ucfirst($history['status']); ?> 
                              </td>
                          </tr>
                        <?php endforeach ?>
                      <?php else: ?>
                        <tr>
                          <td colspan="5" style="text-align:center;">No data available</td>
                        </tr>
                      <?php endif ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          </div>
        </div>

      </div>
    </div>

  </div>

</div>

<?php include 'modal_returned.php';?> 


<style type="text/css">
  .bg-violet {
    background-color: #002851 !important;
    color: white;
  }

  div.custom-box-body::-webkit-scrollbar {
      width: 10px;
  }
   
  div.custom-box-body::-webkit-scrollbar-track {
      -webkit-box-shadow: inset 0 0 2px rgba(0,0,0,0.3); 
      border-radius: 2px;
  }
   
  div.custom-box-body::-webkit-scrollbar-thumb {
      border-radius: 2px;
      -webkit-box-shadow: inset 0 0 2px rgba(0,0,0,0.5); 
  }

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

    $(document).on('click', '.btn-return_modal', function(){
      let $modal = $("#modal_return_remarks");
      $modal.modal('show');
    });

    $(document).on('click', '.btn-proceed', function() {
      let tbody = $('#checklist_form tr');
      $counter = 0;
      $.each(tbody, function() {
        let tr = $(this);
        let asmnt = tr.find('.assessments');
        if (asmnt.hasClass('active')) {
          $counter++;
        }
      });

      if ($counter < 14) {
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

    // $(document).on('click', '.btn-attachments_view', function() {
    //   let tr = $(this).closest('tr');
    //   let id = tr.find('#cform-ulist_id');
    //   let $modal = $("#modal-view_attachments");
    //   let form_id = $modal.find('#cform-entry_id');
    //   let path = 'entity/get_attachments.php?id='+id.val()+'&for_renewal=<?php //echo $applicant['for_renewal']; ?>';

    //   $.get(path, function(data, key) {
    //     let dd = JSON.parse(data);
    //     $('#tbody-view_attchmnt').empty();
    //     generateAttachments(dd, $('#tbody-view_attchmnt'));
    //   })

    //   form_id.val(id.val());
    //   $modal.modal('show');
    // });

    $(document).on('click', '.btn-return_modal', function(){
      let $modal = $("#modal_return_remarks");
      $modal.modal('show');
    });

    $(document).on('click', '.btn-attachments_view', function(){
      let tr = $(this).closest('tr');
      let id = tr.find('#cform-ulist_id');
      let $modal = $("#modal-view_attachments");
      let form_id = $modal.find('#cform-entry_id');
      let list_order = tr.find('#checklist-order');
      let caption = 'Checklist #'+list_order.val();
      let modal_label = $modal.find('#exampleModalLabel');
      modal_label.html('<i class="fa fa-link"></i> Attachments - '+caption);

      let path = 'entity/get_bucket_uploads.php?id='+id.val()+'&for_renewal=<?php echo $applicant['for_renewal']; ?>&list_order='+list_order.val();

      $.get(path, function(data, key){
        let dd = JSON.parse(data);
        generateAttachments(dd);
      })

      form_id.val(id.val());
      $modal.modal('show');
    });

    $(document).on('hidden.bs.modal', '#modal-view_attachments', function (e) {
      $('.cont').empty();
      $('.cont').append(generateSpinner());
    })

    function generateSpinner() {
      return '<div class="loadingio-spinner-interwind-1mn62qz6yu9"><div class="ldio-2ejy8czjmjr"><div><div><div><div></div></div></div><div><div><div></div></div></div></div></div></div>';
    }

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

      checker_pass = assessmentCheckerPass();
      checker_fail = assessmentCheckerFail();

      if (checker_pass) {
        // console.log('pass all');
        $('#btn-pass_all').addClass('active');
        $('#btn-fail_all').removeClass('active');

      } else if (checker_fail) {
        $('#btn-fail_all').addClass('active');
        $('#btn-pass_all').removeClass('active');
      } else {
        $('#btn-fail_all').removeClass('active');
        $('#btn-pass_all').removeClass('active');
      }
    });

    $(document).on('click', '.btn-open-exlink', function(e){ 
      e.preventDefault(); 
      var url = $(this).attr('href'); 
      window.open(url);
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

    // function generateAttachments($data, $element) {
    //   let tr = '';
    //   $element.empty();
    //   tr+= '<div class="col-sm-12">';
    //   tr+= '<div class="row">';
    //   $.each($data, function(key, item){
    //     tr+= '<div class="col-sm-2 mb-1">';
    //     tr+= '<div class="card" style="/* width: 15rem; */">';
    //     tr+= '<div class="checkers" style="padding-left: 1.5rem;">';
    //     tr+= '<div class="form-group">';
    //     tr+= '<input type="hidden" name="att_id['+item['caid']+']" value="'+item['file_id']+'">';
    //     // tr+= '<input class="form-check-input chklist_na up-attachment" name="chklists['+item['caid']+']" type="checkbox" value="">';
    //     tr+= '</div>';
    //     tr+= '</div>';
    //     tr+= '<div class="pic-holder" style="padding-top: 5%;height: 8rem;">';

    //     if (item['cover_page'] != null) {
    //       tr+= '<img src="'+item['cover_page']+'" class="card-img-top" alt="..." style="max-width: 100%; max-height: 100%; object-fit: cover;">';  
    //     } else {
    //       tr+= '<img src="https://drive.google.com/uc?export=view&id='+item['file_id']+'" class="card-img-top" alt="..." style="max-width: 100%; max-height: 100%; object-fit: cover;">';
    //     }
        
    //     tr+= '</div>';
    //     tr+= '<div class="card-body" style="text-overflow: ellipsis;white-space: nowrap;overflow: hidden;height: 3.5rem;padding: 0.3rem 0.3rem;">';
    //     tr+= '<div class="row">';
    //     tr+= '<div class="col-sm-12" style="text-align:center;">';
    //     tr+= '<a class="btn btn-md btn-secondary btn-open-exlink" href="'+item['location']+'" style="width:100%">';
    //     tr+= '<i class="fa fa-eye"></i> View';
    //     tr+= '</a>';
    //     tr+= '</div>';
    //     tr+= '</div>';
    //     tr+= '</div>';
    //     tr+= '</div>';
    //     tr+= '</div>';
    //   });
    //   tr+= '</div>';
    //   tr+= '</div>';

    //   $element.append(tr);
    // }

    function generateAttachments($data) {
      let tr = '';
      tr+= '<div class="col-sm-12">';
      tr+= '<div class="row">';
      $.each($data, function(key, item){
        tr+= '<div class="col-sm-2 mb-1">';
        tr+= '<div class="card" style="/* width: 15rem; */ background-color: #c9c9c9;">';
        tr+= '<div class="checkers" style="padding-left: 1.5rem; padding-bottom: .3rem;">';
        tr+= '<div class="form-group">';

        tr+= '<input class="form-check-input chklist_na up-attachment" name="filename[]" type="checkbox" value="'+item.filename+'">';
        tr+= '</div>';
        tr+= '</div>';
        tr+= '<div class="pic-holder" style="padding-top: 5%;height: 8rem; overflow: hidden;">';

        if (item['cover_page'] == null) {
          tr+= '<img src="'+item.url+'" class="card-img-top" alt="..." style="max-width: 100%; max-height: 100%; object-fit: cover; transform: scale(2);">';  
        } else {
          tr+= '<img src="'+item.cover_page+'" class="card-img-top" alt="..." style="max-width: 100%; max-height: 100%; object-fit: cover;">';
        }
        
        tr+= '</div>';
        tr+= '<div class="card-body" style="text-overflow: ellipsis;white-space: nowrap;overflow: hidden;height: 3.5rem;padding: 0.3rem 0.3rem;">';
        tr+= '<div class="row">';
        tr+= '<div class="col-sm-12" style="text-align:center;">';
        tr+= '<a class="btn btn-md btn-success" href="'+item.url+'" target="_blank" rel="noopener noreferrer" style="width:100%">';
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

      // $('').

      $('#tbody-view_attchmnt').css('overflow-y', 'scroll');
      $('.cont').empty();
      $('.cont').hide().append(tr).show('slow');
      // $element.append(tr).show('slow');
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