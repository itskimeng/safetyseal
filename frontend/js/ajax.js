{/* <form method="GET" id="send-form">
<input type="hidden" name="pass" placeholder="password" value="">
<input type="hidden" name="number" value="<?php echo $userinfo['contact_details']; ?>">
<textarea style="display:none;" id="data" name="data" placeholder="data"> Notification from DILG IV-A Safety Seal Portal:
  Hi <?php echo $admininfo['fname']; ?>!,  <?php echo $userinfo['establishment']; ?> applied for Safety Seal Certification with Ctrl No: <?php echo $userinfo['code']; ?>. Kindly login to the portal to proceed with the assessment and issuance of certificate.</textarea>
<input type="hidden" name="id">
<input type="hidden" name="submit">
</form> */}

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
                            console.log('success!');
                        }
                    });
                }
            });
        } else {
            console.log("fail");
        }

    }
});


