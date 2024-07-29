<?php include ('../header.php'); ?>

<div class="page-content">


    <style>
        td,
        th {
            text-align: center;
            white-space: nowrap;
        }
    </style>




    <?php

    $page = isset($_REQUEST['Page']) && is_numeric($_REQUEST['Page']) ? $_REQUEST['Page'] : 1;
    $records_per_page = isset($_REQUEST['perpg']) && in_array($_REQUEST['perpg'], [25, 50, 75, 100]) ? $_REQUEST['perpg'] : 10;
    $offset = ($page - 1) * $records_per_page;



    $abc = "
  SELECT
  CASE
    WHEN (s.live_date IS NOT NULL) THEN s.live_date
    WHEN (ds.liveDate IS NOT NULL) THEN ds.liveDate
    ELSE o.`Live Date`
  END AS live_date,

  s.NewPanelID,
  s.Panel_Make,
  CASE
    WHEN (s.ATMID IS NOT NULL) THEN s.ATMID
    WHEN (ds.ATMID IS NOT NULL) THEN ds.ATMID
    WHEN (d.atmid IS NOT NULL) THEN d.atmid

    ELSE o.ATMID
  END AS ATMID,
  CASE
    WHEN (s.Bank IS NOT NULL) THEN s.Bank
    WHEN (ds.Bank IS NOT NULL) THEN ds.Bank
    ELSE o.Bank
  END AS Bank,
  CASE
    WHEN (s.Customer IS NOT NULL) THEN s.Customer
    WHEN (ds.Customer IS NOT NULL) THEN ds.Customer
    ELSE o.Customer
  END AS Customer,
  CASE
    WHEN (s.City IS NOT NULL) THEN s.City
    WHEN (ds.City IS NOT NULL) THEN ds.City
    ELSE o.city
  END AS City,
  CASE
      WHEN (s.State IS NOT NULL) THEN s.State
      WHEN (ds.State IS NOT NULL) THEN ds.State
      ELSE o.State
      END AS State,
  CASE
    WHEN (s.Zone IS NOT NULL) THEN s.Zone
    WHEN (ds.Zone IS NOT NULL) THEN ds.Zone
    ELSE o.zone
  END AS Zone,    
  CASE
    WHEN (s.SiteAddress IS NOT NULL) THEN s.SiteAddress
    WHEN (ds.SiteAddress IS NOT NULL) THEN ds.SiteAddress
    ELSE o.Address
  END AS SiteAddress,
  CASE
    WHEN (s.project IS NOT NULL) THEN s.project
    WHEN (ds.project IS NOT NULL) THEN ds.project
    ELSE o.project
  END AS 'Project',


  d.IPAddress as 'IP Address',
  d.dvrname as 'DVR Name',
  

(CASE
  WHEN d.status = 1 THEN 'Online'
  ELSE 'Offline'
END) AS ping_status,
DATE_FORMAT(d.last_communication, '%Y-%m-%d %H:%i:%s') AS last_communication,

  CASE
        WHEN DATE(d.cdate) = CURDATE() AND (d.login_status = 0) THEN 'Online'
        ELSE 'Offline'
  END AS 'Network Status',
  CASE
  WHEN DATE(d.cdate) = CURDATE() AND d.login_status = 0 THEN
      CASE
          WHEN d.latency = '' THEN '-'
          WHEN d.latency IS NULL THEN '-'
          ELSE d.latency
      END
  ELSE '-'
