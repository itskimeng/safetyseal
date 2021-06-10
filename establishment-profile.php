<!DOCTYPE html>
<html lang="en">
<?php include 'layout/header.html.php'; ?>
<body>
    <main>
        <div class="container" style="margin-top: 7%;">
                <?php include 'layout/navbar.php'; ?>
                <?php include 'views/establishment-profile.php'; ?>
        </div>
    </main>

    <script>
    	$( ".nav-link" ).removeClass( "active" );
    	$( "#navcertified" ).addClass( "active" );
    </script>
</body>
<?php include 'layout/footer.html.php'; ?>
</html>