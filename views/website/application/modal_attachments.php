<div class="modal fade right" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #ffcd39 !important;">
        <h5 class="modal-title" id="exampleModalLabel" style="color:white;"><i class="fa fa-link"></i> Attachments</h5>
        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
      </div>

      <form method="POST" enctype="multipart/form-data" action="entity/upload_movs.php">
        <input type="hidden" id="cform-checklist_order" name="checklist_order" value=""/>
        <input type="hidden" id="cform-entry_id" name="entry_id" value=""/>
        <input type="hidden" name="control_no" value="<?= $userinfo['code']; ?>"/>  
        <input type="hidden" name="token_id" value="<?= isset($_GET['ssid']) ? $_GET['ssid'] : ''; ?>"/>
        <input type="hidden" name="gcode" value="<?= isset($_GET['code']) ? $_GET['code'] : ''; ?>"/>  
        
        <div class="modal-body">
            <div class="mb-3">
              <div class="row mb-1">
                <div class="col-md-12" style="font-size:14px;">
                  <div class="" style="background-color: #d0d0d0; border-radius: 3px; color: #625d5d; padding: 5px;">
                    Allowed File Size: 10MB<br>
                    Allowed File Type: 'pdf', 'png', 'jpeg', 'jpg', 'xls', 'word'
                  </div>
                </div>
              </div>

              <div class="form-group">
                <div class="custom-file">
                  <input type="file" name="files[]" multiple class="custom-file-input form-control" id="customFile" required>
                </div>
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-close_attachments" data-bs-dismiss="modal"><i class="fa fa-window-close"></i> Close</button>
          <button type="submit  " class="btn btn-primary btn-add_attachments"><i class="fa fa-save"></i> Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<style type="text/css">
  /*.modal-header {
    background-color: #ffcd39 !important;
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

  // $('form').submit(function( e ) {
  //   if(!$('#customFile')[0].files[0].size < 10485760) { // 10 MB (this size is in bytes)
  //       //Prevent default and display error
  //       tata.warn('Warning', 'File size is over 10Mb.');
  //       e.preventDefault();
  //   }
  
  // });

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
