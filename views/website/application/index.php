<?php require_once 'controller/ApplicationController.php';?>

<div class="registration-image" style="padding-top:3%;">
  <div class="container">
    <div class="pt-5">
      <div class="row align-items-center heading">

         <!--  <div class="row">
        <div class="col-md-12 text-white">
            
          <header>
            <h1 class="display-6 headingText">Safety Seal Certification Checklist</h1>
            <p class="lead" style=" font-size:17px; color:#e8e7e7;">
            (DILG as Issuing Authority)
             </p>
            
          </header> 
          </div>
        </div> -->
        <!-- <div class="col-md-12">
            <div class="py-1">
              <div class="form-box shadow p-1 bg-body rounded" style="width:100%;">
                <header>
                  <h1 class="display-6 headingText">Safety Seal Certification Checklist</h1>
                  <p class="lead" style=" font-size:17px; color:#e8e7e7;">
                  (DILG as Issuing Authority)
                   </p>
                  
                </header>
              </div>
            </div>
            
          
        </div> -->

        <div class="col-md-12">
          <div class="py-1">
            <div class="form-box shadow p-1 mb-5 bg-body rounded box">

              <div class="ribbon blue"><span><?php echo $userinfo['status']; ?></span></div>
              
              <form method="POST" action="entity/post_application.php" class="bg-white  rounded-5 shadow-5-strong p-5">
                <input type="hidden" name="is_new" value="<?php echo $is_new; ?>">
                
                <!-- user details -->
                <?php include 'user_details.php'; ?>

                <!-- checklist -->
                <?php include 'checklist.php'; ?>
                

                <!-- Submit button -->
                <?php if ($userinfo['status'] == 'Draft'): ?>
                  <div class="panel panel-default pt-4">
                    <div class="row">
                      
                      <div class="<?php echo $is_new ? 'col-md-12' : 'col-md-6' ;?> pull-right">
                        <button type = "submit" class="btn btn-primary btn-block" name="login" style="width: 100%;"><i class="fa fa-pen-alt"></i> 
                          <?php echo $is_new ? 'Save' : 'Update' ;?>  
                        </button>
                      </div>
                      <?php if (!$is_new): ?>
                        <div class="col-md-6">
                          <button type="button" class="btn btn-success btn-block" name="login" data-bs-toggle="modal" data-bs-target="#modall_proceed" style="width: 100%;"><i class="fa fa-share"></i> Submit</button>
                        </div>
                      <?php endif ?>
                    </div>
                  </div> 
                <?php endif ?> 
              </form>

            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

</div>

<?php include 'modal_attachments.php';?>
<?php include 'modal_proceed.php';?>
<style type="text/css">
.box {
  /*width: 200px;*/
  /*height: 300px;*/
  position: relative;
  border: 1px solid #bbb;
  background: #eee;
  float: left;
  margin: 20px;
}
.ribbon {
  position: absolute;
  right: -6px;
  top: -5px;
  z-index: 1;
  overflow: hidden;
  width: 154px;
  height: 150px;
  text-align: right;
}
.ribbon span {
  font-size: 0.8rem;
  color: #fff;
  text-transform: uppercase;
  text-align: center;
  font-weight: bold;
  line-height: 32px;
  transform: rotate(45deg);
  width: 192px;
  display: block;
  background: #79a70a;
  background: linear-gradient(#9bc90d 0%, #79a70a 100%);
  box-shadow: 0 3px 10px -5px rgba(0, 0, 0, 1);
  position: absolute;
  top: 41px; // change this, if no border
  right: -20px; // change this, if no border
}

.ribbon span::before {
   content: '';
   position: absolute; 
   left: 0px; top: 100%;
   z-index: -1;
   border-left: 3px solid #79A70A;
   border-right: 3px solid transparent;
   border-bottom: 3px solid transparent;
   border-top: 3px solid #79A70A;
}
.ribbon span::after {
   content: '';
   position: absolute; 
   right: 0%; top: 100%;
   z-index: -1;
   border-right: 3px solid #79A70A;
   border-left: 3px solid transparent;
   border-bottom: 3px solid transparent;
   border-top: 3px solid #79A70A;
}

.red span {
  background: linear-gradient(#f70505 0%, #8f0808 100%);
}
.red span::before {
  border-left-color: #8f0808;
  border-top-color: #8f0808;
}
.red span::after {
  border-right-color: #8f0808;
  border-top-color: #8f0808;
}

.blue span {
  background: linear-gradient(#2989d8 0%, #1e5799 100%);
}
.blue span::before {
  border-left-color: #1e5799;
  border-top-color: #1e5799;
}
.blue span::after {
  border-right-color: #1e5799;
  border-top-color: #1e5799;
}

.foo {
  clear: both;
}

.bar {
  content: "";
  left: 0px;
  top: 100%;
  z-index: -1;
  border-left: 3px solid #79a70a;
  border-right: 3px solid transparent;
  border-bottom: 3px solid transparent;
  border-top: 3px solid #79a70a;
}

.baz {
  font-size: 1rem;
  color: #fff;
  text-transform: uppercase;
  text-align: center;
  font-weight: bold;
  line-height: 2em;
  transform: rotate(45deg);
  width: 100px;
  display: block;
  background: #79a70a;
  background: linear-gradient(#9bc90d 0%, #79a70a 100%);
  box-shadow: 0 3px 10px -5px rgba(0, 0, 0, 1);
  position: absolute;
  top: 100px;
  left: 1000px;
}

</style>

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

    <?php
      // toastr output & session reset
      // session_start();
      if (isset($_SESSION['toastr'])) {
        echo 'tata.'.$_SESSION['toastr']['type'].'("'.$_SESSION['toastr']['title'].'", "'.$_SESSION['toastr']['message'].'", {
          duration: 5000
        })';
        unset($_SESSION['toastr']);
      }
    ?> 

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
          reason.val('');
          reason.attr('disabled', true);          
        }

      } else {
        let reason = tr.find('.form-check-reason');
        reason.val('');
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