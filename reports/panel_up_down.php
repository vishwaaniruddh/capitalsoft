<?php include ('../header.php'); ?>

<div class="page-content">


<?php 


$list = array();
$list1 = array();
$curdate = date('Y-m-d');
$month = date('m', strtotime($curdate));

// echo $month;
$year = date('Y', strtotime(($curdate)));

for ($d = 1; $d <= 31; $d++) {
    $time = mktime(12, 0, 0, $month, $d, $year);
    if (date('m', $time) == $month) {
        $list[] = date('Y-m-d-D', $time);
        $list1[] = date('Y-m-d', $time);
    }
}

?>

<style>
    .table thead th,
    .jsgrid .jsgrid-table thead th {
        border-top: 0;
        border-bottom-width: 1px;
        font-weight: bold;
        font-size: .9rem;
        padding: 0.4375rem;
    }

    .bt {
        border-top: 1px solid #1e1f33;
    }

    .br {
        border-right: 1px solid #282844;
    }

    #accordion div.card-body {
        /*	margin:4px, 4px;
            padding:4px;
            background-color: green;
            width: 500px;  
            height: 210px;
            overflow-x: hidden;
            overflow-y: scroll; */
        text-align: justify;
    }
</style>
<style>
    .menu-icon {
        width: 33px;
        margin-right: 7%;
    }

    th,
    td {
        white-space: nowrap;
    }
</style>
    <div class="main-panel">
        <div class="content-wrapper">

            <div class="col-12 grid-margin">
            <h6 class="mb-0 text-uppercase">Site Network report As on Date :
                <?php echo date('d/m/Y'); ?></h6>
<hr />
                <?php
                include ("./sitehealth_filter.php");
                // include ('filters/newnetworkmonthyear_filtertest.php'); 
                ?>
            </div>


            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12" id="ticketview_tbody">
                            <div class="table-responsive">
                                <table id="order-listing" class="table">
                                    <thead>
                                        <tr>
                                            <th>S.N</th>
                                            <th>Client</th>
                                            <th>Bank</th>
                                            <th>ATMID</th>
                                            <th>State</th>
                                            <th>City</th>
                                            <th>Site Address</th>
                                            <th>Status</th>
                                            <?php for ($i = 0; $i < count($list1); $i++) { ?>
                                                <th>
                                                    <?php echo $list1[$i]; ?>
                                                </th>
                                            <?php } ?>
                                            <th>Ageing</th>
                                            <th>Remarks</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
      
<script src="js/panel_up_down.js"></script>



</div>
<?php include ('../footer.php'); ?>

