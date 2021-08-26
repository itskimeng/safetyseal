<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<?php include 'layout/header.html.php'; ?>
<body>
    <main>
        <div class="container" style="margin-top: 5%;">
                <?php include 'layout/navbar.php'; ?>
                <?php include 'views/homepage.html.php'; ?>
        </div>
    </main>
</body>
<?php include 'layout/footer.html.php'; ?>
</html>
<script src="frontend/js/banner.js"></script>

