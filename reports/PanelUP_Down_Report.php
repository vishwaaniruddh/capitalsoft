<?php
include ('../header.php');
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

<div class="page-content">
    <?php
    // Initialize variables
    $page = isset($_REQUEST['Page']) && is_numeric($_REQUEST['Page']) ? $_REQUEST['Page'] : 1;
    $records_per_page = isset($_REQUEST['perpg']) && in_array($_REQUEST['perpg'], [25, 50, 75, 100]) ? $_REQUEST['perpg'] : 10;
    $offset = ($page - 1) * $records_per_page;

    $statement = "SELECT * from panel_health a INNER JOIN sites b ON a.atmid = b.ATMID AND b.live='Y' WHERE 1 ";
    // $statement = "SELECT * from panel_health_backup a INNER JOIN sites b ON a.atmid = b.ATMID WHERE 1 ";
    

    // var_dump($_REQUEST) ; 
    // Apply filters
    if (!empty($_REQUEST['customer'])) {
        $customer = $_REQUEST['customer'];
        $statement .= "AND b.Customer LIKE '%$customer%' ";
    }

    // Check if month and year are provided, otherwise use current month and year
    if (!isset($_REQUEST['month']) || !isset($_REQUEST['year'])) {
        $currentMonth = date('m');
        $currentYear = date('Y');
    } else {
        $currentMonth = $_REQUEST['month'];
        $currentYear = $_REQUEST['year'];
    }

    // Append conditions for selected month and year
    $statement .= "AND MONTH(b.live_date) = $currentMonth AND YEAR(b.live_date) = $currentYear ";

 $withoutLimitsql = $statement;
    $sqlCount = mysqli_query($con, $statement);
    $total_records = mysqli_num_rows($sqlCount);

    $statement .= "LIMIT $offset, $records_per_page";
    $sql = mysqli_query($con, $statement);
    ?>

    <form id="searchForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <div class="row">
            <div class="col">
                <label for="customer">Customer:</label>
                <select name="customer" class="form-control form-control-sm mb-3" id="customer">
                    <option value="">Select Customer Name</option>
                    <?php
                    $xyzz = "SELECT name FROM customer WHERE status = 1";
                    $runxyzz = mysqli_query($con, $xyzz);
                    while ($xyzfetchcus = mysqli_fetch_array($runxyzz)) {
                        $selected = ($customer == $xyzfetchcus['name']) ? 'selected' : '';
                        echo '<option value="' . $xyzfetchcus['name'] . '" ' . $selected . '>' . $xyzfetchcus['name'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col">
                <label for="month">Month</label>
                <select name="month" id="month" class="form-control form-control-sm mb-3">
                    <option value="">Select Month</option>
                    <?php
                    $months = [
                        1 => 'Jan',
                        2 => 'Feb',
                        3 => 'Mar',
                        4 => 'Apr',
                        5 => 'May',
                        6 => 'Jun',
                        7 => 'Jul',
                        8 => 'Aug',
                        9 => 'Sep',
                        10 => 'Oct',
                        11 => 'Nov',
                        12 => 'Dec'
                    ];
                    foreach ($months as $key => $value) {
                        $selected = $currentMonth == $key ? 'selected' : '';
                        echo '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col">
                <label for="year">Year</label>
                <select name="year" id="year" class="form-control form-control-sm mb-3">
                    <option value="">Select Year</option>
                    <?php
                    $years = [2022, 2023, 2024]; // Add more years if needed
                    foreach ($years as $yr) {
                        $selected = $currentYear == $yr ? 'selected' : '';
                        echo '<option value="' . $yr . '" ' . $selected . '>' . $yr . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col">
                <br>
                <button type="submit" class="badge bg-primary" id="submitForm" name="submit"
                    value="search">Search</button>
            </div>
        </div>
    </form>

    <br>
    <br>
    <br>
    <div class="card">
        <div class="card-body" style="overflow:auto;">
            <div class="total_n_export" id="tabletop" style="display: flex; justify-content: space-between;">
                <h6 class="mb-0 text-uppercase">Total Records : <?php echo $total_records; ?></h6>
                <form action="../export/exportPanelUP_Down_Report.php" method="POST">
                    <input type="hidden" name="exportsql" value="<?php echo $withoutLimitsql; ?>">
                    <input type="hidden" name="month" value="<?php echo $currentMonth; ?>">
                    <input type="hidden" name="year" value="<?php echo $currentYear; ?>">

                    <button type="submit" class="btn btn-outline-info btn-sm px-5 radius-30">
                        <i class="bx bx-cloud-download mr-1"></i>Export
                    </button>
                </form>
            </div>
            <hr />
            <table id="alldvrtable" class="table1 table table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th>Sr No</th>
                        <th>Client</th>
                        <th>Bank</th>
                        <th>ATM ID</th>
                        <th>STATE</th>
                        <th>CITY</th>
                        <th>SITE ADDRESS</th>
                        <?php
                        // Display days of the selected month in table header
                        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
                        for ($day = 1; $day <= $daysInMonth; $day++) {
                            echo '<th>' . sprintf('%02d-%s-%02d', $day, date('M', mktime(0, 0, 0, $currentMonth, $day, $currentYear)), substr($currentYear, -2)) . '</th>';
                        }
                        ?>
                        <th>Ageing</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1 + $offset;
                    while ($row = mysqli_fetch_array($sql)) {
                        $customer = $row['Customer'];
                        $bank = $row['Bank'];
                        $atmid = $row['ATMID'];
                        $state = $row['State'];
                        $city = $row['City'];
                        $SiteAddress = $row['SiteAddress'];
                        $ip = $row['ip'];
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $customer; ?></td>
                            <td><?php echo $bank; ?></td>
                            <td><?php echo $atmid; ?></td>
                            <td><?php echo $state; ?></td>
                            <td><?php echo $city; ?></td>
                            <td><?php echo $SiteAddress; ?></td>
                            <?php
                            // Fetch and display status for each day of the selected month
                            for ($day = 1; $day <= $daysInMonth; $day++) {
                                // Construct date in YYYY-MM-DD format
                                $date = sprintf('%04d-%02d-%02d', $currentYear, $currentMonth, $day);
                                // Query to fetch status
                                $statusQuery = "SELECT status FROM panel_history WHERE ip = '$ip' AND DATE(udate) = '$date' order by udate desc";
                                $statusResult = mysqli_query($con, $statusQuery);
                                $status = '1';
                                if (mysqli_num_rows($statusResult) > 0) {
                                    $statusRow = mysqli_fetch_assoc($statusResult);
                                    $status = $statusRow['status'];
                                }
                                echo '<td>' . ($status == 0 ? 'UP' : 'DOWN') . '</td>';
                            }
                            ?>
                            <td></td>
                            <td></td>
                        </tr>
                        <?php
                        $i++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#customer').select2();
    });
</script>

<?php include ('../footer.php'); ?>
<script src="<?php echo BASE_URL; ?>/assets/js/select2.min.js"></script>
<script src="<?php echo BASE_URL; ?>/assets/plugins/select2/js/select2-custom.js"></script>