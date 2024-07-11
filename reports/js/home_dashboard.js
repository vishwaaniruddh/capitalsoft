
getPanel_Detail()
function getPanel_Detail() {
	var Client = 'Hitachi';
	var Bank = 'PNB';

	$("#load").show();
	$.ajax({
		url: "home_dashboard_ajax.php",
		type: "POST",
		data: { client: Client, bank: Bank },
		success: (function (result) {
			$("#load").hide();
			;

			console.log(result);
			var obj = JSON.parse(result);
			if (obj[0].code == 200) {
				var total_site = obj[0].total_site;
				$("#total_site").html(total_site);
				var site_working = obj[0].site_working;
				$("#site_working").html(site_working);
				var site_notworking = obj[0].site_notworking;
				$("#site_notworking").html(site_notworking);

				var ai_total_site = obj[0].ai_total_site;
				$("#ai_total_site").html(ai_total_site);
				var ai_site_working = obj[0].ai_site_working;
				$("#ai_site_working").html(ai_site_working);
				var ai_site_notworking = obj[0].ai_site_notworking;
				$("#ai_site_notworking").html(ai_site_notworking);

				var hdd_fault = obj[0].hdd_fault;
				$("#hdd_fault").html(hdd_fault);

				var hdd_working = obj[0].hdd_working;
				var hdd_notworking = obj[0].hdd_notworking;
				createChart(site_working, site_notworking);
				createaiChart(ai_site_working, ai_site_notworking);
				createhddChart(hdd_working, hdd_notworking);
			}


		})
	});
}

function createChart(site_working, site_notworking) {

	Highcharts.chart('container', {
		chart: {
			plotBackgroundColor: null,
			plotBorderWidth: null,
			plotShadow: true,
			type: 'pie'
		},
		title: {
			text: 'Total Sites Online & Offline',
			align: 'left'
		},
		tooltip: {
			pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
		},
		accessibility: {
			point: {
				valueSuffix: '%'
			}
		},
		plotOptions: {
			pie: {
				allowPointSelect: true,
				cursor: 'pointer',
				dataLabels: {
					enabled: true,
					format: '<b>{point.name}</b>: {point.percentage:.1f} %'
				}
			}
		},
		series: [{
			name: 'Sites',
			colorByPoint: true,
			data: [{
				name: 'Online',
				y: site_working,
				sliced: true,
				color: '#00FF00'

			}, {
				name: 'Offline',
				y: site_notworking,
				color: '#ff0000'
			}]
		}]
	});
}

function createaiChart(ai_site_working, ai_site_notworking) {
	var c3PieChart = c3.generate({
		bindto: '#c3-pie-chart',
		data: {
			// iris data from R
			columns: [
				['Online', ai_site_working],
				['Offline', ai_site_notworking],
			],
			type: 'pie',
			onclick: function (d, i) {
				console.log("onclick", d, i);
			},
			onmouseover: function (d, i) {
				console.log("onmouseover", d, i);
			},
			onmouseout: function (d, i) {
				console.log("onmouseout", d, i);
			}
		},
		color: {
			pattern: ['#00FF00', '#FF0000']
		},
		padding: {
			top: 0,
			right: 0,
			bottom: 30,
			left: 0,
		},
		title: {
			text: 'Total AI Sites Online & Offline', // Specify the chart title
			position: 'top-center',
			// fontSize: 16,
			style: {
				'font-weight': 'bold', // Make the title bold
				'font-size': '20px' // Set the font size as needed
			}
		},
	});

	// setTimeout(function () {
	// 	c3PieChart.load({
	// 		columns: [
	// 			['Online', ai_site_working],
	// 			['Offline', ai_site_notworking],
	// 			// ["Revenue", 2.5, 1.9, 2.1, 1.8, 2.2, 2.1, 1.7, 1.8, 1.8, 2.5, 2.0, 1.9, 2.1, 2.0, 2.4, 2.3, 1.8, 2.2, 2.3, 1.5, 2.3, 2.0, 2.0, 1.8, 2.1, 1.8, 1.8, 1.8, 2.1, 1.6, 1.9, 2.0, 2.2, 1.5, 1.4, 2.3, 2.4, 1.8, 1.8, 2.1, 2.4, 2.3, 1.9, 2.3, 2.5, 2.3, 1.9, 2.0, 2.3, 1.8],
	// 		]
	// 	});
	// }, 600000);

	setTimeout(function () {
		c3PieChart.unload({
			ids: 'Online'
		});
		c3PieChart.unload({
			ids: 'Offline'
		});
	}, 720000);
}
function createhddChart(hdd_working, hdd_notworking) {


	var PieData = {
		datasets: [{
			data: [0, 0],
			backgroundColor: [
				'rgba(0, 255, 0, 0.5)',
				'rgba(255, 0, 0, 0.5)',
			],
			borderColor: [
				'rgba(0, 255, 0, 1)',
				'rgba(255,0,0,1)',
			],
		}],

		// These labels appear in the legend and in the tooltips when hovering different arcs
		labels: [
			'Work in Progress',
			'Close',

		]
	};
	var PieOptions = {
		responsive: true,
		title: {
			display: true,
			text: 'HDD Online & Offline',
			fontSize: 20, // You can adjust the font size as needed
			// position: 'top-center',

		},
		animation: {
			animateScale: true,
			animateRotate: true
		}
	};
	// Use Chart.js to create/update the chart using chartData
	// Example code for creating a Chart.js chart:
	var ctx = document.getElementById('pieChart').getContext('2d');

	var chart = new Chart(ctx, {
		// Configure the chart type, data, and options based on chartData
		type: 'pie',
		data: PieData,
		options: PieOptions
	});


}

