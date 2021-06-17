<?php require_once 'controller/ApplicationController.php';?>

<div class="registration-image">
  <div class="container">
    <div class="pt-5">
      <div class="row align-items-center heading">
        <div class="col-md-12">
          <div class="py-1">
            <div class="form-box shadow p-1 mb-5 bg-body rounded box text-center">
              <div class="container" style="margin-top: 10px;margin-bottom: 10px;border-radius: 10px;border: 1px solid #b0adad;width:50%;">
                <div>
                  <div class="icon-box" style="width: 80px; height: 80px; border: 1px solid gray; border-radius: 50%; margin-left: 43%; background-color: #198754; margin-top: 1%; font-size: 40pt; color: white; ">
                    <i class="fa fa-check"></i>
                  </div>        
                  <h4 class="modal-title w-100">Success!</h4> 
                </div>
                <div>
                  <p class="text-center">Account has been verified for this session.</p>
                  <div class="form-group" style="margin-bottom: 10px;">
                    <?php //print_r($_SESSION); ?>
                    <a href="wbstapplication.php?ssid=<?php echo $_SESSION['ss_id']; ?>&code=<?php echo $_GET['code']; ?>&scope=<?php echo $_GET['scope']; ?>" class="btn btn-success btn-lg" style="width:100%" id="btnContinue">Continue</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

</div>

<?php include 'modal_attachments.php';?>
<?php include 'modal_view_attachments.php';?>
<?php include 'modal_proceed.php';?>
<style type="text/css">
.box {
  /*width: 200px;*/
  /*height: 300px;*/
  position: relative;
  /*border: 1px solid #bbb;*/
  /*background: #eee;*/
  /*float: left;*/
  /*margin: 20px;*/
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

.card-img, .card-img-top {
    border-top-left-radius: calc(-7.75rem - 1px);
    border-top-right-radius: calc(1.25rem - 24px);
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

    $(document).on('click', '.btn-attachments_upload', function(){
      let tr = $(this).closest('tr');
      let vv = $(this);
      let id = tr.find('#cform-ulist_id');
      let $modal = $("#exampleModal");
      let form_id = $modal.find('#cform-entry_id');
      let co_id = $modal.find('#cform-checklist_order');


      form_id.val(id.val());
      co_id.val(vv.val());
      $modal.modal('show');
    });

    $(document).on('click', '.btn-attachments_view', function(){
      let tr = $(this).closest('tr');
      let id = tr.find('#cform-ulist_id');
      let $modal = $("#modal-view_attachments");
      let form_id = $modal.find('#cform-entry_id');


      let path = 'entity/get_attachments.php?id='+id.val();

      $.get(path, function(data, key){
        let dd = JSON.parse(data);
        $('#tbody-view_attchmnt').empty();
        generateAttachments(dd, $('#tbody-view_attchmnt'));
      })

      form_id.val(id.val());
      $modal.modal('show');
    });

  })

  function generateAttachments($data, $element) {
    let tr = '';
    $element.empty();
    tr+= '<div class="col-md-12">';
    tr+= '<div class="row">';
    $.each($data, function(key, item){
      tr+= '<div class="col-md-3 mb-1">';
      tr+= '<div class="card" style="width: 15rem;">';
      tr+= '<div class="checkers" style="padding-left: 1rem;">';
      tr+= '<div class="form-group">';
      tr+= '<input type="hidden" name="att_id['+item['caid']+']" value="'+item['file_id']+'">';
      tr+= '<input class="form-check-input chklist_na" name="chklists['+item['caid']+']" type="checkbox" value="">';
      tr+= '</div>';
      tr+= '</div>';
      tr+= '<div class="pic-holder" style="padding-top: 5%;height: 12rem;">';
      tr+= '<img src="https://drive.google.com/uc?export=view&id='+item['file_id']+'" class="card-img-top" alt="..." style="max-width: 100%; max-height: 100%; object-fit: cover;">';
      tr+= '</div>';
      // tr+= '<iframe src="https://drive.google.com/uc?export=view&id='+item['file_id']+'" class="card-img-top"></iframe>';
      tr+= '<div class="card-body" style="text-overflow: ellipsis;white-space: nowrap;overflow: hidden;height: 3.5rem;padding: 0.3rem 0.3rem;">';
      tr+= '<a href="'+item['location']+'" class="">';
      tr+= item['file_name'];
      tr+= '</a>';
      tr+= '</div>';
      tr+= '</div>';
      tr+= '</div>';


     


      // tr+='<tr>';
      // tr+='<td style="font-size:18pt; width:10%;">';
      // tr+= '<div class="form-group">';
      // tr+= '<input type="hidden" name="att_id['+item['caid']+']" value="'+item['file_id']+'">';
      // tr+= '<input class="form-check-input" type="checkbox" value="" name="chklists['+item['caid']+']">';
      // tr+= '</div>';
      // tr+='</td>';
      // tr+= '<td>';
      // // tr+= '<a href="'+item['location']+'" class="btn btn-secondary btn-block">';
      // // tr+= item['file_name'];
      // // tr+='</a>';
      // tr+= '<img src="'+item['location']+'"/>';
      // tr+= '</td>';
      // tr+='</tr>';
    });
    tr+= '</div>';
    tr+= '</div>';

    $element.append(tr);
  }

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