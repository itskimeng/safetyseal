

<?php
  $to = 'markkimsacluti10101996@gmail.com';
  $subject = "Safety Seal Email Verification";
  $message = '<a style="font-size:24px;font-family:centuryGothic;" href="http://safetyseal.calabarzon.dilg.gov.ph/application/functions/verify.php?vkey="'. $vkey . '">Verify Account</a> <main> <div class="container"> <div class="row"> <div class="col-lg-12"> <img src=\"https://safetyseal.calabarzon.dilg.gov.ph/frontend/images/FINAL_LGMED_LOGO.png\">
    <img src="https://safetyseal.calabarzon.dilg.gov.ph/frontend/images/logo.png" style="width: 80px; height:auto;" /> <img src="https://safetyseal.calabarzon.dilg.gov.ph/frontend/images/calabarzon.png" style="width: 80px; height:auto;" /> <img src="https://safetyseal.calabarzon.dilg.gov.ph/frontend/images/FINAL_LGMED_LOGO.png" style="width: 80px; height:auto;" /> <img src="https://safetyseal.calabarzon.dilg.gov.ph/frontend/images/SAFETY SEAL LOGO.svg" style="margin-left: 10%;width: 130px; height:auto;" /> </div> Welcome to DILG CALABARZON Safety Seal Portal! To complete your Safety Seal profile, we need you to confirm your email address. </div> </div> </main>';
  $headers = "From: safetyseal@calabarzon.dilg.gov.ph \r\n";
  $headers .= "MIME-Version: 1.0" . "\r\n";
  $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
  mail($to, $subject, $message, $headers);
?>

