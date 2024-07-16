<?php include ('../config.php');



$page = isset($_POST['Page']) && is_numeric($_POST['Page']) ? $_POST['Page'] : 1;
$records_per_page = isset($_POST['perpg']) && in_array($_POST['perpg'], [25, 50, 75, 100]) ? $_POST['perpg'] : 10;
$offset = ($page - 1) * $records_per_page;

$statement = "SELECT * from panel_health a INNER JOIN sites b ON a.atmid = b.ATMID AND b.live='Y' where 1 ";


// Apply filters
if (!empty($_REQUEST['customer'])) {
  $customer = $_REQUEST['customer'];
  $statement .= "AND b.Customer LIKE '%$customer%' ";
}
if (!empty($_REQUEST['atmid'])) {
  $atmid = $_REQUEST['atmid'];
  $statement .= "AND a.atmid LIKE '%$atmid%' ";
}

if (!empty($_REQUEST['panelip'])) {
  $panelip = $_REQUEST['panelip'];
  $statement .= "AND a.ip LIKE '%$panelip%' ";
}
if (!empty($_REQUEST['panelName'])) {
  $panelName = $_REQUEST['panelName'];
  $statement .= "AND a.panelName LIKE '%$panelName%' ";
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

      <div class="button-list">

        <button type="button" style="background:#fd3550 !important; color:white;" class=""> 1 - Alert</button>

        <button type="button" style="background-color:#15ca20;color:white;" class=""> 0 - Normal </button>

        <button type="button" style="background-color:orchid;" class="">9 - ByPassed</button>

        <button type="button" style="background-color:white;color:black;border: 2px solid black" color="red" class="">2
          -
          Disconnect</button>
      </div>

      <form action="./exportrecordsrms.php">
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
            
            <th>
              <div>Client</div>
            </th>
            <th>
              <div>Site Name</div>
            </th>

            <th>
              <div>State&nbsp; </div>
            </th>
            <th>
              <div>City&nbsp; </div>
            </th>
            <th>
              <div>Bank&nbsp; </div>
            </th>
            <th>
              <div>PanelIP&nbsp; </div>
            </th>
            <th>
              <div>Panel Name&nbsp; </div>
            </th>
            <th>
              <div>Date_Time&nbsp; </div>
            </th>
            
            <th>
              <div id="">CURRENT STATUS</div>
            </th>
            <th>
              <div>SiteAddress&nbsp; </div>
            </th>
          </tr>
        </thead>

        <tbody>

          <?php
          $i = 1 + $offset; // Adjust index based on current page and offset
          
          while ($row = mysqli_fetch_array($sql)) {

            $StateQry = mysqli_query($conn, "select State,PanelIP,City,SiteAddress,Bank,Customer from sites where ATMID='" . $row['atmid'] . "'");

            $fetchState = mysqli_fetch_array($StateQry);


            ?>
            <tr <?php if ($row[67] == 1) { ?> class="dangeralertClass" <?php } else if ($row[67] == 0) { ?>
                  class="successalertClass" <?php } ?>>
              <td><?php echo $i; ?></td>
              <td><?php echo $fetchState['Customer']; ?></td>
              <td><?php echo $row[68]; ?></td>


              <td><?php echo $fetchState['State']; ?></td>
              <td><?php echo $fetchState['City']; ?></td>
              <td><?php echo $fetchState['Bank']; ?></td>

              <td><?php echo $fetchState['PanelIP']; ?></td>
              <td><?php echo $row['panelName']; ?></td>
              <td><?php echo $row[0]; ?></td>
              <td align="center">
                <div id="">
                  <?php if ($row[67] == 0) {
                    echo "Normal";
                  } else if ($row[67] == 1) {
                    echo "Alert";
                  } else if ($row[67] == 2) {
                    echo "Disconnect";
                  } else if ($row[67] == 9) {
                    echo "By Passed";
                  } ?>
                </div>
              </td>
              <td><?php echo $fetchState['SiteAddress']; ?></td>
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