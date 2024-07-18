<?php include ('./config.php');

$atmid = $_REQUEST['atmid'];
$customer = $_REQUEST['customer'];

if ($customer && $atmid) {
    $sitesql = mysqli_query($con, "SELECT * FROM all_dvr_live WHERE atmid = '$atmid'");
    if ($sitesql_result = mysqli_fetch_array($sitesql)) {



        // var_dump($sitesql_result);
        $dvrname = $dvrName = $sitesql_result['dvrname'];
        $IPAddress = $ip = $sitesql_result['IPAddress'];
        $port = $sitesql_result['port'];
        $UserName = $username = $sitesql_result['UserName'];
        $password = $sitesql_result['Password'];
        $last_communication = $sitesql_result['last_communication'];
        $latency = $sitesql_result['latency'];

        // HDD 
        $hdd = $sitesql_result['hdd'];
        $capacity = $sitesql_result['capacity'];
        $freespace = $sitesql_result['freespace'];

        $recording_from = $sitesql_result['recording_from'];
        $recording_to = $sitesql_result['recording_to'];

        // Camera 

        $cam1 = $sitesql_result['cam1'];
        $cam2 = $sitesql_result['cam2'];
        $cam3 = $sitesql_result['cam3'];
        $cam4 = $sitesql_result['cam4'];

        ?>

        <div class="div" style="display:flex;    justify-content: space-between;">
            <h6 class="mb-0 text-uppercase">DVR Info</h6>
            <input type="image" name="btnPing" id="btnPing" title="Ping" src="<?php echo BASE_URL; ?>/assets/images/reload.png"
                alt="Ping" align="left" style="width: 25px;">
        </div>
        <br>

        <div class="card bg-secondary text-center">
            <div class="row p-4 text-white rounded">
                <div class="col-sm-3">
                    <label>DVR Name :</label>
                    <span><?php echo $dvrname; ?></span>
                </div>

                <div class="col-sm-3">
                    <label>DVR IP :</label>
                    <span><?php echo $IPAddress; ?></span>
                </div>

                <div class="col-sm-3">
                    <label>DVR Port :</label>
                    <span><?php echo $dvrname; ?></span>
                </div>

                <div class="col-sm-3">
                    <label>DVR Model :</label>
                    <span><?php echo $dvrname; ?></span>
                </div>

                <div class="col-sm-3">
                    <label>User Name :</label>
                    <span><?php echo $UserName; ?></span>
                </div>

                <div class="col-sm-3">
                    <label>Password :</label>
                    <span><?php echo $password; ?></span>
                </div>

                <div class="col-sm-3">
                    <label>Last Communication :</label>
                    <span><?php echo $last_communication; ?></span>
                </div>

                <div class="col-sm-3">
                    <label>Latency :</label>
                    <span><?php echo $latency; ?></span>
                </div>

            </div>

        </div>
        <hr>
        <h6 class="mb-0 text-uppercase">Harddisk Info</h6>
        <br>
        <div class="card bg-secondary bg-gradient text-center">
            <div class="row p-4 text-white rounded">
                <div class="col-sm-3">
                    <label>HDD Status : </label>
                    <span><?php echo $hdd ?></span>
                </div>
                <div class="col-sm-3">
                    <label>HDD Capacity : </label>
                    <span><?php echo round($capacity / 1024, 2) . ' GB' ?></span>
                </div>
                <div class="col-sm-3">
                    <label>HDD FreeSpace : </label>
                    <span><?php echo round($freespace / 1024, 2) . ' GB' ?></span>
                </div>

            </div>

        </div>

        <hr>
        <h6 class="mb-0 text-uppercase">Recording Info</h6>
        <br>
        <div class="card bg-secondary bg-gradient text-center">
            <div class="row p-4 text-white rounded">
                <div class="col-sm-3">
                    <label>Recording From : </label>
                    <span><?php echo $recording_from ?></span>
                </div>
                <div class="col-sm-3">
                    <label>Recording To : </label>
                    <span><?php echo $recording_to ?></span>
                </div>

            </div>

        </div>


        <hr>
        <h6 class="mb-0 text-uppercase">Camera Info</h6>
        <br>
        <div class="card bg-secondary bg-gradient text-center">
            <div class="row p-4 text-white rounded">
                <div class="col-sm-3">
                    <label>Camera 1 : </label>
                    <span><?php echo $cam1 ?></span>
                </div>
                <div class="col-sm-3">
                    <label>Camera 2 : </label>
                    <span><?php echo $cam2 ?></span>
                </div>
                <div class="col-sm-3">
                    <label>Camera 3 : </label>
                    <span><?php echo $cam3 ?></span>
                </div>
                <div class="col-sm-3">
                    <label>Camera 4 : </label>
                    <span><?php echo $cam4 ?></span>
                </div>

                <div class="col-sm-12">
                    <p>Live View </p>
                    <hr>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal"
                        data-port="5040" data-camera="1" data-username="<?php echo htmlspecialchars($username); ?>"
                        data-password="<?php echo htmlspecialchars($password); ?>"
                        data-ip="<?php echo htmlspecialchars($ip); ?>"
                        data-dvrname="<?php echo htmlspecialchars($dvrName); ?>">Camera 1</button>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal"
                        data-port="5041" data-camera="2" data-username="<?php echo htmlspecialchars($username); ?>"
                        data-password="<?php echo htmlspecialchars($password); ?>"
                        data-ip="<?php echo htmlspecialchars($ip); ?>"
                        data-dvrname="<?php echo htmlspecialchars($dvrName); ?>">Camera 2</button>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal"
                        data-port="5042" data-camera="3" data-username="<?php echo htmlspecialchars($username); ?>"
                        data-password="<?php echo htmlspecialchars($password); ?>"
                        data-ip="<?php echo htmlspecialchars($ip); ?>"
                        data-dvrname="<?php echo htmlspecialchars($dvrName); ?>">Camera 3</button>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal"
                        data-port="5043" data-camera="4" data-username="<?php echo htmlspecialchars($username); ?>"
                        data-password="<?php echo htmlspecialchars($password); ?>"
                        data-ip="<?php echo htmlspecialchars($ip); ?>"
                        data-dvrname="<?php echo htmlspecialchars($dvrName); ?>">Camera 4</button>

                    <button type="button" class="btn btn-primary btn-sm show-all-btn" data-bs-toggle="modal"
                        data-bs-target="#showAllModal" data-username="<?php echo htmlspecialchars($username); ?>"
                        data-password="<?php echo htmlspecialchars($password); ?>"
                        data-ip="<?php echo htmlspecialchars($ip); ?>"
                        data-dvrname="<?php echo htmlspecialchars($dvrName); ?>">Show All</button>

                </div>
            </div>

        </div>





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
                    var url = 'http://192.168.0.27:' + port + '/?name=' + encodeURIComponent(username + '-' + password + '-' + ip + '-554-' + dvrname + '-Y');

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
                        var url = 'http://192.168.0.27:' + port + '/?name=' + encodeURIComponent(username + '-' + password + '-' + ip + '-554-' + dvrname + '-Y');
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


        <?php



    }
}
?>