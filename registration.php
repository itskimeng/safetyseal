<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<?php require_once 'layout/header.html.php'; ?>
<link href="frontend/css/verified_modal.css" rel="stylesheet">

<body>
    <main>
        <?php require_once 'layout/navbar.php'; ?>
        <?php require_once 'views/registration.html.php'; ?>
    </main>
</body>

<?php require_once 'layout/footer.html.php'; ?>
<?php require_once 'views/verification_modal.php'; ?>
<?php require_once 'views/verified_modal.php'; ?>

</html>
<script>
    $(window).on('load', function() {
        let flag = '<?php if (isset($_GET['flag'])) {
                        echo $_GET['flag'];
                    } else {
                        echo '';
                    } ?>';
        let isVerified = '<?php if (isset($_GET['verified'])) {
                                echo $_GET['verified'];
                            } else {
                                echo '';
                            } ?>';
        if (flag) {
            $('#verification_modal').modal('show');
        }
        if (isVerified) {
            $('#verified_modal').modal('show');
        }
    });

    //if email confirmation did not recieved
    $('#resend').click(function() {
        $.ajax({
            url: "application/functions/registration_save.php",
            method: "POST",
            data: {
                resend: 'resend',
                emailTo: '<?php if (isset($_GET['email'])) {
                                echo $_GET['email'];
                            } else {
                                echo '';
                            } ?>',
            },
            success: function(data) {

            }
        });
    });
    $('#btnContinue').click(function() {
        $.ajax({
            url: "views/login.php",
            method: "POST",
            data: {
                username: '<?php if (isset($_SESSION['username'])) {
                                echo $_SESSION['username'];
                            } else {
                                echo '';
                            } ?>',
                password_reg: '<?php if (isset($_SESSION['password'])) {
                                    echo $_SESSION['password'];
                                } else {
                                    echo '';
                                } ?>',
                login: 'login',
            },
            success: function(data) {
                window.location = 'index.php?username="<?php if (isset($_SESSION['username'])) {
                                                            echo $_SESSION['username'];
                                                        } else {
                                                            echo '';
                                                        } ?>"'



            }
        })
    })
</script>