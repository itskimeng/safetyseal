<?php require_once 'controller/AdminNewApplicationController.php'; ?>

<div class="content-header">
  <div class="container">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h5 class="m-0"> Manual Application Edit</h5>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="dashboard.v2.php">Home</a></li>
          <li class="breadcrumb-item"><a href="admin_application.php">Application List</a></li>
          <li class="breadcrumb-item active"> Edit</li>
        </ol>
      </div>
    </div>
    <hr>
  </div>
</div>
    
<!-- Main content -->
<div class="content">
  <div class="container">
    <!-- <form method="POST" action="entity/post_newapplicant.php"> -->
      <!-- <?php //if (!in_array($applicant['status'], ['Approved', 'Disapproved'])): ?> -->
        <div class="row mb-2">
          <div class="col-md-12">
            <div class="row">
              
              <div class="col-md-6">
                <div class="row">
                    <div class="col-md-2">

                      <a href="admin_application_summary.php?appid=<?= $applicant['acid']; ?>&ussir=<?= $_SESSION['userid']; ?>" class="btn btn-secondary btn-block btn-sm" style="margin-bottom: -2%;">
                        <i class="fa fa-arrow-circle-left"></i> Back</a>
                    </div>  
                </div>
              </div>
              <!-- <div class="col-md-6">
                <div class="row text-right">
                  <div class="col-md-12">
                    <div class="btn-group">
                      <a href="entity/delete_admin_application.php?token=<?= $_GET['appid']; ?>" class="btn btn-danger btn-block btn-sm" style="margin-bottom: -2%;">
                        <i class="fa fa-trash"></i> Remove
                      </a>
                    </div>  
                  </div>
                </div>
              </div> -->

            </div>
          </div>
        </div>
      <!-- <?php //endif ?> -->

      <input type="hidden" name="is_new" value="<?= $is_new; ?>">
      
      <?php include 'add/details.php'; ?>

      <?php if (!$is_new): ?>
        <?php include 'add/checklist.php'; ?>      
      <?php endif ?>   
      
      <div class="row">
        <div class="col-lg-12 col-md-6 col-sm-3 mb-3">   
          <div class="panel panel-default">
            <div class="row">
              <?php if (!$is_readonly): ?>
                <?php if ($is_new): ?>
                  <div class="col-md-12 pull-right">
                    <button type="submit" class="btn btn-primary btn-block" style="width: 100%;"><i class="fa fa-pen-alt"></i> 
                      Save  
                    </button>
                  </div>
                <?php else: ?>
                  <div class="col-md-6">
                    <button type="button" class="btn btn-primary btn-block btn-draft_save" style="width: 100%;"><i class="fa fa-pen-alt"></i> 
                      Save as Draft
                    </button>
                  </div>
                  <div class="col-md-6">
                    <button type="button" class="btn btn-success btn-block btn-proceed" data-toggle="modal" style="width: 100%;"><i class="fa fa-share"></i> Submit</button>
                    </button>
                  </div>
                <?php endif ?>                
              <?php endif ?>
            </div>
          </div> 
        </div>
      </div>


    </div>
    <!-- </form> -->
  </div>
        
