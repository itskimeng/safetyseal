<!DOCTYPE html>
<html lang="en">
<?php include 'layout/header.html.php'; ?>
<body>
    <main>
        <div class="container" style="margin-top: 7%;">
                <?php include 'layout/navbar.php'; ?>
                <?php include 'views/guidelines.php'; ?>
        </div>
    </main>
<!-- sd -->
    <script>
    	$( ".nav-link" ).removeClass( "active" ).addClass( "yourClass" );
    	$( "#guidelines" ).addClass( "active" );
    </script>
</body>
<?php include 'layout/footer.html.php'; ?>
</html>