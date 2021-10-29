<!-- <div class="modal fade right" id="modal-view_attachments" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-link"></i> View Attachments</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" enctype="multipart/form-data" action="entity/delete_attachments.php">
        <input type="hidden" name="checklist_order" value=""/>
        <input type="hidden" id="cform-entry_id" name="entry_id" value=""/>
        <input type="hidden" name="control_no" value="<?php //echo $applicant['control_no']; ?>"/>  
        <input type="hidden" name="token_id" value="<?php //echo $applicant['ssid']; ?>"/>        

        <div class="modal-body" id="tbody-view_attchmnt">
                  
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-window-close"></i> Close</button>
        </div>
      </form>
    </div>
  </div>
</div> -->

<div class="modal fade right" id="modal-view_attachments" aria-modal="true" role="dialog">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="fa fa-link"></i> View Attachments</h4>
      </div>
      <form method="POST" enctype="multipart/form-data" action="entity/delete_attachments.php">
        <input type="hidden" name="checklist_order" value=""/>
        <input type="hidden" id="cform-entry_id" name="entry_id" value=""/>
        <input type="hidden" name="control_no" value="<?php //echo $applicant['control_no']; ?>"/>  
        <input type="hidden" name="token_id" value="<?php //echo $applicant['ssid']; ?>"/>        

        <div class="modal-body" id="tbody-view_attchmnt" style="max-height: 570px; overflow-y: scroll;">
          
        </div>

        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<style type="text/css">
  .modal-header {
    background-color: #ffcd39;
  }
  .bs-callout {
      padding: 20px;
      margin: 20px 0;
      border: 1px solid #eee;
      border-left-width: 5px;
      border-radius: 3px;
  }
</style>
