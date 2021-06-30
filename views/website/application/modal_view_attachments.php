<div class="modal fade right" id="modal-view_attachments" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #0d6efd !important;">
        <h5 class="modal-title" id="exampleModalLabel" style="color:white;"><i class="fa fa-link"></i> View Attachments</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" enctype="multipart/form-data" action="entity/delete_attachments.php">
        <input type="hidden" name="checklist_order" value="CL01"/>
        <input type="hidden" id="cform-entry_id" name="entry_id" value=""/>
        <input type="hidden" name="control_no" value="<?php echo $userinfo['code']; ?>"/>  
        <input type="hidden" name="token_id" value="<?php if(isset($_GET['ssid'])){echo $_GET['ssid'];}else{}?>"/>        

        <div class="modal-body" id="tbody-view_attchmnt">
            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-window-close"></i> Close</button>
          <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Remove Selected</button>
        </div>
      </form>
    </div>
  </div>
</div>

<style type="text/css">
  /*.modal-header  {
    background-color: #0d6efd !important;
    color: white !important;
  }*/
  .bs-callout {
      padding: 20px;
      margin: 20px 0;
      border: 1px solid #eee;
      border-left-width: 5px;
      border-radius: 3px;
  }
</style>

<script type="text/javascript">
  $('input[type="file"]').on("change", function() {
    let filenames = [];
    let files = this.files;
    if (files.length > 1) {
      filenames.push("Total Files (" + files.length + ")");
    } else {
      for (let i in files) {
        if (files.hasOwnProperty(i)) {
          filenames.push(files[i].name);
        }
      }
    }
    $(this)
      .next(".custom-file-label")
      .html(filenames.join(","));
  });
</script>
