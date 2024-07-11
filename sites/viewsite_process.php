<?php  include('../config.php');


$page = isset($_POST['Page']) && is_numeric($_POST['Page']) ? $_POST['Page'] : 1;
$records_per_page = isset($_POST['perpg']) && in_array($_POST['perpg'], [25, 50, 75, 100]) ? $_POST['perpg'] : 10;
$offset = ($page - 1) * $records_per_page;

$statement = "SELECT * from sites  where 1 ";


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
    $statement .= "AND (live_date between '" . $fromdt . "' and '" . $todt . "') ";
}else if(!empty($_REQUEST['F_date'])){
    $fromdt = $_REQUEST['F_date'];
    $statement .= "AND live_date LIKE '" . $fromdt . "'";
}else if(!empty($_REQUEST['T_date'])){
    $todt = $_REQUEST['T_date'];
    $statement .= "AND live_date LIKE '" . $todt . "'";
}


if (!empty($_REQUEST['track'])) {
    $track = $_REQUEST['track'];
    $statement .= "AND TrackerNo LIKE '%$track%' ";
}

  


$withoutLimitsql = $statement;
$sqlCount = mysqli_query($con, $statement);
$total_records = mysqli_num_rows($sqlCount);

$statement .= "LIMIT $offset, $records_per_page";
$sql = mysqli_query($con, $statement);

?>

<div class="total_n_export" style="display: flex;
    justify-content: space-between;">
  
  <h6 class="mb-0 text-uppercase">Total Records : <?php echo $total_records ; ?> </h6>
  
  <form action="./exportrecordsrms.php">
    <input type="hidden" name="exportsql" value="<?php echo $withoutLimitsql ; ?>">
    <button type="submit" class="btn btn-outline-info px-5 radius-30"><i class="bx bx-cloud-download mr-1"></i>Export </button>
  </form>

</div>


<hr>

    <div class="records">
    <table id="tabletop" border=1 style="margin-top:30px" class="table mb-0 table-bordered table-hover">
    <thead class="table-dark">
    <tr>
        <th>Sr No</th>
        <th>Customer</th>
        <?php if ($_SESSION['id'] == "93" || $_SESSION['id'] == "46" || $_SESSION['id'] == "27" || $_SESSION['id'] == "90" || $_SESSION['id'] == "28" || $_SESSION['id'] == "74") {
        ?>
          <th>Live</th>
        <?php } ?>

        <th>Bank</th>
        <th>Tracker No</th>
        <th>ATMID</th>
        <th>OLD ATMID</th>
        <th>ATMID_2</th>
        <th>ATMID_3</th>
        <th>ATMShortName</th>
        <th>City</th>
        <th>State</th>
        <th>Zone</th>
        <th>Panel_Make</th>
        <th>OldPanelID</th>
        <th>NewPanelID</th>
        <th>PanelIP</th>
        <th>DVRIP</th>
        <th>DVRName</th>
        <th>DVR_Model_num</th>
        <th>Router_Model_num</th>
        <th>UserName</th>
        <th>Password</th>
        <th>Live</th>
        <th>LiveDate</th>
        <th>Installation Engineer Name</th>
        <th>Captial Softs Engineer Name</th>
        <th>Captial Softs Engineer Number</th>
        <th>GSM Number</th>
        <th>RA Name</th>
        <th>RA Number</th>
        <th>Police Station</th>
        <th>Police number</th>
        <th>Fire Station Name</th>
        <th>Fire Station number</th>
        <th>Atm Officer Name</th>
        <th>Atm Officer Number</th>
        <th>atm_officer_email</th>
        <th>zonal_co_ordinator_name</th>
        <th>zonal_co_ordinator_number</th>
        <th>zonal_co_ordinator_email</th>
        <th>Bank Officer Name</th>
        <th>Bank Officer Number</th>
        <th>Bank Officer Email ID</th>
        <th>CO Owner Name</th>
        <th>CO Owner Number</th>
        <th>CO Owner Email ID</th>
        <th>Zonal Name</th>
        <th>Zonal Number</th>
        <th>Zonal Email ID</th>

        <th>Site Add Date</th>
        <th>Site Add By</th>
        <th>Site Edit By</th>
        <th>Remark</th>
        <th>RouterIp </th>


        <th>Edit </th>
        <th>Image</th>
        <th>Update/Transfer</th>
        <?php if ($_SESSION['id'] == 27 || $_SESSION['id'] == 24) { ?>
          <th>Send Mail</th>
        <?php } ?>
        <th>Testing</th>
        <th>Sim number</th>
        <th>Sim Owner</th>
        <th>Live date and time</th>

        <th>Camera IP </th>
        <th>Port</th>
        <th>Ip Camera</th>
        <th>SiteAddress</th>

      </tr>
    </thead>  
    
      <?php

      