END AS 'Latency',
  
  CASE
  WHEN DATE(d.cdate) = CURDATE() AND d.login_status = 0 THEN
        CASE
            WHEN d.status = 1 THEN 'Online'
            ELSE 'Offline'
        END
      ELSE 'Offline'
  END AS 'DVR Status',


  DATE_FORMAT(d.cdate, '%d-%m-%Y %H:%i:%s') AS 'Current Date',
  CASE
      WHEN d.dvr_time = '' OR d.dvr_time IS NULL THEN '00-00-0000 00:00:00'
      ELSE DATE_FORMAT(d.dvr_time, '%d-%m-%Y %H:%i:%s')
  END AS 'DVR Time',

    CASE 
    WHEN d.dvr_time IS NOT NULL THEN 
        CASE 
            WHEN d.cdate >= d.dvr_time THEN
                CONCAT(
                    FLOOR(TIMESTAMPDIFF(SECOND, d.dvr_time, d.cdate) / 3600), ':',
                    LPAD(FLOOR(TIMESTAMPDIFF(SECOND, d.dvr_time, d.cdate) % 3600 / 60), 2, '0'), ':',
                    LPAD(TIMESTAMPDIFF(SECOND, d.dvr_time, d.cdate) % 60, 2, '0')
                )
            ELSE
                CONCAT(
                    '-', FLOOR(TIMESTAMPDIFF(SECOND, d.cdate, d.dvr_time) / 3600), ':',
                    LPAD(FLOOR(TIMESTAMPDIFF(SECOND, d.cdate, d.dvr_time) % 3600 / 60), 2, '0'), ':',
                    LPAD(TIMESTAMPDIFF(SECOND, d.cdate, d.dvr_time) % 60, 2, '0')
                )
        END
    ELSE '00:00:00'
END AS 'Time Difference' ,
  
  CASE
  WHEN d.dvr_time = '' OR d.dvr_time IS NULL THEN 'Not Working'
  WHEN (d.cam1 = '') THEN 'Not Working'
  WHEN (d.cam1 IS NULL) THEN 'Not Working'
  WHEN (d.login_status = 1) THEN 'Not Working'
  ELSE  d.cam1 
  END AS cam1,
  
    CASE
  WHEN d.dvr_time = '' OR d.dvr_time IS NULL THEN 'Not Working'
  WHEN (d.cam2 = '') THEN 'Not Working'
  WHEN (d.cam2 IS NULL) THEN 'Not Working'
  WHEN (d.login_status = 1) THEN 'Not Working'
  ELSE  d.cam2 
  END AS cam2,

    CASE
  WHEN d.dvr_time = '' OR d.dvr_time IS NULL THEN 'Not Working'
  WHEN (d.cam3 = '') THEN 'Not Working'
  WHEN (d.cam3 IS NULL) THEN 'Not Working'
  WHEN (d.login_status = 1) THEN 'Not Working'
  ELSE  d.cam3 
  END AS cam3,



  CASE
  WHEN d.dvr_time = '' OR d.dvr_time IS NULL THEN '-'
  WHEN (d.cam4 = '') THEN 'Not Available'
  WHEN (d.cam4 IS NULL) THEN 'Not Available'
  WHEN (d.login_status = 1) THEN 'Not Available'
  ELSE  d.cam4
  END AS cam4
  ,
    
 
CASE
WHEN d.hdd IN('Yes','Normal','ok') THEN 'Working'
ELSE 'Not Working'
END AS 'HDD Status'
,


CASE
WHEN d.dvr_time = '' OR d.dvr_time IS NULL THEN '-'
WHEN COALESCE(d.recording_from, '') = '' THEN '-'
WHEN d.recording_from LIKE '%T%Z' THEN
    DATE_FORMAT(
        STR_TO_DATE(
            d.recording_from,
            '%Y-%m-%dT%H:%i:%sZ'
        ),
        '%d-%m-%Y %H:%i:%s'
    )
    WHEN d.recording_from REGEXP '^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2} [0-9]{1,2}:[0-9]{1,2}:[0-9]{1,2}$' THEN
    DATE_FORMAT(
      STR_TO_DATE(
          d.recording_from,
          '%Y-%m-%d %H:%i:%s'
      ),
      '%d-%m-%Y %H:%i:%s'
  )
WHEN d.recording_from REGEXP '^[0-9]{4}- [0-9]{1,2}-[0-9]{1,2}$' THEN
    DATE_FORMAT(
        STR_TO_DATE(
            d.recording_from,
            '%Y- %m-%d'
        ),
        '%d-%m-%Y %H:%i:%s'
    )
    WHEN d.recording_from REGEXP '^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}$' THEN
    DATE_FORMAT(
        STR_TO_DATE(
            d.recording_from,
            '%Y-%m-%d'
        ),
        '%d-%m-%Y %H:%i:%s'
    )
