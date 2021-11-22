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

        <div class="modal-body" id="tbody-view_attchmnt" style="height: 250px; max-height: 570px; overflow-y: hidden;">
          <div class="cont">
            <div class="loadingio-spinner-interwind-1mn62qz6yu9"><div class="ldio-2ejy8czjmjr">
            <div><div><div><div></div></div></div><div><div><div></div></div></div></div>
            </div></div>
          </div>  
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
