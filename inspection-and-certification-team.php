<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<?php include 'layout/header.html.php'; ?>
<body>
    <main>
        <div class="container" style="margin-top: 5%;">
                <?php include 'layout/navbar.php'; ?>
                <?php include 'views/inspection_view.php'; ?>
        </div>
    </main>

    <script>
    	$( ".nav-link" ).removeClass( "active" );
    	$( "#navinspection" ).addClass( "active" );
    </script>
</body>
<?php include 'layout/footer.html.php'; ?>
</html>