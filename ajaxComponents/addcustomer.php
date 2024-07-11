<?php include("../config.php");

if(isset($_POST['customer'])) {
   $customer = mysqli_real_escape_string($con, $_POST['customer']);
    
   $insert_query = "INSERT INTO customer (name, status) VALUES ('$customer', 1)";
    
    if(mysqli_query($con, $insert_query)) {
        echo 1;
    } else {
        echo 0;
    }
} else {
    echo 0;
}

?>
