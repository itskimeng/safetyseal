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
    
    <?php include 'form/applicant_details.php'; ?>
      
    <div class="row mb-4">
      <?php if ($applicant['status'] <> 'For Receiving' AND $applicant['status'] <> 'Draft'): ?>
      <form method="POST" action="entity/post_assessment.php" id="form-evaluation">
      <?php endif ?>  
        <input type="hidden" name="appid" value="<?php echo $applicant['appid']; ?>">
        <input type="hidden" name="email" value="<?php echo $applicant['email']; ?>">
        <input type="hidden" name="id" value="<?php echo $applicant['user_id']; ?>">
        <input type="hidden" name="control_no" value="<?php echo $applicant['control_no']; ?>">
        <div class="col-lg-12 col-md-6 col-sm-3">
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title"><i class="fa fa-tasks"></i> <b>ANSWERED CHECKLISTS</b></h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                  <table class="table table-hover table-striped" style="font-size:10pt;">
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
                    <tbody id="checklist_form">
                      <?php foreach ($applicants_data as $key => $list): ?>

                        <tr>
                          <td><b><?php echo $key+1; ?>.</b></td>
                          <!-- <td><?php //echo $list['requirement']; ?></td> -->
                          <td>
                            <?php echo $list['requirement']; ?>
                            <?php if ($key == 0): ?>
                                <br><br>Other contact tracing tool. 
                                <span class="badge badge-info right"><?php echo $list['other_tool']; ?></span>
                            <?php endif ?>    
                          </td>
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
                              <?php if (!empty($appchecklists_attchmnt[$list['ulist_id']])): ?>
                                <input type="hidden" id="cform-ulist_id" name="ulist_id[<?php echo $list['ulist_id']; ?>]" value="<?php echo $list['ulist_id']; ?>">
                                <button type="button" class="btn btn-warning btn-sm btn-attachments_view" data-bs-toggle="modal">
                                  <i class="fa fa-link"></i> View
                                </button>
                              <?php else: ?>
                                <p>No Attachments Available</p>
                              <?php endif ?>
                            </div>
                          </td>
                          <?php if ($applicant['status'] <> 'For Receiving' AND $applicant['status'] <> 'Draft'): ?>
                          <td class="text-center">
                            <?php if ($is_readonly): ?>
                              <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <?php if ($list['assessment'] == 'pass'): ?>
                                  <label class="assessments btn bg-success btn-sm bg-success_btn active" style="background-color: #00800099">
                                  <input type="radio" name="assessments[<?php echo $list['ulist_id']; ?>]" value="pass" id="option_b1" autocomplete="off" checked><i class="fa fa-check"></i> Pass
                                </label> 
                                <?php else: ?>
                                  <label class="assessments btn bg-danger btn-sm bg-danger_btn active" style="background-color: #bd21308c">
                                  <input type="radio" name="assessments[<?php echo $list['ulist_id']; ?>]" value="failed" id="option_b2" autocomplete="off" checked><i class="fa fa-times"></i> Failed
                                </label>
                                <?php endif ?>
                              </div> 
                            <?php else: ?>
                              <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="assessments btn bg-success btn-sm bg-success_btn <?php echo $list['assessment'] == 'pass' ? 'active' : ''; ?>" style="background-color: #00800099">
                                  <input type="radio" name="assessments[<?php echo $list['ulist_id']; ?>]" value="pass" id="option_b1" autocomplete="off" <?php echo $list['assessment'] == 'pass' ? 'checked' : ''; ?> ><i class="fa fa-check"></i> Pass
                                </label>
                                <label class="assessments btn bg-danger btn-sm bg-danger_btn <?php echo $list['assessment'] == 'failed' ? 'active' : ''; ?>" style="background-color: #bd21308c">
                                  <input type="radio" name="assessments[<?php echo $list['ulist_id']; ?>]" value="failed" id="option_b2" autocomplete="off" <?php echo $list['assessment'] == 'failed' ? 'checked' : ''; ?> ><i class="fa fa-times"></i> Failed
                                </label>
                              </div>
                            <?php endif ?>

                          </td>
                          <?php endif ?> 
                        </tr>  
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div> 
        </div>

        <?php if ($applicant['status'] <> 'For Receiving' AND $applicant['status'] <> 'Draft'): ?>
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
                    <textarea 
                      class="form-control" 
                      rows="3" 
                      name="defects" 
                      placeholder="Enter ..."
                      <?php echo $is_readonly ? 'disabled' : ''; ?> 
                      value="<?php echo isset($app_notes['defects']) ? $app_notes['defects'] : ''; ?>"><?php echo isset($app_notes['defects']) ? $app_notes['defects'] : ''; ?></textarea>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12" style="margin-bottom:-1%;">
                  <div class="form-group">
                    <label>Recommendations</label>
                    <textarea 
                      class="form-control" 
                      name="recommendations" 
                      rows="3" 
                      placeholder="Enter ..." 
                      <?php echo $is_readonly ? 'disabled' : ''; ?>
                      value="<?php echo isset($app_notes['recommendations']) ? $app_notes['recommendations'] : ''; ?>"><?php echo isset($app_notes['recommendations']) ? $app_notes['recommendations'] : ''; ?></textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php endif ?> 
        
        <?php if ($applicant['status'] <> 'Approved' AND $applicant['status'] <> 'Disapproved'): ?>
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
                          Save as Draft  
                        </button>
                      </div>
                      <div class="col-md-6">
                        <button type="button" class="btn btn-success btn-block btn-proceed" data-toggle="modal" style="width: 100%;"><i class="fa fa-share"></i> Submit</button>
                        </button>
                      </div>
                    <?php endif ?> 
                  </div>
                </div> 
              </div> 
              
          </div>
          
        <?php endif ?>
      <?php if ($applicant['status'] <> 'For Receiving' AND $applicant['status'] <> 'Draft'): ?>
      </form>
      <?php endif ?>
    </div>
  </div>
        
