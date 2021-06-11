<div class="modal fade right" id="modall_proceed" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-share"></i> Proceed</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" enctype="multipart/form-data" action="entity/post_proceed.php">
        <input type="hidden" name="chklist_id" value="<?php echo $userinfo['id']; ?>">
        <div class="modal-body">
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
                        <small>I hereby certify that the facts stated herein are true and correct of my own personal knowledge and any misrepresentation subjects me to criminal or administrative liability.</small>
                      </label>
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
    color:white !important;
    text-decoration: none;
    opacity: .75;
}
</style>

<script type="text/javascript">
  $(document).on('click', '.check_consent', function(){
      let tr = $(this).closest('tr');
      let btn_consent = $('.btn-consent');

      if ($(this).is(':checked')) {
        btn_consent.attr('disabled', false);
      } else {
        btn_consent.attr('disabled', true);
      }
      
    });
</script>
