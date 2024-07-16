<?php
include('../config.php');

if (isset($_POST['customer'])) {
    // Escape the customer input to prevent SQL injection
    $customer = mysqli_real_escape_string($con, $_POST['customer']);
    
    // Query to fetch ATMIDs for the selected customer
    $query = "SELECT ATMID FROM sites WHERE Customer = '$customer'";
    $result = mysqli_query($con, $query);
    
    // Check if $atmid is set in $_POST
    if (isset($_POST['atmid'])) {
        $atmid = $_POST['atmid'];
    } else {
        $atmid = ''; // Default value if not set
    }

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Start building the option tag
            echo '<option value="' . $row['ATMID'] . '"';
            
            // Check if current ATMID should be selected
            if ($atmid == $row['ATMID']) {
                echo ' selected'; // Add 'selected' attribute
            }
            
            echo '>' . $row['ATMID'] . '</option>'; // Complete option tag
        }
    } else {
        echo '<option value="">No ATMID found for this customer</option>';
    }
} else {
    echo '<option value="">Select Customer First</option>';
}
?>
