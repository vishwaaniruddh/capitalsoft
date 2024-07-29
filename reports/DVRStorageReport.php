<?php include ('../header.php');
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);



?>


<style>
    td,
    th {
        text-align: center;
        white-space: nowrap;
    }
</style>



<div class="page-content">

    <?php include ('./part1Dashboard.php'); ?>




    <?php


    $page = isset($_REQUEST['Page']) && is_numeric($_REQUEST['Page']) ? $_REQUEST['Page'] : 1;
    $records_per_page = isset($_REQUEST['perpg']) && in_array($_REQUEST['perpg'], [25, 50, 75, 100]) ? $_REQUEST['perpg'] : 10;
    $offset = ($page - 1) * $records_per_page;



    $abc = "
	  SELECT
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
      WHEN d.dvr_time = '' OR d.dvr_time IS NULL THEN '-'
      WHEN (d.cam1 = '') THEN 'Not Available'
      WHEN (d.cam1 IS NULL) THEN 'Not Available'
      WHEN (d.login_status = 1) THEN 'Not Available'
      ELSE  d.cam1 
      END AS cam1,

      CASE
      WHEN d.dvr_time = '' OR d.dvr_time IS NULL THEN '-'
      WHEN (d.cam2 = '') THEN 'Not Available'
      WHEN (d.cam2 IS NULL) THEN 'Not Available'
      WHEN (d.login_status = 1) THEN 'Not Available'
      ELSE  d.cam2
      END AS cam2
      ,

      CASE
      WHEN d.dvr_time = '' OR d.dvr_time IS NULL THEN '-'
      WHEN (d.cam3 = '') THEN 'Not Available'
      WHEN (d.cam3 IS NULL) THEN 'Not Available'
      WHEN (d.login_status = 1) THEN 'Not Available'
      ELSE  d.cam3
      END AS cam3 ,

      CASE
      WHEN d.dvr_time = '' OR d.dvr_time IS NULL THEN '-'
      WHEN (d.cam4 = '') THEN 'Not Available'
      WHEN (d.cam4 IS NULL) THEN 'Not Available'
      WHEN (d.login_status = 1) THEN 'Not Available'
      ELSE  d.cam4
      END AS cam4
      ,
        
     
  CASE
  WHEN d.dvr_time = '' OR d.dvr_time IS NULL THEN '-'
  WHEN (
      STR_TO_DATE(d.recording_to, '%d - %m - %Y') = CURDATE() 
      OR DATE_FORMAT(d.recording_to, '%Y-%m-%d') = CURDATE()
      OR STR_TO_DATE(d.recording_to, '%Y- %m- %d') = CURDATE()
  ) THEN 'Working'
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
      sites s ON d.IPAddress = s.DVRIP
    LEFT JOIN
      dvronline o ON d.IPAddress = o.IPAddress  
    LEFT JOIN
      dvrsite ds ON d.IPAddress = ds.DVRIP   
      WHERE
        d.live = 'Y' 
        AND 
        s.live='Y'

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


    <div class="card">
        <div class="card-body" style="overflow:auto;">
            <table id="alldvrtable" class="table1 table table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th>Sr No</th>
                        <th>PANEL ID</th>
                        <th>ATM ID </th>
                        <th>PANEL TYPE </th>
                        <th>IP ADDRESS </th>
                        <th>CLIENT </th>
                        <th>SITE </th>
                        <th>START DATE </th>
                        <th>END DATE </th>
                        <th>TOTAL DAYS </th>
                        <th>STORAGE LAST UPDATE DATE</th>
                        <th>HDD STATUS </th>
                        <th>LastRecordingHrs </th>
                        <th>HDD STATUS LAST UPDATE DATE </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = ($page - 1) * $records_per_page + 1;
                    while ($row = mysqli_fetch_array($result)) {

                        // $recordingFrom = $row['Recording From'];
                        // $recordingTo = $row['Recording To'];

                        // $datetime1 = new DateTime($recordingFrom);
                        // $datetime2 = new DateTime($recordingTo);
                        
                        // // Calculate the difference between two DateTime objects
                        // $difference = $datetime1->diff($datetime2);
                        
                        // // Format the difference into days, hours, and optionally minutes
                        // $days = $difference->days;
                        // $hours = $difference->h;
                        // $minutes = $difference->i;
                        
                        // // Build the formatted string
                        // if ($days > 0) {
                        //     $formattedDifference = "$days days ";
                        // }
                        // if ($hours > 0) {
                        //     $formattedDifference .= "$hours hours ";
                        // }
                        // if ($minutes > 0) {
                        //     $formattedDifference .= "$minutes minutes";
                        // }

                        $recordingFrom = isset($row['Recording From']) ? $row['Recording From'] : '';
                        $recordingTo = isset($row['Recording To']) ? $row['Recording To'] : '';



                        $formattedDifference = '-';
                        $difference_in_days = '-';

                        if (!empty($recordingFrom) && !empty($recordingTo)) {
                            try {
                                // Calculate day difference 
                                $from_timestamp = strtotime($recordingFrom);
                                $to_timestamp = strtotime($recordingTo);
                                $difference_in_seconds = $to_timestamp - $from_timestamp;
                                $difference_in_days = $difference_in_seconds / 86400;
                                $difference_in_days = round($difference_in_days);
                                // End
                                $datetime1 = new DateTime($recordingFrom);
                                $datetime2 = new DateTime($recordingTo);

                                // Calculate the difference between two DateTime objects
                                $difference = $datetime1->diff($datetime2);

                                // Format the difference into days, hours, and optionally minutes
                                $days = $difference->days;
                                $hours = $difference->h;
                                $minutes = $difference->i;

                                // Build the formatted string
                                if ($days > 0) {
                                    $formattedDifference = "$days days ";
                                }
                                if ($hours > 0) {
                                    $formattedDifference .= "$hours hours ";
                                }
                                if ($minutes > 0) {
                                    $formattedDifference .= "$minutes minutes";
                                }
                            } catch (Exception $e) {
                                // echo 'Error: ' . $e->getMessage(); // Handle any DateTime parsing exceptions here
                            }
                        } else {
                            echo 'something in else';
                        }


                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $row['NewPanelID']; ?></td>
                            <td><?php echo $row['ATMID']; ?></td>
                            <td><?php echo $row['Panel_Make']; ?></td>
                            <td><?php echo $row['IP Address']; ?></td>
                            <td><?php echo $row['Customer']; ?></td>
                            <td><?php echo $row['SiteAddress']; ?></td>
                            <td><?php echo $row['Recording From']; ?></td>
                            <td><?php echo $row['Recording To']; ?></td>
                            <td><?php echo $formattedDifference; ?></td>
                            <td><?php echo $row['last_communication']; ?></td>
                            <td><?php echo $row['HDD Status']; ?></td>
                            <td><?php echo $row['Recording From']; ?></td>
                            <td><?php echo $row['last_communication']; ?></td>



                        </tr>
                        <?php
                        $i++;
                    }

                    ?>
                </tbody>
            </table>


        </div>
    </div>



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