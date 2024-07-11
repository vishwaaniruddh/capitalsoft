<?php
include ('./config.php');

// Initialize variables
$page = isset($_POST['page']) && is_numeric($_POST['page']) ? $_POST['page'] : 1;
$records_per_page = isset($_POST['perpg']) && in_array($_POST['perpg'], [25, 50, 75, 100]) ? $_POST['perpg'] : 10;
$offset = ($page - 1) * $records_per_page;
$customer = isset($_POST['customer']) ? $_POST['customer'] : '';

// Construct the main SQL query
$sqlBase = "SELECT a.*, b.Customer, b.ATMID 
            FROM alerts a 
            INNER JOIN sites b ON a.panelid = b.NewPanelID 
            WHERE DATE(a.receivedtime) = CURDATE() 
                AND a.sendtoclient = 'S'";

if (!empty($customer)) {
    $sqlBase .= " AND b.Customer = '" . mysqli_real_escape_string($con, $customer) . "'";
}

$sqlBase .= " ORDER BY a.createtime DESC";

$sqlCount = mysqli_query($con, $sqlBase);
$total_records = mysqli_num_rows($sqlCount);

$sqlPagination = $sqlBase . " LIMIT $offset, $records_per_page";
$sql = mysqli_query($con, $sqlPagination);

if (mysqli_num_rows($sql) > 0) {
    // Prepare HTML output
    $output = '<div style="
    display: flex;
    justify-content: space-between;
">
    <h6 class="mb-0 text-uppercase">Alerts Data ! <span style="font-size:11px; color:red;"><a href="./alert/viewalert.php">View All Alerts</a><span> </h6>';

    $output .='<span style="margin:auto 20px; font-size:11px; "> Total Records : '. $total_records .'</span></div>';
     
    $output .= '<hr />';
    $output .= '<style>
                    .openCalls {
                        background-color: #ff4b2bc9 !important;
                        color: white;
                    }
                    .closeCalls {
                        background-color: green !important;
                        color: white;
                    }
                </style>';
    $output .= '<table class="dataTable" id="alertData">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Customer</th>
                            <th>ATMID</th>
                            <th>Panel Id</th>
                            <th>Alert Type</th>
                            <th>Terminal</th>
                            <th>Date Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>';

    // Loop through fetched data and build table rows
    $i = $offset + 1;
    while ($row = mysqli_fetch_assoc($sql)) {

        $statusClass = '';
        if($row['status']=='O'){
            $statusClass = 'openCalls';
            $status = 'Open';
        }else{
            $statusClass = 'closeCalls';
            $status = 'Close';
        }
    $statusClass = $row['status'] == 'O' ? 'openCalls' : 'closeCalls';


        $output .= '<tr class="' . $statusClass . '">
                        <td>' . $i . '</td>
                        <td>' . htmlspecialchars($row['Customer']) . '</td>
                        <td>' . htmlspecialchars($row['ATMID']) . '</td>
                        <td>' . htmlspecialchars($row['panelid']) . '</td>
                        <td>' . htmlspecialchars($row['alerttype']) . '</td>
                        <td>' . htmlspecialchars($row['sendip']) . '</td>
                        <td>' . convertDateTimeFormat($row['createtime']) . '</td>
                        <td>' . htmlspecialchars($status) . '</td>
                        
                    </tr>';
        $i++;
    }

    $output .= '</tbody></table>';

    // Calculate total pages for pagination
    $total_pages = ceil($total_records / $records_per_page);

    // Prepare pagination links
    if ($total_pages > 1) {
        $output .= '<nav aria-label="Page navigation" style="margin: 15px; float: right;">
                        <ul class="pagination justify-content-center">';

        // Calculate the range of links to show
        $range = 2; // Number of links to show before and after the current page

        $start = max(1, $page - $range);
        $end = min($total_pages, $page + $range);

        // Adjust start and end if current page is near the beginning or end of pagination
        if ($page <= $range + 1) {
            $end = min($total_pages, $start + $range * 2);
        } elseif ($page >= $total_pages - $range) {
            $start = max(1, $end - $range * 2);
        }

        // Previous page link
        if ($page > 1) {
            $output .= '<li class="page-item"><a class="page-link" href="#alertData" onclick="fetchData(' . ($page - 1) . ');">Previous</a></li>';
        }

        // Numbered page links
        for ($i = $start; $i <= $end; $i++) {
            $output .= '<li class="page-item ' . ($page == $i ? 'active' : '') . '">
                            <a class="page-link" href="#alertData" onclick="fetchData(' . $i . ');">' . $i . '</a>
                        </li>';
        }

        // Add "..." if there are more pages beyond displayed links
        if ($end < $total_pages) {
            $output .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
            $output .= '<li class="page-item">
                            <a class="page-link" href="#alertData" onclick="fetchData(' . $total_pages . ');">' . $total_pages . '</a>
                        </li>';
        }

        // Next page link
        if ($page < $total_pages) {
            $output .= '<li class="page-item"><a class="page-link" href="#alertData" onclick="fetchData(' . ($page + 1) . ');">Next</a></li>';
        }

        $output .= '</ul></nav>';
    }

    // Output the result
    echo $output;
} else {
    // No records found message
    echo '<h6 class="mb-0 text-uppercase">No Alerts Data Found!</h6>';
}
?>

<script>
    function fetchData(page) {
        var perpg = <?php echo $records_per_page; ?>;
        var customer = '<?php echo addslashes($customer); ?>';

        $.ajax({
            type: "POST",
            url: "./part3Dashboard.php",
            data: { page: page, perpg: perpg, customer: customer },
            success: function (response) {
                $("#part3Dashboard").html(response);
            }
        });
    }
</script>