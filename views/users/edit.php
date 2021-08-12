<?php require_once 'controller/UserAccountsEditController.php'; ?>

<div class="content-header">
  <div class="container">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h5 class="m-0"> User Accounts Edit</h5>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="dashboard.v2.php">Home</a></li>
          <li class="breadcrumb-item"><a href="uac.php">User Accounts</a></li>
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

    <form action="entity/post_user_acct.php?id=<?php echo $_GET['id']; ?>" method="post">

    <div class="row">
      <div class="col-md-4">
        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title"><i class="fa fa-user" aria-hidden="true"></i> Profile</h3>
          </div>
          <div class="card-body">
            <div class="d-flex flex-column align-items-center text-center">
              <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle" width="150">
              <div class="mt-3">
                <h4><b><?php echo $user['name']; ?></b></h4>
                <p class="text-secondary mb-1"><?php echo $user['position']; ?></p>
                <p class="text-muted font-size-sm"><small><?php echo $user['address']; ?></small></p>
                <input type="checkbox" name="user_status" <?php echo $user['is_verified'] ? 'checked' : ''; ?>>
              </div>
            </div>
          </div>
        </div>
    
        <div class="card card-info">
          <div class="card-body">
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
                  <input type="password" name="password" class="form-control" id="exampleInputEmail1" placeholder="Enter fullname" value="">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-5">
                <label class="form-control2" for="exampleInputEmail1">Confirm Password</label>
              </div>
              <div class="col-sm-7 text-secondary">
                <div class="form-group">
                  <input type="password" name="fullname" class="form-control" id="exampleInputEmail1" placeholder="Enter fullname" value="">
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>


      <div class="col-md-8">
        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title"><i class="fa fa-info-circle" aria-hidden="true"></i> General Information</h3>
          </div>
          <div class="card-body">

            <div class="row">
              <div class="col-sm-4">
                <label class="form-control2" for="exampleInputEmail1">Fullname</label>
              </div>
              <div class="col-sm-8 text-secondary">
                <div class="form-group">
                  <input type="text" name="fullname" class="form-control" id="exampleInputEmail1" placeholder="Enter fullname" value="<?php echo $user['name']; ?>">
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-sm-4">
                <label class="form-control2" for="exampleInputEmail1">Position</label>
              </div>
              <div class="col-sm-8 text-secondary">
                <div class="form-group">
                  <input type="text" name="position" class="form-control" id="exampleInputEmail1" placeholder="Enter position" value="<?php echo $user['position']; ?>">
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-sm-4">
                <label class="form-control2" for="exampleInputEmail1">Province</label>
              </div>
              <div class="col-sm-8 text-secondary">
                <div class="form-group">
                  <input type="text" name="province" class="form-control" id="exampleInputEmail1" placeholder="Enter province" value="<?php echo $user['position']; ?>">
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-sm-4">
                <label class="form-control2" for="exampleInputEmail1">City/Municipality</label>
              </div>
              <div class="col-sm-8 text-secondary">
                <div class="form-group">
                  <input type="text" name="lgu" class="form-control" id="exampleInputEmail1" placeholder="Enter city/municipality">
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-sm-4">
                <label class="form-control2" for="exampleInputEmail1">Address</label>
              </div>
              <div class="col-sm-8 text-secondary">
                <div class="form-group">
                  <input type="text" name="address" class="form-control" id="exampleInputEmail1" placeholder="Enter address" value="<?php echo $user['address']; ?>">
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-sm-4">
                <label class="form-control2" for="exampleInputEmail1">Mobile No.</label>
              </div>
              <div class="col-sm-8 text-secondary">
                <div class="form-group">
                  <input type="text" name="mobile_no" class="form-control" id="exampleInputEmail1" placeholder="Enter mobile no." value="<?php echo $user['mobile_no']; ?>">
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-sm-4">
                <label class="form-control2" for="exampleInputEmail1">Email</label>
              </div>
              <div class="col-sm-8 text-secondary">
                <div class="form-group">
                  <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email" value="<?php echo $user['email']; ?>">
                </div>
              </div>
            </div>
            <br>

            <div class="row">
              <div class="col-sm-4">
                <label class="form-control2" for="exampleInputEmail1">Name of Government Agency/Office</label>
              </div>
              <div class="col-sm-8 text-secondary">
                <div class="form-group">
                  <input type="text" name="gov_agency" class="form-control" id="exampleInputEmail1" placeholder="Enter name of agency" value="<?php echo $user['gov_agency']; ?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-4">
                <label class="form-control2" for="exampleInputEmail1">Name of Sub-office/Unit</label>
              </div>
              <div class="col-sm-8 text-secondary">
                <div class="form-group">
                  <input type="text" name="sub_office" class="form-control" id="exampleInputEmail1" placeholder="Enter name of sub-office" value="<?php echo $user['sub_office']; ?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-4">
                <label class="form-control2" for="exampleInputEmail1">Nature of Government Establishments</label>
              </div>
              <div class="col-sm-8 text-secondary">
                <div class="form-group">
                  <input type="text" name="establishment" class="form-control" id="exampleInputEmail1" placeholder="Enter nature of government establishment" value="<?php echo $user['establishment']; ?>">
                </div>
              </div>
            </div>

          </div>
          
          </div>
        </div>
      </div>


      <div class="row">
        <div class="col-md-12">
          <div class="card card-info">
            <div class="card-footer text-right">
              <div class="btn-group">
                <a href="uac.php" class="btn btn-block btn-secondary"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancel</a>
              </div>

              <div class="btn-group">
                <button type="submit" class="btn btn-block btn-success"><i class="fa fa-arrow-right" aria-hidden="true"></i> Submit</button>
              </div>

            </div>
          </div>
        </div>
      </div>
      



    </form>
  </div>

  </div>      
</div>


<style type="text/css">
  .form-control2 {
    display: block;
    width: 100%;
    height: calc(2.25rem + 2px);
    /*padding: .375rem .75rem;*/
    padding-top:  .375rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    /* border: 1px solid #ced4da; */
    border-radius: .25rem;
    box-shadow: inset 0 0 0 transparent;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
  }


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

    // 

    $("[name='user_status']").bootstrapSwitch();

    $(document).on('click', '.btn-draft_save', function(){
      let form = $('#app-details').serialize();
      let path = 'entity/post_newapplicant.php';

      $.post(path, form, function(data, key){
        // if (status == 'success') {
            // setTimeout(function(){// wait for 5 secs(2)
            //   location.reload(); // then reload the page.(3) 
            // }, 1000);
          // }
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