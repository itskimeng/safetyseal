
// ping ip address
setInterval(function () {
    $.ajax({
        url: 'entity/post_ping.php',
        dataType: 'json',
        cache: false,
        success: function (data) {
            let ip_address = data.ip_address;
            $.ajax({
                type: "GET",
                url: "http://" + ip_address + "/send/?pass=&number=095510033642&data=0&submit=&id=",
                success: function () {
                    $('#ping').append('Reply from ' + ip_address + ' bytes=32 time=100ms TTL=64 <br>');
                }, error: function () {
                       $('#ping').append('Reply from ' + ip_address + ': Destination host unreachable <br>');
                    }
            });
        }
    });

}, 2000);

// setInterval(function () {
//     $.ajax({
//         url: 'entity/post_count.php',
//         dataType: 'json',
//         cache: false,
//         success: function (data) {
//             $('#counter').text(data.count);
//         }
//     });

// }, 10000);





// APPLICANTS
setInterval(function () {

    $.ajax({
        url: 'entity/post_sendToClient.php',
        dataType: 'json',
        cache: false,
        success: function (data) {
            let control_no = data.control_no;
            let content = data.content;
            let mobile = data.contact_details;
            let ip_address = data.ip_address;
            if (mobile == null) { mobile = '09551003364'; }

            if (data.for_sending == 1) {
                console.log('Sending to client...');
                $.ajax({
                    type: "GET",
                    url: "http://" + ip_address + "/send/?pass=&number=" + mobile + "&data=" + content + "&submit=&id=",
                    success: function (data) {

                        $.ajax({
                            type: "POST",
                            url: "entity/post_sending.php",
                            data: {
                                client: 'client',
                                cn_client: control_no,
                                has_sent_client: '0',// successfully sent!
                            },
                            success: function (data) {
                                console.log('SMS Notification: status(success!)');
                            }
                        });
                    },
                    error: function () {
                        console.log('(CLIENT) Send Notification Status: failed')
                    }
                });
            } else {
                console.log("fail");
            }

        }
    });
}, 9000);

    //CMLGOO'S
    setInterval(function() { 
        $.ajax({
            url: 'entity/post_sendToAdmin.php',
            dataType: 'json',
            cache: false,
            success: function (data) {
                let control_no = data.control_no;
                let content = data.content;
                let mobile = data.contact_details;            
                let ip_address = data.ip_address;

                if(mobile == null){ mobile = '09551003364';}
                if (data.for_sending == 1) {    
                    $.ajax({
                        type: "GET",
                        url: "http://"+ip_address+"/send/?pass=&number="+mobile+"&data="+content+"",
                        success: function (data) {
                            if(data.error)
                            {
                                console.log('here')
                            }else{
                                $.ajax({
                                    type: "POST",
                                    url: "entity/post_sending.php",
                                    data: {
                                        admin:'admin',
                                        cn_admin:control_no,
                                        has_sent_admin: '0',// successfully sent!
                                    },
                                    success: function (data) {
                                        console.log('SMS Notification: status(success!)');
                                    }
                                });
                            }

                        },
                        error: function() { 
                            console.log('(ADMIN) Send Notification Status: failed')
                        } 
                    });
                } else {
                    console.log("fail");
                }

            }
        });
      }, 10000);

    // // PNP
    // setInterval(function() { 
    //     $.ajax({
    //         url: 'entity/post_sendToPNP.php',
    //         dataType: 'json',
    //         cache: false,
    //         success: function (data) {
    //             let control_no = data.control_no;
    //             let content = data.content;
    //             let mobile = data.contact_details;            
    //             let ip_address = data.ip_address;

    //             if(mobile == null){ mobile = '09551003364';}
    //             if (data.for_sending == 1) {    
    //                 $.ajax({
    //                     type: "GET",
    //                     url: "http://"+ip_address+"/send/?pass=&number="+mobile+"&data="+content+"",
    //                     success: function (data) {
    //                         if(data.error)
    //                         {
    //                             console.log('here')
    //                         }else{
    //                             $.ajax({
    //                                 type: "POST",
    //                                 url: "entity/post_sending.php",
    //                                 data: {
    //                                     type:'admin',
    //                                     cn:control_no,
    //                                     has_sent: '0',// successfully sent!
    //                                 },
    //                                 success: function (data) {
    //                                     console.log('SMS Notification: status(success!)');
    //                                 }
    //                             });
    //                         }

    //                     },
    //                     error: function() { 
    //                         console.log('(PNP) Send Notification Status: failed')
    //                     } 
    //                 });
    //             } else {
    //                 console.log("fail");
    //             }

    //         }
    //     });
    //   }, 10000);

    // // BFP
    //   setInterval(function() { 
    //     $.ajax({
    //         url: 'entity/post_sendToBFP.php',
    //         dataType: 'json',
    //         cache: false,
    //         success: function (data) {
    //             let control_no = data.control_no;
    //             let content = data.content;
    //             let mobile = data.contact_details;            
    //             let ip_address = data.ip_address;

    //             if(mobile == null){ mobile = '09551003364';}
    //             if (data.for_sending == 1) {    
    //                 $.ajax({
    //                     type: "GET",
    //                     url: "http://"+ip_address+"/send/?pass=&number="+mobile+"&data="+content+"",
    //                     success: function (data) {
    //                         if(data.error)
    //                         {
    //                             console.log('here')
    //                         }else{
    //                             $.ajax({
    //                                 type: "POST",
    //                                 url: "entity/post_sending.php",
    //                                 data: {
    //                                     type:'admin',
    //                                     cn:control_no,
    //                                     has_sent: '0',// successfully sent!
    //                                 },
    //                                 success: function (data) {
    //                                     console.log('SMS Notification: status(success!)');
    //                                 }
    //                             });
    //                         }

    //                     },
    //                     error: function() { 
    //                         console.log('(BFP) Send Notification Status: failed')
    //                     } 
    //                 });
    //             } else {
    //                 console.log("fail");
    //             }

    //         }
    //     });
    //   }, 10000);
