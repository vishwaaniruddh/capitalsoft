<?php include('../config.php');
function startsWith($string, $startString)
{
    $len = strlen($startString);
    return (substr($string, 0, $len) === $startString);
}

function getPanelName($atmid, $con)
{
    //global $con;
    //$con = OpenCon();
    $sql = mysqli_query($con, "select Panel_Make from sites where ATMID='" . $atmid . "'");
    $sql_result = mysqli_fetch_assoc($sql);
    //CloseCon($con);
    return $sql_result['Panel_Make'];
}

function getrass($zone, $paramater, $atmid, $con)
{
    //global $con;
    //$con = OpenCon();
    $panel_name = getPanelName($atmid, $con);
    $paramater = 'SensorName';
    $sql = "";
    $_change = 0;
    if ($panel_name == 'comfort') {
        $sql = mysqli_query($con, "select $paramater,SCODE from comfort where ZONE='" . $zone . "'");
    }
    if ($panel_name == 'rass_boi') {
        $sql = mysqli_query($con, "select $paramater,SCODE from rass_boi where ZONE='" . $zone . "'");
    }
    if ($panel_name == 'rass_pnb') {
        $sql = mysqli_query($con, "select $paramater,SCODE from rass_pnb where ZONE='" . $zone . "'");
    }
    if ($panel_name == 'smarti_boi') {
        $sql = mysqli_query($con, "select $paramater,SCODE from smarti_boi where ZONE='" . $zone . "'");
    }
    if ($panel_name == 'smarti_pnb') {
        $sql = mysqli_query($con, "select $paramater,SCODE from smarti_pnb where ZONE='" . $zone . "'");
    }
    if ($panel_name == 'RASS') {
        $sql = mysqli_query($con, "select $paramater,SCODE from rass where ZONE='" . $zone . "' AND status=0");
    }
    if ($panel_name == 'rass_cloud') {
        $sql = mysqli_query($con, "select $paramater,SCODE from rass_cloud where ZONE='" . $zone . "' AND status=0");
    }
    if ($panel_name == 'rass_cloudnew') {
        $sql = mysqli_query($con, "select $paramater from rass_cloudnew where ZONE='" . $zone . "' AND status=0");
    }
    if ($panel_name == 'rass_sbi') {
        $sql = mysqli_query($con, "select $paramater,SCODE from rass_sbi where ZONE='" . $zone . "' AND status=0");
    }
    if ($panel_name == 'SEC') {
        $sql = mysqli_query($con, "select $paramater,SCODE from securico where ZONE='" . $zone . "' AND status=0");
    }
    if ($panel_name == 'securico_gx4816') {
        $sql = mysqli_query($con, "select $paramater,SCODE from securico_gx4816 where ZONE='" . $zone . "' AND status=0");
    }
    if ($panel_name == 'sec_sbi') {
        $sql = mysqli_query($con, "select $paramater,SCODE from sec_sbi where ZONE='" . $zone . "' AND status=0");
    }
    if ($panel_name == 'Raxx') {
        $sql = mysqli_query($con, "select $paramater,SCODE from raxx where ZONE='" . $zone . "' AND status=0");
    }
    if ($panel_name == 'SMART -I') {
        $sql = mysqli_query($con, "select $paramater,SCODE from smarti where ZONE='" . $zone . "' AND status=0");
    }
    if ($panel_name == 'SMART-IN') {
        $sql = mysqli_query($con, "select $paramater,SCODE from smartinew where ZONE='" . $zone . "' AND status=0");
    }
    if ($sql == "") {
        $return = "";
    } else {
        if (mysqli_num_rows($sql) > 0) {
            $sql_result = mysqli_fetch_assoc($sql);
            $alarm = $sql_result['SCODE'];
            if ($_change == 1) {
                if ($panel_name == 'comfort') {

                    if (substr($alarm, -1) == 'R' || substr($alarm, -1) == 'N') {
                        $return = $sql_result[$paramater] . " Restoral";
                    }
                } else {
                    if (substr($alarm, -1) == 'R') {
                        $return = $sql_result[$paramater] . " Restoral";
                    }
                }

            } else {
                $return = $sql_result[$paramater];
            }
        } else {
            $return = "";
        }

    }
    return $return;
}
/*
function getrass($zone){
    global $con;

    $sql = mysqli_query($con,"select * from rass_cloudnew where ZONE='".$zone."'");
    $sql_result = mysqli_fetch_assoc($sql);

    return $sql_result['SensorName'];
}
*/
function getrassstatus($paramater, $atmid, $con)
{
    //global $con;
    //$con = OpenCon();
    $sql = mysqli_query($con, "select $paramater from panel_health_api_response where atmid='" . $atmid . "'");
    if (mysqli_num_rows($sql)) {
        $sql_result = mysqli_fetch_assoc($sql);
        $return_data = $sql_result[$paramater];
    } else {
        $return_data = '';
    }
    // CloseCon($con);
    return $return_data;
}


$atmid = $_GET['atmid'];


$sitessql = mysqli_query($con, "select ATMID_2,State,City,SiteAddress from sites where atmid = '" . $atmid . "' ");
if (mysqli_num_rows($sitessql) > 0) {
    $sites_result = mysqli_fetch_row($sitessql);
    $atmid2 = $sites_result[0];
    $state = $sites_result[1];
    $city = $sites_result[2];
    $address = $sites_result[3];
}





