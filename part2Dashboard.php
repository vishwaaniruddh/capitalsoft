<?php 

if($customer){

    
    $oneDaySqlAll = mysqli_query($con,"SELECT count(1) as count FROM alerts a INNER JOIN sites b 
    ON a.panelid = b.NewPanelID
    WHERE b.live='Y' AND a.receivedtime >= DATE_SUB(NOW(), INTERVAL 12 HOUR) and a.sendtoclient = 'S' and b.Customer='".$customer."'");
    
    $oneDaySqlOpen = mysqli_query($con,"SELECT count(1) as count FROM alerts a INNER JOIN sites b 
    ON a.panelid = b.NewPanelID
    WHERE b.live='Y' AND a.receivedtime >= DATE_SUB(NOW(), INTERVAL 12 HOUR) and a.sendtoclient = 'S' and a.status='O' and b.Customer='".$customer."'");
    
    $oneDaySqlClose = mysqli_query($con,"SELECT count(1) as count FROM alerts a INNER JOIN sites b 
    ON a.panelid = b.NewPanelID
    WHERE b.live='Y' AND a.receivedtime >= DATE_SUB(NOW(), INTERVAL 12 HOUR) and a.sendtoclient = 'S' and a.status='C' and b.Customer='".$customer."'");
    
    $oneDaySqlAllCritical = mysqli_query($con,"SELECT count(1) as count FROM alerts a INNER JOIN 
    sites s ON a.panelid = s.NewPanelID 
    LEFT JOIN alerttype b
    ON a.alerttype = b.alertType
    WHERE s.live='Y' AND a.receivedtime >= DATE_SUB(NOW(), INTERVAL 12 HOUR) and a.sendtoclient = 'S' and s.Customer='".$customer."'");
    
}else{
    $oneDaySqlAll = mysqli_query($con,"SELECT count(1) as count FROM alerts a INNER JOIN sites b
    ON a.panelid = b.NewPanelID
    WHERE b.live='Y' AND a.receivedtime >= DATE_SUB(NOW(), INTERVAL 12 HOUR) and a.sendtoclient = 'S'");
    
    $oneDaySqlOpen = mysqli_query($con,"SELECT count(1) as count FROM alerts a INNER JOIN sites b
    ON a.panelid = b.NewPanelID
    WHERE b.live='Y' AND a.receivedtime >= DATE_SUB(NOW(), INTERVAL 12 HOUR) and a.sendtoclient = 'S' and a.status='O'");
    
    $oneDaySqlClose = mysqli_query($con,"SELECT count(1) as count FROM alerts a INNER JOIN sites b
    ON a.panelid = b.NewPanelID
    WHERE b.live='Y' AND a.receivedtime >= DATE_SUB(NOW(), INTERVAL 12 HOUR) and a.sendtoclient = 'S' and a.status='C'");
    
    $oneDaySqlAllCritical = mysqli_query($con,"SELECT count(1) as count FROM alerts a INNER JOIN sites b
    ON a.panelid = b.NewPanelID    
    INNER JOIN alerttype c
    ON a.alerttype = c.alertType
    WHERE b.live='Y' AND a.receivedtime >= DATE_SUB(NOW(), INTERVAL 12 HOUR) and a.sendtoclient = 'S'");
    
    
}




// fetch
// 1stgraph
$oneDaySqlResult = mysqli_fetch_array($oneDaySqlAll);
$totalAlerts1day = $oneDaySqlResult['count'];

$oneDaySqlOpenResult = mysqli_fetch_array($oneDaySqlOpen);
$totalAlerts1dayOpen = $oneDaySqlOpenResult['count'];

$oneDaySqlCloseResult = mysqli_fetch_array($oneDaySqlClose);
$totalAlerts1dayClose = $oneDaySqlCloseResult['count'];


$oneDaySqlAllCriticalResult = mysqli_fetch_array($oneDaySqlAllCritical);
$oneDaySqlAllCriticalCount = $oneDaySqlAllCriticalResult['count'];



?>
<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
    <div class="col">
        <div class="card radius-10 ">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0">Total Alerts - <span style="color: #fd3550; font-size:11px;">12-hours</span></p>
                        <h5 class="mb-0"><?php echo $totalAlerts1day ; ?></h5>
                    </div>

                </div>
                <div class="" id="w-chart1"></div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card radius-10">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0">Open Alerts</p>
                        <h5 class="mb-0"><?php echo $totalAlerts1dayOpen ; ?></h5>
                    </div>


                </div>
                <div class="" id="w-chart2"></div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card radius-10">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0">Close Alerts</p>
                        <h5 class="mb-0"><?php echo $totalAlerts1dayClose ; ?></h5>
                    </div>

                </div>
                <div class="" id="w-chart3"></div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card radius-10">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0">Total Critical</p>
                        <h5 class="mb-0"><?php echo $oneDaySqlAllCriticalCount ; ?></h5>
                    </div>

                </div>
                <div class="" id="w-chart4"></div>
            </div>
        </div>
    </div>
    </div>
    <script src="assets/plugins/apexcharts-bundle/js/apexcharts.min.js"></script>

    <script>
    var customer = '<?php echo isset($_GET["customer"]) ? $_GET["customer"] : ""; ?>';
</script>
    <script src="./assets/js/widgets.js?customer=<?php echo $customer; ?>"></script>