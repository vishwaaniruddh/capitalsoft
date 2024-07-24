<?php
include ('./header.php');
$customer = '';
$atmid = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer = isset($_POST['customer']) ? $_POST['customer'] : '';
    $atmid = isset($_POST['atmid']) ? $_POST['atmid'] : '';
}
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

<script>
    function fetchDataPanel() {
        $('#panelData').html('');
        $('#panelDashboardDVR').html('');
        $('#panelDashboardAlert').html('');

        var atmid = $('#atmid').val();
        var customer = $('#customer').val();
        $.ajax({
            type: 'POST',
            url: 'getPanelDashboardData.php',
            data: {
                atmid: atmid,
                customer: customer,

            },
            success: function (msg) {
                $('#panelData').html(msg);
                $('#loadingmessage').hide(); // Hide the loading message after update
            }
        });
        $.ajax({
            type: 'POST',
            url: 'getPanelDashboardData_dvr.php',
            data: {
                atmid: atmid,
                customer: customer,

            },
            success: function (msg) {
                $('#panelDashboardDVR').html(msg);
                $('#loadingmessage').hide(); // Hide the loading message after update
            }
        });

        $.ajax({
            type: 'POST',
            url: 'getPanelDashboardData_alert.php',
            data: {
                atmid: atmid,
                customer: customer,
            },
            success: function (alertmsg) {
                $('#panelDashboardAlert').html(alertmsg);
                $('#loadingmessage').hide(); // Hide the loading message after update
            }
        });
    }
    $(document).ready(function () {
        // Initialize Select2 on customer dropdown
        $('#customer').select2();
        $('#atmid').select2();
        $('#customer').on('change', function () {
            var customer = $(this).val();
            var atmid = $("#atmid").val();
            if (customer !== '') {
                $.ajax({
                    type: 'POST',
                    url: './ajaxComponents/fetch_atmids.php',
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
<div class="page-content">
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
                        $result = mysqli_query($con, $query);
                        if ($result) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $selected = ($atmid == $row['ATMID']) ? 'selected' : '';
                                echo '<option value="' . $row['ATMID'] . '" ' . $selected . '>' . $row['ATMID'] . '</option>';
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
                <br>
                <button type="button" class="badge bg-primary" id="submitForm" name="submit" onclick="fetchDataPanel()"
                    value="search">Search</button>
            </div>
        </div>

    </form>
    <div id='loadingmessage' style='display:none;'>
        <div class="spinner-grow" role="status" style="margin: auto; display: block;">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div id="show">
        <style>
            .custom_box {
                height: 50px;
                width: 50px;
                border: 1px solid;
                padding: 10px;
                margin: 5px auto;
            }
        </style>
        <br> <br>
        <div class="row">
            <div class="col">
                <h6 class="mb-0 text-uppercase">Panel Dashboard</h6>
                <hr />
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-primary" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" data-bs-toggle="tab" href="#panelData" role="tab"
                                    aria-selected="true">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon"><i class='bx bx-home font-18 me-1'></i>
                                        </div>
                                        <div class="tab-title">Panel</div>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#panelDashboardDVR" role="tab"
                                    aria-selected="false">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon"><i class='bx bx-user-pin font-18 me-1'></i>
                                        </div>
                                        <div class="tab-title">Dvr</div>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#panelDashboardAlert" role="tab"
                                    aria-selected="false">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon"><i class='bx bx-microphone font-18 me-1'></i>
                                        </div>
                                        <div class="tab-title">Alert</div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content py-3">
                            <div class="tab-pane fade show active" id="panelData" role="tabpanel">
                                Panel
                            </div>
                            <div class="tab-pane fade" id="panelDashboardDVR" role="tabpanel"></div>
                            <div class="tab-pane fade" id="panelDashboardAlert" role="tabpanel"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include ('./footer.php'); ?>
<script src="<?php echo BASE_URL; ?>/assets/js/select2.min.js"></script>
<script src="<?php echo BASE_URL; ?>/assets/plugins/select2/js/select2-custom.js"></script>