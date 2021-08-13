<?php require_once 'controller/UserAccountsEditController.php'; ?>

<div class="content-header">
  <div class="container">
    <div class="row mb-2">
      <?php include 'edit/breadcrumbs.php'; ?>  
    </div>
    <hr>
  </div>
</div>
    
<!-- Main content -->
<div class="content">
  <div class="container">

    <form action="entity/post_user_acct.php?id=<?php echo $_GET['id']; ?>" method="post">
      <div class="row">
        <div class="col-md-4">
          <?php include 'edit/profile.php'; ?>
          <?php include 'edit/acct_credentials.php'; ?>
        </div>

        <div class="col-md-8">
          <?php include 'edit/gen_info.php'; ?>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="card card-info">
            <div class="card-footer text-right">
              <div class="btn-group">
                <a href="uac.php" class="btn btn-block btn-secondary"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancel</a>
              </div>

              <div class="btn-group">
                <button type="submit" class="btn btn-block btn-success"><i class="fa fa-arrow-right" aria-hidden="true"></i> Submit</button>
              </div>

            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>      

<?php include 'edit/custom.css'; ?>

<script>
  $(function () {
    <?php
      if (isset($_SESSION['toastr'])) {
        echo 'tata.'.$_SESSION['toastr']['type'].'("'.$_SESSION['toastr']['title'].'", "'.$_SESSION['toastr']['message'].'", {
          duration: 5000
        })';
        unset($_SESSION['toastr']);
      }
    ?> 

    $("[name='user_status']").bootstrapSwitch();

    $(document).on('change', '#province', function(){
      $('#lgu').val('');
      $('#lgu').empty();
      let id = $(this).val();

      let opts = <?php echo $lgu_opts2; ?>;
      $('#lgu').append($('<option>').val('').text(''));
      $.each(opts[id], function(key, item){
        $('#lgu').append($('<option>').val(item.code).text(item.name));
      });
    })

    function postTask(path, data) {
      $.post(path, data,
        function(data, status){
          if (status == 'success') {
            setTimeout(function(){// wait for 5 secs(2)
              location.reload(); // then reload the page.(3) 
            }, 1000);
          }
        }
      );

      return data;
    }




});
</script>