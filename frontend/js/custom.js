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


