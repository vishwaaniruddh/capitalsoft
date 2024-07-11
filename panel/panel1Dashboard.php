<?php


$customer = $_REQUEST['customer'];

if ($customer) {



    $query1 = "SELECT count(1) as count from panel_health a
        INNER JOIN 
        sites b ON a.panelid = b.NewPanelID
        WHERE b.live='Y' and b.Customer='" . $customer . "'";

    $queries = [$query1];
    $results = [];
    foreach ($queries as $query) {
        $result = mysqli_query($con, $query);
        $count = mysqli_fetch_assoc($result)['count'];
        $results[] = $count;
    }


    $query3 = "SELECT 
        COUNT(CASE WHEN a.status = 0 THEN 1 END) AS online_count,
        COUNT(CASE WHEN a.status != 0 THEN 1 END) AS offline_count
        FROM 
        panel_health a
        INNER JOIN 
        sites b ON a.panelid = b.NewPanelID
        WHERE b.live='Y' and b.Customer='" . $customer . "'
        ";


} else {
    $query1 = "SELECT count(1) as count from panel_health";
    // $query2 = "SELECT count(1) as count from panel_health where status=1";
    // $query3 = "SELECT count(1) as count from panel_health where status=0";

    $queries = [$query1];
    $results = [];
    foreach ($queries as $query) {
        $result = mysqli_query($con, $query);
        $count = mysqli_fetch_assoc($result)['count'];
        $results[] = $count;
    }


    $query3 = "SELECT 
    COUNT(CASE WHEN a.status = 0 THEN 1 END) AS online_count,
    COUNT(CASE WHEN a.status != 0 THEN 1 END) AS offline_count
    FROM 
    panel_health a
    INNER JOIN 
    sites b ON a.panelid = b.NewPanelID
    WHERE b.live='Y'
    ";

}


//3rd
$panelStatusCountSql = mysqli_query($con, $query3);
$panelStatusResult = mysqli_fetch_assoc($panelStatusCountSql);
$panelOffline = $panelStatusResult['offline_count'];
$panelOnline = $panelStatusResult['online_count'];



?>

<div class="row">
    <div class="col">
        <div class="card radius-10 bg-gradient-cosmic">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <p class="mb-0 text-white">Total Panel</p>
                        <h4 class="my-1 text-white"><?php echo $results[0]; ?></h4>
                    </div>
                    <div id="chart1"><canvas width="81" height="35"
                            style="display: inline-block; width: 81px; height: 35px; vertical-align: top;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card radius-10 bg-gradient-ibiza">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <p class="mb-0 text-white">Total Online</p>
                        <h4 class="my-1 text-white"><?php echo $panelOnline; ?></h4>
                    </div>
                    <div id="chart2"><canvas width="80" height="40"
                            style="display: inline-block; width: 80px; height: 40px; vertical-align: top;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card radius-10 bg-gradient-ohhappiness">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <p class="mb-0 text-white">Total Offline</p>
                        <h4 class="my-1 text-white"><?php echo $panelOffline; ?></h4>
                    </div>
                    <div id="chart3"><canvas width="75" height="40"
                            style="display: inline-block; width: 75px; height: 40px; vertical-align: top;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="card w-100 radius-10">

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-items-center table-flush align-middle">
                        <thead>
                            <tr class="table-primary">
                                <th>Panel</th>
                                <th>Total</th>
                                <th>Online</th>
                                <th>Offline</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total_records = 0;
                            $total_online = 0;
                            $total_offline = 0;

                            $panelsql = mysqli_query($con, 'SELECT panelName,
                                                        COUNT(*) as total,
                                                        SUM(status = 1) as online,
                                                        SUM(status = 0) as offline
                                                        FROM panel_health
                                                        GROUP BY panelName');

                            while ($panelsqlResult = mysqli_fetch_assoc($panelsql)) {
                                $total_records += $panelsqlResult['total'];
                                $total_online += $panelsqlResult['online'];
                                $total_offline += $panelsqlResult['offline'];
                                ?>
                                <tr>
                                    <td><?php echo strtoupper($panelsqlResult['panelName']); ?></td>
                                    <td><?php echo $panelsqlResult['total']; ?></td>
                                    <td><?php echo $panelsqlResult['online']; ?></td>
                                    <td><?php echo $panelsqlResult['offline']; ?></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td></td>
                                <td> <?php echo $total_records; ?></td>
                                <td> <?php echo $total_online; ?></td>
                                <td> <?php echo $total_offline; ?></td>
                            </tr>
                        </tbody>
                    </table>


                </div>

            </div>
        </div>

    </div>
</div>