<?php require_once 'controller/AdminNewApplicationController.php'; ?>

<div class="content-header">
  <div class="container">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h5 class="m-0"> Manual Application New</h5>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="dashboard.v2.php">Home</a></li>
          <li class="breadcrumb-item"><a href="admin_application.php">Application List</a></li>
          <li class="breadcrumb-item active"> New</li>
        </ol>
      </div>
    </div>
    <hr>
  </div>
</div>
    
<!-- Main content -->
<div class="content">
  <div class="container">

    <div class="row mb-2">
      <div class="col-md-12">
        <a href="admin_application.php" class="btn btn-secondary btn-sm">
          <i class="fa fa-arrow-circle-left"></i> Back
        </a>
      </div>
    </div>

    <form method="POST" action="entity/post_newapplicant.php">
      
      <?php include 'add/add_details.php'; ?>   

      <div class="row mb-3">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-6">
              <button type="submit" class="btn btn-primary btn-block" style="width: 100%;"><i class="fa fa-pen-alt"></i> Save</button>
            </div>
            <?php if (!$is_new): ?>
              <div class="col-md-6">
                <button type="submit" class="btn btn-success btn-block" style="width: 100%;"><i class="fa fa-pen-alt"></i> Submit</button>
              </div>
            <?php endif ?>
          </div>
        </div>
      </div>

    </form>
  </div>
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

      console.log($counter);
      
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