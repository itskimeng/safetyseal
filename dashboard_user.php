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
<?php include 'layout/custom_page-above.php'; ?>

<script>
        $(document).ready(function(){
            <?php
                if (isset($_SESSION['toastr'])) {
                  echo 'tata.' . $_SESSION['toastr']['type'] . '("' . $_SESSION['toastr']['title'] . '", "' . $_SESSION['toastr']['message'] . '", {
                      duration: 5000
                    })';
                  unset($_SESSION['toastr']);
                }
            ?>
            
            $(".owl-carousel").owlCarousel({
                stagePadding: 50,
                loop:true,
                margin:20,
                autoplay:true,
                autoplayTimeout:3000,
                autoplayHoverPause:true,
                nav: true,
                navText: [
                    '<i class="fa fa-angle-left navCursor" aria-hidden="true"></i>',
                    '<i class="fa fa-angle-right navCursor" aria-hidden="true"></i>'
                ],
                navContainer: '.main-content .custom-nav',
                responsive:{
                    0:{
                        items:1,
                        loop:true
                    },
                    600:{
                        items:3,
                        loop:true
                    },
                    1000:{
                        items:3,
                        loop:true
                    }
                }
            });
        });
    </script>
<script src="frontend/js/banner.js"></script>

