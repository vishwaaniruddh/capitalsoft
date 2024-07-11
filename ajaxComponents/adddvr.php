<?php include("../config.php");

if(isset($_POST['dvr'])) {
   $dvr = mysqli_real_escape_string($con, $_POST['dvr']);
    
   $insert_query = "INSERT INTO dvr_name (name, status) VALUES ('$dvr', 1)";
    
    if(mysqli_query($con, $insert_query)) {
        echo 1;
    } else {
        echo 0;
    }
} else {
    echo 0;
}

?>
