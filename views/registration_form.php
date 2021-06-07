
    <?php include '../layout/css_includes.php'; ?><br><br>
<center>
  <h1 style="font-family: sans-serif;">Registration</h1><hr>
  <!-- <div class="loginForm"> -->

    <div class="container" style="font-family: sans-serif;">

      <div class="row">
        <div class="col-md-12">
          <h4 class="float-left">Basic Information</h4>
        </div>
      </div>  
      <hr>

      <div class="row mb-2">
        <div class="col-md-1">
        </div>
        <div class="col-md-2">
          <h6>Name of Government Agency/Office:</h6>
        </div>
        <div class="col-md-8">
          <input type="text" class="form-control" name="" id="lastname">
        </div>
      </div>

      <div class="row mb-2">
        <div class="col-md-1">
        </div>
        <div class="col-md-2">
          <h6>Name of Government Establishment/Department/Office/Unit:</h6>
        </div>
        <div class="col-md-8">
          <input type="text" class="form-control" name="" id="firstname">
        </div>
      </div>

      <div class="row mb-2">
        <div class="col-md-1">
        </div>
        <div class="col-md-2">
          <h6>Middlename:</h6>
        </div>
        <div class="col-md-8">
          <input type="text" class="form-control" name="" id="middlename">
        </div>
      </div>
      



      <div class="row mb-2">
        <div class="col-md-1">
        </div>
        <div class="col-md-2">
          Address
        </div>
        <div class="col-md-8">
          <input type="text" class="form-control" name="" id="address">
        </div>
      </div>

      <div class="row mb-2">
        <div class="col-md-3">
          Mobile Number
        </div>
        <div class="col-md-8">
          <input type="text" class="form-control" name="" id="mobile">
        </div>
      </div>

      
      <div class="row mb-2">
        <div class="col-md-1">
        </div>
        <div class="col-md-2">
          Birthday
        </div>
        <div class="col-md-8">
          <input type="date" class="form-control" name="" id="birthday">
        </div>
      </div>

      
      <div class="row mb-4">
        <div class="col-md-3">
          Email Address
        </div>
        <div class="col-md-8">
          <input type="email" class="form-control" name="" id="email">
        </div>
      </div>

      <hr>
      <div class="row my-2">
        <div class="col-md-12">
          <h4 class="float-left">Account Information</h4>
        </div>
      </div>
      <hr>

      <div class="row mb-2">
        <div class="col-md-1">
        </div>
        <div class="col-md-2">
          Username
        </div>
        <div class="col-md-8">
          <input type="text" class="form-control" name="" id="username">
        </div>
      </div>

      <div class="row mb-2">
        <div class="col-md-1">
        </div>
        <div class="col-md-2">
          Password
        </div>
        <div class="col-md-8">
          <input type="Password" class="form-control" name="" id="password">
        </div>
      </div>



      <div class="row mb-2">
        <div class="col-md-1">
        </div>
        <div class="col-md-2">
          Confirm Password
        </div>
        <div class="col-md-8">
          <input type="Password" class="form-control" name="" id="confirmPassword">
        </div>
      </div>





    </div>
    <!-- <div class="container"> -->
<hr>
    <br>
    <button class="btn btn-lg btn-primary" id="btnRegister">Proceed <i class="fa fa-check"></i></button>
  <!-- </div> -->
  <br>
</center>
<br><br>

<?php include '../layout/js_includes.php'; ?>
<script type="text/javascript">

$('#btnRegister').click(function(){
  
  var lastname = $('#lastname').val();
  var firstname = $('#firstname').val();
  var middlename = $('#middlename').val();
  var address = $('#address').val();
  var mobile = $('#mobile').val();
  var birthday = $('#birthday').val();
  var username = $('#username').val();
  var password = $('#password').val();
  var confirmPassword = $('#confirmPassword').val();
  var email = $('#email').val();


  var passwordLength = password.length;

  if ( lastname == '' || firstname == '' || middlename == '' || address == '' || mobile == '' || birthday == '' || username == '' || password == '' || confirmPassword == '' || email == '' ) 
  {
    swal('Incomplete Data!','Please fill up required fields','error');
  }
  else
  {
    if ( password != confirmPassword ) 
    {
      swal('Password do not match!','Please check your password','error');
    }
    else if (passwordLength < 6 )
    {
      swal('Password too short!','Must be more than 6 characters','error');
    }
    else
    {
      var other_data = 'lastname='+lastname+'&firstname='+firstname+'&middlename='+middlename+'&address='+address+'&mobile='+mobile+'&birthday='+birthday+'&username='+username+'&password='+password+'&email='+email;
      // alert(other_data);
      $.ajax({
        url:"function php/insertUser.php?"+other_data,  
        method:"POST",  
        dataType:"text",
        cache:false,     
        beforeSend:function() {

                 
        },  
        error:function(data){

                       
        }, 
        success:function(data)
        {
          // alert(data);
          if (data == 'error') 
          {
            swal('Username Already Exist!','Please select other username','warning');
            document.getElementById("username").style.borderColor = "red";
          }
          else if (data == 'errorEmail') 
          {
            swal('Email Already Exist!','Please select other username','warning');
            document.getElementById("email").style.borderColor = "red";
          }
          else
          {
            swal({
            title: "Registration Complete!",
            text: data,
            type: "success",
            showCancelButton: false,
            confirmButtonColor: "#5cb85c",
            confirmButtonText: '<span class="fa fa-check"></span>&nbspProceed',
            confirmButtonClass: "btn"
            }).then((result) => {
              if (result.value) {
                // window.location = 'index.php';
                window.location.reload();
              }
            });
          }

        }
      }); 
      //ajax end
    }
  }

});


$('#username').click(function(){
  document.getElementById("username").style.borderColor = "#ced4da";
});







</script>