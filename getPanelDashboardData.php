<?php include('./config.php');

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
            <div class="col-sm-3">
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
                    <button type="button" style="background:#fd3550 !important; color:white;">1 - Alert</button>
                    <button type="button" style="background-color:#15ca20;color:white;">0 - Normal</button>
                    <button type="button" style="background-color:orchid;">9 - ByPassed</button>
                    <button type="button" style="background-color:white;color:black;border: 2px solid black">2 - Disconnect</button>
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
                                $backgroundColor = '#fd3550';
                                break;
                            case 1:
                                $backgroundColor = '#15ca20';
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
                        <div class="col-sm-2">
                            <div class="custom_box" style="cursor:pointer; white-space:nowrap; background-color: <?php echo $backgroundColor; ?>;" title="<?php echo htmlspecialchars($SensorName); ?>">
                                <b><?php echo htmlspecialchars($zone); ?></b>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
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