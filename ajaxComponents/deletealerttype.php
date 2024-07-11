<?php
include("../config.php");

if(isset($_POST['alerttype_id'])) {
    $alerttype_id = mysqli_real_escape_string($con, $_POST['alerttype_id']);
    $update_query = "UPDATE alertType SET status = 0 WHERE id = '$alerttype_id'";
    
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
