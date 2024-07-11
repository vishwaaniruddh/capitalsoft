<?php include ('db_connection.php');
$con = OpenCon();
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
	$paramater = 'SensorName,SCODE';
	$sql = "";
	$_change = 0;
	if ($panel_name == 'comfort') {
		$sql = mysqli_query($con, "select $paramater from comfort where ZONE='" . $zone . "'");
	}
	if ($panel_name == 'rass_boi') {
		$sql = mysqli_query($con, "select $paramater from rass_boi where ZONE='" . $zone . "'");
	}
	if ($panel_name == 'rass_pnb') {
		$sql = mysqli_query($con, "select $paramater from rass_pnb where ZONE='" . $zone . "'");
	}
	if ($panel_name == 'smarti_boi') {
		$sql = mysqli_query($con, "select $paramater from smarti_boi where ZONE='" . $zone . "'");
	}
	if ($panel_name == 'smarti_pnb') {
		$sql = mysqli_query($con, "select $paramater from smarti_pnb where ZONE='" . $zone . "'");
	}
	if ($panel_name == 'RASS') {
		$sql = mysqli_query($con, "select $paramater from rass where ZONE='" . $zone . "' AND status=0");
	}
	if ($panel_name == 'rass_cloud') {
		$sql = mysqli_query($con, "select $paramater from rass_cloud where ZONE='" . $zone . "' AND status=0");
	}
	if ($panel_name == 'rass_cloudnew') {
		$sql = mysqli_query($con, "select $paramater from rass_cloudnew where ZONE='" . $zone . "' AND status=0");
	}
	if ($panel_name == 'rass_sbi') {
		$sql = mysqli_query($con, "select $paramater from rass_sbi where ZONE='" . $zone . "' AND status=0");
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
//$atmid  = 'A1000310';
$sql = mysqli_query($con, "select * from panel_health_api_response where atmid='" . $atmid . "'");
if (!$sql || mysqli_num_rows($sql) == 0) { ?>
<span>No Data Found</span>
<?php } else {
	$sql_result = mysqli_fetch_assoc($sql);
	$zone_config = json_decode($sql_result['zone_config']);
	//echo '<pre>';print_r($zone_config);echo '</pre>';die;
//$keys = array_keys((array)$sql_result);
	$keys = $zone_config;
	//$sql_result1 = mysqli_fetch_assoc($sql);
	?>

<div class="table-responsive">
    <table id="order-listing" class="table">
        <thead>
            <tr>
                <th>ATMID</th>
                <th>Action</th>
                <?php
					$count = 1;

					foreach ($keys as $val => $key) {
						// echo '<pre>';print_r($key);echo '</pre>';
						$zone_no = $key->zone_no;
						$intkey = $zone_no;

						if ($intkey < 10) {
							$intkey = '00' . $intkey;
						} else if ($intkey < 100) {
							$intkey = '0' . $intkey;
						}

						//if($intkey!='997' || $intkey!='998'){
						?>
                <!--<th id="thid<?php echo $count; ?>" onclick="getrass(<?php echo $intkey; ?>,'SensorName',<?php echo $atmid; ?>)"><?php echo getrass($intkey, 'SensorName', $atmid, $con); ?></th> -->
                <th id="thid<?php echo $count; ?>"
                    onclick="getrass(<?php echo $intkey; ?>,'SensorName',<?php echo $atmid; ?>)">
                    <?php echo $key->zone_name; ?>
                </th>
                <?php $count++; //} 
					}
					?>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <?php echo $atmid; ?>
                </td>
                <td><a href="add_ticket.php?alarmtype=0&atmid=<?php echo $atmid; ?>" target="_blank">Ticket Raise</a>
                </td>
                <?php
					$count = 1;
					//echo '<pre>';print_r($sql_result);echo '';die;
					$zone_status_text = "";
					foreach ($keys as $value => $key) {
						$zone_no = $key->zone_no;
						$_status = $key->status;
						if ($zone_no <= 36) {
							if ($_status == '0') {
								$zone_status_text = 'Close';
							}
							if ($_status == '1') {
								$zone_status_text = 'Open';
							}
						} else {
							if ($_status == '0') {
								$zone_status_text = 'Close';
							}
							if ($_status == '1') {
								$zone_status_text = 'Triggered';
							}
							if ($_status == '2') {
								$zone_status_text = 'Disconnected';
							}
							if ($_status == '3') {
								$zone_status_text = 'Open';
							}
						}
						//if(startsWith ($key, 'zon')){   ?>
                <td id="tdid<?php echo $count; ?>">
                    <p style="text-align:center;">
                        <?php echo 'zon' . $zone_no; ?>
                    </p>
                    <p <?php if ($_status == '0') {
								echo "class='paneltime green'";
							} elseif ($_status == '1') {
								echo 'class="paneltime red"';
							} elseif ($_status == '2') {
								echo 'class="paneltime white"';
							} elseif (getrassstatus($key, $atmid, $con) == '9') {
								echo 'class="paneltime orchid"';
							}
							?>>
                        <?php echo $zone_status_text; //echo 'zon'.$zone_no;   ?>
                    </p>
                </td>
                <?php $count++;	//}
					}


					?>
            </tr>
        </tbody>
    </table>
</div>

<?php }
CloseCon($con); ?>