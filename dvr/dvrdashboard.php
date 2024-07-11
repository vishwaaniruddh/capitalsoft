<?php include ('../header.php');




$query1 = "SELECT COUNT(*) AS count FROM all_dvr_live WHERE live='Y'";
$query2 = "SELECT COUNT(*) AS count FROM all_dvr_live WHERE live='Y' and status = 1"; // network online
$query3 = "SELECT COUNT(*) AS count FROM all_dvr_live WHERE live='Y' and login_status = 1 AND status = 1";
$query4 = "SELECT COUNT(*) AS count FROM all_dvr_live WHERE live='Y' and login_status IS NULL";



$query5 = "SELECT COUNT(*) AS count FROM all_dvr_live WHERE live='Y' and status=1 AND login_status = 0"; // DVR online
$query6 = "SELECT COUNT(*) AS count FROM all_dvr_live WHERE live='Y' and (status = 0 OR status IS NULL)";

$query7 = " SELECT COUNT(*) AS count FROM port_status_network_report p
JOIN (SELECT SN FROM dvr_health) d ON p.site_id = d.SN
JOIN (SELECT site_id, MAX(rectime) AS max_rectime
   FROM port_status_network_report GROUP BY site_id) max_times ON p.site_id = max_times.site_id AND 
   p.rectime = max_times.max_rectime WHERE p.http_port IN ('O', 'N') AND DATE(p.rectime) = CURDATE()";


$query8 = " SELECT COUNT(*) AS count FROM  port_status_network_report p
JOIN  (SELECT SN FROM dvr_health) d ON p.site_id = d.SN
JOIN  (SELECT site_id, MAX(rectime) AS max_rectime FROM port_status_network_report
   GROUP BY site_id) max_times ON p.site_id = max_times.site_id 
                                AND p.rectime = max_times.max_rectime
WHERE 
  p.rtsp_port IN ('O', 'N')
  AND DATE(p.rectime) = CURDATE()";

$query9 = " SELECT 
  COUNT(*) AS count
FROM 
  port_status_network_report p
JOIN 
  (SELECT SN FROM dvr_health) d ON p.site_id = d.SN
JOIN 
  (SELECT site_id, MAX(rectime) AS max_rectime
   FROM port_status_network_report
   GROUP BY site_id) max_times ON p.site_id = max_times.site_id 
                                AND p.rectime = max_times.max_rectime
WHERE 
  p.router_port IN ('O', 'N')
  AND DATE(p.rectime) = CURDATE()";

$query10 = "SELECT 
  COUNT(*) AS count
FROM 
  port_status_network_report p
JOIN 
  (SELECT SN FROM dvr_health) d ON p.site_id = d.SN
JOIN 
  (SELECT site_id, MAX(rectime) AS max_rectime
   FROM port_status_network_report
   GROUP BY site_id) max_times ON p.site_id = max_times.site_id 
                                AND p.rectime = max_times.max_rectime
WHERE 
  p.sdk_port IN ('O', 'N')
  AND DATE(p.rectime) = CURDATE()";

$query11 = "SELECT COUNT(*) AS count
FROM  port_status_network_report p
JOIN (SELECT SN FROM dvr_health) d ON p.site_id = d.SN
JOIN (SELECT site_id, MAX(rectime) AS max_rectime
   FROM port_status_network_report
   GROUP BY site_id) max_times ON p.site_id = max_times.site_id 
                                AND p.rectime = max_times.max_rectime
WHERE 
  p.ai_port IN ('O', 'N')
  AND DATE(p.rectime) = CURDATE()
  ";


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

$dvrStatusResult = mysqli_query($con, $dvrStatussql);

// Initialize counts
$onlineCount = 0;
$offlineCount = 0;

while ($row = mysqli_fetch_assoc($dvrStatusResult)) {
	if ($row['networkStatus'] == 'Offline') {
		$offlineCount = $row['networkcount'];
	} else if ($row['networkStatus'] == 'Online') {
		$onlineCount = $row['networkcount'];
	}
}


