<?php session_start(); ?>
<?php 
    if (!isset($_SESSION['username'])) {
        $_SESSION['toastr'] = [
                'type'      => 'warn',
                'title'     => 'Session Expired',
                'message'   => 'Please Login again.'
            ];

        header('location:registration.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once 'layout/header.html.php'; ?>
<body >
    <main>
        <?php require_once 'layout/navbar.php'; ?>
        <?php require_once 'views/website/application/index.php'; ?>
    </main>
</body>

<?php require_once 'layout/footer.html.php'; ?>
</html>