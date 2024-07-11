<?php
include("../config.php");

if(isset($_POST['customer_id'])) {
    $customer_id = mysqli_real_escape_string($con, $_POST['customer_id']);
    
    $update_query = "UPDATE customer SET status = 0 WHERE id = '$customer_id'";
    
    if(mysqli_query($con, $update_query)) {
        echo 1;
    } else {
        echo 0;
    }
} else {
    echo 0;
}

mysqli_close($con);
?>
