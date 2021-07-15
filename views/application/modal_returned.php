<div class="modal fade" id="modal_return_remarks" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <form method="POST" enctype="multipart/form-data" action="entity/return_application.php">
      <div class="modal-content">
        <!-- <form method="POST" action="f"></form> -->
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-question-circle" aria-hidden="true"></i> Return</h5>
        </div>
        <div class="modal-body">
          <input type="hidden" id="rtn-chklist_id" name="rtn-chklist_id" value="">
          <div class="col-md-12">
            <div class="form-group">
              <label for="exampleFormControlTextarea1">Remarks: </label>
              <textarea class="form-control" rows="3" name="remarks" placeholder="-- Enter Remarks --" style="font-size: 9.5pt;" value="" required></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal"><i class="fa fa-window-close"></i> Cancel</button>
          <button type="submit" class="btn btn-primary btn-save_application"><i class="fa fa-step-forward"></i> Proceed</button>
        </div>
      </div>
    </form>
  </div>
</div>  