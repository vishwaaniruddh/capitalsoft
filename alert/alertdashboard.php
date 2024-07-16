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
	</div>
	<?php
	$alertCloseCount = mysqli_query(
		$con,
		"SELECT closedBy, COUNT(1), DATE(receivedtime) AS alert_date FROM `alerts` WHERE `status` = 'C' AND `sendtoclient` = 'S' AND 
receivedtime >= DATE_SUB(NOW(), INTERVAL 7 DAY) 
GROUP BY DATE(receivedtime) ORDER BY alert_date DESC"
	);
	while ($alertCloseCount = mysqli_fetch_assoc($alertCloseCount)) {

		$alertClose = $alertCloseCount['closedBy'];
		$alertdate = $alertCloseCount["alert_date"];




	}

	?>


</div>





<script src="../assets/js/index3.js"></script>
<script src="../assets/js/index2.js"></script>

<?php include ('../footer.php'); ?>