<!DOCTYPE html>
<html lang="en">
<?php require_once 'layout/header.html.php'; ?>
<body >
    <main>
                <?php require_once 'layout/navbar.php'; ?>
                <?php require_once 'views/registration.html.php'; ?>
    </main>
</body>

<?php require_once 'layout/footer.html.php'; ?>
<?php require_once 'views/verification_modal.php'; ?>
</html>
<script>
   $(window).on('load',function(){
       let flag = <?php echo $_GET['flag'];?>;
       if(flag){
        $('#verification_modal').modal('show');

       }
    });
    $('#resend').click(function(){
         $.ajax({
        url: "application/functions/registration_save.php",
        method: "POST",
        data: {
            resend:'resend',
            emailTo:<?php echo $_GET['email'];?>,
        },
        success: function (data) {

        }
    });
    })
</script>
