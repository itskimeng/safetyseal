<div class="row" id="checklist_div">
  <div class="col-md-12">
    <div class="card card-default">
      <div class="card-header">
        <h3 class="card-title"><i class="fa fa-tasks"></i> <b>CHECKLISTS</b></h3>
      </div>
      <div class="card-body">

        <?php if (!isset($_SESSION['accessToken']) AND !isset($_GET['code'])): ?>
            <form method="POST" action="entity/verify_gdrive_user2.php">
              <input type="hidden" name="token_id" value="<?php echo $_GET['appid']; ?>">
              <input type="hidden" name="gcode" value="<?php echo isset($_GET['code']) ? $_GET['code'] : ''; ?>"/>
              <input type="hidden" name="gscope" value="<?php echo isset($_GET['gscope']) ? $_GET['gscope'] : ''; ?>"/>  
              <input type="hidden" name="filename_upload" class="filename_upload" value="">

              <div class="row">
                  <div class="col-lg-3">
                    <div class="btn-group w-100">
                      <button type="submit" id="btn-verify_acct" class="btn btn-success col fileinput-button">
                        <i class="fas fa-plus"></i>
                        <span>Add files</span>
                      </button>
                    </div>
                  </div>
              </div>        
            </form>
        <?php else: ?>
          <?php if ($applicant['status'] == 'Approved'): ?>
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                      <div class="input-group">
                        <input type="text" class="form-control filename_upload" readonly style="z-index: 30;" value="<?php echo isset($attachments['file_name']) ? $attachments['file_name'] : ''; ?>">
                        <div class="input-group-btn">
                        
                          <div class="fileUpload btn-group" style="right:3px;">
                            <a href="<?php echo $attachments['location']; ?>" class="btn btn-warning cancel">
                              <i class="fas fa-times-circle"></i><span> View</span>
                            </a>
                          </div>                    
                        </div>
                      </div>
                    </div>         
                </div>
              </div>
            </div>
          <?php else: ?>
            <div class="col-md-12">
            <div class="row">
          <div class="col-md-12">
            <form method="POST" enctype="multipart/form-data" action="entity/post_admin_attachments.php">
              <div class="form-group">
                <div class="input-group">
                  
                  <input type="hidden" name="ttid" value="<?php echo $_GET['appid']; ?>">

                  <input type="text" class="form-control filename_upload" autocomplete="off" readonly style="z-index: 30;" value="<?php echo isset($attachments['file_name']) ? $attachments['file_name'] : ''; ?>">
                  <div class="input-group-btn">
                    <span class="fileUpload btn btn-secondary <?php echo !empty($attachments) ? 'btn-disabled' : ''; ?>" style="right: 4px;">
                      <span class="upl" id="upload">Select single file</span>
                        <input type="file" name="file" class="upload up" id="up" onchange="readURL(this);" required />
                    </span>

                    <div class="btn-group">                        
                      <button type="submit" class="btn btn-primary start" <?php echo !empty($attachments) ? 'disabled' : ''; ?>>                          
                        <i class="fas fa-upload"></i><span> Upload</span>                        
                      </button>                      
            </form>
              <?php if (isset($attachments['location'])): ?>
                      <a href="<?php echo $attachments['location']; ?>" class="btn btn-warning cancel">
                        <i class="fas fa-times-circle"></i><span> View</span>
                      </a>
                      <form method="POST" enctype="multipart/form-data" action="entity/delete_encoded_attachments.php">
                        <input type="hidden" name="ttid" value="<?php echo $_GET['appid']; ?>">
                        <input type="hidden" name="fid" value="<?php echo $attachments['file_id']; ?>">
                        <input type="hidden" name="iid" value="<?php echo $attachments['attid']; ?>">

                        <button type="submit" class="btn btn-danger delete">
                          <i class="fas fa-trash"></i><span> Delete</span>
                        </button>                
                      </form>     
                
              <?php endif ?>
                    </div>                    
                  </div>
                </div>
              </div>         
          </div>
          </div>
          </div>
          <?php endif ?>
        <?php endif ?>

      </div>
    </div>
  </div>
</div>

<style type="text/css">

  .btn-disabled {
    pointer-events: none;
    cursor: not-allowed !important;
    opacity: 0.65 !important;
    filter: alpha(opacity=65) !important;
    -webkit-box-shadow: none !important;
    box-shadow: none;
  }

  .it .btn-orange
{
  background-color: blue;
  border-color: #777!important;
  color: #777;
  text-align: left;
  width:100%;
}
.it input.form-control
{
  
  border:none;
  margin-bottom:0px;
  border-radius: 0px;
  border-bottom: 1px solid #ddd;
  box-shadow: none;
}
.it .form-control:focus
{
  border-color: #ff4d0d;
  box-shadow: none;
  outline: none;
}
.fileUpload {
    position: relative;
    overflow: hidden;
}
.fileUpload input.upload {
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    padding: 0;
    font-size: 20px;
    cursor: pointer;
    opacity: 0;
    filter: alpha(opacity=0);
}
</style>

<script type="text/javascript">

  $(document).on('change','.up', function(){
      var names = [];
      var length = $(this).get(0).files.length;
        for (var i = 0; i < $(this).get(0).files.length; ++i) {
            names.push($(this).get(0).files[i].name);
        }
        // $("input[name=file]").val(names);
      if(length>2){
        var fileName = names.join(', ');
        $(this).closest('.form-group').find('.form-control').attr("value",length+" files selected");
      }
      else{
        $(this).closest('.form-group').find('.form-control').attr("value",names);
      }
   });

  // $(document).on('click', '#btn-verify_acct', function(){
  //   let path = 'entity/verify_gdrive_user2.php';
    
  //   $.get(path, function(url, key){
  //     window.location(url);
  //   });  
  // })


    // function insert(){
    // DropzoneJS Demo Code Start
    // Dropzone.autoDiscover = false

    // // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
    // var previewNode = document.querySelector("#template")
    // previewNode.id = ""
    // var previewTemplate = previewNode.parentNode.innerHTML
    // previewNode.parentNode.removeChild(previewNode)

    // var myDropzone = new Dropzone("#checklist_div", { // Make the whole body a dropzone
    //   url: 'entity/post_admin_attachments.php', // Set the url
    //   //  method: "POST",
    //   thumbnailWidth: 80,
    //   thumbnailHeight: 80,
    //   parallelUploads: 20,
    //   previewTemplate: previewTemplate,
    //   autoQueue: false, // Make sure the files aren't queued until manually added
    //   previewsContainer: "#previews", // Define the container to display the previews
    //   clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
    // })

    // myDropzone.on("addedfile", function(file) {

    //   console.log(myDropzone);

    //   // Hookup the start button
    //   file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file) }
    // })

    // // // Update the total progress bar
    // // myDropzone.on("totaluploadprogress", function(progress) {
    // //   document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
    // // })

    // myDropzone.on("sending", function(file) {
    //   // Show the total progress bar when upload starts
    //   // document.querySelector("#total-progress").style.opacity = "1"
    //   // And disable the start button
    //   file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
    // })

    // Hide the total progress bar when nothing's uploading anymore
    // myDropzone.on("queuecomplete", function(progress) {
    //   document.querySelector("#total-progress").style.opacity = "0"
    // })

    // Setup the buttons for all transfers
    // The "add files" button doesn't need to be setup because the config
    // `clickable` has already been specified.
    // document.querySelector("#actions .start").onclick = function() {
    //   myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
    // }
    // document.querySelector("#actions .cancel").onclick = function() {
    //   myDropzone.removeAllFiles(true)
    // }
    // DropzoneJS Demo Code End
  // }
  
</script>