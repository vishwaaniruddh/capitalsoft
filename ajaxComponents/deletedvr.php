<?php
include("../config.php");

if(isset($_POST['dvr_id'])) {
    $dvr_id = mysqli_real_escape_string($con, $_POST['dvr_id']);
    
    $update_query = "UPDATE dvr_name SET status = 0 WHERE id = '$dvr_id'";
    
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
