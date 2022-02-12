<div class="modal fade right" id="modal-delete_app" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content" style="border-radius: 10px;">
      <div class="modal-header" style="background-color:#c80114 !important;">
        <h5 class="modal-title" id="exampleModalLabel" style="color:white;"><i class="fas fa-exclamation-triangle"></i> Confirmation</h5>
      </div>

      <form method="POST" enctype="multipart/form-data" action="../entity/delete_application.php?ssid=<?= $_GET['ssid']; ?>">
        <div class="modal-body">
          <div class="mb-3">
            <div class="row mb-1">
              <div class="col-md-12 pt-2 mb-3" style="text-align:center;">
                <span class="mb-5"><i class="fa fa-3x fa-trash-alt" style="color: #c80114;"></i></span>
              </div>

              <div class="col-md-12" style="font-size:14px;">
                <p style="text-align:center; font-size: 19px;">
                  Do you really want to delete this application? This process cannot be undone.
                </p>
              </div>

              <div class="col-md-12" style="text-align: center;">
                <button type="button" class="btn btn-secondary btn-close_attachments" data-bs-dismiss="modal"><i class="fa fa-window-close"></i> NO</button>
                <button type="submit" class="btn btn-danger btn-add_attachments"><i class="fa fa-check"></i> YES</button>
              </div>
            </div>
          </div>
        </div>
      </form>

    </div>
  </div>
</div>

<style type="text/css">
  .bs-callout {
      padding: 20px;
      margin: 20px 0;
      border: 1px solid #eee;
      border-left-width: 5px;
      border-radius: 3px;
  }
</style>
