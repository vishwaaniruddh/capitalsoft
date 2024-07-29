<?php include ('../header.php'); ?>

<div class="page-content">
    <?php

    $customer = 'CCIL';
    $atmid = '';
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);


    // Check if form submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Retrieve form data
        $customer = isset($_POST['customer']) ? $_POST['customer'] : '';
        $atmid = isset($_POST['atmid']) ? $_POST['atmid'] : '';
    }
    ?>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <script>
        $(document).ready(function () {
            $('#customer').select2();
            $('#atmid').select2();

            $('#customer').on('change', function () {
                var customer = $(this).val();
                var atmid = $("#atmid").val();
                if (customer !== '') {
                    $.ajax({
                        type: 'POST',
                        url: '../ajaxComponents/fetch_atmids.php',
                        data: { customer: customer, atmid: atmid },
                        success: function (response) {
                            $('#atmid').html(response);
                        }
                    });
                } else {
                    $('#atmid').html('<option value="">Select Customer First</option>');
                }
            });

            if ($('#customer').val() !== '') {
                $('#customer').trigger('change');
            }

            $('#customer').val('<?php echo $customer; ?>').trigger('change');
            $('#atmid').val('<?php echo $atmid; ?>').trigger('change');
        });
    </script>


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

    $abc .= " AND d.customer LIKE '%" . $customer . "%'";
    

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
                <label for="customer">Customer:</label>
                <select name="customer" class="form-control form-control-sm mb-3" id="customer">
                    <option value="">Select Customer Name</option>
                    <?php
                    $xyzz = "SELECT name FROM customer WHERE status = 1";
                    $runxyzz = mysqli_query($con, $xyzz);
                    while ($xyzfetchcus = mysqli_fetch_array($runxyzz)) {
                        $selected = ($customer == $xyzfetchcus['name']) ? 'selected' : '';
                        echo '<option value="' . $xyzfetchcus['name'] . '" ' . $selected . '>' . $xyzfetchcus['name'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col">
                <label for="atmid">ATMID</label>
                <select class="form-control form-control-sm mb-3" name="atmid" id="atmid"
                    data-placeholder="Choose ATMID">
                    <?php
                    // Populate ATMID dropdown based on selected customer
                    if (!empty($customer)) {
                        $selected_customer = mysqli_real_escape_string($con, $customer);
                        $query = "SELECT ATMID FROM sites WHERE Customer = '$selected_customer'";
                        $selected_customer = mysqli_query($con, $query);
                        if ($selected_customer) {
                            while ($customerrow = mysqli_fetch_assoc($selected_customer)) {
                                $selected = ($atmid == $customerrow['ATMID']) ? 'selected' : '';
                                echo '<option value="' . $customerrow['ATMID'] . '" ' . $selected . '>' . $customerrow['ATMID'] . '</option>';
                            }
                        } else {
                            echo '<option value="">No ATMID found for this customer</option>';
                        }
                    } else {
                        echo '<option value="">Select Customer First</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col">
                <input type="hidden" name="Page" id="currentPage" value="<?php echo $page; ?>">
                <input type="hidden" name="perpg" id="perPage" value="<?php echo $records_per_page; ?>">
                <br>
                <input type="button" class="badge bg-primary" onclick="submitForm(<?php echo $page; ?>, <?php echo $records_per_page; ?>);"
                    class="" value="Search">
                <!-- <br>
                <button type="button" class="badge bg-primary" id="submitForm" name="submit" onclick="submitForm()"
                    value="search">Search</button> -->
            </div>
        </div>

    </form>


    <br>
    <br>
    <br>
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
                        <th>Sr No</th>
                        <th>ATM ID</th>
                        <th>ATM ID 2</th>
                        <th>State</th>
                        <th>City</th>
                        <th>Loc. Name</th>
                        <th>Main Panel functional (Y/N)</th>
                        <th>DVR (W / NW)</th>
                        <th>Hard Disk status(W/NW)</th>
                        <th>Footage Start DateTime</th>
                        <th>Footage Stop DateTime</th>
                        <th>Footage available in days</th>
                        <th>ATM Lobby Camera (W/ NW)</th>
                        <th>Back Room Camera (W/ NW)</th>
                        <th>Out Side Camera (W/ NW)</th>
                        <th>All Sensors (W/ NW)</th>
                        <th>Panic Alarm Switch (W/NW)</th>
                        <th>Hooter (W/NW)</th>
                        <th>Two-way Communicaton (W/NW)</th>
                        <th>Smoke detector (w/NW)</th>
                        <th>Glass Break Sensor (W/NW)</th>
                        <th>Backroom Door Key pad (W/NW)</th>
                        <th>ATM Removal Sensor (W/NW)</th>
                        <th>Vibration Sensor(W/NW)</th>
                        <th>Hood Sensor</th>
                        <th>Chest door open sensor(W/NW)</th>
                        <th>ATM Thermal Sensor(W/NW)</th>
                        <th>PIR Sensor(Pet Immune)(W/NW)</th>
                        <th>Speaker Mic Removal Sensor(W/NW)</th>
                        <th>AC removal (W/NW)</th>
                        <th>Lobby temperature sensor</th>
                        <th>EM Lock(W/NW)</th>
                        <th>Ageing</th>
                        <th>Site Live Date</th>
                        <th>120 Days footage not available Remarks</th>
                        <th>Vendor</th>
                        <th>Bank</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = ($page - 1) * $records_per_page + 1;
                    while ($row = mysqli_fetch_assoc($result)) {

                        $recordingFrom = null;
                        $recordingTo = null;



                        $atmid = $row['ATMID'];
                        $state = $row['State'];
                        $city = $row['City'];
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

                        $bank = $row['Bank'];
                        $live_date = $row['live_date'];



                        $SiteAddress = $row['SiteAddress'];
                        $ip = $row['IP Address'];
                        $ping_status = $row['ping_status'];
                        $hdd_status = $row['HDD Status'];

                        $cam1 = $row['cam1'];
                        $cam2 = $row['cam2'];
                        $cam3 = $row['cam3'];


                        // Get Panel Data
                        $panelsql = mysqli_query($con, "select * from panel_health where ip='" . $ip . "'");
                        $panelsql_result = mysqli_fetch_assoc($panelsql);

                        // var_dump($panelsql_result);
                        $panel_status = $panelsql_result['status'];
                        $panelMake = $panelsql_result['panelName'];


                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $atmid; ?></td>
                            <td><?php ''; ?></td>
                            <td><?php echo $state; ?></td>
                            <td><?php echo $city; ?></td>
                            <td><?php echo $SiteAddress; ?></td>
                            <td><?php echo ($panel_status == 0 ? 'Yes' : 'No'); ?></td>
                            <td><?php echo ($ping_status == 'Online' ? 'Working' : 'Not Working'); ?></td>
                            <td><?php echo $hdd_status; ?></td>
                            <td><?php echo $recordingFrom; ?></td>
                            <td><?php echo $recordingTo; ?></td>
                            <td><?php echo $difference_in_days; ?></td>
                            <td><?php echo ucwords($cam1); ?></td>
                            <td><?php echo ucwords($cam2); ?></td>
                            <td><?php echo ucwords($cam3); ?></td>

                            <td><?php echo 'Working';
                            // Dummy Here
                            ?></td>
                            <td><?php echo 'Working';
                            // Dummy Here
                            ?></td>



                            <td>
                                <?php echo getPanelZoneStatus($ip, getPanelZone($panelMake, 'Hooter')) == 0 ? 'Working' : 'Not Working'; ?>
                            </td>
                            <td>
                                <!-- Show Working by default for 2 way -->
                                <?php echo 'Working'; ?>
                            </td>
                            <td>
                                <?php echo getPanelZoneStatus($ip, getPanelZone($panelMake, 'Smoke S')) == 0 ? 'Working' : 'Not Working'; ?>
                            </td>

                            <td>
                                <?php echo getPanelZoneStatus($ip, getPanelZone($panelMake, 'glass break')) == 0 ? 'Working' : 'Not Working'; ?>
                            </td>
                            <td><?php echo 'Working';
                            // Dummy Here
                            ?></td>

                            <td>
                                <?php echo getPanelZoneStatus($ip, getPanelZone($panelMake, 'ATM removal')) == 0 ? 'Working' : 'Not Working'; ?>
                            </td>
                            <td>
                                <?php echo getPanelZoneStatus($ip, getPanelZone($panelMake, 'vibration')) == 0 ? 'Working' : 'Not Working'; ?>
                            </td>
                            <td>
                                <?php echo getPanelZoneStatus($ip, getPanelZone($panelMake, 'Hood')) == 0 ? 'Working' : 'Not Working'; ?>
                            </td>

                            <td>
                                <?php echo getPanelZoneStatus($ip, getPanelZone($panelMake, 'Chest Door')) == 0 ? 'Working' : 'Not Working'; ?>
                            </td>
                            <td><?php echo 'Working';
                            // Dummy Here Thermal
                            ?></td>
                            <td>
                                <?php echo getPanelZoneStatus($ip, getPanelZone($panelMake, 'motion')) == 0 ? 'Working' : 'Not Working'; ?>
                            </td>
                            <td>
                                <?php echo getPanelZoneStatus($ip, getPanelZone($panelMake, 'ATM SPK & MIC Removal')) == 0 ? 'Working' : 'Not Working'; ?>
                            </td>


                            <td>
                                <?php echo getPanelZoneStatus($ip, getPanelZone($panelMake, 'ATM AC')) == 0 ? 'Working' : 'Not Working'; ?>
                            </td>

                            <td>
                                <?php echo getPanelZoneStatus($ip, getPanelZone($panelMake, 'Temperature Sensor')) == 0 ? 'Working' : 'Not Working'; ?>
                            </td>
                            <td><?php echo 'Working';
                            // Dummy Here
                            ?></td>
                            <td><?php echo 'Working';
                            // Dummy Here
                            ?></td>
                            <td><?php echo convertDateFormat($live_date); ?></td>
                            <td><?php echo '_'; ?></td>
                            <td><?php echo 'CAPITALSOFTS'; ?></td>
                            <td><?php echo $bank; ?></td>


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
<script src="<?php echo BASE_URL; ?>/assets/js/select2.min.js"></script>
<script src="<?php echo BASE_URL; ?>/assets/plugins/select2/js/select2-custom.js"></script>