// $atmid  = 'P3ENPN28';
// echo "select * from health_check_report where atmid='" . $atmid . "'" ;
$sql = mysqli_query($con, "select * from health_check_report where atmid='" . $atmid . "'");
if (!$sql || mysqli_num_rows($sql) == 0) { ?>
    <span>No Data Found</span>
<?php } else {
    $sql_result = mysqli_fetch_assoc($sql);
  
    ?>

    <div class="table-responsive">
        <table id="order-listing" class="table">
            <thead>
                <tr>
                    <th>ATMID</th>
                    <th>ATMID 2</th>
                    <th>State</th>
                    <th>City</th>
                    <th>Location Name</th>
                    <th>Main Panel Functional (Y/N)</th>
                    <th>DVR (W/NW)</th>
                    <th>Hard Disk Status (W/NW)</th>
                    <th>Footage Start DateTime</th>
                    <th>Footage Stop DateTime</th>
                    <th>Days</th>
                    <th>ATM Lobby Camera</th>
                    <th>Backroom Camera</th>
                    <th>Outside Camera</th>
                    <th>All Sensors (W/NW)</th>
                    <th>Panic Alarm Switch</th>
                    <th>Hooter</th>
                    <th>Two-Way Communication</th>
                    <th>Smoke Detector</th>
                    <th>Glass Break Sensor</th>
                    <th>backroom Door Keypad</th>
                    <th>ATM Removal Sensor</th>
                    <th>Vibration Sensor</th>
                    <th>Hood Sensor</th>
                    <th>Chest Door Open Sensor</th>
                    <th>ATM Thermal Sensor</th>
                    <th>PIR Sensor(Pet Immune)</th>
                    <th>Speaker Mic Removal</th>
                    <th>AC Removal</th>
                    <th>Lobby Temperature Sensor</th>
                    <th>EM Lock</th>
                    <th>Ageing</th>
                    <th>Remark,if any</th>
                    <th>120 days footage not available remark</th>
                    <th>Vendor</th>
                    <th>Bank</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <?php echo $atmid; ?>
                    </td>
                    <td>
                        <?= $atmid2 ?>
                    </td>
                    <td>
                        <?= $state ?>
                    </td>
                    <td>
                        <?= $city ?>
                    </td>
                    <td>
                        <?= $address ?>
                    </td>
                    <td>
                        <?= $sql_result['Main_Panel'] ?>
                    </td>
                    <td>
                        <?= $sql_result['DVR'] ?>
                    </td>
                    <td>
                        <?= $sql_result['hard_disk_status'] ?>
                    </td>
                    <td>
                        <?= $sql_result['footage_start_dt'] ?>
                    </td>
                    <td>
                        <?= $sql_result['footage_stop_dt'] ?>
                    </td>
                    <td>
                        <?= $sql_result['days'] ?>
                    </td>
                    <td>
                        <?= $sql_result['atm_lobby_cam'] ?>
                    </td>
                    <td>
                        <?= $sql_result['backroom_cam'] ?>
                    </td>
                    <td>
                        <?= $sql_result['outside_cam'] ?>
                    </td>
                    <td>
                        <?= $sql_result['all_sensor'] ?>
                    </td>
                    <td>
                        <?= $sql_result['panic_alarm_switch'] ?>
                    </td>
                    <td>
                        <?= $sql_result['hooter'] ?>
                    </td>
                    <td>
                        <?= $sql_result['two_way_communication'] ?>
                    </td>
                    <td>
                        <?= $sql_result['smoke_detector'] ?>
                    </td>
                    <td>
                        <?= $sql_result['glass_break'] ?>
                    </td>
                    <td>
                        <?= $sql_result['backroom_door'] ?>
                    </td>
                    <td>
                        <?= $sql_result['atm_removal'] ?>
                    </td>
                    <td>
                        <?= $sql_result['vibration'] ?>
                    </td>
                    <td>
                        <?= $sql_result['hood'] ?>
                    </td>
                    <td>
                        <?= $sql_result['chestdoor_open'] ?>
                    </td>
                    <td>
                        <?= $sql_result['atm_thermal'] ?>
                    </td>
                    <td>
                        <?= $sql_result['pir'] ?>
                    </td>
                    <td>
                        <?= $sql_result['speaker_mic'] ?>
                    </td>
                    <td>
                        <?= $sql_result['ac_removal'] ?>
                    </td>
                    <td>
                        <?= $sql_result['lobby_temp'] ?>
                    </td>
                    <td>
                        <?= $sql_result['em_lock'] ?>
                    </td>
                    <td>
                        <?= $sql_result['ageing'] ?>
                    </td>
                    <td>
                        <?= $sql_result['remark'] ?>
                    </td>
                    <td>
                        <?= $sql_result['120_days_footage_not_available_remark'] ?>
                    </td>
                    <td>
                        <?= $sql_result['vendor'] ?>
                    </td>
                    <td>
                        <?= $sql_result['bank'] ?>
                    </td>






                </tr>
            </tbody>
        </table>
    </div>

<?php }
CloseCon($con); ?>