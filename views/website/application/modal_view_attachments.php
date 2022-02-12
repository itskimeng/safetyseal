<div class="modal fade right" id="modal-view_attachments" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #0d6efd !important;">
        <h5 class="modal-title" id="exampleModalLabel" style="color:white;"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" enctype="multipart/form-data" action="entity/delete_movs.php">
        <input type="hidden" name="checklist_order" value="CL01"/>
        <input type="hidden" id="cform-entry_id" name="entry_id" value=""/>
        <input type="hidden" name="control_no" value="<?php echo $userinfo['code']; ?>"/>  
        <input type="hidden" name="token_id" value="<?php if(isset($_GET['ssid'])){echo $_GET['ssid'];}else{}?>"/>        

        <div class="modal-body" id="tbody-view_attchmnt" style="height: 250px; max-height: 570px; overflow-y: hidden;">
          
          <div class="cont">
            <div class="loadingio-spinner-interwind-1mn62qz6yu9"><div class="ldio-2ejy8czjmjr">
            <div><div><div><div></div></div></div><div><div><div></div></div></div></div>
            </div></div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-window-close"></i> Close</button>
          <?php if (!in_array($userinfo['status'], ["For Receiving", "Approved", "Disapproved"])): ?>
            <button type="button" class="btn btn-warning btn-all_attachments button-hidden" data-value="unselectall"><i class="fa fa-check-circle"></i> Select All</button>

            <button type="submit" class="btn btn-danger btn-delete_attachments button-hidden" disabled><i class="fa fa-trash"></i> Remove Selected</button>
          <?php else: ?>
          <?php echo $userinfo['status']; ?>
          <?php endif ?>
        </div>
      </form>
    </div>
  </div>
</div>

<style type="text/css">
  .button-hidden {
    display: none;
  }
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

/*.lds-grid {
  display: block;
  position: absolute;
  width: 80px;
  height: 80px;
  left: 46%;
  top: 30%;
}
.lds-grid div {
  left:0;right:0;top:0;bottom:0;
  position: absolute;
  width: 16px;
  height: 16px;
  border-radius: 50%;
  background: #fff;
  animation: lds-grid 1.2s linear infinite;
}
.lds-grid div:nth-child(1) {
  top: 8px;
  left: 8px;
  animation-delay: 0s;
}
.lds-grid div:nth-child(2) {
  top: 8px;
  left: 32px;
  animation-delay: -0.4s;
}
.lds-grid div:nth-child(3) {
  top: 8px;
  left: 56px;
  animation-delay: -0.8s;
}
.lds-grid div:nth-child(4) {
  top: 32px;
  left: 8px;
  animation-delay: -0.4s;
}
.lds-grid div:nth-child(5) {
  top: 32px;
  left: 32px;
  animation-delay: -0.8s;
}
.lds-grid div:nth-child(6) {
  top: 32px;
  left: 56px;
  animation-delay: -1.2s;
}
.lds-grid div:nth-child(7) {
  top: 56px;
  left: 8px;
  animation-delay: -0.8s;
}
.lds-grid div:nth-child(8) {
  top: 56px;
  left: 32px;
  animation-delay: -1.2s;
}
.lds-grid div:nth-child(9) {
  top: 56px;
  left: 56px;
  animation-delay: -1.6s;
}
@keyframes lds-grid {
  0%, 100% {
    opacity: 1;
  }
  50% {
    opacity: 0.5;
  }
}*/

@keyframes ldio-2ejy8czjmjr-r {
  0%, 100% { animation-timing-function: cubic-bezier(0.2 0 0.8 0.8) }
  50% { animation-timing-function: cubic-bezier(0.2 0.2 0.8 1) }
  0% { transform: rotate(0deg) }
  50% { transform: rotate(180deg) }
  100% { transform: rotate(360deg) }
}
@keyframes ldio-2ejy8czjmjr-s {
  0%, 100% { animation-timing-function: cubic-bezier(0.2 0 0.8 0.8) }
  50% { animation-timing-function: cubic-bezier(0.2 0.2 0.8 1) }
  0% { transform: translate(-30px,-30px) scale(0) }
  50% { transform: translate(-30px,-30px) scale(1) }
  100% { transform: translate(-30px,-30px) scale(0) }
}
.ldio-2ejy8czjmjr > div { transform: translate(0px,-15px) }
.ldio-2ejy8czjmjr > div > div {
  animation: ldio-2ejy8czjmjr-r 1.923076923076923s linear infinite;
  transform-origin: 100px 100px;
}
.ldio-2ejy8czjmjr > div > div > div {
  position: absolute;
  transform: translate(100px, 82px);
}
.ldio-2ejy8czjmjr > div > div > div > div {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  background: #fe718d;
  animation: ldio-2ejy8czjmjr-s 1.923076923076923s linear infinite;
}
.ldio-2ejy8czjmjr > div > div:last-child {
  animation-delay: -0.9615384615384615s;
}
.ldio-2ejy8czjmjr > div > div:last-child > div > div {
  animation-delay: -0.9615384615384615s;
  background: #46dff0;
}
.loadingio-spinner-interwind-1mn62qz6yu9 {
  width: 200px;
  height: 200px;
  display: block;
  position: absolute;
  left: 41%;
  overflow: hidden;
  background: #ffffff;
}
.ldio-2ejy8czjmjr {
  width: 100%;
  height: 100%;
  position: relative;
  transform: translateZ(0) scale(1);
  backface-visibility: hidden;
  transform-origin: 0 0; /* see note above */
}
.ldio-2ejy8czjmjr div { box-sizing: content-box; }


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

  $(document).on('click', '.btn-all_attachments', function(e){

    if ($(this).data('value') == 'unselectall') {
      $('.up-attachment').prop('checked', true);
      $(this).data('value', 'selectall');
      $(this).html('<i class="fa fa-times-circle"></i> Unselect All');
      $('.btn-delete_attachments').attr('disabled', false); 
    } else {
      $('.up-attachment').prop('checked', false);
      $(this).data('value', 'unselectall');
      $(this).html('<i class="fa fa-check-circle"></i> Select All');
      $('.btn-delete_attachments').attr('disabled', true);  
    }

  });

  $(document).on('click', '.btn-delete_attachments', function(e){
    $('.btn-all_attachments').attr('disabled', true);
    $(this).html('<i class="fa fa-circle-notch fa-spin"></i> Removing...');
  });

  $(document).on('change', '.up-attachment', function(){
    let xbox = $('.up-attachment');
    let is_valid = false;
    
    $.each(xbox, function(key, item){
      if ($(this).is(':checked')) {
        is_valid = true;
      }
    });

    if (is_valid) {
      $('.btn-delete_attachments').attr('disabled', false);  
    } else {
      $('.btn-delete_attachments').attr('disabled', true);  
    }
  });

  
</script>
