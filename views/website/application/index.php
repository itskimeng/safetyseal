<?php require_once 'controller/ApplicationController.php'; ?>
<?php require_once 'controller/RegistrationComponentsController.php'; ?>

<div class="container" style="padding-top: 5%;">
  <img src="frontend/images/banner_calabarzon.png" height="10%" width="100%" alt="">
  <hr>

</div>

<div class="registration-image">
  <div class="container">
    <div class="pt-4">
      <div class="row align-items-center heading">

        <?php if ($count_ent == 14 and $count_answeredlist == 9) : ?>
          <div class="col-md-12">
            <div class="form-box shadow px-5 mb-2 bg-body rounded box">
              <div class="bg-white pt-2 pb-2" style="color:#b56501">
                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Your province has been updated to <b><u>Alert Level <?= $alert_level; ?></u></b>. Delete this application and create a new application.
              </div>
            </div>
          </div>
        <?php endif ?>

        <div class="col-md-12">
          <div class="form-box shadow px-5 mb-2 bg-body rounded box">
            <div class="bg-white pt-2 pb-2">
              <span class="">
                <?php if (isset($_GET['create_new']) || isset($_GET['create_newv1'])) : ?>
                  <a href="user/application_list.php" type="button" class="btn btn-secondary btn-sm">
                    <i class="fa fa-arrow-circle-left"></i> Back</a>
                <?php else : ?>
                  <a href="user/application.php?form=<?= $_GET['form']; ?>&ssid=<?= $_GET['ssid']; ?>&code=<?= $_GET['code']; ?>&scope=<?= $_GET['scope']; ?>" type="button" class="btn btn-secondary btn-sm">
                    <i class="fa fa-arrow-circle-left"></i> Back</a>
                <?php endif ?>


                <?php if (in_array($userinfo['status'], ['Returned', 'Revoked'])) : ?>
                  <a href="entity/post_reassess.php?ssid=<?php echo $_GET['ssid']; ?>&stt=Reassess" class="btn btn-warning btn-sm"><i class="fa fa-redo" aria-hidden="true"></i> Reassess
                  </a>
                  <a type="button" class="btn btn-danger btn-sm btn-delete_app" data-bs-toggle="modal" data-target="#modal-delete_app"><i class="fas fa-trash"></i> Delete</a>
                <?php endif ?>
              </span>

            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="py-1">
            <div class="form-box shadow p-1 mb-4 bg-body rounded box">

              <div class="ribbon <?= $userinfo['status'] == 'Expired' ? 'red' : 'blue'; ?>">
                <?php if (isset($_GET['create_new'])) : ?>
                  <span>Draft</span>
                <?php elseif ($userinfo['status'] == 'Reassess') : ?>
                  <span>Draft</span>
                <?php else : ?>
                  <span><?= $userinfo['status']; ?></span>
                <?php endif ?>
              </div>

              <form method="POST" action="entity/post_application.php" class="bg-white rounded-5 shadow-5-strong p-5">
                <div class="form-group">
                  <strong style="font-size:20px;"><i class="fas fa-clipboard-list"></i> CHECKLIST FORM</strong>
                </div>
                <hr>
                <?php if (isset($_GET['create_new'])) : ?>
                  <input type="hidden" name="checklist" value="create_new">
                <?php else : ?>
                  <input type="hidden" name="checklist" value="create_newv1">
                <?php endif ?>
                <input type="hidden" name="is_new" value="<?php echo $is_new; ?>">
                <input type="hidden" name="token" value="<?php echo !empty($_GET['ssid']) ? $_GET['ssid'] : ''; ?>">
                <input type="hidden" name="mobile_no" value="<?php echo $userinfo['contact_details']; ?>">
                <input type="hidden" name="province" value="<?php echo $_SESSION['province']; ?>">
                <input type="hidden" name="city_mun" value="<?php echo $_SESSION['city_mun']; ?>">

                <!-- user details -->
                <div class="col-md-12 mt-3">
                  <?php include 'user_details.php'; ?>
                </div>

                <?php if (!$is_new) : ?>
                  <?php include 'checklist.php'; ?>

                <?php endif ?>

                <?php if (in_array($userinfo['status'], ['Returned', 'Disapproved', 'Revoked'])) : ?>
                  <?php include 'comments.php'; ?>
                <?php endif ?>

                <!-- Submit button -->
                <?php if (isset($_GET['create_new']) or in_array($userinfo['status'], ['Draft', 'Disapproved', 'Reassess', 'For Renewal'])) : ?>
                  <div class="panel panel-default pt-4">
                    <div class="row">

                      <div class="<?php echo $is_new ? 'col-md-12' : 'col-md-6'; ?> pull-right">
                        <button type="submit" class="btn btn-primary btn-block" name="login" style="width: 100%;"><i class="fa fa-pen-alt"></i>
                          <?php echo $is_new ? 'Save' : 'Save as Draft'; ?>
                        </button>
                      </div>
                      <?php if (in_array($userinfo['status'], ['Disapproved', 'Reassess'])) : ?>
                        <div class="col-md-6">
                          <a href="#" type="button" class="btn btn-success btn-block btn-reassess" style="width: 100%;"><i class="fa fa-share"></i> Submit</a>
                        </div>
                      <?php elseif (!$is_new) : ?>
                        <div class="col-md-6">
                          <button type="button" class="btn btn-success btn-block btn-submit_application" name="login" data-bs-toggle="modal" style="width: 100%;"><i class="fa fa-share"></i> Submit</button>
                        </div>
                      <?php endif ?>
                    </div>
                  </div>
                <?php else : ?>
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

