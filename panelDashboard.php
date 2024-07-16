<?php
include ('./header.php'); // Include your header.php for consistency

// Initialize variables
$customer = '';
$atmid = '';

// Check if form submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $customer = isset($_POST['customer']) ? $_POST['customer'] : '';
    $atmid = isset($_POST['atmid']) ? $_POST['atmid'] : '';
}
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

<script>
    // Function to fetch data using AJAX
    function fetchData() {
        $('#show').html('');
        var atmid = $('#atmid').val();
        var customer = $('#customer').val();
        var Page = $('#currentPage').val(); // Assuming you are using these variables in your data object

        $.ajax({
            type: 'POST',
            url: 'getPanelDashboardData.php',
            data: {
                atmid: atmid,
                customer: customer,
                
            },
            success: function (msg) {
                $('#show').html(msg);
                $('#loadingmessage').hide(); // Hide the loading message after update
            }
        });
    }

    $(document).ready(function () {
        // Initialize Select2 on customer dropdown
        $('#customer').select2();
        $('#atmid').select2();

        // Fetch ATMIDs when customer is selected
        $('#customer').on('change', function () {
            var customer = $(this).val();
            var atmid = $("#atmid").val();
            if (customer !== '') {
                $.ajax({
                    type: 'POST',
                    url: './ajaxComponents/fetch_atmids.php',
                    data: { customer: customer,atmid:atmid },
                    success: function (response) {
                        $('#atmid').html(response);
                    }
                });
            } else {
                $('#atmid').html('<option value="">Select Customer First</option>');
            }
        });

        // Trigger change event on customer dropdown if it has a selected value initially
        if ($('#customer').val() !== '') {
            $('#customer').trigger('change');
        }

        // Set selected options based on PHP variables
        $('#customer').val('<?php echo $customer; ?>').trigger('change');
        $('#atmid').val('<?php echo $atmid; ?>').trigger('change');

        // Initial fetch data
        fetchData();

        // Setup interval to fetch data every 15 seconds
        setInterval(fetchData, 15000);
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
                <select class="form-control form-control-sm mb-3" name="atmid" id="atmid" data-placeholder="Choose ATMID">
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
                <input type="button" class="btn btn-primary px-5 rounded-0" id="submitForm" name="submit" onclick="fetchData()"
                value="search">
            </div>
        </div>

    </form>

    <div id='loadingmessage' style='display:none;'>
        <div class="spinner-grow" role="status" style="margin: auto; display: block;">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div id="show"></div>
</div>

<?php include ('./footer.php'); ?>

<script src="<?php echo BASE_URL; ?>/assets/js/select2.min.js"></script>
<script src="<?php echo BASE_URL; ?>/assets/plugins/select2/js/select2-custom.js"></script>