$i = 1 + $offset; // Adjust index based on current page and offset
while ($row = mysqli_fetch_array($sql)) {

        $site_id = $row['SN'];
        $sql1 = "select * from esurvsites where ATM_ID='" . $row["ATMID"] . "'";

        $result1 = mysqli_query($conn, $sql1);
        $row1 = mysqli_fetch_array($result1);

        $sql2 = "select files from site_attachment where site_id='" . $row[0] . "' order by id desc";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_array($result2);

      ?>



        <tr style="background-color:#cfe8c7">
          <td>
            <?php echo $i; ?>
          </td>
          <td>
            <?php echo $row["Customer"]; ?>
          </td>
          <?php if ($_SESSION['id'] == "93" || $_SESSION['id'] == "46" || $_SESSION['id'] == "27" || $_SESSION['id'] == "90" || $_SESSION['id'] == "28" || $_SESSION['id'] == "74") {
          ?>
            <td>
              <a href="updateSites.php?process=rms&id=<?php echo $row[0]; ?>">Live</a>

              <?php $rms_sql = mysqli_query($conn, "select * from rms_update where rms_id = '" . $row[0] . "'");
              if ($rms_sql_result = mysqli_fetch_assoc($rms_sql)) { ?>

                | <a href="tcpdf/TCPDF-main/examples/report.php?id=<?php echo $row[0]; ?>" target="_blank">PDF</a>
              <?php } ?>
            </td>

          <?php } ?>
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
            <?php echo $row["old_atmid"]; ?>
          </td>

          <td>
            <?php echo $row["ATMID_2"]; ?>
          </td>
          <td>
            <?php echo $row["ATMID_3"]; ?>
          </td>
          <!--<td><?php echo $row["ATMID_4"]; ?></td>
    <td><?php echo $row["TrackerNo"]; ?></td>-->
          <td>
            <?php echo $row["ATMShortName"]; ?>
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
            <?php echo $row["Panel_Make"]; ?>
          </td>
          <td>
            <?php echo $row["OldPanelID"]; ?>
          </td>
          <td>
            <?php echo $row["NewPanelID"]; ?>
          </td>
          <td>
            <?php echo $row["PanelIP"]; ?>
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
            <?php echo $row["Router_Model_num"]; ?>
          </td>



          <td>
            <?php echo $row["UserName"]; ?>
          </td>
          <td>
            <?php echo $row["Password"]; ?>
          </td>

          <td>
            <?php echo $row["live"]; ?>
            
            <a href="view_live_history.php?id=<?php echo $site_id; ?>&table=sites" target="_blank">View History</a>
          </td>

          <td>
            <?php echo $row["live_date"]; ?>
          </td>
          <td>
            <?php echo $row["eng_name"]; ?>
          </td>
          <?php
          $gsm = "select TwoWayNumber from esurvsites where ATM_ID='" . $row["ATMID"] . "'";
          $gsmrun = mysqli_query($conn, $gsm);
          $gsmfetch = mysqli_fetch_array($gsmrun);

          ?>


          <td>
            <?php echo $row1["CTS_Engineer_Name"]; ?>
          </td>
          <td>
            <?php echo $row1["CTS_Engineer_Number"]; ?>
          </td>




          <td>
            <?php echo $gsmfetch[0]; ?>
          </td>
        
          <td>
            <?php echo $row1["RA_QRT_NAME"]; ?>
          </td>
          <td>
            <?php echo $row1["RA_QRT_NUMBER"]; ?>
          </td>

          <td>
            <?php echo $row1["Policestation"]; ?>
          </td>
          <td>
            <?php echo $row1["Polstnname"]; ?>
          </td>

          <td>
            <?php echo $row1["firestation_name"]; ?>
          </td>
          <td>
            <?php echo $row1["firestation_number"]; ?>
          </td>

          <td>
            <?php echo $row1["atm_officer_name"]; ?>
          </td>
          <td>
            <?php echo $row1["atm_officer_number"]; ?>
          </td>

          <td>
            <?php echo $row1["atm_officer_email"]; ?>
          </td>
          <td>
            <?php echo $row1["zonal_co_ordinator_name"]; ?>
          </td>
          <td>
            <?php echo $row1["zonal_co_ordinator_number"]; ?>
          </td>
          <td>
            <?php echo $row1["zonal_co_ordinator_email"]; ?>
          </td>





          <td>
            <?php echo $row1["bank_officer_name"]; ?>
          </td>
          <td>
            <?php echo $row1["bank_officer_number"]; ?>
          </td>



          <td>
            <?php echo $row1['Bank_Officer_Email_ID']; ?>
          </td>
          <td>
            <?php echo $row1['CO_Owner_Name']; ?>
          </td>
          <td>
            <?php echo $row1['CO_Owner_Number']; ?>
          </td>
          <td>
            <?php echo $row1['CO_Owner_Email_ID']; ?>
          </td>
          <td>
            <?php echo $row1['Zonal_Name']; ?>
          </td>
          <td>
            <?php echo $row1['Zonal_Number']; ?>
          </td>
          <td>
            <?php echo $row1['Zonal_Email_ID']; ?>
          </td>





          <td>
            <?php echo $row["current_dt"]; ?>
          </td>
          <td>
            <?php echo $row["addedby"]; ?>
          </td>
          <td><a onclick="window.open('sitelogview.php?siteid=<?php echo $row[0]; ?>', '_blank', 'location=yes,height=500,width=1200,left=100,scrollbars=yes,status=yes');" style="color: red;">view</a>
            <?php echo $row["editby"]; ?>
          </td>
          <td>
            <?php echo $row["site_remark"]; ?>
          </td>


          <?php
          $brodChkAvilable = mysqli_query($conn, "select * from broadbanddetails where atmid='" . $row["ATMID"] . "' ");
          $brodChkfetch = mysqli_fetch_array($brodChkAvilable);
          ?>


          <td>
            <?php echo $row["RouterIp"]; ?>
          </td>



          <td>
            <?php if (in_array(51, $arr)) { ?>
              <a href="edit2Demo.php?atmid=<?php echo $row[0]; ?>" title="Edit" class="icon-1 info-tooltip">Edit</a>
            <?php } ?>
          </td>

          <td><a href="<?php echo $row2["files"] ?>">
              <?php
              echo
              $row2["files"] ? '<img src="' . $row2["files"] . '" height="120" width="120" download />' : 'No files';
              ?>
            </a></td>

          <td>
            <?php if (in_array(51, $arr)) { ?><a href="editwith_update.php?atmid=<?php echo $row[5]; ?>" title="Edit" class="icon-1 info-tooltip">update</a>
            <?php } ?>
            
            <?php if ($row["live"] == 'Y' || $row["live"] == 'N' || $row["live"] == 'P' || $row["live"] == 'T') { ?><span style="cursor:pointer;color:red;" onclick="transfer_site('<?php echo $row["SN"]; ?>')">Transfer Site Data</span>
            <?php } ?>
          </td>



          <?php if (($_SESSION['id'] == 24 && $row["live"] == 'Y') || ($_SESSION['id'] == 27 && $row["live"] == 'Y')) { ?>
            <td>
              <a href="gmail_attached?ids=<?php echo $row[0]; ?>" title="send" class="icon-1 info-tooltip">Send Mail</a>
            </td>
          <?php } ?>


          <td>
            <?php if ($row["live"] != "T") { ?>
              <input type="button" value="Testing" id="testing<?php echo $row[0]; ?>" name="testing<?php echo $row[0]; ?>" onclick="TestingAction1('T','<?php echo $row[0]; ?>','<?php echo $row['ATMID']; ?>')" />
            <?php } else { ?><input type="button" value="Live" id="Live<?php echo $row[0]; ?>" name="Live<?php echo $row[0]; ?>" onclick="TestingAction1('Y','<?php echo $row[0]; ?>','<?php echo $row['ATMID']; ?>')" />
            <?php } ?>
          </td>




          <td>
            <?php echo getsiminfo($row["ATMID"], 'simnnumber'); ?>
          </td>
          <td>
            <?php echo getsiminfo($row["ATMID"], 'simowner'); ?>
          </td>


          <td>
            <?php
            $get_livedatetime = get_livedatetime($row["ATMID"]);
            if (count($get_livedatetime) > 0) {
              foreach ($get_livedatetime as $key => $value) {
                echo $value . ' ' ;
              }
            } else {
              echo '';
            }
            ?>
          </td>




          <td>
            <?php
            $data = '';
            $data = get_sites_info($row["ATMID"], 'cam_ip');
            foreach ($data as $key => $value) {
              echo $value . ' ' ;
              
            }
            ?>
          </td>
          <td>
            <?php
            $data = '';
            $data = get_sites_info($row["ATMID"], 'port');
            foreach ($data as $key => $value) {
              echo $value . ' ' ;
            }
            ?>
          </td>
          <td>
            <?php
            $data = '';
            $data = get_sites_info($row["ATMID"], 'cam_name');
            foreach ($data as $key => $value) {
              echo $value . ' ' ;

            }
            ?>
          </td>





          <td>
            <?php echo $row["SiteAddress"]; ?>
          </td>

        </tr>


      <?php
        $i++;
      }
      ?>


    </table>

    </div>

    </form>
   
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