<?php include 'modal_evaluation.php'; ?>
<?php include 'modal_view_attachments.php'; ?>

</div>


<style type="text/css">
  .dlk-radio input[type="radio"]
{
  margin-left:-99999px;
  display:none;
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
.card-img, .card-img-top {
    border-top-left-radius: calc(-7.75rem - 1px);
    border-top-right-radius: calc(1.25rem - 24px);
}
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

    $(".btn-tool-onsite").click(function(){
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

    $(document).on('click', '.btn-proceed', function(){
      let tbody = $('#checklist_form tr');
      $counter = 0;
      $.each(tbody, function(){
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

    $(document).on('click', '.btn-save_application', function(){
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

    $(document).on('click', '.btn-attachments_view', function(){
        console.log('qeqwewqe');
        let tr = $(this).closest('tr');
        let id = tr.find('#cform-ulist_id');
        let $modal = $("#modal-view_attachments");
        let form_id = $modal.find('#cform-entry_id');


        let path = 'entity/get_attachments.php?id='+id.val();


        $.get(path, function(data, key){
          let dd = JSON.parse(data);
          $('#tbody-view_attchmnt').empty();
          generateAttachments(dd, $('#tbody-view_attchmnt'));
        })

        form_id.val(id.val());
        $modal.modal('show');
      });

    function generateAttachments($data, $element) {
    let tr = '';
    $element.empty();
    tr+= '<div class="col-md-12">';
    tr+= '<div class="row">';
    $.each($data, function(key, item){
      tr+= '<div class="col-md-3 mb-1">';
      tr+= '<div class="card" style="width: 15rem;">';
      tr+= '<div class="pic-holder" style="padding-top: 5%;height: 12rem;">';
      tr+= '<img src="https://drive.google.com/uc?export=view&id='+item['file_id']+'" class="card-img-top" alt="..." style="max-width: 100%; max-height: 100%; object-fit: cover;">';
      tr+= '</div>';
      // tr+= '<iframe src="https://drive.google.com/uc?export=view&id='+item['file_id']+'" class="card-img-top"></iframe>';
      tr+= '<div class="card-body" style="text-overflow: ellipsis;white-space: nowrap;overflow: hidden;height: 3.5rem;padding: 0.3rem 0.3rem;">';
      tr+= '<a href="'+item['location']+'" class="">';
      tr+= item['file_name'];
      tr+= '</a>';
      tr+= '</div>';
      tr+= '</div>';
      tr+= '</div>';


     


      // tr+='<tr>';
      // tr+='<td style="font-size:18pt; width:10%;">';
      // tr+= '<div class="form-group">';
      // tr+= '<input type="hidden" name="att_id['+item['caid']+']" value="'+item['file_id']+'">';
      // tr+= '<input class="form-check-input" type="checkbox" value="" name="chklists['+item['caid']+']">';
      // tr+= '</div>';
      // tr+='</td>';
      // tr+= '<td>';
      // // tr+= '<a href="'+item['location']+'" class="btn btn-secondary btn-block">';
      // // tr+= item['file_name'];
      // // tr+='</a>';
      // tr+= '<img src="'+item['location']+'"/>';
      // tr+= '</td>';
      // tr+='</tr>';
    });
    tr+= '</div>';
    tr+= '</div>';

    $element.append(tr);
  }

    function postTask(path, data) {
      $.post(path, data,
        function(data, status){
          if (status == 'success') {
            setTimeout(function(){// wait for 5 secs(2)
              location.reload(); // then reload the page.(3) 
            }, 1000);
          }
        }
      );

      return data;
    }

  });
</script>