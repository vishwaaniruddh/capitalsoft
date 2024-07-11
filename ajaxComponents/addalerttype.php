<?php include("../config.php");



if(isset($_POST['alerttype']) && isset($_POST['isCritical'])) {
    $alertType = mysqli_real_escape_string($con, $_POST['alerttype']);
    $isCritical = mysqli_real_escape_string($con, $_POST['isCritical']);
    
     $insert_query = "INSERT INTO alertType (alertType, isCritical, status,created_at,created_by) 
    VALUES ('$alertType', '$isCritical',1,'".$datetime."','".$userid."')";
    
    if(mysqli_query($con, $insert_query)) {
        echo 1;
    } else {
        echo 0;
    }
} else {
    echo 0;
}

?>
