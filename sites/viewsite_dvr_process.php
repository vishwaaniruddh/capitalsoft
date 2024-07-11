<?php  include('../config.php');

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);



$page = isset($_POST['Page']) && is_numeric($_POST['Page']) ? $_POST['Page'] : 1;
$records_per_page = isset($_POST['perpg']) && in_array($_POST['perpg'], [25, 50, 75, 100]) ? $_POST['perpg'] : 10;
$offset = ($page - 1) * $records_per_page;


$statement = "SELECT * from dvrsite  where 1 ";


// Apply filters
if (!empty($_REQUEST['cust'])) {
    $customer = $_REQUEST['cust'];
    $statement .= "AND Customer LIKE '%$customer%' ";
}
if (!empty($_REQUEST['bank'])) {
    $bank = $_REQUEST['bank'];
    $statement .= "AND Bank LIKE '%$bank%' ";
}

if (!empty($_REQUEST['lstatus']) && $_REQUEST['lstatus'] !='PL' ) {
    $lstatus = $_REQUEST['lstatus'];
    $statement .= "AND live LIKE '%$lstatus%' ";
}

if (!empty($_REQUEST['lstatus']) && $_REQUEST['lstatus'] =='PL' ) {
    $lstatus = $_REQUEST['lstatus'];
    $statement .= "AND live LIKE 'Y' and partial_live='1' ";
}

if (!empty($_REQUEST['cities'])) {
    $cities = $_REQUEST['cities'];
    $statement .= "AND City LIKE '%$cities%' ";
}

if (!empty($_REQUEST['DVRIP'])) {
    $DVRIP = $_REQUEST['DVRIP'];
    $statement .= "AND DVRIP LIKE '%$DVRIP%' ";
}

if (!empty($_REQUEST['atmid'])) {
    $atmid = $_REQUEST['atmid'];
    $statement .= "AND ( ATMID LIKE '%$atmid%' or ATMID_2 like '%" . $atmid . "%') ";
}

if (!empty($_REQUEST['track'])) {
    $track = $_REQUEST['track'];
    $statement .= "AND TrackerNo LIKE '%$track%' ";
}


if (!empty($_REQUEST['F_date']) && !empty($_REQUEST['T_date'])) {
    $fromdt = $_REQUEST['F_date'];
    $todt = $_REQUEST['T_date'];
    $statement .= "AND (liveDate between '" . $fromdt . "' and '" . $todt . "') ";
}else if(!empty($_REQUEST['F_date'])){
    $fromdt = $_REQUEST['F_date'];
    $statement .= "AND liveDate LIKE '" . $fromdt . "'";
}else if(!empty($_REQUEST['T_date'])){
    $todt = $_REQUEST['T_date'];
    $statement .= "AND liveDate LIKE '" . $todt . "'";
}


if (!empty($_REQUEST['track'])) {
    $track = $_REQUEST['track'];
    $statement .= "AND TrackerNo LIKE '%$track%' ";
}


$withoutLimitsql = $statement;
$sqlCount = mysqli_query($con, $statement);
$total_records = mysqli_num_rows($sqlCount);

echo $statement .= "LIMIT $offset, $records_per_page";
$sql = mysqli_query($con, $statement);


?>



<div class="total_n_export" style="display: flex;
    justify-content: space-between;">
  
  <h6 class="mb-0 text-uppercase">Total Records : <?php echo $total_records ; ?> </h6>
  
  <form action="./exportrecordsdvr.php">
    <input type="hidden" name="exportsql" value="<?php echo $withoutLimitsql ; ?>">
    <button type="submit" class="btn btn-outline-info px-5 radius-30"><i class="bx bx-cloud-download mr-1"></i>Export </button>
  </form>

</div>


<hr>