WHEN d.recording_from REGEXP '^[0-9]{1,2} - [0-9]{1,2} - [0-9]{4}$' THEN
    DATE_FORMAT(
        STR_TO_DATE(
            d.recording_from,
            '%d - %m - %Y'
        ),
        '%d-%m-%Y %H:%i:%s'
    )
WHEN d.recording_from REGEXP '^[0-9]{1,2}-[0-9]{1,2}-[0-9]{4}$' THEN
    DATE_FORMAT(
        STR_TO_DATE(
            d.recording_from,
            '%d-%m-%Y'
        ),
        '%d-%m-%Y %H:%i:%s'
    )
ELSE '-'
END AS 'Recording From',

CASE
WHEN d.dvr_time = '' OR d.dvr_time IS NULL THEN '-'
WHEN COALESCE(d.recording_to, '') = '' THEN '-'
WHEN d.recording_to LIKE '%T%Z' THEN
    DATE_FORMAT(
        STR_TO_DATE(
            d.recording_to,
            '%Y-%m-%dT%H:%i:%sZ'
        ),
        '%d-%m-%Y %H:%i:%s'
    )
    WHEN d.recording_to REGEXP '^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2} [0-9]{1,2}:[0-9]{1,2}:[0-9]{1,2}$' THEN
    DATE_FORMAT(
      STR_TO_DATE(
          d.recording_to,
          '%Y-%m-%d %H:%i:%s'
      ),
      '%d-%m-%Y %H:%i:%s'
  )

WHEN d.recording_to REGEXP '^[0-9]{1,2} - [0-9]{1,2} - [0-9]{4}$' THEN
    DATE_FORMAT(
        STR_TO_DATE(
            d.recording_to,
            '%d - %m - %Y'
        ),
        '%d-%m-%Y %H:%i:%s'
    )
WHEN d.recording_to REGEXP '^[0-9]{4}- [0-9]{1,2}-[0-9]{1,2}$' THEN
    DATE_FORMAT(
        STR_TO_DATE(
            d.recording_to,
            '%Y- %m-%d'
        ),
        '%d-%m-%Y %H:%i:%s'
    )
    WHEN d.recording_to REGEXP '^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}$' THEN
    DATE_FORMAT(
        STR_TO_DATE(
            d.recording_to,
            '%Y-%m-%d'
        ),
        '%d-%m-%Y %H:%i:%s'
    )
WHEN d.recording_to REGEXP '^[0-9]{1,2}-[0-9]{1,2}-[0-9]{4}$' THEN
    DATE_FORMAT(
        STR_TO_DATE(
            d.recording_to,
            '%d-%m-%Y'
        ),
        '%d-%m-%Y %H:%i:%s'
    )
ELSE '-'
END AS 'Recording To',

  CASE
  WHEN d.dvr_time = '' OR d.dvr_time IS NULL THEN 'Stop'
    WHEN (
      STR_TO_DATE(d.recording_to, '%d - %m - %Y') = CURDATE() 
      OR DATE_FORMAT(d.recording_to, '%Y-%m-%d') = CURDATE()
      OR STR_TO_DATE(d.recording_to, '%Y- %m- %d') = CURDATE()
    ) 
     THEN 'Running'
    ELSE 'Stop'
  END AS 'Recording To Status'
  


  
  FROM
  all_dvr_live d
  LEFT JOIN
  sites s ON d.IPAddress = s.DVRIP AND s.live='Y'
LEFT JOIN
  dvronline o ON d.IPAddress = o.IPAddress  
