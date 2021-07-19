<div class="modal fade" id="modal_return_remarks" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <form method="POST" enctype="multipart/form-data" action="entity/return_application.php">
      <div class="modal-content">
        <!-- <form method="POST" action="f"></form> -->
        <div class="modal-header" style="background-color: #e13939; color: white;">
          <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-question-circle" aria-hidden="true"></i> Return to Applicant</h5>
        </div>
        <div class="modal-body">
          <input type="hidden" id="rtn-chklist_id" name="rtn-chklist_id" value="<?php echo $_GET['appid']; ?>">
          <div class="col-md-12">
            <div class="form-group">
              <label for="exampleFormControlTextarea1">Reason: </label>
              <textarea class="form-control" rows="5" name="remarks" placeholder="-- Enter Reason --" value="" required></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal"><i class="fa fa-window-close"></i> Cancel</button>
          <button type="submit" class="btn btn-danger btn-return_application"><i class="fa fa-step-forward"></i> Proceed</button>
        </div>
      </div>
    </form>
  </div>
</div>  