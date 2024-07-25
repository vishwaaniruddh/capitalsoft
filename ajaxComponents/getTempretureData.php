<?php include ('../config.php');



$page = isset($_POST['Page']) && is_numeric($_POST['Page']) ? $_POST['Page'] : 1;
$records_per_page = isset($_POST['perpg']) && in_array($_POST['perpg'], [25, 50, 75, 100]) ? $_POST['perpg'] : 10;
$offset = ($page - 1) * $records_per_page;

$statement = "SELECT a.*,b.Customer,b.Zone,b.ATMID,b.ATMShortName,b.SiteAddress from alerts a INNER JOIN sites b ON a.panelid = b.NewPanelID AND b.live='Y' where a.alerttype like '%Temperature%' ";

// Apply filters
if (!empty($_REQUEST['customer'])) {
    $customer = $_REQUEST['customer'];
    $statement .= "AND b.Customer LIKE '%$customer%' ";
}
if (!empty($_REQUEST['atmid'])) {
    $atmid = $_REQUEST['atmid'];
    $statement .= "AND a.atmid LIKE '%$atmid%' ";
}

$withoutLimitsql = $statement;
$sqlCount = mysqli_query($con, $statement);
$total_records = mysqli_num_rows($sqlCount);

$statement .= "LIMIT $offset, $records_per_page";
$sql = mysqli_query($con, $statement);


// echo $statement ; 
?>
<br><br>
<div class="card">
    <div class="card-body">

        <div class="total_n_export" style="display: flex;
    justify-content: space-between;">

            <h6 class="mb-0 text-uppercase">Total Records : <?php echo $total_records; ?> </h6>


            <form action="../export/exportrecordTempreture.php">
                <input type="hidden" name="exportsql" value="<?php echo $withoutLimitsql; ?>">
                <button type="submit" class="btn btn-outline-info px-5 radius-30"><i
                        class="bx bx-cloud-download mr-1"></i>Export
                </button>
            </form>

        </div>


        <hr>

        <div class="records">

            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                    <tr class="table-primary">
                        <th>SN</th>
                        <th>Client</th>
                        <th>Region</th>
                        <th>ATMID</th>
                        <th>Site Name</th>
                        <th>Address</th>
                        <th>Open Date</th>
                        <th>Open Time</th>
                        <th>Close Date</th>
                        <th>Close Time</th>
                    </tr>
                </thead>

                <tbody>

                    <?php
                    $i = 1 + $offset; // Adjust index based on current page and offset
                    
                    while ($row = mysqli_fetch_array($sql)) {

                      
                        $receivedDatetime = $row['receivedtime'];
                        
                        $receivedDate = date('Y-m-d', strtotime($receivedDatetime)); // Format 'Y-m-d'
                        $receivedTime = date('H:i:s', strtotime($receivedDatetime)); // Format 'H:i:s'
                    
                        $closedDateTime = $row['closedtime'];

                        $closedDate = date('Y-m-d', strtotime($closedDateTime)); // Format 'Y-m-d'
                        $closedTime = date('H:i:s', strtotime($closedDateTime)); // Format 'H:i:s'
                    
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $row['Customer']; ?></td>
                            <td><?php echo $row['Zone']; ?></td>
                            <td><?php echo $row['ATMID']; ?></td>
                            <td><?php echo $row['ATMShortName']; ?></td>
                            <td><?php echo $row['SiteAddress']; ?></td>
                            <td><?php echo $receivedDate; ?></td>
                            <td><?php echo $receivedTime; ?></td>
                            <td><?php echo $closedDate; ?></td>
                            <td><?php echo $closedTime; ?></td>
                            
                        </tr>
                        <?php
                        $i++;
                        ?>
                        <?php
                    }
                    ?>
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