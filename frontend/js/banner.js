
$(function(){
    const applicationBanner = document.querySelector('.application').offsetHeight;
    const guidelinesBanner = document.querySelector('.banner-guidelines').offsetHeight;
    const requestBanner = document.querySelector('.request_forms-banner').offsetHeight;
    const establishmentBanner = document.querySelector('.list_establishment-banner').offsetHeight;
    const contactBanner = document.querySelector('.contact-banner').offsetHeight;
    const inquiriesBanner = document.querySelector('.inquiries_complaints').offsetHeight;

    const resApp = applicationBanner - 70;
    const resGuide = guidelinesBanner - 70;
    const resRequest = requestBanner - 70;
    const resEstablishment = establishmentBanner - 70;
    const resContact = contactBanner - 70;
    const resInquiries = inquiriesBanner - 70;

    $('.btn-application').css('margin-top',resApp);
    $('.btn-guide').css('margin-top',resGuide);
    $('.btn-request').css('margin-top',resRequest);
    $('.btn-establishment').css('margin-top',resEstablishment);
    $('.btn-contact').css('margin-top',resContact);
    $('.btn-inquiries').css('margin-top',resInquiries);
});