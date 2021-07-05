<!DOCTYPE html>
<html lang="en">
<?php include 'layout/header.html.php'; ?>
<body>
    <main>
        <div class="container" style="margin-top: 4%;">
                <?php include 'layout/navbar.php'; ?>
                <?php include 'views/homepage.html.php'; ?>
        </div>
    </main>


    <script>
		$(document).ready(function(){
			$(".owl-carousel").owlCarousel({
				loop:true,
				margin:20,
			    autoplay:true,
			    autoplayTimeout:3000,
			    autoplayHoverPause:true,
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
</body>
<?php include 'layout/footer.html.php'; ?>
</html>
<script src="frontend/js/banner.js"></script>

