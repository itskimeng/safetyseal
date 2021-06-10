<?php require_once 'controller/ApplicationController.php';?>

<div class="registration-image" style="padding-top:3%;">
  <div class="container">
    <div class="pt-5">
      <div class="row align-items-center heading">

        <div class="col-lg-12 text-white">
          <!-- <header class="py-5 mt-5"> -->
          <header>
            <h1 class="display-6 headingText">Safety Seal Certification Checklist</h1>
            <p class="lead" style=" font-size:17px; color:#e8e7e7;">
            (DILG as Issuing Authority)
             </p>
            
          </header> 
        </div>

        <div class="col-md-12">
          <div class="py-1">
            <div class="form-box shadow p-1 mb-5 bg-body rounded">
              <form method="POST" action="entity/post_application.php" class="bg-white  rounded-5 shadow-5-strong p-5">
                
                <?php include 'checklist.php'; ?>
                <!-- Submit button -->
                <!-- <div class="row">
                  <div class="btn-group">
                    <button type = "submit" class="btn btn-primary btn-block" name="login">Proceed</button>
                  </div>
                  
                </div> -->
              </form>

            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

</div>

<?php include 'modal_attachments.php';?>

<script>
  // Example starter JavaScript for disabling form submissions if there are invalid fields
  (function() {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
      .forEach(function(form) {
        form.addEventListener('submit', function(event) {
          if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
          }

          form.classList.add('was-validated')
        }, false)
      })
  })()
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $(document).on('click', '.form-check-input', function(){
      let tr = $(this).closest('tr');
      let chkcol = $(this).data('chkcol');

      uncheckOthers(chkcol, tr);

      if (chkcol == 'na') {
        let rr = tr.find('.chklist_na');
        if (rr.is(':checked')) {
          let reason = tr.find('.form-check-reason');
          reason.attr('disabled', false);

        } else {
          let reason = tr.find('.form-check-reason');
          reason.attr('disabled', true);          
        }

      } else {
        let reason = tr.find('.form-check-reason');
        reason.attr('disabled', true);
      }
    });
  })

  function uncheckOthers(arg, tr) {
    let arr = ['yes','no','na'];
    $.each(arr, function(i,b){
      if (arg != b) {
        let dd = tr.find('.chklist_'+b);
        dd.prop('checked', false);
      }
    });
  }
</script>
<script src="frontend/js/ajax.js"></script>