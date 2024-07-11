<?php include("../config.php");

if(isset($_POST['city']) && isset($_POST['state_id']) && isset($_POST['state_name'])) {
    $city = mysqli_real_escape_string($con, $_POST['city']);
    $state_id = mysqli_real_escape_string($con, $_POST['state_id']);
    $state_name = mysqli_real_escape_string($con, $_POST['state_name']);
    
    $insert_query = "INSERT INTO cities (city, state_id, state, status) VALUES ('$city', '$state_id', '$state_name', 1)";
    
    if(mysqli_query($con, $insert_query)) {
        echo 1;
    } else {
        echo 0;
    }
} else {
    echo 0;
}

?>
