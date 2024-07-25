<?php include ('../header.php'); ?>


<style>
    img#stream{
        height: 300px;
        max-height:500px;
    }
</style>
<div class="page-content">



    <?php


    $page = isset($_REQUEST['Page']) && is_numeric($_REQUEST['Page']) ? $_REQUEST['Page'] : 1;
    $records_per_page = isset($_REQUEST['perpg']) && in_array($_REQUEST['perpg'], [25, 50, 75, 100]) ? $_REQUEST['perpg'] : 10;
    $offset = ($page - 1) * $records_per_page;



    $abc = "
  SELECT
  d.UserName,
  d.Password,
  s.NewPanelID,
  
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
            class="btn btn-primary px-5 rounded-0" value="Search">
    </form>


    <div class="card">
        <div class="card-body" style="overflow:auto;">
            <table id="alldvrtable" class="table1 table table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th>Sr No</th>
                        <th>Bank Name</th>
                        <th>Panel Number</th>
                        <th>ATM Id</th>
                        <th>IP</th>
                        <th>Dvr Name</th>
                        <th>Live View</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = ($page - 1) * $records_per_page + 1;

                    while ($row = mysqli_fetch_array($result)) {
                        // Extracting values from $row
                        $bank = $row['Bank'];
                        $panelID = $row['NewPanelID'];
                        $atmID = $row['ATMID'];

                        // Extracting values for live view link
                        $username = $row['UserName'];
                        $password = $row['Password'];
                        $ip = $row['IP Address'];
                        $dvrName = $row['DVR Name'];
                        
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $bank; ?></td>
                            <td><?php echo $panelID; ?></td>
                            <td><?php echo $atmID; ?></td>
                            <td><?php echo $ip; ?></td>
                            <td><?php echo $dvrName; ?></td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal" data-port="5040" data-camera="1"
                                    data-username="<?php echo htmlspecialchars($username); ?>"
                                    data-password="<?php echo htmlspecialchars($password); ?>"
                                    data-ip="<?php echo htmlspecialchars($ip); ?>"
                                    data-dvrname="<?php echo htmlspecialchars($dvrName); ?>"
                                    >Camera 1</button>
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal" data-port="5041" data-camera="2"
                                    data-username="<?php echo htmlspecialchars($username); ?>"
                                    data-password="<?php echo htmlspecialchars($password); ?>"
                                    data-ip="<?php echo htmlspecialchars($ip); ?>"
                                    data-dvrname="<?php echo htmlspecialchars($dvrName); ?>"
                                    >Camera 2</button>
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal" data-port="5042" data-camera="3"
                                    data-username="<?php echo htmlspecialchars($username); ?>"
                                    data-password="<?php echo htmlspecialchars($password); ?>"
                                    data-ip="<?php echo htmlspecialchars($ip); ?>" 
                                    data-dvrname="<?php echo htmlspecialchars($dvrName); ?>"
                                    >Camera 3</button>
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal" data-port="5043" data-camera="4"
                                    data-username="<?php echo htmlspecialchars($username); ?>"
                                    data-password="<?php echo htmlspecialchars($password); ?>"
                                    data-ip="<?php echo htmlspecialchars($ip); ?>"
                                    data-dvrname="<?php echo htmlspecialchars($dvrName); ?>"
                                    >Camera 4</button>

                                <button type="button" class="btn btn-primary btn-sm show-all-btn" data-bs-toggle="modal"
                                    data-bs-target="#showAllModal"
                                    data-username="<?php echo htmlspecialchars($username); ?>"
                                    data-password="<?php echo htmlspecialchars($password); ?>"
                                    data-ip="<?php echo htmlspecialchars($ip); ?>"
                                    data-dvrname="<?php echo htmlspecialchars($dvrName); ?>"
                                    >Show All</button>

                             
                            </td>
                        </tr>
                        <?php
                        $i++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
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

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Live View</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe id="liveViewFrame" width="100%" height="400" frameborder="0"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="showAllModal" tabindex="-1" aria-labelledby="showAllModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showAllModalLabel">Show All Cameras</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
<div class="row"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
        $('#exampleModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var port = button.data('port'); // Extract info from data-* attributes
            var camera = button.data('camera'); // Extract info from data-* attributes
            var username = button.data('username'); // Extract username from data-* attribute
            var password = button.data('password'); // Extract password from data-* attribute
            var ip = button.data('ip'); // Extract ip from data-* attribute
            var dvrname = button.data('dvrname'); // Extract ip from data-* attribute
            var modal = $(this);

            // Construct the URL with dynamic username, password, and ip
            var url = 'http://192.168.0.27:' + port + '/?name=' + encodeURIComponent(username + '-' + password + '-' + ip + '-554-'+dvrname+'-Y');

            // Set the iframe src attribute to the constructed URL
            modal.find('.modal-body iframe').attr('src', url);
        });
    });


    $(document).ready(function () {
        // Event listener for "Show All" button click
        $('.show-all-btn').on('click', function () {
            var username = $(this).data('username');
            var password = $(this).data('password');
            var ip = $(this).data('ip');
            var dvrname = $(this).data('dvrname');

            // Construct URLs for all cameras
            var cameras = [
                { port: '5040', camera: '1' },
                { port: '5041', camera: '2' },
                { port: '5042', camera: '3' },
                { port: '5043', camera: '4' }
            ];

            // Construct HTML for iframes
            var iframeHtml = '';
            cameras.forEach(function (camera) {
                var port = camera.port;
                var url = 'http://192.168.0.27:' + port + '/?name=' + encodeURIComponent(username + '-' + password + '-' + ip + '-554-'+dvrname+'-Y');
                iframeHtml += '<div class="col-md-6 mb-4">';
                iframeHtml += '<h5>Camera ' + camera.camera + '</h5>';
                iframeHtml += '<iframe width="100%" height="300" src="' + url + '" frameborder="0"></iframe>';
                iframeHtml += '</div>';
            });

            // Update modal body with iframes
            $('#showAllModal .modal-body .row').html(iframeHtml);

            // Show the modal
            $('#showAllModal').modal('show');
        });
    });
</script>

</div>
<?php include ('../footer.php'); ?>