<?php include 'modal_attachments.php'; ?>
<?php include 'modal_view_attachments.php'; ?>
<?php include 'modal_proceed.php'; ?>
<?php include 'modal_delete_app.php'; ?>
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
    top: 41px;
    right: -40px;
  }

  .ribbon span::before {
    content: '';
    position: absolute;
    left: 0px;
    top: 100%;
    z-index: -1;
    border-left: 3px solid #79A70A;
    border-right: 3px solid transparent;
    border-bottom: 3px solid transparent;
    border-top: 3px solid #79A70A;
  }

  .ribbon span::after {
    content: '';
    position: absolute;
    right: 0%;
    top: 100%;
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

  .card-img,
  .card-img-top {
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
  $(document).ready(function() {

    validatechk_aspaces();
    <?php
    if (isset($_SESSION['toastr'])) {
      echo 'tata.' . $_SESSION['toastr']['type'] . '("' . $_SESSION['toastr']['title'] . '", "' . $_SESSION['toastr']['message'] . '", {
          duration: 20000
        })';
      unset($_SESSION['toastr']);
    }
    ?>

    var checker_count = 0;

    $(document).on('click', '.form-check-input', function() {
      let tr = $(this).closest('tr');
      let chkcol = $(this).data('chkcol');
      let other_tool = tr.find('.other_tool');

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

      if ($(this).is(':checked')) {
        other_tool.val('');
        other_tool.prop('disabled', true);
      } else {
        other_tool.prop('disabled', false);
      }
    });

    $(document).on('click', '.btn-add_attachments', function(e) {
      let $this = $(this);
      let $attachment = $('#customFile');
      let len = $attachment[0].files.length;
      let $filesizes = 0;
      let $valid_file = true;
      let btn_close = $("#modal_evaluation .btn-secondary");

      for (var i = 0; i < len; i++) {
        let filetype = $attachment[0].files[i].type;

        if (filetype.indexOf("png") < 0 && filetype.indexOf("jpg") < 0 && filetype.indexOf("jpeg") < 0 && filetype.indexOf("JPG") < 0 && filetype.indexOf("JPEG") < 0 && filetype.indexOf("PNG") < 0 && filetype.indexOf("word") < 0 && filetype.indexOf("sheet") < 0 && filetype.indexOf("pdf") < 0) {
          $valid_file = false;
        }

        $filesizes = $filesizes + $attachment[0].files[i].size;
      }

      if (($filesizes > 10485760) || (!$valid_file)) { // 10 MB (this size is in bytes)
        tata.warn('Warning', 'Invalid file type or file size is over 10Mb.');
        e.preventDefault();
      } else {
        if ($attachment.val() != "") {
          $this.html('<i class="fa fa-circle-notch fa-spin"></i> Uploading...');
          $('.btn-close_attachments').attr('disabled', true);
        }

        btn_close.css('display', 'none');
        $("#modal_attachments").modal({
          backdrop: 'static',
          keyboard: false
        });
      }

    });

    $(document).on('click', '.option', function() {
      let $this = $(this);
      let tr = $this.closest('tr');
      let opts = tr.find('.form-check-input');
      let other_field = tr.find('.other-sstools');
      let inp = tr.find('#cform-other_tool');

      opts.attr('checked', false);

      if ($this.data('val') == 'others') {
        opts.attr('disabled', true);
        other_field.removeClass('hidden-other_tools');
        inp.attr('disabled', false);
      } else {
        opts.attr('disabled', false);
        other_field.addClass('hidden-other_tools');
        inp.attr('disabled', true);
      }
    });

    $(document).on('click', '.btn-attachments_upload', function() {
      let tr = $(this).closest('tr');
      let vv = $(this);
      let id = tr.find('#cform-ulist_id');
      let $modal = $("#exampleModal");
      let modal_label = $modal.find('#exampleModalLabel');
      let list_order = tr.find('#checklist-order');
      let caption = 'Checklist #' + list_order.val();

      let form_id = $modal.find('#cform-entry_id');
      let co_id = $modal.find('#cform-checklist_order');
      modal_label.html('<i class="fa fa-link"></i> Attachments - ' + caption);

      form_id.val(id.val());
      co_id.val(vv.val());
      $modal.modal('show');
    });

    $(document).on('click', '.btn-attachments_view', function() {
      let tr = $(this).closest('tr');
      let id = tr.find('#cform-ulist_id');
      let $modal = $("#modal-view_attachments");
      let form_id = $modal.find('#cform-entry_id');
      let list_order = tr.find('#checklist-order');
      let caption = 'Checklist #' + list_order.val();
      let modal_label = $modal.find('#exampleModalLabel');
      let checker_id = $(this).data('checker_id');
      modal_label.html('<i class="fa fa-link"></i> Attachments - ' + caption);

      if (checker_id != checker_count) {
        clearModalView();

        let path = 'entity/get_attachments.php?id=' + id.val() + '&for_renewal=<?php echo $userinfo['for_renewal']; ?>&list_order=' + list_order.val();

        $.get(path, function(data, key) {
          let dd = JSON.parse(data);
          setTimeout(function() {
            generateAttachments(dd)
          }, 1500);
        });

        checker_count = checker_id;
      }

      form_id.val(id.val());
      $modal.modal('show');
    });

    function clearModalView() {
      $('.cont').empty();
      $('.cont').append(generateSpinner());

      $('.btn-all_attachments').hide('slow');
      $('.btn-delete_attachments').hide('slow');

      $('.btn-all_attachments').addClass('button-hidden');
      $('.btn-delete_attachments').addClass('button-hidden');
    }

    function generateSpinner() {
      return '<div class="loadingio-spinner-interwind-1mn62qz6yu9"><div class="ldio-2ejy8czjmjr"><div><div><div><div></div></div></div><div><div><div></div></div></div></div></div></div>';
    }

    $(document).on('click', '.btn-delete_app', function(e) {
      $('#modal-delete_app').modal('show');
    });

    $(document).on('click', '.btn-submit_application', function() {
      let checker1 = checkAllSelected();
      let checker2 = checkUploads();

      let alert_level = '<?= $alert_level; ?>';

      // let checker2 = checkUploads();
      // let valid_request = '<?= $valid_request; ?>';
      let form_validator = checklistChecker();
      if (alert_level == 1) {
        // if (checker1 && checker2) {
        if (checker1 && checker2) {
          $('#modall_proceed').modal('show');
        } else {
          tata.info('Info', 'All changes made in the list must be save first to proceed.');
        }
      } else {
        // if (checker1 && checker2) {
        if (checker1 & checker2) {
          if (form_validator) {
            $('#modall_proceed').modal('show');
          } else {
            tata.info('Info', 'All changes made in the list must be save first to proceed.');
          }

        }
      }

    });


    $(document).on('click', '#chklist_yes9', function(event) { //on click
      if (this.checked) { // check select status
        for (let index = 9; index <= 17; index++) {
          $('#chklist_na' + index).prop('checked', false);
        }
        for (let index = 18; index <= 28; index++) {
          $('#chklist_na' + index).prop('checked', true);
          $('#chklist_yes' + index).prop('checked', false);
        }

      } else {
        for (let index = 9; index <= 17; index++) {
          $('#chklist_yes' + index).prop('checked', false);
          $('#chklist_na' + index).prop('checked', true);
        }

      }
    });

    $(document).on('click', '#chklist_no9', function(event) {
      if (this.checked) { // check select status
        for (let index = 9; index <= 17; index++) {
          $('#chklist_na' + index).prop('checked', false);
        }
        for (let index = 18; index <= 28; index++) {
          $('#chklist_na' + index).prop('checked', false);
          $('#chklist_yes' + index).prop('checked', false);
        }

      } else {
        for (let index = 9; index <= 17; index++) {
          $('#chklist_yes' + index).prop('checked', false);
          $('#chklist_na' + index).prop('checked', true);
        }

      }
    })


    // // ===============================================

    $(document).on('click', '#chklist_yes18', function(event) { //on click
      if (this.checked) { // check select status
        for (let index = 9; index <= 17; index++) {
          $('#chklist_yes' + index).prop('checked', false);
          $('#chklist_no' + index).prop('checked', false);
        }

      } else {


      }
    });

    $(document).on('click', '.btn-reassess', function() {
      let path = 'entity/post_reassess.php?ssid=<?php echo isset($_GET['ssid']) ? $_GET['ssid'] : ''; ?>&stt=FA';

      let checker1 = checkAllSelected();
      // let checker2 = checkUploads();
      if (checker1) {
        $.get(path, function(data, status) {
          if (status == 'success') {
            tata.success('Success', 'Application Successfully submitted.');
            setTimeout(function() { // wait for 5 secs(2)
              location.reload(); // then reload the page.(3) 
            }, 999);
          }
        });
      }
    });

    $(document).on('keyup', '.other_tool', function() {
      let $this = $(this);
      let tr = $this.closest('tr');
      let check_yes = tr.find('.chklist_yes');
      let check_no = tr.find('.chklist_no');
      let check_na = tr.find('.chklist_na');
      let reason = tr.find('.form-check-reason');

      if ($this.val() != '') {
        check_yes.prop('checked', false);
        check_yes.prop('disabled', true);

        check_no.prop('checked', false);
        check_no.prop('disabled', true);

        check_na.prop('checked', false);
        check_na.prop('disabled', true);

        reason.val('');
        reason.prop('disabled', true);
      } else {
        check_yes.prop('disabled', false);
        check_no.prop('disabled', false);
        check_na.prop('disabled', false);
        reason.prop('disabled', true);
      }
    });

  })

  $(document).on('click', '.btn-open-exlink', function(e) {
    e.preventDefault();
    var url = $(this).attr('href');
    window.open(url);
  });


  function validatechk_aspaces() {
    let checker = true;
    if ($('#chklist_yes18').is(':checked')) {
      checker = false;
    }
    return checker;
  }

  function checklistChecker() { // will check for any changes made in the checklist
    let answered_checklist = JSON.parse('<?= $answered_checklist; ?>');
    let checker = true;

    $('#chklist_body #chklist_tr').each(function(key, item) {
      let answer = '';
      let row = $(this);

      if (row.find('.chklist_yes').is(':checked')) {
        answer = 'yes';
      } else if (row.find('.chklist_no').is(':checked')) {
        answer = 'no';
      } else if (row.find('.chklist_na').is(':checked')) {
        answer = 'n/a';
      } else if (row.find('.checklist2_opt').is(':checked')) {
        answer = 'other';
      }

      if (answered_checklist[key] != answer) {
        checker = false;
      }

    })
    return checker;
  }

  function checkAll() {
    let check_asp = validatechk_aspaces();
    let chklist_id = [];
    if (check_asp) {
      chklist_id = [1, 2, 3, 4, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 29, 30, 31, 32, 33, 34, 35, 36, 37, 39]; //for non-airconditioned
    } else {
      chklist_id = [1, 2, 3, 4, 7, 8, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 39]; //for airconditioned
    }
    let checker = true;
    $.each(chklist_id, function(key, item) {
      var chklist_yes = $("#chklist_yes" + item).serializeArray();
      var chklist_no = $("#chklist_no" + item).serializeArray();
      var chklist_na = $("#chklist_na" + item).serializeArray();
      // if(chklist_yes.length == 0){
      //   checker = false;
      // }


    })
    return checker;
  }

  function checkAllSelected() {
    let tbody = $('#chklist_body tr');
    $counter = 0;
    checker = true;
    let count_entries = '<?= $count_ent; ?>';
    let count_answeredlist = '<?= $count_answeredlist; ?>';
    let alert_level = '<?= $alert_level; ?>';
    let c = $counter;
    let chk_opt = JSON.parse('<?= $optional_chklist; ?>');
    let check_req = checkAll();

    $.each(tbody, function() {
      let tr = $(this);
      let asmnt = tr.find('.form-check-input');
      let other_tool = tr.find('.other_tool');

      if (other_tool.val() != undefined) {
        if (asmnt.is(':checked') || other_tool.val() != '') {
          $counter++;
        }
      } else if (asmnt.is(':checked')) {
        $counter++;
      }

      // if (asmnt.is(':checked') || other_tool.val() != undefined && other_tool.val() != '') {
      // }
    });
    if (count_entries == 14 && count_answeredlist == 9) {
      tata.warn('Alert', 'Your province has been updated to  Alert Level ' + '<?= $alert_level; ?>' + '. Delete this application and create a new application.', {
        duration: 20000
      });
      checker = false;

    } else if (!check_req) {
      tata.warn('Alert', 'All items without optional in the checklist must be assess.');
      checker = false;
    }
    // else if ($counter < count_entries) {
    //   tata.warn('Alert', 'All items without optional in the checklist must be assess.');
    //   checker = false;
    // else if ($counter != count_entries) {
    // tata.warn('Alert', 'Your province has updated to  Alert Level ' + '<?= $alert_level; ?>' + '. Delete this application and create a new application.', {
    //   duration: 20000
    // });

    // }




    return checker;
  }

  function checkUploads() {
    let tbody = $('#chklist_body tr');
    $counter = 0;
    checker = true;

    $.each(tbody, function() {
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


  function generateAttachments($data) {
    let tr = '';
    tr += '<div class="col-sm-12">';
    tr += '<div class="row">';
    $.each($data, function(key, item) {
      tr += '<div class="col-sm-2 mb-1">';
      tr += '<div class="card" style="/* width: 15rem; */ background-color: #c9c9c9;">';
      tr += '<div class="checkers" style="padding-left: .5rem;">';
      tr += '<div class="form-group">';

      tr += '<input class="form-check-input chklist_na up-attachment" name="filename[' + item.caid + ']" type="checkbox" value="' + item.file_id + '">';
      tr += '</div>';
      tr += '</div>';
      tr += '<div class="pic-holder" style="padding-top: 5%;height: 8rem; overflow: hidden;">';

      if (item['cover_page'] == null) {
        tr += '<img src="' + item.url + '" class="card-img-top" alt="..." style="max-width: 100%; max-height: 100%; object-fit: cover; transform: scale(2);">';
      } else {
        tr += '<img src="' + item.cover_page + '" class="card-img-top" alt="..." style="max-width: 100%; max-height: 100%; object-fit: cover;">';
      }

      tr += '</div>';
      tr += '<div class="card-body" style="text-overflow: ellipsis;white-space: nowrap;overflow: hidden;height: 3.5rem;padding: 0.3rem 0.3rem;">';
      tr += '<div class="row">';
      tr += '<div class="col-sm-12" style="text-align:center;">';
      tr += '<a class="btn btn-md btn-success" href="' + item.url + '" target="_blank" rel="noopener noreferrer" style="width:100%">';
      tr += '<i class="fa fa-eye"></i> View';
      tr += '</a>';
      tr += '</div>';
      tr += '</div>';
      tr += '</div>';
      tr += '</div>';
      tr += '</div>';
    });
    tr += '</div>';
    tr += '</div>';

    $('#tbody-view_attchmnt').css('overflow-y', 'scroll');
    $('.cont').empty();
    $('.cont').hide().append(tr).show('slow');

    $('.btn-all_attachments').show('slow');
    $('.btn-delete_attachments').show('slow');

    $('.btn-all_attachments').removeClass('button-hidden');
    $('.btn-delete_attachments').removeClass('button-hidden');

    // $element.append(tr).show('slow');
  }

  function uncheckOthers(arg, tr) {
    let arr = ['yes', 'no', 'na'];
    $.each(arr, function(i, b) {
      if (arg != b) {
        let dd = tr.find('.chklist_' + b);
        dd.prop('checked', false);
      }
    });
  }
</script>