<div class="records">
<table id="tabletop" border=1 style="margin-top:30px" class="table mb-0 table-hover">
<thead class="table-dark">
  <tr>
    <th>Sr No</th>
    <th>Customer</th>
    <th>Bank</th>
    <th>Tracker No</th>
    <th>ATMID</th>
    <th>ATMID_2</th>
    <th>ATMShortName</th>
    <th>SiteAddress</th>
    <th>City</th>
    <th>State</th>
    <th>Zone</th>
    <th>DVRIP</th>
    <th>DVRName</th>
    <th>DVR_Model_num</th>

    <th>DVR_Serial_num </th>
    <th>CTSLocalBranch </th>
    <th>CTS_BM_Name </th>
    <th>CTS_BM_Number </th>
    <th>HDD </th>
    <th>Camera1 </th>
    <th>Camera2</th>

    <th>Camera3 </th>
    <th>Attachment1 </th>
    <th>Attachment2 </th>
    <th>LiveDate </th>
    <th>Site Remark </th>
    <th>User Name</th>
    <th>Password</th>
    <th>Live</th>
    <th>Edit</th>
    <th>Live Status</th>
    <th>Old ATMID</th>
  </tr>
  </thead>

  <?php

    $i = 1 + $offset; // Adjust index based on current page and offset
    while ($row = mysqli_fetch_array($sql)) {
    

  ?>



    <tr style="background-color:#cfe8c7">
      <td>
        <?php echo $i; ?>
      </td>
      <!--<td><?php echo $row["SN"]; ?></td>-->
      <!--<td><?php echo $row["Status"]; ?></td>
<td><?php echo $row["Phase"]; ?></td>-->
      <td>
        <?php echo $row["Customer"]; ?>
      </td>
      <td>
        <?php echo $row["Bank"]; ?>
      </td>
      <td>
        <?php echo $row["TrackerNo"]; ?>
      </td>
      <td>
        <?php echo $row["ATMID"]; ?>
      </td>

      <td>
        <?php echo $row["ATMID_2"]; ?>
      </td>
      <!--<td><?php echo $row["ATMID_3"]; ?></td>
<td><?php echo $row["ATMID_4"]; ?></td>
<td><?php echo $row["TrackerNo"]; ?></td>-->
      <td>
        <?php echo $row["ATMShortName"]; ?>
      </td>
      <td>
        <?php echo $row["SiteAddress"]; ?>
      </td>
      <td>
        <?php echo $row["City"]; ?>
      </td>
      <td>
        <?php echo $row["State"]; ?>
      </td>
      <td>
        <?php echo $row["Zone"]; ?>
      </td>
      <td>
        <?php echo $row["DVRIP"]; ?>
      </td>

      <td>
        <?php echo $row["DVRName"]; ?>
      </td>
      <td>
        <?php echo $row["DVR_Model_num"]; ?>
      </td>
      <td>
        <?php echo $row["DVR_Serial_num"]; ?>
      </td>
      <td>
        <?php echo $row["CTSLocalBranch"]; ?>
      </td>
      <td>
        <?php echo $row["CTS_BM_Name"]; ?>
      </td>
      <td>
        <?php echo $row["CTS_BM_Number"]; ?>
      </td>
      <td>
        <?php echo $row["HDD"]; ?>
      </td>
      <td>
        <?php echo $row["Camera1"]; ?>
      </td>
      <td>
        <?php echo $row["Camera2"]; ?>
      </td>
      <td>
        <?php echo $row["Camera3"]; ?>
      </td>
      <td>
        <?php 
        
        if(is_image($row["Attachment1"])){
          ?>
          <img src="<?php echo $row["Attachment1"]; ?>" style="height:60px;width:60px">
          <?php
        }else{
          echo 'No Image' ; 
        }


        
        
        ?>
    
    
    </td>
      <td>
      <?php
      
      if(is_image($row["Attachment2"])){
        ?>
        <img src="<?php echo $row["Attachment2"]; ?>" style="height:60px;width:60px">
        <?php
      }else{
        echo 'No Image' ; 
      }

      ?>  
      </td>
      <td>
        <?php echo $row["liveDate"]; ?>
      </td>
      <td>
        <?php echo $row["site_remark"]; ?>
      </td>
      <td>
        <?php echo $row["UserName"]; ?>
      </td>
      <td>
        <?php echo $row["Password"]; ?>
      </td>



      <?php if ($row['live'] != 'Y') { ?>
        <td>
          <a href="sitelive.php?id=<?php echo $row[0]; ?>" title="Live" class="icon-1 info-tooltip">Live</a>
        </td>
      <?php } else { ?>
        <td> </td>
      <?php } ?>


      <td> <a href="editDVR.php?atmid=<?php echo $row[0]; ?>" title="Edit" class="icon-1 info-tooltip">Edit</a></td>
      <td><?= $row['live']; ?></td>
      <td><?= $row['old_atmid']; ?></td>
    </tr>


  <?php
    $i++;
  }
  ?>


</table>
</div>



<?php
$total_pages = ceil($total_records / $records_per_page);
$filters = http_build_query(['network_ip' => $_POST['network_ip'], 'router_ip' => $_POST['router_ip'], 'atm_ip' => $_POST['atm_ip'], 'isAssign' => $_POST['isAssign']]);

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