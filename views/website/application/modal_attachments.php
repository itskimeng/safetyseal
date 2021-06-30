<div class="modal fade right" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-link"></i> Attachments</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <?php if (isset($_GET['code'])): ?>
        <form method="POST" enctype="multipart/form-data" action="entity/post_attachments2.php">
      <?php else: ?>
        <form method="POST" enctype="multipart/form-data" action="entity/verify_gdrive_user.php">
      <?php endif ?>
        <input type="hidden" id="cform-checklist_order" name="checklist_order" value=""/>
        <input type="hidden" id="cform-entry_id" name="entry_id" value=""/>
        <input type="hidden" name="control_no" value="<?php echo $userinfo['code']; ?>"/>  
        <input type="hidden" name="token_id" value="<?php echo isset($_GET['ssid']) ? $_GET['ssid'] : ''; ?>"/>
        <input type="hidden" name="gcode" value="<?php echo isset($_GET['code']) ? $_GET['code'] : ''; ?>"/>
        <input type="hidden" name="gscope" value="<?php echo isset($_GET['gscope']) ? $_GET['gscope'] : ''; ?>"/>        



        <div class="modal-body">
            <div class="mb-3">
              <!-- <input class="form-control" type="file" id="formFileMultiple" multiple> -->
              <div class="form-group">
                <div class="custom-file">
                  <input type="file" name="files[]" multiple class="custom-file-input form-control" id="customFile" required>
                </div>
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-window-close"></i> Close</button>
          <button type="submit  " class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
        </div>
      </form>
    </div>
  </div>
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
