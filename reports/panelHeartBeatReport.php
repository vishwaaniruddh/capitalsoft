<?php include ('../header.php'); ?>

<div class="page-content">



    <style>
        th,
        td {
            white-space: nowrap;
        }

        .table>:not(caption) tr {
            background-color: inherit;
        }

        .dangeralertClass td {
            background-color: #fd3550 !important;
            color: white;
        }

        .successalertClass td {
            background-color: #15ca20 !important;
            color: white;
        }
    </style>
    <script>
        function a(strPage, perpg) {
            $('#show').html('');
            var atmid = document.getElementById("atmid").value;
            var customer = document.getElementById("customer").value;
            var panelip = document.getElementById("panelip").value;
            var panelName = document.getElementById("panelName").value;

            var Page = "";
            if (strPage != "") {
                Page = strPage;
            }

            // Function to fetch data using AJAX
            function fetchData() {
                var showElement = $('#datatable-buttons');
                var originalScrollLeft = showElement.scrollLeft();

                $.ajax({
                    type: 'POST',
                    url: '../ajaxComponents/getPanelHeartbeatData.php',
                    data: {
                        atmid: atmid,
                        customer: customer,
                        panelip: panelip,
                        panelName: panelName,
                        Page: Page,
                        perpg: perpg,
                    },
                    success: function (msg) {

                        $('#show').html(msg);
                        // Restore scroll position only if there was a previous scroll position
                        if (originalScrollLeft > 0) {
                            showElement.scrollLeft(originalScrollLeft);
                        }

                        $('#loadingmessage').hide(); // Hide the loading message after update
                    }
                });
            }

            // Initial fetch
            fetchData();

        }

    </script>

    <form id="searchForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <div class="row">
            <div class="col">
                <label for="">ATMID</label>
                <input type="text" name="atmid" id="atmid" class="form-control form-control-sm mb-3"
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
                <label for="">Panel IP</label>
                <input type="text" name="panelip" id="panelip" class="form-control form-control-sm mb-3"
                    value="<?php echo isset($_REQUEST['panelip']) ? $_REQUEST['panelip'] : ''; ?>" />
            </div>
            <div class="col">
                <label for="">Panel Make</label>
                <select name="panelName" id="panelName" class="form-control form-control-sm mb-3">
                    <option value="">Select</option>
                    <?php
                    $panelNamesql = mysqli_query($con, "select distinct(panelName) as panelName from panel_health");
                    while ($panelNamesqlResult = mysqli_fetch_assoc($panelNamesql)) {
                        $panelName = $panelNamesqlResult["panelName"];

                        ?>
                        <option value="<?php echo $panelName; ?>"><?php echo $panelName; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col">
                <br>
                <button type="button" class="badge bg-primary btn btn-primary" id="submitForm" name="submit"
                    onclick="a('','')" value="search">Search</button>
            </div>
        </div>
        <input type="hidden" name="Page" id="currentPage" value="<?php echo $page; ?>">
        <input type="hidden" name="perpg" id="perPage" value="<?php echo $records_per_page; ?>">


    </form>

    <div id='loadingmessage' style='display:none;'>
        <div class="spinner-grow" role="status" style="margin: auto;
    display: block;"> <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div id="show"></div>



</div>
<?php include ('../footer.php'); ?>