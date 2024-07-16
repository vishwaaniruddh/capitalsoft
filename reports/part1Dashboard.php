<?php

$customer = $_REQUEST['customer'];

if ($customer) {

	if ($customer == 'AXIS_Bank') {
		$query = "select count(1) as count from dvrsite where Customer='" . $customer . "' and live='Y'";
	} else {
		$query = "select count(1) as count from sites where Customer='" . $customer . "' and live='Y'";
	}

	$dvrStatussql = "SELECT
    COALESCE(online_counts.`networkStatus`, 'Online') AS `networkStatus`,
    COALESCE(online_counts.`networkcount`, 0) AS `networkcount`
FROM (
    SELECT
        CASE
            WHEN DATE(d.cdate) = CURDATE() AND d.login_status = 0 THEN 'Online'
            ELSE 'Offline'
        END AS `networkStatus`,
        COUNT(*) AS `networkcount`
    FROM
        all_dvr_live d
    LEFT JOIN
        sites s ON d.IPAddress = s.DVRIP
    LEFT JOIN
        dvronline o ON d.IPAddress = o.IPAddress  
    LEFT JOIN
        dvrsite ds ON d.IPAddress = ds.DVRIP   
    WHERE
        d.live = 'Y'
        AND 
        s.live='Y'
		        AND d.customer = '" . $customer . "'
    GROUP BY
        CASE
            WHEN DATE(d.cdate) = CURDATE() AND d.login_status = 0 THEN 'Online'
            ELSE 'Offline'
        END
) AS online_counts
RIGHT JOIN (
    SELECT 'Online' AS `networkStatus`
    UNION ALL
    SELECT 'Offline' AS `networkStatus`
) AS all_statuses
ON online_counts.`networkStatus` = all_statuses.`networkStatus`";


	$query3 = "SELECT 
COUNT(CASE WHEN a.status = 0 THEN 1 END) AS online_count,
COUNT(CASE WHEN a.status != 0 THEN 1 END) AS offline_count
FROM 
panel_health a
INNER JOIN 
sites b ON a.panelid = b.NewPanelID AND b.live='Y'
WHERE b.Customer='" . $customer . "' and b.live='Y'
";


	$query4 = "SELECT COUNT(CASE WHEN hdd IN ('Yes', 'Normal', 'ok') THEN 1 ELSE NULL END) AS working_count, 
COUNT(CASE WHEN hdd IS NULL THEN 1 ELSE NULL END) AS not_working_count FROM all_dvr_live where customer='" . $customer . "'";

} else {
	// $query = "select count(1) as count from sites where live='Y'";

	$query = "select (SELECT COUNT(1) FROM sites where live='Y') + (SELECT COUNT(1) FROM dvrsite WHERE live='Y') AS count";

	$dvrStatussql = "SELECT
    COALESCE(online_counts.`networkStatus`, 'Online') AS `networkStatus`,
    COALESCE(online_counts.`networkcount`, 0) AS `networkcount`
FROM (
    SELECT
        CASE
            WHEN DATE(d.cdate) = CURDATE() AND d.login_status = 0 THEN 'Online'
            ELSE 'Offline'
        END AS `networkStatus`,
        COUNT(*) AS `networkcount`
    FROM
        all_dvr_live d
    LEFT JOIN
        sites s ON d.IPAddress = s.DVRIP
    LEFT JOIN
        dvronline o ON d.IPAddress = o.IPAddress  
    LEFT JOIN
        dvrsite ds ON d.IPAddress = ds.DVRIP   
    WHERE
        d.live = 'Y'
        AND 
        s.live='Y'
    GROUP BY
        CASE
            WHEN DATE(d.cdate) = CURDATE() AND d.login_status = 0 THEN 'Online'
            ELSE 'Offline'
        END
) AS online_counts
RIGHT JOIN (
    SELECT 'Online' AS `networkStatus`
    UNION ALL
    SELECT 'Offline' AS `networkStatus`
) AS all_statuses
ON online_counts.`networkStatus` = all_statuses.`networkStatus`
ORDER BY
    all_statuses.`networkStatus`";



	$query3 = "SELECT 
    COUNT(CASE WHEN a.status = 0 THEN 1 END) AS online_count,
    COUNT(CASE WHEN a.status != 0 THEN 1 END) AS offline_count
FROM 
    panel_health a
INNER JOIN 
    sites b ON a.panelid = b.NewPanelID
	WHERE b.live='Y'
	";

	$query4 = "SELECT COUNT(CASE WHEN hdd IN ('Yes', 'Normal', 'ok') THEN 1 ELSE NULL END) AS working_count, 
COUNT(CASE WHEN hdd IS NULL THEN 1 ELSE NULL END) AS not_working_count FROM all_dvr_live";

}





$sql = mysqli_query($con, $query);
$result = mysqli_fetch_assoc($sql);
$totalSites = $result['count'];


//2nd
$dvrStatusResult = mysqli_query($con, $dvrStatussql);

// Initialize counts
$onlineCount = 0;
$offlineCount = 0;

// Fetch data and process
while ($row = mysqli_fetch_assoc($dvrStatusResult)) {
	if ($row['networkStatus'] == 'Offline') {
		$offlineCount = $row['networkcount'];
	} else if ($row['networkStatus'] == 'Online') {
		$onlineCount = $row['networkcount'];
	}
}


//3rd
$panelStatusCountSql = mysqli_query($con, $query3);
$panelStatusResult = mysqli_fetch_assoc($panelStatusCountSql);
$panelOffline = $panelStatusResult['offline_count'];
$panelOnline = $panelStatusResult['online_count'];

//4th
$hddStatusCountSql = mysqli_query($con, $query4);
$hddStatusResult = mysqli_fetch_assoc($hddStatusCountSql);
$hddOffline = $hddStatusResult['not_working_count'];
$hddOnline = $hddStatusResult['working_count'];


?>

<!-- <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4"> -->
<div class="row">

	<div class="col">
		<div class="card radius-10 border-start border-0 border-4 border-danger">
			<div class="card-body">
				<div class="d-flex align-items-center">
					<div>
						<p class="mb-0 text-secondary">Total DVR</p>
						<h4 class="my-1 text-danger"><?php echo $onlineCount; ?> / <?php echo $offlineCount; ?></h4>
						<!-- <p class="mb-0 font-13">+5.4% from last week</p> -->
					</div>
					<div class="widgets-icons-2 rounded-circle bg-gradient-burning text-white ms-auto"><i
							class="bx bxs-wallet"></i>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col">
		<div class="card radius-10 border-start border-0 border-4 border-success">
			<div class="card-body">
				<div class="d-flex align-items-center">
					<div>
						<p class="mb-0 text-secondary">Panel</p>
						<h4 class="my-1 text-success"><?php echo $panelOnline . ' / ' . $panelOffline; ?> </h4>
						<!-- <p class="mb-0 font-13">-4.5% from last week</p> -->
					</div>
					<div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto"><i
							class="bx bxs-bar-chart-alt-2"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
	
</div>





