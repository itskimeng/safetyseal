
<script type="text/javascript" src="admin/assets/js/jquery3.min.js"></script>

<script type="text/javascript" src="admin/assets/js/sweetalert2.all.min.js"></script>

<script type="text/javascript" src="admin/assets/js/bootstrap.min.js"></script>


<script type="text/javascript" src="admin/assets/izimodal/js/iziModal.min.js"></script>


<script type="text/javascript" src="admin/DataTables/datatables.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>



<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous"></script>

<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
<script async defer src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.2"></script>

<script src="https://unpkg.com/pdfjs-dist@2.0.489/build/pdf.min.js"></script>
    
<!-- <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha384-vk5WoKIaW/vJyUAd9n/wmopsmNhiy+L2Z+SBxGYnUkunIxVxAv/UtMOhba/xskxh" crossorigin="anonymous"></script> -->


<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

<script src="dist/js/BsMultiSelect.js?v3"></script> -->
        
<script type="text/javascript" src="admin/assets/bootstrap-4/dist/js/BsMultiSelect.js"></script>

<script type="text/javascript">
$(function () {
    // $('.navbar').addClass('active');
    $(window).on('scroll', function () {
        if ( $(window).scrollTop() > 10 ) {
            $('.navbar').addClass('active');
        } else {
            $('.navbar').removeClass('active');
        }
    });

     // scroll down
    $("html, body").animate({
        scrollTop: 1
    }, 1);

    $("html, body").animate({
        scrollTop: 1	
    }, 1);
});

AOS.init();



$(document).ready(function(){
  var owl = $('.owl-carousel');
  owl.owlCarousel({
    loop:true,
    margin:10,
    nav:false,
    items: 1,
    autoplay: true,
    autoPlaySpeed: 500,
    autoPlayTimeout: 5000,
    autoplayHoverPause: true,
    responsive:{
        0:{
            items:3
        },
        600:{
            items:3
        },
        1000:{
            items:6
        }
    }
  });
  
  // Custom Button
  $('.customNextBtn').click(function() {
    owl.trigger('next.owl.carousel');   
  });
  $('.customPreviousBtn').click(function() {
    owl.trigger('prev.owl.carousel');
  });
  
});



//




$('.scrollTo').click(function(){
    $('html, body').animate({
        scrollTop: $( $(this).attr('href') ).offset().top
    }, 500);
    return false;
});






</script>