<?php
include("../config.php");

if(isset($_POST['city_id'])) {
    $city_id = mysqli_real_escape_string($con, $_POST['city_id']);
    
    $update_query = "UPDATE cities SET status = 0 WHERE city_id = '$city_id'";
    
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
