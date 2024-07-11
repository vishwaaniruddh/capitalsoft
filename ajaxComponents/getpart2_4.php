<?php
include("../config.php");

$customer = $_REQUEST['customer'];

$hours = [];
for ($i = 0; $i < 12; $i++) {
    $hours[] = "HOUR(NOW() - INTERVAL $i HOUR)";
}
$hour_sequence = implode(", ", $hours);

// Query to fetch counts for each hour, even if no data exists
$query = "
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
                  
                  AND a.receivedtime >= NOW() - INTERVAL 11 HOUR
    LEFT JOIN
        alertType at ON a.alerttype = at.alertType
                  AND at.isCritical = 1
                  ";

if (!empty($customer)) {
    $query .= "
    INNER JOIN
        sites s ON a.panelid = s.NewPanelID
                AND s.Customer = '" . mysqli_real_escape_string($con, $customer) . "'";
}

$query .= "
    WHERE
        HOUR(NOW() - INTERVAL h.seq HOUR) BETWEEN HOUR(NOW() - INTERVAL 11 HOUR) AND HOUR(NOW())
    GROUP BY
        hour_of_day
    ORDER BY
        hour_of_day
";


$result = mysqli_query($con, $query);

// Fetch data and prepare for ApexCharts
$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = (int)$row['count']; // Convert count to integer
}

// Define categories dynamically for the last 12 hours
$categories = [];
for ($i = 11; $i >= 0; $i--) {
    $hour = date('g A', strtotime("-$i hours")); // Format hour in AM/PM format
    $categories[] = $hour;
}

// Convert arrays to comma-separated strings
if($customer=='AXIS_Bank'){
    $data_string = "0,0,0,0,0,0,0,0,0,0,0,0"; 
 }else{
     $data_string = implode(",", $data);
 }
$categories_string = '["' . implode('","', $categories) . '"]';

// Prepare the final result array
$result = [
    'data' => $data_string,
    'categories' => $categories_string
];

// Encode result as JSON and output
echo json_encode($result);

mysqli_close($con);
?>
