<?php
include("../config.php");

$customer = $_REQUEST['customer'];

// Build the hour sequence for the last 12 hours
$hours_3 = [];
for ($thirdi = 0; $thirdi < 12; $thirdi++) {
    $hours_3[] = "HOUR(NOW() - INTERVAL $thirdi HOUR)";
}
$hour_sequence_3 = implode(", ", $hours_3);

// Build the query
$query_3 = "
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
                  AND a.status = 'C'
                  AND a.receivedtime >= NOW() - INTERVAL 11 HOUR";

if (!empty($customer)) {
    $query_3 .= "
    INNER JOIN
        sites s ON a.panelid = s.NewPanelID
                AND s.Customer = '" . mysqli_real_escape_string($con, $customer) . "'";
}

$query_3 .= "
    GROUP BY
        hour_of_day
    ORDER BY
        hour_of_day";

$result_3 = mysqli_query($con, $query_3);

$data_3 = [];
$categories_3 = [];

// Initialize count array for all hours from 0 to 11
$countArray_3 = array_fill(0, 12, 0);

while ($row_3 = mysqli_fetch_assoc($result_3)) {
    $hour_of_day_3 = intval($row_3['hour_of_day']);
    $count_3 = intval($row_3['count']);
    $countArray_3[$hour_of_day_3] = $count_3;
}

// Populate data and categories arrays with count data
foreach ($countArray_3 as $hour_3 => $count_3) {
    $hour_label_3 = date('g A', strtotime("-$hour_3 hours"));
    $categories_3[] = $hour_label_3;
    $data_3[] = $count_3;
}

if($customer=='AXIS_Bank'){
   $data_3_string = "0,0,0,0,0,0,0,0,0,0,0,0"; 
}else{
    $data_3_string = implode(",", $data_3);
}
// Prepare JSON response


$categories_3_string = '["' . implode('","', $categories_3) . '"]';



$response_3 = [
    'data' => $data_3_string,
    'categories' => $categories_3_string
];

// var_dump($response_3);

// Output JSON
echo json_encode($response_3);

mysqli_close($con);
?>
