$(function(){
    $('.navbar').data('size','big');
});

$(window).scroll(function(){
    if($(document).scrollTop() > 0)
    {
        if($('.navbar').data('size') == 'big')
        {
            $('.navbar').data('size','small');
            $('.navbar').stop().animate({
                height:'50px'
            },400);
        }
    }
    else
    {
        if($('.navbar').data('size') == 'small')
        {
            $('.navbar').data('size','big');
            $('.navbar').stop().animate({
                height:'65px'
            },400);
        }  
    }
});


function modalRegister()
{
  $('#modalRegister').iziModal({
  title: 'Fill Up Form',
  headerColor: '#192f72',
  width: 970,
  iframe: true, 
  iframeHeight: 600, 
  iframeURL: 'views/registration_form.php',
  // openFullscreen: true,
  closeOnEscape: false,
  closeButton: true
  // onClosed: function(){document.getElementById("viewer1").hidden=false;}
  });


  $('#modalRegister').iziModal('open', this); 
}