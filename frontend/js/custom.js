$(function(){
    $('.navscroll').data('size','big');
});
// set btn to bottom part of the div

$(window).scroll(function(){
    if($(document).scrollTop() > 0)
    {
        if($('.navscroll').data('size') == 'big')
        {
            $('.navscroll').data('size','small');
            $('.navscroll').stop().animate({
                height:'50px'
            },400);
        }
    }
    else
    {
        if($('.navscroll').data('size') == 'small')
        {
            $('.navscroll').data('size','big');
            $('.navscroll').stop().animate({
                height:'65px'
            },400);
        }  
    }
    
});




