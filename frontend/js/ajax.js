

$.ajax({
    url: 'entity/checkPendingMessage.php',
    dataType: 'json',
    cache: false,
    success: function (data) {
        let control_no = data.control_no;
        let content = data.content;
        let mobile = data.contact_details;
        let ip_address = data.ip_address;
        if (data.for_sending == 1) {    
            $.ajax({
                type: "GET",
                url: "http://"+ip_address+"/send/?pass=&number="+mobile+"&data="+content+"",
                success: function (data) {
                    
                    $.ajax({
                        type: "POST",
                        url: "entity/post_sending.php",
                        data: {
                            cn:control_no,
                            has_sent: '0',// successfully sent!
                        },
                        success: function (data) {
                            console.log('SMS Notification: status(success!)');
                        }
                    });
                }
            });
        } else {
            console.log("fail");
        }

    }
});



$.ajax({
    url: 'entity/checkEmailPendingMessage.php',
    dataType: 'json',
    cache: false,
    success: function (data) {
        let control_no = data.control_no;
        let content = data.content;
        let mobile = data.contact_details;
        let ip_address = data.ip_address;
        console.log(ip_address);
        if (data.for_sending == 1) {    
            $.ajax({
                type: "GET",
                url: "http://"+ip_address+"/send/?pass=&number="+mobile+"&data="+content+"",
                success: function (data) {
                    
                    $.ajax({
                        type: "POST",
                        url: "entity/post_sending.php",
                        data: {
                            cn:control_no,
                            has_sent: '0',// successfully sent!
                        },
                        success: function (data) {
                            console.log('SMS Notification: status(success!)');
                        }
                    });
                }
            });
        } else {
            console.log("fail");
        }

    }
});

