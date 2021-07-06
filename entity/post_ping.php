<?php
include '../application/config/connection.php';

        $sqlQuery = "SELECT * from  tbl_ipadd_details";
    $result = mysqli_query($conn, $sqlQuery);

    while ($row = mysqli_fetch_array($result)) {
  
                echo json_encode(array(
                    "ip_address" => $row['IP_ADDRESS']
                ));
            }
        // }

    // }





  
    

