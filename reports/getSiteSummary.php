<?php
include('../config.php');

$page = isset($_POST['Page']) && is_numeric($_POST['Page']) ? $_POST['Page'] : 1;
$records_per_page = isset($_POST['perpg']) && in_array($_POST['perpg'], [25, 50, 75, 100]) ? $_POST['perpg'] : 10;
$offset = ($page - 1) * $records_per_page;

$statement = "SELECT a.*, 
                    COUNT(d.id) as total_scans, 
                    SUM(CASE WHEN d.login_status = 0 AND d.status = 1 THEN 1 ELSE 0 END) as total_online, 
                    SUM(CASE WHEN d.login_status = 0 AND d.status = 0 THEN 1 
                             WHEN d.login_status = 1 AND d.status = 0 THEN 1 
                             WHEN d.login_status = 1 AND d.status = 1 THEN 1 ELSE 0 END) as total_offline
             FROM sites a
             LEFT JOIN dvr_history d ON a.atmid = d.atmid
             WHERE 1 ";

if (!empty($_REQUEST['customer'])) {
    $customer = $_REQUEST['customer'];
    $statement .= "AND a.Customer LIKE '%$customer%' ";
}
if (!empty($_REQUEST['atmid'])) {
    $atmid = $_REQUEST['atmid'];
    $statement .= "AND a.atmid LIKE '%$atmid%' ";
}
if (!empty($_REQUEST['month'])) {
    $month = $_REQUEST['month'];
    $statement .= "AND MONTH(d.cdate) LIKE '%$month%' ";
}

if (!empty($_REQUEST['year'])) {
    $year = $_REQUEST['year'];
    $statement .= "AND YEAR(d.cdate) LIKE '%$year%' ";
}
$statement .= "GROUP BY a.atmid ";

$withoutLimitsql = $statement;

$sqlCount = mysqli_query($con, $statement);
$total_records = mysqli_num_rows($sqlCount);

$statement .= " LIMIT $offset, $records_per_page";
$sql = mysqli_query($con, $statement);

?>
<br><br>
<div class="card">
    <div class="card-body">
        <div class="total_n_export" style="display: flex; justify-content: space-between;">
            <h6 class="mb-0 text-uppercase">Total Records : <?php echo $total_records; ?> </h6>
            <form action="./exportSiteSummaryReport.php">
                <input type="hidden" name="exportsql" value="<?php echo $withoutLimitsql; ?>">
                <button type="submit" class="btn btn-outline-info px-5 radius-30"><i class="bx bx-cloud-download mr-1"></i>Export</button>
            </form>
        </div>
        <hr>
        <div class="records">
            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                    <tr class="table-primary">
                        <th>Sr No</th>
                        <th>Client</th>
                        <th>Site</th>
                        <th>Panel Id</th>
                        <th>ATMID</th>
                        <th>Total Scan</th>
                        <th>Total Online</th>
                        <th>Total Offline</th>
                        <th>Online %</th>
                        <th>Offline %</th>
                        <th>DVRIP</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1 + $offset; // Adjust index based on current page and offset
                    while ($row = mysqli_fetch_array($sql)) {
                        $atmid = $row['ATMID'];
                        $Customer = $row['Customer'];
                        $dvrip = $row['DVRIP'];
                        $panelID = $row['NewPanelID'];
                        $siteName = $row['ATMShortName'];
                        $total_scans = $row['total_scans'];
                        $total_online = $row['total_online'];
                        $total_offline = $row['total_offline'];
                        $online_percentage = ($total_scans > 0) ? round(($total_online / $total_scans) * 100, 2) : 0;
                        $offline_percentage = ($total_scans > 0) ? round(($total_offline / $total_scans) * 100, 2) : 0;
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $Customer; ?></td>
                            <td><?php echo $siteName; ?></td>
                            <td><?php echo $panelID; ?></td>
                            <td><?php echo $atmid; ?></td>
                            <td><?php echo $total_scans; ?></td>
                            <td><?php echo $total_online; ?></td>
                            <td><?php echo $total_offline; ?></td>
                            <td><?php echo $online_percentage; ?>%</td>
                            <td><?php echo $offline_percentage; ?>%</td>
                            <td><?php echo $dvrip; ?></td>
                        </tr>
                        <?php $i++;
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
$total_pages = ceil($total_records / $records_per_page);
$filters = http_build_query(['atmid' => $_POST['atmid'], 'customer' => $_POST['customer'], 'panelip' => $_POST['panelip']]);
if ($total_pages > 1) {
    echo '<nav aria-label="Page navigation"><ul class="pagination justify-content-center">';
    if ($page > 1) {
        echo '<li class="page-item"><a class="page-link" href="#tabletop" onclick="a(1, ' . $records_per_page . ');">First</a></li>';
    }
    if ($page > 1) {
        echo '<li class="page-item"><a class="page-link" href="#tabletop" onclick="a(' . ($page - 1) . ', ' . $records_per_page . ');">Previous</a></li>';
    }
    $start = max(1, $page - 2);
    $end = min($total_pages, $page + 2);
    for ($i = $start; $i <= $end; $i++) {
        echo '<li class="page-item ' . ($page == $i ? 'active' : '') . '"><a class="page-link" href="#tabletop" onclick="a(' . $i . ', ' . $records_per_page . ');">' . $i . '</a></li>';
    }
    if ($page < $total_pages) {
        echo '<li class="page-item"><a class="page-link" href="#tabletop" onclick="a(' . ($page + 1) . ', ' . $records_per_page . ');">Next</a></li>';
    }
    if ($page < $total_pages) {
        echo '<li class="page-item"><a class="page-link" href="#tabletop" onclick="a(' . $total_pages . ', ' . $records_per_page . ');">Last</a></li>';
    }
    echo '</ul></nav>';
}
?>
