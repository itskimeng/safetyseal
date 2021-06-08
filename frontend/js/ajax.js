$('#submit').click(function () {
    var queryString = $('#registrationForm').serialize();
    alert(queryString);
    // $.ajax({
    //     url: "_editTAForm_save.php",
    //     method: "POST",
    //     data: $("#submit").serialize(),
    //     success: function (data) {
    //         setTimeout(function () {
    //             swal("Record saved successfully!");
    //         }, 1000);
    //         window.location = "processing.php?division=<?php echo $_GET['division'];?>";
    //     }
    // });
})