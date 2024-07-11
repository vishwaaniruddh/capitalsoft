<?php include ('../config.php');
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


function get_sensor_name($zone, $panelname, $con, $alarm)
{
    $panel_name = $panelname;
    $paramater = 'SensorName';
    $sql = "";
    $_change = 0;
    if ($panel_name == 'smarti_hdfc32') {
        if (substr($alarm, -1) == 'R' || substr($alarm, -1) == 'N') {
            $_change = 1;
            $remain_char = substr($alarm, 0, -1);
            $sql = mysqli_query($con, "select $paramater from comfort where ZONE='" . $zone . "' AND SCODE LIKE '" . $remain_char . "%'");
        } else {
            $sql = mysqli_query($con, "select $paramater from comfort where ZONE='" . $zone . "' AND SCODE='" . $alarm . "'");
        }
    }
    if ($panel_name == 'comfort') {
        if (substr($alarm, -1) == 'R' || substr($alarm, -1) == 'N') {
            $_change = 1;
            $remain_char = substr($alarm, 0, -1);
            $sql = mysqli_query($con, "select $paramater from comfort where ZONE='" . $zone . "' AND SCODE LIKE '" . $remain_char . "%'");
        } else {
            $sql = mysqli_query($con, "select $paramater from comfort where ZONE='" . $zone . "' AND SCODE='" . $alarm . "'");
        }
    }
    if ($panel_name == 'comfort_hdfc') {
        if (substr($alarm, -1) == 'R' || substr($alarm, -1) == 'N') {
            $_change = 1;
            $remain_char = substr($alarm, 0, -1);
            $sql = mysqli_query($con, "select $paramater from comfort_hdfc where ZONE='" . $zone . "' AND SCODE LIKE '" . $remain_char . "%'");
        } else {
            $sql = mysqli_query($con, "select $paramater from comfort_hdfc where ZONE='" . $zone . "' AND SCODE='" . $alarm . "'");
        }
    }
    if ($panel_name == 'rass_boi') {
        if (substr($alarm, -1) == 'R') {
            $_change = 1;
            $remain_char = substr($alarm, 0, -1);
            $sql = mysqli_query($con, "select $paramater from rass_boi where ZONE='" . $zone . "' AND SCODE LIKE '" . $remain_char . "%'");
        } else {
            $sql = mysqli_query($con, "select $paramater from rass_boi where ZONE='" . $zone . "' AND SCODE='" . $alarm . "'");
        }
    }
    if ($panel_name == 'rass_pnb') {
        if (substr($alarm, -1) == 'R') {
            $_change = 1;
            $remain_char = substr($alarm, 0, -1);
            $sql = mysqli_query($con, "select $paramater from rass_pnb where ZONE='" . $zone . "' AND SCODE LIKE '" . $remain_char . "%'");
        } else {
            $sql = mysqli_query($con, "select $paramater from rass_pnb where ZONE='" . $zone . "' AND SCODE='" . $alarm . "'");
        }
    }
    if ($panel_name == 'smarti_boi') {
        if (substr($alarm, -1) == 'R') {
            $_change = 1;
            $remain_char = substr($alarm, 0, -1);
            $sql = mysqli_query($con, "select $paramater from smarti_boi where ZONE='" . $zone . "' AND SCODE LIKE '" . $remain_char . "%'");
        } else {
            $sql = mysqli_query($con, "select $paramater from smarti_boi where ZONE='" . $zone . "' AND SCODE='" . $alarm . "'");
        }
    }
    if ($panel_name == 'smarti_pnb') {
        if (substr($alarm, -1) == 'R') {
            $_change = 1;
            $remain_char = substr($alarm, 0, -1);
            $sql = mysqli_query($con, "select $paramater from smarti_pnb where ZONE='" . $zone . "' AND SCODE LIKE '" . $remain_char . "%'");
        } else {
            $sql = mysqli_query($con, "select $paramater from smarti_pnb where ZONE='" . $zone . "' AND SCODE='" . $alarm . "'");
        }
    }
    if ($panel_name == 'smarti_hdfc32') {
        if (substr($alarm, -1) == 'R') {
            $_change = 1;
            $remain_char = substr($alarm, 0, -1);
            $sql = mysqli_query($con, "select $paramater from smarti_hdfc32 where ZONE='" . $zone . "' AND SCODE LIKE '" . $remain_char . "%'");
        } else {
            $sql = mysqli_query($con, "select $paramater from smarti_hdfc32 where ZONE='" . $zone . "' AND SCODE='" . $alarm . "'");
        }
    }

    if ($panel_name == 'comfort') {
        $sql = mysqli_query($con, "select $paramater from comfort where ZONE='" . $zone . "' AND SCODE='" . $alarm . "' ");
    }
    if ($panel_name == 'RASS') {
        $sql = mysqli_query($con, "select $paramater from rass where ZONE='" . $zone . "' AND SCODE='" . $alarm . "'");
    }
    if ($panel_name == 'rass_cloud') {
        $sql = mysqli_query($con, "select $paramater from rass_cloud where ZONE='" . $zone . "' AND status=0");
    }
    if ($panel_name == 'rass_cloudnew') {
        $sql = mysqli_query($con, "select $paramater from rass_cloudnew where ZONE='" . $zone . "' AND status=0");
    }
    if ($panel_name == 'rass_sbi') {
        $sql = mysqli_query($con, "select $paramater from rass_sbi where ZONE='" . $zone . "'");
    }
    if ($panel_name == 'SEC') {
        $sql = mysqli_query($con, "select $paramater from securico where ZONE='" . $zone . "' AND status=0");
    }
    if ($panel_name == 'securico_gx4816') {
        $sql = mysqli_query($con, "select $paramater from securico_gx4816 where ZONE='" . $zone . "' AND status=0");
    }
    if ($panel_name == 'sec_sbi') {
        $sql = mysqli_query($con, "select $paramater from sec_sbi where ZONE='" . $zone . "' AND status=0");
    }
    if ($panel_name == 'Raxx') {
        $sql = mysqli_query($con, "select $paramater from raxx where ZONE='" . $zone . "' AND status=0");
    }
    if ($panel_name == 'SMART -I') {
        $sql = mysqli_query($con, "select $paramater from smarti where ZONE='" . $zone . "' AND status=0");
    }
    if ($panel_name == 'SMART-IN') {
        $sql = mysqli_query($con, "select $paramater from smartinew where ZONE='" . $zone . "' AND status=0");
    }

    if ($sql == "") {
        $return = "";
    } else {
        if (mysqli_num_rows($sql) > 0) {
            $sql_result = mysqli_fetch_assoc($sql);
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



// $atmid = $_GET['atmid'];
$panelid = $_GET['panelid'];



$agency = "CapitalSoft";

$chestdoorsql = "SELECT s.NewPanelID,s.ATMID,s.customer,s.bank,s.SiteAddress,s.city,s.state,s.Panel_Make,a.zone,a.alerttype,a.createtime,a.receivedtime,a.closedtime,a.status,a.alarm FROM `sites` s join alerts a on s.NewPanelID = a.panelid where a.alerttype like '%chest%'  ";

if ($panelid != '') {
    $chestdoorsql .= "and a.panelid = '" . $panelid . "'";
}

$chestdoorsql .= " order by a.id,s.sn ASC";
$chestdoorsql . "<br>";

$sql = mysqli_query($con, $chestdoorsql);


if (!$sql || mysqli_num_rows($sql) == 0) { ?>
    <span>No Data Found</span>
<?php } else {

?>

<div class="table-responsive">
        <table id="order-listing" class="table">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Bank</th>
                    <th>Agency</th>
                    <th>ATMID</th>
                    <th>State</th>
                    <th>City</th>
                    <th>Address</th>
                    <th>Alert Name</th>
                    <th>Alerts Generated DateTime</th>
                    <th>Alerts Received DateTime</th>
                    <th>Alerts Closure DateTime</th>
                    <th>Duration</th>
                    <th>Status</th>
                    <th>Alert Closure Remark</th>

                </tr>
            </thead>
            <tbody>
<?php
    while($sql_result = mysqli_fetch_assoc($sql)){
        $customer = $sql_result['customer'];
        $bank = $sql_result['bank'];
        $atmid = $sql_result['ATMID'];
        $city = $sql_result['city'];
        $state = $sql_result['state'];
        $address = $sql_result['SiteAddress'];
        $alarm = $sql_result['alarm'];
        $alert_generated_dt = $sql_result['createtime'];
        $alert_received_dt = $sql_result['receivedtime'];
        $alert_closed_dt = $sql_result['closedtime'];
        $status = $sql_result['status'];
        $alerttype = $sql_result['alerttype'];
        $zoneid = $sql_result['zone'];
        $panel_name = $sql_result['Panel_Make'];
        $alertname = $sql_result['alerttype'];
        $panel_id = $sql_result['NewPanelID'];
    
    
        $closure_remark = get_sensor_name($alarm, $panel_name, $con, $zoneid);
    
        $alert_closed = new DateTime($alert_closed_dt);
        $diff = $alert_closed->diff(new DateTime($alert_received_dt));
    
        $hr = $diff->h;
        $min = $diff->i;
    
        $duration = $hr . ":" . $min;
    
        if ($status == 'O') {
            $_status = "Open";
        }
        if ($status == 'C') {
            $_status = "Closed";
        }

?>

<tr>
                    <td>
                        <?= $customer ?>
                    </td>
                    <td>
                        <?= $bank ?>
                    </td>
                    <td>
                        <?= $agency ?>
                    </td>
                    <td>
                        <?= $atmid; ?>
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
                        <?= $alerttype ?>
                    </td>

                    <td>
                    <?php echo  convertDateTimeFormat($alert_generated_dt) ?>

                    </td>
                    <td>
                    <?php echo  convertDateTimeFormat($alert_generated_dt) ?>

                    </td>
                    <td>
                    <?php echo  convertDateTimeFormat($alert_closed_dt) ?>

                    </td>

                    <td>
                        <?= $duration ?>
                    </td>
                    <td>
                        <?= $_status ?>
                    </td>
                    <td>
                        <?= $closure_remark ?>
                    </td>

                </tr>
<?php


    }



    ?> </tbody>
    </table>
</div>

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>


   
           

    <script>
 $(document).ready(function() {
        $('#order-listing').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'excelHtml5'
            ]
        });
    });
</script>
<?php } ?>