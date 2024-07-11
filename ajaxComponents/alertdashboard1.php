<?php
include ("../config.php");

// Get customer from request
$customer = isset($_REQUEST['customer']) ? $_REQUEST['customer'] : '';

// Define the hours sequence dynamically
$hours = [];
for ($i = 0; $i < 12; $i++) {
    $hours[] = "HOUR(NOW() - INTERVAL $i HOUR)";
}
$hour_sequence = implode(", ", $hours);

// Query to fetch count of alerts received in the last 12 hours
$query_alerts = "
    SELECT 
        HOUR(NOW() - INTERVAL h.seq HOUR) AS hour_of_day, 
        COALESCE(COUNT(a.receivedtime), 0) AS count
    FROM
        (SELECT 0 AS seq UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL 
         SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL 
         SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL 
         SELECT 9 UNION ALL SELECT 10 UNION ALL SELECT 11) AS h
    LEFT JOIN
        alerts a ON HOUR(a.receivedtime) = HOUR(NOW() - INTERVAL h.seq HOUR)
                  AND a.sendtoclient = 'S'
                  AND a.receivedtime >= NOW() - INTERVAL 11 HOUR";

// If customer is specified, join with sites table
if (!empty($customer)) {
    $query_alerts .= "
        INNER JOIN
        sites s ON a.panelid = s.NewPanelID
        AND s.Customer = '" . mysqli_real_escape_string($con, $customer) . "'";
}

$query_alerts .= "
    GROUP BY
        hour_of_day
    ORDER BY
        hour_of_day";

$result_alerts = mysqli_query($con, $query_alerts);

$countArray_alerts = array_fill(0, 12, 0);

while ($row_alerts = mysqli_fetch_assoc($result_alerts)) {
    $hour_of_day_alerts = intval($row_alerts['hour_of_day']);

    $current_hour = date('G'); // Get current hour in 24-hour format
    $index = ($current_hour - $hour_of_day_alerts + 12) % 12;

    if ($index >= 0 && $index < 12) {
        $count_alerts = intval($row_alerts['count']);
        $countArray_alerts[($index + 12) % 12] = $count_alerts;
    }
}
$countArray_alerts = array_reverse($countArray_alerts);

// Prepare data_a string with exactly 12 elements
$data_a = [];
foreach ($countArray_alerts as $count_alerts) {
    $data_a[] = $count_alerts;
}

// If customer is 'AXIS_Bank', set data_a to all zeros
if ($customer == 'AXIS_Bank') {
    $data_a = array_fill(0, 12, 0);
}

// Query to fetch count of closed alerts in the last 12 hours
$query_closed_alerts = "
    SELECT 
        HOUR(NOW() - INTERVAL h.seq HOUR) AS hour_of_day, 
        COALESCE(COUNT(a.closedtime), 0) AS count
    FROM
        (SELECT 0 AS seq UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL 
         SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL 
         SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL 
         SELECT 9 UNION ALL SELECT 10 UNION ALL SELECT 11) AS h
    LEFT JOIN
        alerts a ON HOUR(a.closedtime) = HOUR(NOW() - INTERVAL h.seq HOUR)
                  AND a.sendtoclient = 'S'
                  AND a.status = 'C'
                  AND a.closedtime >= NOW() - INTERVAL 11 HOUR";

// If customer is specified, join with sites table
if (!empty($customer)) {
    $query_closed_alerts .= "
        INNER JOIN
        sites s ON a.panelid = s.NewPanelID
        AND s.Customer = '" . mysqli_real_escape_string($con, $customer) . "'";
}

$query_closed_alerts .= "
    GROUP BY
        hour_of_day
    ORDER BY
        hour_of_day";

$result_closed_alerts = mysqli_query($con, $query_closed_alerts);

// Initialize count array for all hours from 0 to 11
$countArray_closed_alerts = array_fill(0, 12, 0);

while ($row_closed_alerts = mysqli_fetch_assoc($result_closed_alerts)) {
    $hour_of_day_closed_alerts = intval($row_closed_alerts['hour_of_day']);

    $current_hour = date('G'); // Get current hour in 24-hour format
    $index = ($current_hour - $hour_of_day_closed_alerts + 12) % 12;

    if ($index >= 0 && $index < 12) {
        $count_closed_alerts = intval($row_closed_alerts['count']);
        $countArray_closed_alerts[($index + 12) % 12] = $count_closed_alerts;
    }
}

$countArray_closed_alerts = array_reverse($countArray_closed_alerts);

// Prepare data_b string with exactly 12 elements
$data_b = [];
foreach ($countArray_closed_alerts as $count_closed_alerts) {
    $data_b[] = $count_closed_alerts;
}

// If customer is 'AXIS_Bank', set data_b to all zeros
if ($customer == 'AXIS_Bank') {
    $data_b = array_fill(0, 12, 0);
}

// Convert arrays to comma-separated strings
$data_string_a = implode(",", $data_a);
$data_string_b = implode(",", $data_b);

// Define categories dynamically for the last 12 hours
$categories = [];
for ($i = 11; $i >= 0; $i--) {
    $hour_label = date('g A', strtotime("-$i hours")); // Format hour in AM/PM format
    $categories[] = $hour_label;
}

// Convert categories array to JSON format
$categories_string = json_encode($categories);

// Prepare the final result array
$result = [
    'data_a' => $data_string_a,
    'data_b' => $data_string_b,
    'categories' => $categories_string
];

// Encode result as JSON and output
echo json_encode($result);

mysqli_close($con);
?>