<?php  //set_time_limit(100);
ini_set('memory_limit', '256M');


include '../config.php';


$page = isset($_POST['Page']) && is_numeric($_POST['Page']) ? $_POST['Page'] : 1;
$records_per_page = isset($_POST['perpg']) && in_array($_POST['perpg'], [25, 50, 75, 100]) ? $_POST['perpg'] : 10;
$offset = ($page - 1) * $records_per_page;



$viewalert = $_POST['viewalert'];
$panelid = $_POST['panelid'];
$ATMID = $_POST['ATMID'];
$DVRIP = $_POST['DVRIP'];
$compy = $_POST['compy'];

$panelmk = $_POST['panelmak'];
$from = $_POST['from'];
$to = $_POST['to'];
$strPage = $_POST['Page'];
$fix = 670;

function endsWith($haystack, $needle)
{
    $length = strlen($needle);

    return $length === 0 ||
        (substr($haystack, -$length) === $needle);
}

if ($from != "") {
    //$newDate = date_format($date,"y/m/d H:i:s");
    $fromdt = date("Y-m-d", strtotime($from));
} else {
    $fromdt = "";
}
if ($to != "") {
    $todt = date("Y-m-d", strtotime($to));
} else {
    $todt = "";
}

$sr = 1;


if ($viewalert == "" || $viewalert == 3) {

    $abc = "SELECT  a.Customer,a.Bank,a.ATMID,a.ATMShortName,a.SiteAddress,a.DVRIP,a.Panel_make,a.zone as zon,a.City,a.State,b.id,b.panelid,b.createtime,b.receivedtime,b.comment,b.zone,b.alarm,b.closedBy,b.closedtime,b.sendip FROM sites a,`alerts` b WHERE (a.OldPanelID=b.panelid or a.NewPanelID=b.panelid) and b.`status`='C'";
} else if ($viewalert == 1) {
    $abc = "SELECT  a.Customer,a.Bank,a.ATMID,a.ATMShortName,a.SiteAddress,a.DVRIP,a.Panel_make,a.zone as zon,a.City,a.State,b.id,b.panelid,b.createtime,b.receivedtime,b.comment,b.zone,b.alarm,b.closedBy,b.closedtime,b.sendip FROM sites a,`alerts` b WHERE (a.OldPanelID=b.panelid or a.NewPanelID=b.panelid) ";

} else if ($viewalert == 2) {
    $abc = "SELECT  a.Customer,a.Bank,a.ATMID,a.ATMShortName,a.SiteAddress,a.DVRIP,a.Panel_make,a.zone as zon,a.City,a.State,b.id,b.panelid,b.createtime,b.receivedtime,b.comment,b.zone,b.alarm,b.closedBy,b.closedtime,b.sendip FROM sites a,`alerts` b WHERE (a.OldPanelID=b.panelid or a.NewPanelID=b.panelid) and b.`status`='O' ";

} else if ($viewalert == 4) {
    $abc = "SELECT  a.Customer,a.Bank,a.ATMID,a.ATMShortName,a.SiteAddress,a.DVRIP,a.Panel_make,a.zone as zon,a.City,a.State,b.id,b.panelid,b.createtime,b.receivedtime,b.comment,b.zone,b.alarm,b.closedBy,b.closedtime,b.sendip FROM sites a,`alerts` b WHERE (a.OldPanelID=b.panelid or a.NewPanelID=b.panelid) and ((b.zone='014' and a.Panel_make='smart -i') or (b.zone='015' and a.Panel_make='rass') or (b.zone='008' and a.Panel_make='sec')) ";

} else if ($viewalert == 5) {
    $abc = "SELECT  a.Customer,a.Bank,a.ATMID,a.ATMShortName,a.SiteAddress,a.DVRIP,a.Panel_make,a.zone as zon,a.City,a.State,b.id,b.panelid,b.createtime,b.receivedtime,b.comment,b.zone,b.alarm,b.closedBy,b.closedtime,b.sendip FROM sites a,`alerts` b WHERE (a.OldPanelID=b.panelid or a.NewPanelID=b.panelid) and ((b.zone='001' and a.Panel_make='smart -i') or (b.zone='029' and a.Panel_make='rass') or (b.zone='027' and a.Panel_make='sec') )  ";
    //echo $abc; 
} else if ($viewalert == 6) {
    $abc = "SELECT  a.Customer,a.Bank,a.ATMID,a.ATMShortName,a.SiteAddress,a.DVRIP,a.Panel_make,a.zone as zon,a.City,a.State,b.id,b.panelid,b.createtime,b.receivedtime,b.comment,b.zone,b.alarm,b.closedBy,b.closedtime,b.sendip FROM sites a,`alerts` b WHERE (a.OldPanelID=b.panelid or a.NewPanelID=b.panelid) and ((b.zone='008' and a.Panel_make='smart -i') or (b.zone='023' and a.Panel_make='rass') or (b.zone='021' and a.Panel_make='sec') )   ";

} else if ($viewalert == 7) {
    $abc = "SELECT  a.Customer,a.Bank,a.ATMID,a.ATMShortName,a.SiteAddress,a.DVRIP,a.Panel_make,a.zone as zon,a.City,a.State,b.id,b.panelid,b.createtime,b.receivedtime,b.comment,b.zone,b.alarm,b.closedBy,b.closedtime,b.sendip FROM sites a,`alerts` b WHERE (a.OldPanelID=b.panelid or a.NewPanelID=b.panelid) and ((b.zone='007' and a.Panel_make='smart -i') or (b.zone='003' and a.Panel_make='rass') or (b.zone='003' and a.Panel_make='sec') )   ";
    //echo $abc; 
} else if ($viewalert == 8) {
    $abc = "SELECT  a.Customer,a.Bank,a.ATMID,a.ATMShortName,a.SiteAddress,a.DVRIP,a.Panel_make,a.zone as zon,a.City,a.State,b.id,b.panelid,b.createtime,b.receivedtime,b.comment,b.zone,b.alarm,b.closedBy,b.closedtime,b.sendip FROM sites a,`alerts` b WHERE (a.OldPanelID=b.panelid or a.NewPanelID=b.panelid) and ((b.zone='002' and a.Panel_make='smart -i') or (b.zone='030' and a.Panel_make='rass') or (b.zone='028' and a.Panel_make='sec') )   ";
    //echo $abc; 
} else if ($viewalert == 9) {
    $abc = "SELECT  a.Customer,a.Bank,a.ATMID,a.ATMShortName,a.SiteAddress,a.DVRIP,a.Panel_make,a.zone as zon,a.City,a.State,b.id,b.panelid,b.createtime,b.receivedtime,b.comment,b.zone,b.alarm,b.closedBy,b.closedtime,b.sendip FROM sites a,`alerts` b WHERE (a.OldPanelID=b.panelid or a.NewPanelID=b.panelid) and ((b.zone='998' and a.Panel_make='rass'))   ";
    //echo $abc; 
}
//$result=mysqli_query($conn,$abc);
else if ($viewalert == 10) {
    $abc = "SELECT  a.Customer,a.Bank,a.ATMID,a.ATMShortName,a.SiteAddress,a.DVRIP,a.Panel_make,a.zone as zon,a.City,a.State,b.id,b.panelid,b.createtime,b.receivedtime,b.comment,b.zone,b.alarm,b.closedBy,b.closedtime,b.sendip FROM sites a,`alerts` b WHERE (a.OldPanelID=b.panelid or a.NewPanelID=b.panelid) and ((b.zone='004' and a.Panel_make='rass') or (b.zone='004' and a.Panel_make='sec') or (b.zone='015' and a.Panel_make='smart -i'))  ";
    //echo $abc; 
} else if ($viewalert == 11) {
    $abc = "SELECT  a.Customer,a.Bank,a.ATMID,a.ATMShortName,a.SiteAddress,a.DVRIP,a.Panel_make,a.zone as zon,a.City,a.State,b.id,b.panelid,b.createtime,b.receivedtime,b.comment,b.zone,b.alarm,b.closedBy,b.closedtime,b.sendip FROM sites a,`alerts` b WHERE (a.OldPanelID=b.panelid or a.NewPanelID=b.panelid) and ((b.zone='024' or b.zone='026' and a.Panel_make='rass') or (b.zone='022' and a.Panel_make='smart -i'))  ";
    //echo $abc; 
} else if ($viewalert == 12) {
    $abc = "SELECT  a.Customer,a.Bank,a.ATMID,a.ATMShortName,a.SiteAddress,a.DVRIP,a.Panel_make,a.zone as zon,a.City,a.State,b.id,b.panelid,b.createtime,b.receivedtime,b.comment,b.zone,b.alarm,b.closedBy,b.closedtime,b.sendip FROM sites a,`alerts` b WHERE (a.OldPanelID=b.panelid or a.NewPanelID=b.panelid) and ((b.zone='025' and a.Panel_make='rass') or (b.zone='013' and a.Panel_make='sec') or (b.zone='017' and a.Panel_make='smart -i'))  ";
    //echo $abc; 
} else if ($viewalert == 13) {
    $abc = "SELECT  a.Customer,a.Bank,a.ATMID,a.ATMShortName,a.SiteAddress,a.DVRIP,a.Panel_make,a.zone as zon,a.City,a.State,b.id,b.panelid,b.createtime,b.receivedtime,b.comment,b.zone,b.alarm,b.closedBy,b.closedtime,b.sendip FROM sites a,`alerts` b WHERE (a.OldPanelID=b.panelid or a.NewPanelID=b.panelid) and ((b.zone='006' and a.Panel_make='rass') or (b.zone='006' and a.Panel_make='sec') or (b.zone='011' and a.Panel_make='smart -i'))  ";
    //echo $abc; 
} else if ($viewalert == 14) {
    $abc = "SELECT  a.Customer,a.Bank,a.ATMID,a.ATMShortName,a.SiteAddress,a.DVRIP,a.Panel_make,a.zone as zon,a.City,a.State,b.id,b.panelid,b.createtime,b.receivedtime,b.comment,b.zone,b.alarm,b.closedBy,b.closedtime,b.sendip FROM sites a,`alerts` b WHERE (a.OldPanelID=b.panelid or a.NewPanelID=b.panelid) and ((b.zone='013' and a.Panel_make='rass') or (b.zone='007' and a.Panel_make='sec') or (b.zone='013' and a.Panel_make='smart -i'))  ";
    //echo $abc; 
} else if ($viewalert == 15) {
    $abc = "SELECT  a.Customer,a.Bank,a.ATMID,a.ATMShortName,a.SiteAddress,a.DVRIP,a.Panel_make,a.zone as zon,a.City,a.State,b.id,b.panelid,b.createtime,b.receivedtime,b.comment,b.zone,b.alarm,b.closedBy,b.closedtime,b.sendip FROM sites a,`alerts` b WHERE (a.OldPanelID=b.panelid or a.NewPanelID=b.panelid) and ((b.zone='009' and a.Panel_make='rass') or (b.zone='005' and a.Panel_make='sec') or (b.zone='012' and a.Panel_make='smart -i'))  ";
    //echo $abc; 
} else if ($viewalert == 16) {
    $abc = "SELECT  a.Customer,a.Bank,a.ATMID,a.ATMShortName,a.SiteAddress,a.DVRIP,a.Panel_make,a.zone as zon,a.City,a.State,b.id,b.panelid,b.createtime,b.receivedtime,b.comment,b.zone,b.alarm,b.closedBy,b.closedtime,b.sendip FROM sites a,`alerts` b WHERE (a.OldPanelID=b.panelid or a.NewPanelID=b.panelid) and ((b.zone='002' and a.Panel_make='rass') or (b.zone='002' and a.Panel_make='sec') or (b.zone='010' and a.Panel_make='smart -i'))  ";
    //echo $abc; 
} else if ($viewalert == 17) {
    $abc = "SELECT  a.Customer,a.Bank,a.ATMID,a.ATMShortName,a.SiteAddress,a.DVRIP,a.Panel_make,a.zone as zon,a.City,a.State,b.id,b.panelid,b.createtime,b.receivedtime,b.comment,b.zone,b.alarm,b.closedBy,b.closedtime,b.sendip FROM sites a,`alerts` b WHERE (a.OldPanelID=b.panelid or a.NewPanelID=b.panelid) and ((b.zone='001' and a.Panel_make='rass') or (b.zone='001' and a.Panel_make='sec') or (b.zone='009' and a.Panel_make='smart -i'))  ";
    //echo $abc; 
} else if ($viewalert == 18) {
    $abc = "SELECT  a.Customer,a.Bank,a.ATMID,a.ATMShortName,a.SiteAddress,a.DVRIP,a.Panel_make,a.zone as zon,a.City,a.State,b.id,b.panelid,b.createtime,b.receivedtime,b.comment,b.zone,b.alarm,b.closedBy,b.closedtime,b.sendip FROM sites a,`alerts` b WHERE (a.OldPanelID=b.panelid or a.NewPanelID=b.panelid) and ((b.zone='004' and a.Panel_make='smart -i') or (b.zone='100' and a.Panel_make='sec') )  ";
    //echo $abc; 
} else if ($viewalert == 19) {
    $abc = "SELECT  a.Customer,a.Bank,a.ATMID,a.ATMShortName,a.SiteAddress,a.DVRIP,a.Panel_make,a.zone as zon,a.City,a.State,b.id,b.panelid,b.createtime,b.receivedtime,b.comment,b.zone,b.alarm,b.closedBy,b.closedtime,b.sendip FROM sites a,`alerts` b WHERE (a.OldPanelID=b.panelid or a.NewPanelID=b.panelid) and ((b.zone='011' and a.Panel_make='rass') or (b.zone='041' and a.Panel_make='sec') or (b.zone='059' and a.Panel_make='smart -i'))  ";
    //echo $abc; 
}