LEFT JOIN
  dvrsite ds ON d.IPAddress = ds.DVRIP AND ds.live='Y'
  WHERE
    d.live = 'Y' 


		";

    if (!empty($_REQUEST['atmid'])) {
        $abc .= " AND d.atmid LIKE '%" . $_REQUEST['atmid'] . "%'";
    }
    if (!empty($_REQUEST['dvrip'])) {
        $abc .= " AND d.IPAddress LIKE '%" . $_REQUEST['dvrip'] . "%'";
    }
    if (!empty($_REQUEST['customer'])) {
        $abc .= " AND d.customer LIKE '%" . $_REQUEST['customer'] . "%'";
    }

    // Query to get total records count
    $sqlCount = mysqli_query($con, $abc);
    $total_records = mysqli_num_rows($sqlCount);

    // Add LIMIT clause for pagination
    $abc .= " GROUP BY d.IPAddress ";
    $withoutLimitsql = $abc;

    $abc .= " LIMIT $offset, $records_per_page";
    $result = mysqli_query($con, $abc);

    // Function to generate pagination HTML
    function generatePagination($page, $total_pages, $records_per_page)
    {
        $html = '<nav aria-label="Page navigation"><ul class="pagination justify-content-center">';
        if ($page > 1) {
            $html .= '<li class="page-item"><a class="page-link" href="#alldvrtable" onclick="submitForm(1, ' . $records_per_page . ');">First</a></li>';
            $html .= '<li class="page-item"><a class="page-link" href="#alldvrtable" onclick="submitForm(' . ($page - 1) . ', ' . $records_per_page . ');">Previous</a></li>';
        }
        $start = max(1, $page - 2);
        $end = min($total_pages, $page + 2);
        for ($i = $start; $i <= $end; $i++) {
            $html .= '<li class="page-item ' . ($page == $i ? 'active' : '') . '"><a class="page-link" href="#alldvrtable" onclick="submitForm(' . $i . ', ' . $records_per_page . ');">' . $i . '</a></li>';
        }
        if ($page < $total_pages) {
            $html .= '<li class="page-item"><a class="page-link" href="#alldvrtable" onclick="submitForm(' . ($page + 1) . ', ' . $records_per_page . ');">Next</a></li>';
            $html .= '<li class="page-item"><a class="page-link" href="#alldvrtable" onclick="submitForm(' . $total_pages . ', ' . $records_per_page . ');">Last</a></li>';
        }
        $html .= '</ul></nav>';
        return $html;
    }
    ?>



    <form id="searchForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <div class="row">
            <div class="col">
                <label for="">ATMID</label>
                <input type="text" name="atmid" class="form-control form-control-sm mb-3"
                    value="<?php echo isset($_REQUEST['atmid']) ? $_REQUEST['atmid'] : ''; ?>" />
            </div>
            <div class="col">
                <label for="">Customer:</label>
                <select name="customer" class="form-control form-control-sm mb-3" id="customer">
                    <option value="">Select Customer Name</option>
                    <?php
                    $xyzz = "SELECT name FROM customer WHERE status = 1";
                    $runxyzz = mysqli_query($con, $xyzz);
                    while ($xyzfetchcus = mysqli_fetch_array($runxyzz)) {
                        $selected = '';
                        if (isset($_REQUEST['customer']) && $_REQUEST['customer'] == $xyzfetchcus['name']) {
                            $selected = 'selected';
                        }
                        echo '<option value="' . $xyzfetchcus['name'] . '" ' . $selected . '>' . $xyzfetchcus['name'] . '</option>';
                    }
                    ?>
                </select>

            </div>
            <div class="col">
                <label for="">DVRIP</label>
                <input type="text" name="dvrip" class="form-control form-control-sm mb-3"
                    value="<?php echo isset($_REQUEST['dvrip']) ? $_REQUEST['dvrip'] : ''; ?>" />
            </div>
        </div>
        <input type="hidden" name="Page" id="currentPage" value="<?php echo $page; ?>">
        <input type="hidden" name="perpg" id="perPage" value="<?php echo $records_per_page; ?>">
        <input type="button" onclick="submitForm(<?php echo $page; ?>, <?php echo $records_per_page; ?>);"
            class="badge bg-primary" value="Search">
    </form>

    <hr>

    <div class="card">
        <div class="card-body" style="overflow:auto;">
            <div class="total_n_export" id="tabletop" style="display: flex;
    justify-content: space-between;">


                <h6 class="mb-0 text-uppercase">Total Records : <?php echo $total_records; ?></h6>
                <form action="../export/exportHealthCheckUpReport.php" method="POST">
                    <input type="hidden" name="exportsql" value="<?php echo $withoutLimitsql; ?>">
                    <button type="submit" class="btn btn-outline-info btn-sm px-5 radius-30"><i
                            class="bx bx-cloud-download mr-1"></i>Export</button>
                </form>
            </div>

            <hr />

            <table id="alldvrtable" class="table1 table table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th>SRNO</th>
                        <th>ATMID</th>
                        <th>BANK</th>
                        <th>CUSTOMER</th>
                        <th>DVR STATUS</th>
                        <th>DVR TIME</th>
                        <th>PING STATUS</th>
                        <th>CDATE</th>
                        <th>TIME DIFF (HH:MM)</th>
                        <th>LAST COMMUNICATION</th>
                        <th>DOWN SINCE (Days)</th>
                        <th>DVR NAME</th>
                        <th>IP</th>
                        <th>HDD DB</th>
                        <th>HDD</th>
                        <th>REC</th>
                        <th>CAM STATUS</th>

                        <th>REC FROM</th>
                        <th>REC TO</th>
                        <th>AGING (Days)</th>
                        <th>Site Type</th>
                        <th>REFRESH</th>
                        <th>CITY</th>
                        <th>STATE</th>
                        <th>BRANCH ADDRESS</th>
                        <th>ZONE</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = ($page - 1) * $records_per_page + 1;

                    while ($row = mysqli_fetch_array($result)) {


                        $difference = '-' ;
                        $ping_status = $row['ping_status'] ; 
                        if($ping_status=='Offline'){

                            $oldestofflineDate = mysqli_fetch_assoc(mysqli_query($con,"SELECT  cdate
                            FROM dvr_history
                            WHERE id > (
                                SELECT MAX(id)
                                FROM dvr_history
                                WHERE login_status = 0 AND status = 1 AND `ip` LIKE '172.16.12.151'
                            )
                            AND login_status != 0 AND `ip` LIKE '172.16.12.151'")) ;
                            $lastofflineRecord = $oldestofflineDate['cdate'];
                            $currentDate = $row['Current Date'] ; 
                            $oldestTimestamp = strtotime($lastofflineRecord);
                            $currentTimestamp = strtotime($currentDate);
                            
                            // Calculate difference in seconds
                            $difference = $currentTimestamp - $oldestTimestamp;
                            
                            // Convert difference to days, hours, and minutes
                            $days = floor($difference / (60 * 60 * 24));
                            $hours = floor(($difference - ($days * 60 * 60 * 24)) / (60 * 60));
                            $minutes = floor(($difference - ($days * 60 * 60 * 24) - ($hours * 60 * 60)) / 60);
                            
                            // Output the difference
                            $difference = "$days days, $hours hours, $minutes minutes";
                            

                        }
 


                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $row['ATMID']; ?></td>
                            <td><?php echo $row['Bank']; ?></td>
                            <td><?php echo $row['Customer']; ?></td>
                            <td><?php echo $row['DVR Status']; ?></td>
                            <td><?php echo $row['DVR Time']; ?></td>
                            <td><?php echo $row['ping_status']; ?></td>
                            <td><?php echo $row['Current Date']; ?></td>
                            <td><?php echo $row['Time Difference']; ?></td>
                            <td><?php echo $row['last_communication']; ?></td>

                            <td><?php echo $difference ; ?></td>
                            <td><?php echo $row['DVR Name']; ?></td>
                            <td><?php echo $row['IP Address']; ?></td>
                            <td><?php echo $row['HDD Status']; ?></td>
                            <td style="text-align:center;"><?php

                            if ($row['HDD Status'] == 'Working') {
                                echo '<i class="fadeIn animated bx bx-check-circle" style="cursor:pointer; color:green;"></i>';
                            } else {
                                echo '<i class="lni lni-cross-circle" style="cursor:pointer; color:red;"></i>';
                            }
                            ?></td>


                            <td style="text-align:center;"><?php

                            if ($row['Recording To Status'] == 'Running') {
                                echo '<i class="fadeIn animated bx bx-check-circle" style="cursor:pointer; color:green;"></i>';
                            } else {
                                echo '<i class="lni lni-cross-circle" style="cursor:pointer; color:red;"></i>';
                            }
                            ?>



                            </td>
                            <td>
                                <?php
                                if ($row['cam1'] == 'working') {
                                    echo '<i class="fadeIn animated bx bx-camera" style="cursor:pointer; color:green;"
									title="Working"></i> |';
                                } else {
                                    echo '<i class="fadeIn animated bx bx-camera-off" style="cursor:pointer; color:red;"
									title="Not Working"></i> |';
                                }

                                if ($row['cam2'] == 'working') {
                                    echo '<i class="fadeIn animated bx bx-camera" style="cursor:pointer; color:green;"
									title="Working"></i> |';
                                } else {
                                    echo '<i class="fadeIn animated bx bx-camera-off" style="cursor:pointer; color:red;"
									title="Not Working"></i> |';
                                }

                                if ($row['cam3'] == 'working') {
                                    echo '<i class="fadeIn animated bx bx-camera" style="cursor:pointer; color:green;"
									title="Working"></i> |';
                                } else {
                                    echo '<i class="fadeIn animated bx bx-camera-off" style="cursor:pointer; color:red;"
									title="Not Working"></i> |';
                                }

                                if ($row['cam4'] == 'working') {
                                    echo '<i class="fadeIn animated bx bx-camera" style="cursor:pointer; color:green;"
									title="Working"></i>';
                                } else {
                                    echo '<i class="fadeIn animated bx bx-camera-off" style="cursor:pointer; color:red;"
									title="Not Working"></i>';
                                }

                                ?>
                            </td>

                            <td><?php echo $row['Recording From']; ?></td>
                            <td><?php echo $row['Recording To']; ?></td>
<?php 

$recordingFrom = isset($row['Recording From']) ? $row['Recording From'] : '';
$recordingTo = isset($row['Recording To']) ? $row['Recording To'] : '';

    $difference_in_days = '-';

    if (!empty($recordingFrom) && !empty($recordingTo)) {
        try {
        // Calculate day difference 
        $from_timestamp = strtotime($recordingFrom);
        $to_timestamp = strtotime($recordingTo);
        $difference_in_seconds = $to_timestamp - $from_timestamp;
        $difference_in_days = $difference_in_seconds / 86400;
        $difference_in_days = round($difference_in_days) . ' Days' ;
       
    } catch (Exception $e) {
        // echo 'Error: ' . $e->getMessage(); // Handle any DateTime parsing exceptions here
    }
}




?>
                            <td><?php echo $difference_in_days ; ?></td>
                            <td><?php echo $row['Project']; ?></td>
                            <td style="text-align:center;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-refresh-ccw text-primary" style="
    font-size: 14px;
">
                                    <polyline points="1 4 1 10 7 10"></polyline>
                                    <polyline points="23 20 23 14 17 14"></polyline>
                                    <path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"></path>
                                </svg>
                            </td>
                            <td><?php echo $row['City']; ?></td>
                            <td><?php echo $row['State']; ?></td>
                            <td><?php echo $row['SiteAddress']; ?></td>
                            <td><?php echo $row['Zone']; ?></td>
                        </tr>
                        <?php
                        $i++;
                    }

                    ?>
                </tbody>
            </table>
            <?php
            // Calculate total pages
            $total_pages = ceil($total_records / $records_per_page);
            // Output pagination controls
            echo generatePagination($page, $total_pages, $records_per_page);
            ?>
        </div>
    </div>

    <script>
        function submitForm(page, perPage) {
            document.getElementById('currentPage').value = page;
            document.getElementById('perPage').value = perPage;
            document.getElementById('searchForm').submit();
        }
    </script>

</div>

<?php include ('../footer.php'); ?>