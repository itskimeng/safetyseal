$(function(){
    $('.navscroll').data('size','big');
});
// set btn to bottom part of the div

$(function(){
    const applicationBanner = document.querySelector('.application').offsetHeight;
    const guidelinesBanner = document.querySelector('.banner-guidelines').offsetHeight;
    const requestBanner = document.querySelector('.request_forms-banner').offsetHeight;
    const establishmentBanner = document.querySelector('.list_establishment-banner').offsetHeight;
    const contactBanner = document.querySelector('.contact-banner').offsetHeight;
    const inquiriesBanner = document.querySelector('.inquiries_complaints').offsetHeight;

    const resApp = applicationBanner - 60;
    const resGuide = guidelinesBanner - 70;
    const resRequest = requestBanner - 60;
    const resEstablishment = establishmentBanner - 60;
    const resContact = contactBanner - 60;
    const resInquiries = inquiriesBanner - 70;

    $('.btn-application').css('margin-top',resApp);
    $('.btn-guide').css('margin-top',resGuide);
    $('.btn-request').css('margin-top',resRequest);
    $('.btn-establishment').css('margin-top',resEstablishment);
    $('.btn-contact').css('margin-top',resContact);
    $('.btn-inquiries').css('margin-top',resInquiries);


});

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



