<?php include ('../header.php'); ?>

<div class="page-content">


    <div class="row">
        <div class="col">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">Alerts Overview</h6>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container-0">
                        <canvas id="chart1"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div><!--end row-->


    
<?php

$alertCloseCount = mysqli_query(
	$con, "SELECT closedBy, COUNT(1), DATE(receivedtime) AS alert_date FROM `alerts` WHERE `status` = 'C' AND `sendtoclient` = 'S' AND 
receivedtime >= DATE_SUB(NOW(), INTERVAL 7 DAY) 
GROUP BY DATE(receivedtime) ORDER BY alert_date DESC"
);
while($alertCloseCount = mysqli_fetch_assoc($alertCloseCount)){

	$alertClose = $alertCloseCount['closedBy'];
	$alertdate = $alertCloseCount["alert_date"];




}

?>

<div class="col d-flex">
							<div class="card radius-10 w-100">
								<div class="card-header bg-transparent">
									<div class="d-flex align-items-center">
										<div>
											<h6 class="mb-0">Profit Ratio</h6>
										</div>
										<div class="dropdown ms-auto">
											<a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class="bx bx-dots-horizontal-rounded font-22 text-option"></i>
											</a>
											<ul class="dropdown-menu">
												<li><a class="dropdown-item" href="javascript:;">Action</a>
												</li>
												<li><a class="dropdown-item" href="javascript:;">Another action</a>
												</li>
												<li>
													<hr class="dropdown-divider">
												</li>
												<li><a class="dropdown-item" href="javascript:;">Something else here</a>
												</li>
											</ul>
										</div>
									</div>
								</div>
								<div class="card-body">
									<div class="chart-container-1">
										<canvas id="chart17" width="317" height="233" style="display: block; box-sizing: border-box; height: 260px; width: 352px;"></canvas>
									  </div>
								</div>
								<ul class="list-group list-group-flush">
									<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center border-top">Gross Profit <span class="badge bg-gradient-quepal rounded-pill">25</span>
									</li>
									<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Revenue <span class="badge bg-gradient-ibiza rounded-pill">10</span>
									</li>
									<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Expense <span class="badge bg-gradient-deepblue rounded-pill">65</span>
									</li>
								</ul>
							</div>
						  </div>

</div>





<script src="../assets/js/index3.js"></script>
<script src="../assets/js/index2.js"></script>

<?php include ('../footer.php'); ?>