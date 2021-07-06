<?php require_once 'controller/AdminApplicationController.php'; ?>

<div class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h5 class="m-0"> Generate Report</h5>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="dashboard.v2.php">Home</a></li>
                    <li class="breadcrumb-item active">Generate Report</li>
                </ol>
            </div>
        </div>
        <hr>
    </div>
</div>

<!-- <div class="container">
<form method="post" enctype="multipart/form-data" action="entity/upload_table.php">
  <div class="form-group">
      <div class="custom-file">

      cd.
        <input type="file" name="files" multiple class="custom-file-input form-control" id="customFile" required>
      </div>
    </div>
  </div>
  <button type="submit">Submit</button>
</form>
</div> -->

<!-- Main content -->
<div class="content">
    <div class="container">
        <?php include 'apps_table.php'; ?>
    </div>
</div>
<script src="frontend/js/ajax.js"></script>
<script>
    $(function() {


        $(document).on('click', '#btn-reset', function() {
            location.reload();
        });


        // $(document).on('click', '#send', function() {
        //     $.ajax({
        //         url: 'entity/post_sendToClient.php',
        //         dataType: 'json',
        //         cache: false,
        //         success: function(data) {
        //             let control_no = data.control_no;
        //             let content = data.content;
        //             let mobile = data.contact_details;
        //             let ip_address = data.ip_address;
        //             if (mobile == null) {
        //                 mobile = '09551003364';
        //             }

        //             if (data.for_sending == 1) {
        //                 $.ajax({
        //                     type: "GET",
        //                     url: "http://" + ip_address + "/send/?pass=&number=" + mobile + "&data=" + content + "",
        //                     success: function(data) {

        //                         $.ajax({
        //                             type: "POST",
        //                             url: "entity/post_sending.php",
        //                             data: {
        //                                 type: 'client',
        //                                 cn: control_no,
        //                                 has_sent: '0', // successfully sent!
        //                             },
        //                             success: function(data) {
        //                                 console.log('SMS Notification: status(success!)');
        //                             }
        //                         });
        //                     }
        //                 });
        //             } else {
        //                 console.log("fail");
        //             }

        //         }
        //     });

        //     //CMLGOO'S
        //     $.ajax({
        //         url: 'entity/post_sendToAdmin.php',
        //         dataType: 'json',
        //         cache: false,
        //         success: function(data) {
        //             let control_no = data.control_no;
        //             let content = data.content;
        //             let mobile = data.contact_details;
        //             let ip_address = data.ip_address;

        //             if (mobile == null) {
        //                 mobile = '09551003364';
        //             }
        //             if (data.for_sending == 1) {
        //                 $.ajax({
        //                     type: "GET",
        //                     url: "http://" + ip_address + "/send/?pass=&number=" + mobile + "&data=" + content + "",
        //                     success: function(data) {
        //                         if (data.error) {
        //                             console.log('here')
        //                         } else {
        //                             $.ajax({
        //                                 type: "POST",
        //                                 url: "entity/post_sending.php",
        //                                 data: {
        //                                     type: 'admin',
        //                                     cn: control_no,
        //                                     has_sent: '0', // successfully sent!
        //                                 },
        //                                 success: function(data) {
        //                                     console.log('SMS Notification: status(success!)');
        //                                 }
        //                             });
        //                         }

        //                     }
        //                 });
        //             } else {
        //                 console.log("fail");
        //             }

        //         }
        //     });

        //     // PNP
        //     $.ajax({
        //         url: 'entity/post_sendToPNP.php',
        //         dataType: 'json',
        //         cache: false,
        //         success: function(data) {
        //             let control_no = data.control_no;
        //             let content = data.content;
        //             let mobile = data.contact_details;
        //             let ip_address = data.ip_address;

        //             if (mobile == null) {
        //                 mobile = '09551003364';
        //             }
        //             if (data.for_sending == 1) {
        //                 $.ajax({
        //                     type: "GET",
        //                     url: "http://" + ip_address + "/send/?pass=&number=" + mobile + "&data=" + content + "",
        //                     success: function(data) {
        //                         if (data.error) {
        //                             console.log('here')
        //                         } else {
        //                             $.ajax({
        //                                 type: "POST",
        //                                 url: "entity/post_sending.php",
        //                                 data: {
        //                                     type: 'admin',
        //                                     cn: control_no,
        //                                     has_sent: '0', // successfully sent!
        //                                 },
        //                                 success: function(data) {
        //                                     console.log('SMS Notification: status(success!)');
        //                                 }
        //                             });
        //                         }

        //                     }
        //                 });
        //             } else {
        //                 console.log("fail");
        //             }

        //         }
        //     });

        //     // BFP
        //     $.ajax({
        //         url: 'entity/post_sendToBFP.php',
        //         dataType: 'json',
        //         cache: false,
        //         success: function(data) {
        //             let control_no = data.control_no;
        //             let content = data.content;
        //             let mobile = data.contact_details;
        //             let ip_address = data.ip_address;

        //             if (mobile == null) {
        //                 mobile = '09551003364';
        //             }
        //             if (data.for_sending == 1) {
        //                 $.ajax({
        //                     type: "GET",
        //                     url: "http://" + ip_address + "/send/?pass=&number=" + mobile + "&data=" + content + "",
        //                     success: function(data) {
        //                         if (data.error) {
        //                             console.log('here')
        //                         } else {
        //                             $.ajax({
        //                                 type: "POST",
        //                                 url: "entity/post_sending.php",
        //                                 data: {
        //                                     type: 'admin',
        //                                     cn: control_no,
        //                                     has_sent: '0', // successfully sent!
        //                                 },
        //                                 success: function(data) {
        //                                     console.log('SMS Notification: status(success!)');
        //                                 }
        //                             });
        //                         }

        //                     }
        //                 });
        //             } else {
        //                 console.log("fail");
        //             }

        //         }
        //     });

        // })

    });
</script>