<?php include 'modal_evaluation.php'; ?>
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
          duration: 20000
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
      let upload = $('.filename_upload').val();
      let $counter = 0;

      if (upload == '') {
        $counter = 1;
      }
      
      if ($counter > 0) {
        tata.warn('Warning', 'Checklist must be uploaded.', 'Warning');
      } else {
        $('#modal_evaluation').modal('show');
      }  
    })

    // $('input[type="file"]').on("change", function() {
    //   let filenames = [];
    //   let files = this.files;
    //   if (files.length > 1) {
    //     filenames.push("Total Files (" + files.length + ")");
    //   } else {
    //     for (let i in files) {
    //       if (files.hasOwnProperty(i)) {
    //         filenames.push(files[i].name);
    //       }
    //     }
    //   }
    //   $(this)
    //     .next(".custom-file-label")
    //     .html(filenames.join(","));
    // });

    $(document).on('click', '.btn-save_application', function(){
      let form = {id: "<?= $_GET['appid']; ?>", citymun: $('#cform-citymun').val()};
      let path = 'entity/post_evaluation2.php';

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

    $(document).on('click', '.btn-draft_save', function(){
      let form = $('#app-details').serialize();
      let path = 'entity/post_newapplicant.php';
      // test
      $.post(path, form, function(data, key){
        if (key == 'success') {
            setTimeout(function(){// wait for 5 secs(2)
              location.reload(); // then reload the page.(3) 
            }, 1000);
          }
      });
    })

    $(document).on('click', '.btn-attachments_view', function(){
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

    $(document).on('click', '.assessments', function(){
      let $this = $(this);
      let tr = $this.closest('tr');
      let id = tr.find('#cform-hidden_certid');
      $this.addClass('active')
      
      if ($this.hasClass('pass')) {
        let el = '<input type="radio" name="assessments['+id.val()+']" class="opt_assmnt" value="pass" id="option_b1" autocomplete="off" checked><i class="fa fa-check"></i> Passed';
        $(this).html(el);


        let btn_fail = tr.find('.bg-danger_btn');
        btn_fail.removeClass('active');
        btn_fail.html('<input type="radio" name="assessments['+id.val()+']" class="opt_assmnt" value="fail" id="option_b2" autocomplete="off"><i class="fa fa-times"></i> Fail');
      } else {
        let btn_pass = tr.find('.bg-success_btn');
        btn_pass.removeClass('active');
        btn_pass.html('<input type="radio" name="assessments['+id.val()+']" class="opt_assmnt" value="pass" id="option_b1" autocomplete="off"><i class="fa fa-check"></i> Pass');

        let el = '<input type="radio" name="assessments['+id.val()+']" class="opt_assmnt" value="fail" id="option_b2" autocomplete="off" checked><i class="fa fa-times"></i> Failed';
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

    $(document).on('click', '#btn-pass_all', function(){
      let tb = $('#checklist_form tr');
      $.each(tb, function(){
        let id = $(this).find('#cform-hidden_certid');
        let pp = $(this).find('.bg-success_btn');
        pp.addClass('active');
        pp.html('<input type="radio" name="assessments['+id.val()+']" class="opt_assmnt" value="pass" id="option_b1" autocomplete="off" checked><i class="fa fa-check"></i> Passed');

        let pp2 = $(this).find('.bg-danger_btn');
        pp2.removeClass('active');
        pp2.html('<input type="radio" name="assessments['+id.val()+']" class="opt_assmnt" value="fail" id="option_b2" autocomplete="off"><i class="fa fa-check"></i> Fail');
      });
    });

    $(document).on('click', '#btn-fail_all', function(){
      let tb = $('#checklist_form tr');
      $.each(tb, function(){
        let id = $(this).find('#cform-hidden_certid');
        let pp = $(this).find('.bg-danger_btn');

        pp.addClass('active');
        pp.html('<input type="radio" name="assessments['+id.val()+']" class="opt_assmnt" value="fail" id="option_b2" autocomplete="off" checked><i class="fa fa-check"></i> Failed');

        let pp2 = $(this).find('.bg-success_btn');
        pp2.removeClass('active');
        pp2.html('<input type="radio" name="assessments['+id.val()+']" class="opt_assmnt" value="pass" id="option_b1" autocomplete="off"><i class="fa fa-check"></i> Pass');
      });
    });

    function assessmentCheckerPass() {
      let tb = $('#checklist_form tr'); 
      $counter = 0;
      $.each(tb, function(){
        let pp = $(this).find('.bg-success_btn');
        if (pp.hasClass('active')) {
          $counter++;
        }
      });

      if ($counter == 14) {
        return true;
      } else {
        return false;
      }
    }

    function assessmentCheckerFail() {
      let tb = $('#checklist_form tr'); 
      $counter = 0;
      $.each(tb, function(){
        let pp = $(this).find('.bg-danger_btn');
        if (pp.hasClass('active')) {
          $counter++;
        }
      });

      if ($counter == 14) {
        return true;
      } else {
        return false;
      }
    }

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