if (!empty($_REQUEST['panelid'])) {
    $panelid = $_REQUEST['ATMID'];
    $abc .= "AND b.panelid LIKE '%$panelid%' ";

}


if (!empty($_REQUEST['ATMID'])) {
    $ATMID = $_REQUEST['ATMID'];
    $abc .= "AND a.ATMID LIKE '%$ATMID%' ";

}

if (!empty($_REQUEST['DVRIP'])) {
    $DVRIP = $_REQUEST['DVRIP'];
    $abc .= "AND a.DVRIP LIKE '%$DVRIP%' ";

}

if (!empty($_REQUEST['compy'])) {
    $compy = $_REQUEST['compy'];
    $abc .= "AND a.Customer LIKE '%$compy%' ";
}

if (!empty($_REQUEST['panelmak'])) {
    $panelmk = $_REQUEST['compy'];
    $abc .= "AND a.Panel_Make LIKE '%$panelmk%' ";
}


$abc .= " and a.live='Y' and sendtoclient='S'";


if (!empty($_REQUEST['from']) && !empty($_REQUEST['to'])) {
    $fromdt = $_REQUEST['from'];
    $todt = $_REQUEST['to'];
    $abc .= " and b.receivedtime between '" . $fromdt . " 00:00:00' and '" . $todt . " 23:59:59' ";

} else if (!empty($_REQUEST['from'])) {
    $fromdt = $_REQUEST['from'];

    $abc .= " and b.receivedtime='" . $fromdt . "'";

} else if (!empty($_REQUEST['to'])) {
    $todt = $_REQUEST['to'];
    $abc .= " and receivedtime='" . $todt . "'";

} else {
    $fromdt = date('Y-m-d 00:00:00');
    $todt = date('Y-m-d 23:59:59');
    $abc .= " and b.receivedtime between '" . $fromdt . "' and '" . $todt . "'";

}


