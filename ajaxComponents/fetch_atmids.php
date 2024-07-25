<?php
include ('../config.php');

if (isset($_POST['customer'])) {
    // Escape the customer input to prevent SQL injection
    $customer = mysqli_real_escape_string($con, $_POST['customer']);

    if ($customer == 'AXIS_Bank') {
        $table = 'dvrsite';
    } else {
        $table = 'sites';
    }

    // Query to fetch ATMIDs for the selected customer
    $query = "SELECT ATMID FROM $table WHERE Customer = '$customer' and live='Y'";
    $result = mysqli_query($con, $query);

    $isATMID = 0;

    // Check if $atmid is set in $_POST
    if (isset($_POST['atmid'])) {
        $atmid = $_POST['atmid'];
        $isATMID = 1;
    } else {
        $atmid = ''; // Default value if not set
    }

    if (mysqli_num_rows($result) > 0) {

        echo '<option value=""> Select </option>';
        while ($row = mysqli_fetch_assoc($result)) {
            // Start building the option tag
            echo '<option value="' . $row['ATMID'] . '"';

            // Check if current ATMID should be selected
            if ($atmid == $row['ATMID'] && $isATMID == 1) {
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