<?php include ('../header.php'); ?>


<div class="page-content">



    <div class="card">
        <div class="card-body">

            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="GET">

                <div class="row">
                    <div class="col-sm-12">
                        <label>ATMID</label>
                        <input type="text" class="form-control form-control-sm mb-3" name="atmid"
                            value="<?php echo $_REQUEST['atmid']; ?>">
                    </div>
                    <div class="col-sm-12">
                        <br>
                        <input type="submit" name="Submit" class="btn btn-sm btn-primary px-5 rounded-0">
                    </div>

                </div>

            </form>

        </div>
    </div>

    <?php
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



    $atmid = $_GET['atmid'];



    // $panelid = $_GET['panelid'];
    


    $vendor = "CapitalSoft";

    $upssql = "SELECT s.ATMID,s.customer,s.bank,s.SiteAddress,s.city,s.state,s.Panel_Make,
    p.eb_power_failure_alert_received_dt,p.ups_power_available_alert_dt,p.ups_power_failure_alert_received_dt,
    p.eb_power_available_alert_dt,p.comments FROM `sites` s, power_ups_report p where s.ATMID = p.ATMID ";

    if ($atmid != '') {
        $upssql .= "and s.ATMID = '" . $atmid . "'";
    }

    $upssql .= " order by p.id,s.sn ASC";
    $upssql . "<br>";

    $sql = mysqli_query($con, $upssql);


    if (!$sql || mysqli_num_rows($sql) == 0) { ?>
        <span>No Data Found</span>
    <?php } else {

        ?>


        <div class="table-responsive">
            <table id="order-listing" class="table">
                <thead>
                    <tr>
                        <th>Bank</th>
                        <th>Site ID</th>
                        <th>ATMID</th>
                        <th>Client</th>
                        <th>State</th>
                        <th>City</th>
                        <th>Site Address</th>
                        <th>EB Power Failure Alert Received DateTime</th>
                        <th>UPS Power Available Alert DateTime</th>
                        <th>UPS Power Failure Alert Received DateTime</th>
                        <th>EB Power Available Alerts DateTime</th>
                        <th>Duration</th>
                        <th>Comments</th>
                        <th>Vendor</th>

                    </tr>
                </thead>
                <tbody>

                    <?php
                    while ($sql_result = mysqli_fetch_assoc($sql)) {


                        $customer = $sql_result['customer'];
                        $bank = $sql_result['bank'];
                        $atmid = $sql_result['ATMID'];
                        $city = $sql_result['city'];
                        $state = $sql_result['state'];
                        $address = $sql_result['SiteAddress'];
                        $panel_id = $sql_result['NewPanelID'];
                        $eb_power_failure_alert_received_dt = $sql_result['eb_power_failure_alert_received_dt'];
                        $ups_power_available_alert_dt = $sql_result['ups_power_available_alert_dt'];
                        $ups_power_failure_alert_received_dt = $sql_result['ups_power_failure_alert_received_dt'];
                        $eb_power_available_alert_dt = $sql_result['eb_power_available_alert_dt'];
                        $comments = $sql_result['comments'];


                        // $closure_remark = get_sensor_name($alarm, $panel_name, $con, $zoneid);
                
                        $alert_closed = new DateTime($eb_power_available_alert_dt);
                        $diff = $alert_closed->diff(new DateTime($eb_power_failure_alert_received_dt));

                        $hr = $diff->h;
                        $min = $diff->i;

                        $duration = $hr . ":" . $min;

                        // if ($status == 'O') {
                        //     $_status = "Open";
                        // }
                        // if ($status == 'C') {
                        //     $_status = "Closed";
                        // }
                

                        ?>

                        <tr>

                            <td>
                                <?= $bank ?>
                            </td>
                            <td>
                                <?= $panel_id ?>
                            </td>
                            <td>
                                <?= $atmid; ?>
                            </td>
                            <td>
                                <?= $client ?>
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
                                <?php echo convertDateTimeFormat($eb_power_failure_alert_received_dt) ?>


                            </td>

                            <td>
                                <?php echo convertDateTimeFormat($ups_power_available_alert_dt) ?>

                            </td>
                            <td>
                                <?php echo convertDateTimeFormat($ups_power_failure_alert_received_dt) ?>

                            </td>
                            <td>
                                <?= $eb_power_available_alert_dt ?>
                            </td>

                            <td>
                                <?= $duration ?>
                            </td>
                            <td>
                                <?= $comments ?>
                            </td>
                            <td>
                                <?= $vendor ?>
                            </td>







                        </tr>

                        <?php
                    }



                    ?>



                </tbody>
            </table>
        </div>


        



    <?php }
    ?>
</div>

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
<?php include ('../footer.php'); ?>