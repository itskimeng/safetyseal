<?php require_once 'controller/ApplicationController.php';?>
<?php require_once 'controller/RegistrationComponentsController.php';?>

<div class="registration-image" style="padding-top:3%;">
  <div class="container">
    <div class="pt-5">
      <div class="row align-items-center heading">
        
        <div class="col-md-12">
          <div class="py-1">
            <div class="form-box shadow p-1 mb-5 bg-body rounded box">

              <div class="ribbon blue"><span><?php echo $userinfo['status']; ?></span></div>
              
              <form method="POST" action="entity/post_application.php" class="bg-white  rounded-5 shadow-5-strong p-5">
                <span class="label label-lg label-light-success label-inline font-weight-bold py-3">
                    <a href="user/users_establishments.php" class="btn btn-secondary btn-md">
                        <i class="fa fa-arrow-circle-left"></i> Close
                    </a>
                </span>
                <hr>
                <input type="hidden" name="is_new" value="<?php echo $is_new; ?>">
                <input type="hidden" name="token" value="<?php echo !empty($_GET['ssid']) ? $_GET['ssid'] : ''; ?>">
                <input type="hidden" name="email" value="<?php echo $userinfo['email'];?>">
                <input type="hidden" name="mobile_no" value="<?php echo $userinfo['mobile_no'];?>">

                <!-- user details -->
                <div class="col-md-12 mt-3">
                  <?php include 'user_details.php'; ?>
                </div>

                <?php if (!$is_new): ?>
                  <!-- checklist -->
                  <?php include 'checklist.php'; ?>
                <?php endif ?>

                <!-- Submit button -->
                <?php if (in_array($userinfo['status'], ['Draft', 'Disapproved', 'Reassess'])): ?>
                  <div class="panel panel-default pt-4">
                    <div class="row">
                      
                      <div class="<?php echo $is_new ? 'col-md-12' : 'col-md-6' ;?> pull-right">
                        <button type = "submit" class="btn btn-primary btn-block" name="login" style="width: 100%;"><i class="fa fa-pen-alt"></i> 
                          <?php echo $is_new ? 'Save' : 'Save as Draft' ;?>  
                        </button>
                      </div>
                      <?php if (in_array($userinfo['status'], ['Disapproved','Reassess'])): ?>
                        <div class="col-md-6">
                          <a href="#" type="button" class="btn btn-success btn-block btn-reassess" style="width: 100%;"><i class="fa fa-share"></i> Reassess</a>
                        </div>
                      <?php elseif (!$is_new): ?>
                        <div class="col-md-6">
                          <button type="button" class="btn btn-success btn-block btn-submit_application" name="login" data-bs-toggle="modal" style="width: 100%;"><i class="fa fa-share"></i> Submit</button>
                        </div>
                      <?php endif ?>
                    </div>
                  </div>
                <?php else: ?>
                  <div class="panel panel-default pt-4">
                  <table>
                <tbody>
                  <tr>
                    <td style="text-align:center; width:8%;">
                      <div class="form-group">
                      <input class="form-check-input check_consent" type="checkbox" value="" name="consent" checked disabled style="padding: 12pt;"> 
                    </div>
                    </td>
                    <td>
                      <label>
                        <small>I hereby certify that the facts stated herein are true and correct of my own personal knowledge and any misinterpresentation subjects me to criminal or administrative liability.</small>
                      </label>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2">
                      <div class="col-md-12">
                          <div class="text-center" style="margin-top: 1%; margin-bottom: -1%; font-size:20pt;">
                            <p>
                              <b><?php echo $userinfo['fname']; ?></b>
                              <small style="font-size:15pt;">/ <?php echo $userinfo['date_proceed']; ?></small>
                            </p>
                          </div>
                          <div class="form-outline text-center" style="margin-left: 10%; margin-right: 10%;border-top: 1px solid #19191b42;">
                            Name of Person in Charge / Date
                          </div>
                      </div>
                    </td>
                  </tr> 
                </tbody>
              </table>
            </div>
                <?php endif ?> 
              </form>

            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

</div>