$queries = [$query1, $query2, $query3, $query4, $query5, $query6, $query7, $query8, $query9, $query10, $query11];
$results = [];
foreach ($queries as $query) {
    $result = mysqli_query($con, $query);
    $count = mysqli_fetch_assoc($result)['count'];
    $results[] = $count;
}

// SELECT COUNT(*) AS net_online_count
//       FROM all_dvr_live
//       WHERE status = 1
?>




<div class="page-content">

    <?php

    // echo '<pre>';
// var_dump($results);
// echo '</pre>';
    
    ?>
    <h6 class="mb-0 text-uppercase">DVR Dashboard</h6>
    <hr />
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Total</p>
                            <h4 class="my-1"><?php echo $results[0]; ?></h4>
                        </div>
                        <div class="widgets-icons bg-light-success text-success ms-auto"><i class="bx bxs-wallet"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Network Online</p>
                            <h4 class="my-1"><?php echo $results[1]; ?></h4>
                        </div>
                        <div class="widgets-icons bg-light-info text-info ms-auto"><i class='bx bxs-group'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Network Offline</p>
                            <h4 class="my-1"><?php echo $results[2]; ?></h4>
                        </div>
                        <div class="widgets-icons bg-light-danger text-danger ms-auto"><i class='bx bxs-binoculars'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Never ON</p>
                            <h4 class="my-1"><?php echo $results[3]; ?></h4>
                        </div>
                        <div class="widgets-icons bg-light-warning text-warning ms-auto"><i
                                class='bx bx-line-chart-down'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card radius-10 bg-success bg-gradient">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-white">DVR Online</p>
                            <h4 class="my-1 text-white"><?php echo $onlineCount; ?></h4>
                        </div>
                        <div class="text-white ms-auto font-35"><i class='bx bx-comment-detail'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 bg-danger bg-gradient">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-white">DVR Offline</p>
                            <h4 class="my-1 text-white"><?php echo $offlineCount; ?></h4>
                        </div>
                        <div class="text-white ms-auto font-35"><i class='bx bx-dollar'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>



    <!-- <div class="row row-cols-1 row-cols-md-3 row-cols-xl-5">
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="text-center">
                        <div class="widgets-icons rounded-circle mx-auto bg-light-primary text-primary mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-lock text-primary">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                        </div>
                        <h4 class="my-1"><?php echo $results[6]; ?></h4>
                        <p class="mb-0 text-secondary">HTTP</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="text-center">
                        <div class="widgets-icons rounded-circle mx-auto bg-light-danger text-danger mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-video text-primary">
                                <polygon points="23 7 16 12 23 17 23 7"></polygon>
                                <rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect>
                            </svg>
                        </div>
                        <h4 class="my-1"><?php echo $results[7]; ?></h4>
                        <p class="mb-0 text-secondary">RTSP</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="text-center">
                        <div class="widgets-icons rounded-circle mx-auto bg-light-info text-info mb-3">
                            <i class="lni lni-network"></i>
                        </div>
                        <h4 class="my-1"><?php echo $results[8]; ?></h4>
                        <p class="mb-0 text-secondary">ROUTER</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="text-center">
                        <div class="widgets-icons rounded-circle mx-auto bg-light-success text-success mb-3"><i
                                class="fadeIn animated bx bx-package"></i>
                        </div>
                        <h4 class="my-1"><?php echo $results[9]; ?></h4>
                        <p class="mb-0 text-secondary">SDK</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="text-center">
                        <div class="widgets-icons rounded-circle mx-auto bg-light-warning text-warning mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-activity text-primary">
                                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                            </svg>
                        </div>
                        <h4 class="my-1"><?php echo $results[10]; ?></h4>
                        <p class="mb-0 text-secondary">AI</p>
                    </div>
                </div>
            </div>
        </div>
    </div> -->


</div>
<?php include ('../footer.php'); ?>