$abc .= " order by receivedtime desc ";

$withoutLimitsql = $abc;
$sqlCount = mysqli_query($con, $abc);
$total_records = mysqli_num_rows($sqlCount);

$abc .= " LIMIT $offset, $records_per_page";
$result = mysqli_query($con, $abc);


?>

<style>
    th,
    td {
        white-space: nowrap;
    }
</style>

<div class="total_n_export" id="tabletop" style="display: flex;
    justify-content: space-between;">

    <h6 class="mb-0 text-uppercase">Total Records : <?php echo $total_records; ?> </h6>

    <form action="./exportrecords_viewalert.php">
        <input type="hidden" name="exportsql" value="<?php echo $withoutLimitsql; ?>">
        <button type="submit" class="btn btn-outline-info btn-sm px-5 radius-30"><i
                class="bx bx-cloud-download mr-1"></i>Export</button>
    </form>

</div>


<hr>




<div class="records">
    <table id="tabletop" border=1 style="margin-top:30px" class="table mb-0 table-bordered table-hover">
        <thead class="table-dark">

            <tr>
                <!--<th>sr</th>-->
                <th>Client Name</th>
                <th> Incident Number</th>
                <th>Region</th>
                <!--<th>Circle</th>
      <th>Location</th>-->




                <th>ATMID</th>
                <th style="white-space: nowrap;">Address</th>
                <th>City</th>
                <th>State</th>
                <th>Zone</th>
                <th>Alarm</th>

                <th>Incident Category</th>
                <th>Alarm Message</th>
                <th>Incident Date Time</th>
                <th>Alarm Received Date Time</th>
                <th> Close Date Time</th>
                <th>DVRIP</th>
                <th>Panel_make</th>
                <th>panelid</th>


                <th>Bank</th>
                <!--<th>comment</th>-->
                <th>Reactive</th>
                <th>Closed By</th>
                <th>Closed Date</th>
                <th>Remark</th>
                <th>Send Ip</th>
                <th>TestingByServiceTeam</th>
                <th>Testing Remark</th>


            </tr>
        </thead>

        <?php while ($row = mysqli_fetch_array($result)) {

            $incident_query = mysqli_query($conn, "select TestingByService,remark from Testing_alertDetails where incident_id='" . $row["id"] . "' ");
            $incident_fetch = mysqli_fetch_array($incident_query);





            ?>

            <tr style="background-color:#cfe8c7">
                <!--<td><?php echo $sr; ?></td>-->
                <td><?php echo $row["Customer"]; ?></td>
                <td><?php echo $row["id"]; ?></td>
                <td><?php echo $row["zon"]; ?></td>
                <!-- <td><?php echo $row["City"] . "," . $row["State"]; ?></td>
     <td><?php echo $row["ATMShortName"]; ?></td>-->
                <td><?php echo $row["ATMID"]; ?></td>
                <td style="white-space: nowrap;"><?php echo $row["SiteAddress"]; ?></td>
                <td><?php echo $row["City"]; ?></td>
                <td><?php echo $row["State"]; ?></td>
                <td><?php echo $row["zone"]; ?></td>
                <td><?php echo $row["alarm"]; ?></td>

                <?php
                $dtconvt = $row["receivedtime"];
                $timestamp = strtotime($dtconvt);
                $newDate = date('d-F-Y', $timestamp);

                // echo $row["Panel_make"] . '<br />';


                // if ($row["Panel_make"] == "securico_hdfceuronet") {
                //     $sql1 = "select SensorName as Description,Camera from securico_hdfceuronet where (Zone='" . $row["zone"] . "' and SCODE='" . $row['alarm'] . "')";
                // } else if ($row["Panel_make"] == "mspl_hdfcadvait32") {
                //     $sql1 = "select SensorName as Description,Camera from mspl_hdfcadvait32 where (Zone='" . $row["zone"] . "' and SCODE='" . $row['alarm'] . "')";
                // } else if ($row["Panel_make"] == "mspl_idfceuronetadvait32") {
                //     $sql1 = "select SensorName as Description,Camera from mspl_idfceuronetadvait32 where (Zone='" . $row["zone"] . "' and SCODE='" . $row['alarm'] . "')";
                // } else if ($row["Panel_make"] == "rass_hdfceuronetsap500") {
                //     $sql1 = "select SensorName as Description,Camera from rass_hdfceuronetsap500 where (Zone='" . $row["zone"] . "' and SCODE='" . $row['alarm'] . "')";
                // } else if ($row["Panel_make"] == "rass_india1sap500") {
                //     $sql1 = "select SensorName as Description,Camera from rass_india1sap500 where (Zone='" . $row["zone"] . "' and SCODE='" . $row['alarm'] . "')";
                // } else if ($row["Panel_make"] == "RAXX_32Z-G1") {
                //     $sql1 = "select SensorName as Description,Camera from RAXX_32Z-G1 where (Zone='" . $row["zone"] . "' and SCODE='" . $row['alarm'] . "')";
                // } else if ($row["Panel_make"] == "raxx_ccil32zg1") {
                //     $sql1 = "select SensorName as Description,Camera from raxx_ccil32zg1 where (Zone='" . $row["zone"] . "' and SCODE='" . $row['alarm'] . "')";
                // } else if ($row["Panel_make"] == "raxx_ccilrtaapg1v2") {
                //     $sql1 = "select SensorName as Description,Camera from raxx_ccilrtaapg1v2 where (Zone='" . $row["zone"] . "' and SCODE='" . $row['alarm'] . "')";
                // } else if ($row["Panel_make"] == "raxx_hdfceuronet32zg1") {
                //     $sql1 = "select SensorName as Description,Camera from raxx_hdfceuronet32zg1 where (Zone='" . $row["zone"] . "' and SCODE='" . $row['alarm'] . "')";
                // } else if ($row["Panel_make"] == "raxx_india132zg1") {
                //     $sql1 = "select SensorName as Description,Camera from raxx_india132zg1 where (Zone='" . $row["zone"] . "' and SCODE='" . $row['alarm'] . "')";
                // } else if ($row["Panel_make"] == "raxx_india1rtaapg1v2") {
                //     $sql1 = "select SensorName as Description,Camera from raxx_india1rtaapg1v2 where (Zone='" . $row["zone"] . "' and SCODE='" . $row['alarm'] . "')";
                // } else if ($row["Panel_make"] == "raxx_kotakeuronet32zg1") {
                //     $sql1 = "select SensorName as Description,Camera from raxx_kotakeuronet32zg1 where (Zone='" . $row["zone"] . "' and SCODE='" . $row['alarm'] . "')";
                // } else if ($row["Panel_make"] == "RT-AAP-G1(V2)") {
                //     $sql1 = "select SensorName as Description,Camera from RT-AAP-G1(V2) where (Zone='" . $row["zone"] . "' and SCODE='" . $row['alarm'] . "')";
                // } else if ($row["Panel_make"] == "SEC-GX4816") {
                //     $sql1 = "select SensorName as Description,Camera from SEC-GX4816 where (Zone='" . $row["zone"] . "' and SCODE='" . $row['alarm'] . "')";
                // } else if ($row["Panel_make"] == "securico_ccil") {
                //     $sql1 = "select SensorName as Description,Camera from securico_ccil where (Zone='" . $row["zone"] . "' and SCODE='" . $row['alarm'] . "')";
                // } else if ($row["Panel_make"] == "securico_cnspoc") {
                //     $sql1 = "select SensorName as Description,Camera from securico_cnspoc where (Zone='" . $row["zone"] . "' and SCODE='" . $row['alarm'] . "')";
                // } else if ($row["Panel_make"] == "securico_gx4816") {
                //     $sql1 = "select SensorName as Description,Camera from securico_gx4816 where (Zone='" . $row["zone"] . "' and SCODE='" . $row['alarm'] . "')";
                // } else if ($row["Panel_make"] == "securico_kjsb") {
                //     $sql1 = "select SensorName as Description,Camera from securico_kjsb where (Zone='" . $row["zone"] . "' and SCODE='" . $row['alarm'] . "')";
                // } else if ($row["Panel_make"] == "SMART-I(04)") {
                //     $sql1 = "select SensorName as Description,Camera from SMART-I(04) where (Zone='" . $row["zone"] . "' and SCODE='" . $row['alarm'] . "')";
                // } else if ($row["Panel_make"] == "SMART-I(16)") {
                //     $sql1 = "select SensorName as Description,Camera from SMART-I(16) where (Zone='" . $row["zone"] . "' and SCODE='" . $row['alarm'] . "')";
                // } else if ($row["Panel_make"] == "SMART-I(32)") {
                //     $sql1 = "select SensorName as Description,Camera from SMART-I(32) where (Zone='" . $row["zone"] . "' and SCODE='" . $row['alarm'] . "')";
                // } else if ($row["Panel_make"] == "smarti_advaithdfc32") {
                //     $sql1 = "select SensorName as Description,Camera from smarti_advaithdfc32 where (Zone='" . $row["zone"] . "' and SCODE='" . $row['alarm'] . "')";
                // } else if ($row["Panel_make"] == "smarti_ccil16") {
                //     $sql1 = "select SensorName as Description,Camera from smarti_ccil16 where (Zone='" . $row["zone"] . "' and SCODE='" . $row['alarm'] . "')";
                // } else if ($row["Panel_make"] == "smarti_cnspoc32") {
                //     $sql1 = "select SensorName as Description,Camera from smarti_cnspoc32 where (Zone='" . $row["zone"] . "' and SCODE='" . $row['alarm'] . "')";
                // } else if ($row["Panel_make"] == "smarti_hdfcadvait24") {
                //     $sql1 = "select SensorName as Description,Camera from smarti_hdfcadvait24 where (Zone='" . $row["zone"] . "' and SCODE='" . $row['alarm'] . "')";
                // } else if ($row["Panel_make"] == "smarti_hdfcadvaitgam24") {
                //     $sql1 = "select SensorName as Description,Camera from smarti_hdfcadvaitgam24 where (Zone='" . $row["zone"] . "' and SCODE='" . $row['alarm'] . "')";
                // } else if ($row["Panel_make"] == "smarti_hdfcadvaitgam32") {
                //     $sql1 = "select SensorName as Description,Camera from smarti_hdfcadvaitgam32 where (Zone='" . $row["zone"] . "' and SCODE='" . $row['alarm'] . "')";
                // } else if ($row["Panel_make"] == "smarti_hdfceuronet32") {
                //     $sql1 = "select SensorName as Description,Camera from smarti_hdfceuronet32 where (Zone='" . $row["zone"] . "' and SCODE='" . $row['alarm'] . "')";
                // } else if ($row["Panel_make"] == "smarti_idfceuronet32") {
                //     $sql1 = "select SensorName as Description,Camera from smarti_idfceuronet32 where (Zone='" . $row["zone"] . "' and SCODE='" . $row['alarm'] . "')";
                // } else if ($row["Panel_make"] == "smarti_idfceuronetadvait24") {
                //     $sql1 = "select SensorName as Description,Camera from smarti_idfceuronetadvait24 where (Zone='" . $row["zone"] . "' and SCODE='" . $row['alarm'] . "')";
                // } else if ($row["Panel_make"] == "smarti_idfceuronetadvaitgam24") {
                //     $sql1 = "select SensorName as Description,Camera from smarti_idfceuronetadvaitgam24 where (Zone='" . $row["zone"] . "' and SCODE='" . $row['alarm'] . "')";
                // } else if ($row["Panel_make"] == "smarti_idfceuronetadvaitgam32v3") {
                //     $sql1 = "select SensorName as Description,Camera from smarti_idfceuronetadvaitgam32v3 where (Zone='" . $row["zone"] . "' and SCODE='" . $row['alarm'] . "')";
                // } else if ($row["Panel_make"] == "smarti_kjsb32") {
                //     $sql1 = "select SensorName as Description,Camera from smarti_kjsb32 where (Zone='" . $row["zone"] . "' and SCODE='" . $row['alarm'] . "')";
                // } 
                
                // else if ($row["Panel_make"] == "smarti_kotakeuronet32") {
                //     $sql1 = "select SensorName as Description,Camera from smarti_kotakeuronet32 where (Zone='" . $row["zone"] . "' and SCODE='" . $row['alarm'] . "')";
                // } 
                
                // else if ($row["Panel_make"] == "smarti_kotakeuronetadvaitgam24") {
                //     $sql1 = "select SensorName as Description,Camera from smarti_kotakeuronetadvaitgam24 where (Zone='" . $row["zone"] . "' and SCODE='" . $row['alarm'] . "')";
                // } 
                
                // else if ($row["Panel_make"] == "smarti_kotakeuronetadvaitgam32") {
                //     $sql1 = "select SensorName as Description,Camera from smarti_kotakeuronetadvaitgam32 where (Zone='" . $row["zone"] . "' and SCODE='" . $row['alarm'] . "')";
                // } 
                
                
                // else if ($row["Panel_make"] == "SMART -I") {
                //     $sql1 = "select SensorName as Description,Camera from smarti where (Zone='" . $row["zone"] . "' and SCODE='" . $row['alarm'] . "')";
                // } 
                
                // else if ($row["Panel_make"] == "SMART-IN") {
                //     $sql1 = "select SensorName as Description,Camera from smartinew where (Zone='" . $row["zone"] . "' and SCODE='" . $row['alarm'] . "')";
                // } else if ($row["Panel_make"] == "SEC") {
                //     $sql1 = "select sensorname as Description,camera from securico where (Zone='" . $row["zone"] . "' and SCODE='" . $row['alarm'] . "')";
                // } else if ($row["Panel_make"] == "sec_sbi") {
                //     $sql1 = "select SensorName as Description,Camera from sec_sbi where (Zone='" . $row["zone"] . "' and SCODE='" . $row['alarm'] . "')";
                // } else if ($row["Panel_make"] == "RASS") {
                //     $sql1 = "select SensorName as Description,Camera from rass where (Zone='" . $row["zone"] . "' and SCODE='" . $row['alarm'] . "')";
                // } else if ($row["Panel_make"] == "rass_sbi") {
                //     $sql1 = "select SensorName as Description,Camera from rass_sbi where (Zone='" . $row["zone"] . "' and SCODE='" . $row['alarm'] . "')";
                // } else if ($row["Panel_make"] == "rass_cloud") {
                //     $sql1 = "select SensorName as Description,Camera from rass_cloud where (Zone='" . $row["zone"] . "' and SCODE='" . $row['alarm'] . "')";
                // } else if ($row["Panel_make"] == "Raxx") {
                //     $sql1 = "select SensorsName as Description,Camera from raxx where ZoneNumber='" . $row["zone"] . "' ";
                // } else if ($row["Panel_make"] == "securico_gx4816") {
                //     $sql1 = "select sensorname as Description,camera from securico_gx4816 where zone='" . $row["zone"] . "' ";
                // }

                $panelmake = $row["Panel_make"];

                $alram_sql = mysqli_query($con, "select * from $panelmake where (Zone='" . $row["zone"] . "' and 
                SCODE='" . $row['alarm'] . "')");
                $result1 = mysqli_fetch_assoc($alram_sql);
            
                if (endsWith($row["alarm"], "R")) {
                    $ds = $result1["SensorName"] . ' Restoral';
                } else {
                    $ds = $result1["SensorName"];
                }



                // echo $sql1;
                $result1 = mysqli_query($conn, $sql1);
                $row1 = mysqli_fetch_array($result1);
                ?>



                <td><?php echo $ds; ?></td>
                <td><?php if (endsWith($row["alarm"], "R"))
                    echo $ds . ' Restoral';
                else
                    echo $ds; ?>
                </td>
                <td><?php echo $row["createtime"]; ?></td>
                <td><?php echo $row["receivedtime"]; ?></td>
                <td><?php echo $newDate; ?></td>
                <td><?php echo $row["DVRIP"]; ?></td>
                <td><?php echo $row["Panel_make"]; ?></td>
                <td><?php echo $row["panelid"]; ?></td>
                <td><?php echo $row["Bank"]; ?></td>
                <!--<td><?php echo $row["comment"]; ?></td>-->
                <td><?php if (endsWith($row["alarm"], "R"))
                    echo 'Non-Reactive';
                else
                    echo 'Reactive'; ?></td>
                <td><?php echo $row["closedBy"]; ?></td>
                <td><?php echo $row["closedtime"]; ?></td>
                <td><?php echo $row["comment"]; ?></td>
                <td><?php echo $row["sendip"]; ?></td>
                <td><?php echo $incident_fetch["TestingByService"]; ?></td>
                <td><?php echo $incident_fetch["remark"]; ?></td>
            </tr>

            <?php $sr++;
        } ?>



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