<?php include 'modal_attachments.php';?>
<?php include 'modal_view_attachments.php';?>
<?php include 'modal_proceed.php';?>
<style type="text/css">
.box {
  /*width: 200px;*/
  /*height: 300px;*/
  position: relative;
  /*border: 1px solid #bbb;*/
  /*background: #eee;*/
  /*float: left;*/
  /*margin: 20px;*/
}
.ribbon {
  position: absolute;
  right: -6px;
  top: -5px;
  z-index: 1;
  overflow: hidden;
  width: 154px;
  height: 150px;
  text-align: right;
}
.ribbon span {
  font-size: 0.8rem;
  color: #fff;
  text-transform: uppercase;
  text-align: center;
  font-weight: bold;
  line-height: 32px;
  transform: rotate(45deg);
  width: 192px;
  display: block;
  background: #79a70a;
  background: linear-gradient(#9bc90d 0%, #79a70a 100%);
  box-shadow: 0 3px 10px -5px rgba(0, 0, 0, 1);
  position: absolute;
  top: 41px; // change this, if no border
  right: -20px; // change this, if no border
}

.ribbon span::before {
   content: '';
   position: absolute; 
   left: 0px; top: 100%;
   z-index: -1;
   border-left: 3px solid #79A70A;
   border-right: 3px solid transparent;
   border-bottom: 3px solid transparent;
   border-top: 3px solid #79A70A;
}
.ribbon span::after {
   content: '';
   position: absolute; 
   right: 0%; top: 100%;
   z-index: -1;
   border-right: 3px solid #79A70A;
   border-left: 3px solid transparent;
   border-bottom: 3px solid transparent;
   border-top: 3px solid #79A70A;
}

.red span {
  background: linear-gradient(#f70505 0%, #8f0808 100%);
}
.red span::before {
  border-left-color: #8f0808;
  border-top-color: #8f0808;
}
.red span::after {
  border-right-color: #8f0808;
  border-top-color: #8f0808;
}

.blue span {
  background: linear-gradient(#2989d8 0%, #1e5799 100%);
}
.blue span::before {
  border-left-color: #1e5799;
  border-top-color: #1e5799;
}
.blue span::after {
  border-right-color: #1e5799;
  border-top-color: #1e5799;
}

.foo {
  clear: both;
}

.bar {
  content: "";
  left: 0px;
  top: 100%;
  z-index: -1;
  border-left: 3px solid #79a70a;
  border-right: 3px solid transparent;
  border-bottom: 3px solid transparent;
  border-top: 3px solid #79a70a;
}

.baz {
  font-size: 1rem;
  color: #fff;
  text-transform: uppercase;
  text-align: center;
  font-weight: bold;
  line-height: 2em;
  transform: rotate(45deg);
  width: 100px;
  display: block;
  background: #79a70a;
  background: linear-gradient(#9bc90d 0%, #79a70a 100%);
  box-shadow: 0 3px 10px -5px rgba(0, 0, 0, 1);
  position: absolute;
  top: 100px;
  left: 1000px;
}

.card-img, .card-img-top {
    border-top-left-radius: calc(-7.75rem - 1px);
    border-top-right-radius: calc(1.25rem - 24px);
}
</style>

<script>
  // Example starter JavaScript for disabling form submissions if there are invalid fields
  (function() {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
      .forEach(function(form) {
        form.addEventListener('submit', function(event) {
          if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
          }

          form.classList.add('was-validated')
        }, false)
      })
  })()
</script>
<script type="text/javascript">
  $(document).ready(function(){

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

    $(document).on('click', '.form-check-input', function(){
      let tr = $(this).closest('tr');
      let chkcol = $(this).data('chkcol');

      uncheckOthers(chkcol, tr);

      if (chkcol == 'na') {
        let rr = tr.find('.chklist_na');
        if (rr.is(':checked')) {
          let reason = tr.find('.form-check-reason');
          reason.attr('disabled', false);

        } else {
          let reason = tr.find('.form-check-reason');
          reason.val('');
          reason.attr('disabled', true);          
        }

      } else {
        let reason = tr.find('.form-check-reason');
        reason.val('');
        reason.attr('disabled', true);
      }
    });

    $(document).on('click', '.btn-attachments_upload', function(){
      let tr = $(this).closest('tr');
      let vv = $(this);
      let id = tr.find('#cform-ulist_id');
      let $modal = $("#exampleModal");
      let form_id = $modal.find('#cform-entry_id');
      let co_id = $modal.find('#cform-checklist_order');


      form_id.val(id.val());
      co_id.val(vv.val());
      $modal.modal('show');
    });

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

    $(document).on('click', '.btn-submit_application', function(){
      let checker1 = checkAllSelected();
      let checker2 = checkUploads();

      if (checker1 && checker2) {
        $('#modall_proceed').modal('show');  
      }
    });

    $(document).on('click', '.btn-reassess', function(){
      let path = 'entity/post_reassess.php?ssid=<?php echo $_GET['ssid']; ?>&stt=FA';

      let checker1 = checkAllSelected();
      let checker2 = checkUploads();
      if (checker1 && checker2) {
        $.get(path, function(data, status){
          if (status == 'success') {
            setTimeout(function(){// wait for 5 secs(2)
              location.reload(); // then reload the page.(3) 
            }, 1000);
          }
        });
      }
    });

  })

  function checkAllSelected()
  {
    let tbody = $('#chklist_body tr');
    $counter = 0;
    checker = true;
    
    $.each(tbody, function(){
      let tr = $(this);
      let asmnt = tr.find('.form-check-input');
      if (asmnt.is(':checked')) {
        $counter++;
      }
    });

    if ($counter < 14) {
      tata.warn('Warning', 'All items in the checklist must be assess.');
      checker = false;
    }
    //  else {
    //   $('#modal_attachments').modal('show');
    // }

    return checker;
  }

  function checkUploads()
  {
    let tbody = $('#chklist_body tr');
    $counter = 0;
    checker = true;
    
    $.each(tbody, function(){
      let tr = $(this);
      let attchmnt = tr.find('.has_attachments');
      let asmnt = tr.find('.chklist_yes');

      if (asmnt.is(':checked')) {
        if (!attchmnt.val() || attchmnt.val() == 'false') {
          $counter = $counter + 1;
        }
      }
    });

    if ($counter > 0) {
      tata.error('Warning', 'All checked items must have uploaded MOVs.');
      checker = false;
    }
    //  else {
    //   $('#modal_attachments').modal('show');
    // }
    return checker;
  }

      
      // if ($counter < 14) {
      //   tata.warn('Warning', 'All items in the checklist must be assess.');
      // } else {
      //   $('#modal_evaluation').modal('show');
      // }  

  function generateAttachments($data, $element) {
    let tr = '';
    $element.empty();
    tr+= '<div class="col-md-12">';
    tr+= '<div class="row">';
    $.each($data, function(key, item){
      tr+= '<div class="col-md-3 mb-1">';
      tr+= '<div class="card" style="width: 15rem;">';
      tr+= '<div class="checkers" style="padding-left: 1rem;">';
      tr+= '<div class="form-group">';
      tr+= '<input type="hidden" name="att_id['+item['caid']+']" value="'+item['file_id']+'">';
      tr+= '<input class="form-check-input chklist_na" name="chklists['+item['caid']+']" type="checkbox" value="">';
      tr+= '</div>';
      tr+= '</div>';
      tr+= '<div class="pic-holder" style="padding-top: 5%;height: 12rem;">';
      tr+= '<img src="https://drive.google.com/uc?export=view&id='+item['file_id']+'" class="card-img-top" alt="..." style="max-width: 100%; max-height: 100%; object-fit: cover;">';
      tr+= '</div>';
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

  function uncheckOthers(arg, tr) {
    let arr = ['yes','no','na'];
    $.each(arr, function(i,b){
      if (arg != b) {
        let dd = tr.find('.chklist_'+b);
        dd.prop('checked', false);
      }
    });
  }
</script>
<script src="frontend/js/ajax.js"></script>