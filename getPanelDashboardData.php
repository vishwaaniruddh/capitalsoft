<?php include ('./config.php');

$atmid = $_REQUEST['atmid'];
$customer = $_REQUEST['customer'];

if ($customer && $atmid) {
    $sitesql = mysqli_query($con, "SELECT * FROM sites WHERE ATMID = '$atmid'");
    if ($sitesql_result = mysqli_fetch_array($sitesql)) {
        $panelid = $sitesql_result['NewPanelID'];
        $panelip = $sitesql_result['PanelIP'];
        $panel_port = $sitesql_result['panel_port'];
        $panel_make = $sitesql_result['Panel_Make'];
        ?>

        <style>
            .border-right {
                border-right: 2px solid;
            }

            .border-bottom {
                border-bottom: 2px solid;
            }
        </style>

        <div class="row">
            <div class="col-sm-3">
                <label>Panel ID:</label>
                <span><?php echo htmlspecialchars($panelid); ?></span>
            </div>
            <div class="col-sm-3">
                <label>Panel IP:</label>
                <span><?php echo htmlspecialchars($panelip); ?></span>
            </div>
            <div class="col-sm-3">
                <label>Panel Port:</label>
                <span><?php echo htmlspecialchars($panel_port); ?></span>
            </div>
            <div class="col-sm-3">
                <label>Panel Make:</label>
                <span><?php echo htmlspecialchars($panel_make); ?></span>
            </div>
            <div class="col-sm-3">
                <label>Panel MacID:</label>
                <span></span>
            </div>
            <div class="col-sm-3">
                <label>Panel Model:</label>
                <span></span>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-sm-3 border-right">
                <?php
                $i = 1;
                $panelsql = mysqli_query($con, "SELECT * FROM $panel_make");
                while ($panelsql_result = mysqli_fetch_array($panelsql)) {
                    $SensorName = $panelsql_result['SensorName'];
                    $zone = $panelsql_result['ZONE'];
                    echo $i . ') ' . htmlspecialchars($SensorName) . ' (' . htmlspecialchars($zone) . ')<br />';
                    $i++;
                }
                ?>
            </div>
            <div class="col-sm-9">
                <div class="button-list">
                    <button type="button" style="background-color:#15ca20;color:white;">0 - Normal</button>
                    <button type="button" style="background:#fd3550 !important; color:white;">1 - Alert</button>
                    <button type="button" style="background-color:orchid;">9 - ByPassed</button>
                    <button type="button" style="background-color:white;color:black;border: 2px solid black">2 -
                        Disconnect</button>
                </div>
                <hr>
                <div class="row">
                    <?php
                    $panelsql = mysqli_query($con, "SELECT * FROM $panel_make");
                    while ($panelsql_result = mysqli_fetch_array($panelsql)) {
                        $zone = $panelsql_result['ZONE'];
                        $SensorName = $panelsql_result['SensorName'];
                        $zoneNumber = ltrim($zone, '0');
                        $panelData = getPanelZoneStatus($panelip, $zone);

                        $backgroundColor = '';
                        switch ($panelData) {
                            case 0:
                                $backgroundColor = '#15ca20';
                                break;
                            case 1:
                                $backgroundColor = '#fd3550';
                                break;
                            case 9:
                                $backgroundColor = 'orchid';
                                break;
                            case 2:
                                $backgroundColor = 'white';
                                break;
                            default:
                                $backgroundColor = 'transparent'; // Default color if none of the conditions match
                                break;
                        }
                        ?>
                        <div class="col-sm-1">
                            <div class="custom_box"
                                style="cursor:pointer; white-space:nowrap; background-color: <?php echo $backgroundColor; ?>;"
                                title="<?php echo htmlspecialchars($SensorName); ?>">
                                <b><?php echo htmlspecialchars($zone); ?></b>
                            </div>
                        </div>
                        <?php
                    }
                    ?>

                    <br>
                    <br>
                    <br>
                    <br>
                    <hr>

                    <br>
                    <div class="col-sm-12" style="display: flex;justify-content: center;">

                        <table class="table" style="width:50%;">
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="image" name="btnPing" id="btnPing" title="Ping"
                                            src="<?php echo BASE_URL; ?>/assets/images/pingB.png" alt="Ping" align="left"
                                            style="padding: 7px;">

                                    </td>
                                    <td>
                                        <input type="image" name="btnArm" id="btnArm" title="Arm"
                                            src="<?php echo BASE_URL; ?>/assets/images/ArmN.png" alt="Arm" align="left" style="																		padding: 5px;
                                                                ">
                                    </td>
                                    <td>
                                        <input type="image" name="btnDisArm" id="btnDisArm" title="DisArm"
                                            src="<?php echo BASE_URL; ?>/assets/images/DisArm.png" alt="DisArm" align="left"
                                            style="padding: 7px;">

                                    </td>
                                    <td>


                                        <input type="image" name="btnSirenON" id="btnSirenON" title="Siren ON"
                                            src="<?php echo BASE_URL; ?>/assets/images/siron.png" alt="SirenON" align="left"
                                            style="padding: 7px;">

                                    </td>
                                    <td>

                                        <input type="image" name="btnSirenOFF" id="btnSirenOFF" title="Siren OFF"
                                            src="<?php echo BASE_URL; ?>/assets/images/sironoff.png" alt="SirenOFF" align="left"
                                            style="padding: 7px;">

                                    </td>

                                    <td>

                                        <!-- <input type="image" name="btnShutterOPEN" id="btnShutterOPEN" title="Shutter OPEN" src="<?php echo BASE_URL; ?>/assets/images/ArmN.png" alt="ShutterOPEN" align="left"  style="padding: 7px;" /> -->
                                        <input type="image" name="btnEMLOpen" id="btnEMLOpen" title="EML OPEN"
                                            src="<?php echo BASE_URL; ?>/assets/images/ArmN.png" alt="EMLOPEN" align="left"
                                            style="padding: 7px;">

                                    </td>

                                    <td>

                                        <input type="image" name="btnDVRRst" id="btnDVRRst" title="DVR Rst"
                                            src="<?php echo BASE_URL; ?>/assets/images/DisArm.png" alt="DVRRst" align="left"
                                            style="padding: 7px;">

                                    </td>

                                    <td>

                                        <input type="image" name="btnPanelRestart" id="btnPanelRestart" title="Panel Restart"
                                            src="<?php echo BASE_URL; ?>/assets/images/siron.png" alt="PanelRestart"
                                            align="left" style="padding: 7px;">

                                    </td>

                                    <td>

                                        <input type="image" name="btnTwowayRestart" id="btnTwowayRestart" title="Twoway Restart"
                                            src="<?php echo BASE_URL; ?>/assets/images/sironoff.png" alt="TwowayRestart"
                                            align="left" style="padding: 7px;">

                                    </td>




                                </tr>

                                <tr>
                                    <td style="text-align:center">PING</td>
                                    <td style="text-align:center"><span id="lblPanelARM">ARM</span></td>
                                    <td style="text-align:center"><span id="lblPanelDISARM">DISARM</span></td>
                                    <td style="text-align:center">SIRENON</td>
                                    <td style="text-align:center">SIRENOFF</td>
                                    <td style="text-align:center;display:none;">FIRERESET</td>
                                    <td style="text-align:center;">EML OPEN</td>
                                    <td style="text-align:center;">DVR RST</td>
                                    <td style="text-align:center;">PANEL RST</td>
                                    <td style="text-align:center;">TWOWAY RST</td>

                                </tr>






                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
    </div>






















<?php } else {
    echo 'Select ATMID to get data...';
}


?>