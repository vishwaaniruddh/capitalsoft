<?php
include("../config.php");

$customer = $_REQUEST['customer'];

// Build the hour sequence for the last 12 hours
$hours = [];
for ($i = 0; $i < 12; $i++) {
    $hours[] = "HOUR(NOW() - INTERVAL $i HOUR)";
}
$hour_sequence = implode(", ", $hours);

// Build the query
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
                  AND a.status = 'O'
                  AND a.receivedtime >= NOW() - INTERVAL 11 HOUR";

if (!empty($customer)) {
    $query .= "
    INNER JOIN
        sites s ON a.panelid = s.NewPanelID
                AND s.Customer = '" . mysqli_real_escape_string($con, $customer) . "'";
}

$query .= "
    GROUP BY
        hour_of_day
    ORDER BY
        hour_of_day";

$result = mysqli_query($con, $query);

$data = [];
$categories = [];

// Initialize count array for all hours from 0 to 11
$countArray = array_fill(0, 12, 0);

while ($row = mysqli_fetch_assoc($result)) {
    $hour_of_day = intval($row['hour_of_day']);
    $count = intval($row['count']);
    $countArray[$hour_of_day] = $count;
}

// Populate data and categories arrays with count data
foreach ($countArray as $hour => $count) {
    $hour_label = date('g A', strtotime("-$hour hours"));
    $categories[] = $hour_label;
    $data[] = $count;
}

if($customer=='AXIS_Bank'){
   $data_string = "0,0,0,0,0,0,0,0,0,0,0,0"; 
}else{
    $data_string = implode(",", $data);
}
// Prepare JSON response


$categories_string = '["' . implode('","', $categories) . '"]';



$response = [
    'data' => $data_string,
    'categories' => $categories_string
];

// var_dump($response);

// Output JSON
echo json_encode($response);

mysqli_close($con);
?>
