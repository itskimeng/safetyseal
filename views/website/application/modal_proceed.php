<div class="modal fade right" id="modall_proceed" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" style="color:white;" id="exampleModalLabel"><i class="fas fa-question-circle"></i> Proceed</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

   
      <form method="post" enctype="multipart/form-data" action="entity/post_proceed.php">
        <input type="hidden" name="chklist_id" value="<?php echo $userinfo['acid']; ?>">
        <input type="hidden" name="token" value="<?php echo !empty($_GET['ssid']) ? $_GET['ssid'] : ''; ?>">
        <input type="hidden" name="name" value="<?php echo $_SESSION['name']; ?>">
        <input type="hidden" name="email" value="<?php echo $_SESSION['email']; ?>">
        <input type="hidden" name="control_no" value="<?php echo $userinfo['code']; ?>">
        <input type="hidden" name="contact_details" value="<?php echo $userinfo['contact_details']; ?>">



        <div class="modal-body" style="padding: 40px;">
          <div class="mb-3">
            <table>
              <tbody>
                <tr>
                  <td style="text-align:center; width:10%;">
                    <div class="form-group">
                      <input class="form-check-input check_consent" type="checkbox" value="" name="consent" style="padding: 12pt;">
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
                      <div class="text-center" style="margin-top: 3%; margin-bottom: -1%; font-size:20pt;">
                        <p>
                          <b><?php echo $userinfo['fname']; ?></b>
                          <small>/ <?php echo $today; ?></small>
                        </p>
                      </div>
                      <div class="form-outline text-center" style="margin-left: 10%; margin-right: 10%;border-top: 1px solid;">
                        <b>Name of Person in Charge / Date</b>
                      </div>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-window-close"></i> Close</button>
          <button type="submit" class="btn btn-success btn-consent" disabled><i class="fa fa-step-forward"></i> Proceed</button>
        </div>
      </form>
    </div>
  </div>
</div>

<style type="text/css">
  .modal-header {
    background-color: #146c43;
    color: white;
  }

  .btn-close:hover {
    color: white !important;
    text-decoration: none;
    opacity: .75;
  }
</style>

<script type="text/javascript">
  $(document).on('click', '.check_consent', function() {
    let tr = $(this).closest('tr');
    let btn_consent = $('.btn-consent');

    if ($(this).is(':checked')) {
      btn_consent.attr('disabled', false);
    } else {
      btn_consent.attr('disabled', true);
    }
    
  });
</script>
