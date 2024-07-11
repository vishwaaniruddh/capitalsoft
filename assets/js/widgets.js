$(function () {
	"use strict";
	// var e = {
	// 	series: [{
	// 		name: "Total Users",
	// 		data: [240, 161, 671, 414, 555, 257, 901, 613, 727, 414, 555, 257]
	// 	}],
	// 	chart: {
	// 		type: "line",
	// 		height: 65,
	// 		toolbar: {
	// 			show: !1
	// 		},
	// 		zoom: {
	// 			enabled: !1
	// 		},
	// 		dropShadow: {
	// 			enabled: !0,
	// 			top: 3,
	// 			left: 14,
	// 			blur: 4,
	// 			opacity: .12,
	// 			color: "#17a00e"
	// 		},
	// 		sparkline: {
	// 			enabled: !0
	// 		}
	// 	},
	// 	markers: {
	// 		size: 0,
	// 		colors: ["#17a00e"],
	// 		strokeColors: "#fff",
	// 		strokeWidth: 2,
	// 		hover: {
	// 			size: 7
	// 		}
	// 	},
	// 	plotOptions: {
	// 		bar: {
	// 			horizontal: !1,
	// 			columnWidth: "45%",
	// 			endingShape: "rounded"
	// 		}
	// 	},
	// 	dataLabels: {
	// 		enabled: !1
	// 	},
	// 	stroke: {
	// 		show: !0,
	// 		width: 2.4,
	// 		curve: "smooth"
	// 	},
	// 	colors: ["#17a00e"],
	// 	xaxis: {
	// 		categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
	// 	},
	// 	fill: {
	// 		opacity: 1
	// 	},
	// 	tooltip: {
	// 		theme: "dark",
	// 		fixed: {
	// 			enabled: !1
	// 		},
	// 		x: {
	// 			show: !1
	// 		},
	// 		y: {
	// 			title: {
	// 				formatter: function (e) {
	// 					return ""
	// 				}
	// 			}
	// 		},
	// 		marker: {
	// 			show: !1
	// 		}
	// 	}
	// };

	var url = window.location.href;
	var queryString = url.split('?')[1];

	var customer = null;
	if (queryString) {
		var params = queryString.split('&');
		for (var i = 0; i < params.length; i++) {
			var param = params[i].split('=');
			if (param[0] === 'customer') {
				customer = param[1];
				break; // Exit the loop once found
			}
		}
	}
	console.log('Customer:', customer);
	$.ajax({
		type: "POST",
		url: "../../vertical/ajaxComponents/getpart2_1.php",
		data: { customer: customer },
		success: function (response) {
			var a = JSON.parse(response);

			if (a.data) {
				// Parse categories from JSON string to array
				var categories = JSON.parse(a.categories);
				var data = a.data.split(',').map(Number);

				var allalertsjson = {
					series: [{
						name: "Alert Counts",
						data: data
					}],
					chart: {
						type: "bar",
						height: 65,
						toolbar: {
							show: false
						},
						zoom: {
							enabled: false
						},
						dropShadow: {
							enabled: true,
							top: 3,
							left: 14,
							blur: 4,
							opacity: 0.12,
							color: "#f41127"
						},
						sparkline: {
							enabled: true
						}
					},
					markers: {
						size: 0,
						colors: ["#f41127"],
						strokeColors: "#fff",
						strokeWidth: 2,
						hover: {
							size: 7
						}
					},
					plotOptions: {
						bar: {
							horizontal: false,
							columnWidth: "35%",
							endingShape: "rounded"
						}
					},
					dataLabels: {
						enabled: false
					},
					stroke: {
						show: true,
						width: 0,
						curve: "smooth"
					},
					colors: ["#f41127"],
					xaxis: {
						categories: categories
					},
					fill: {
						opacity: 1
					},
					tooltip: {
						theme: "dark",
						fixed: {
							enabled: false
						},
						x: {
							show: false
						},
						y: {
							title: {
								formatter: function (e) {
									return "";
								}
							}
						},
						marker: {
							show: false
						}
					}
				};

				console.log(allalertsjson);

				new ApexCharts(document.querySelector("#w-chart1"), allalertsjson).render();
			} else {
				$("#w-chart1").html('<hr><h5>No Data to show</h5>');
			}

		}
	});




	$.ajax({
		type: "POST",
		url: "../../vertical/ajaxComponents/getpart2_2.php",
		data: { customer: customer },
		success: function (response) {

			// console.log(response)
			var b = JSON.parse(response);
			if (b.data) {
			// Parse categories from JSON string to array
			var categories = JSON.parse(b.categories);
			var data = b.data.split(',').map(Number);


			var openAlerts = {
				series: [{
					name: "Avg. Session Duration",
					data: data
				}],
				chart: {
					type: "line",
					height: 65,
					toolbar: {
						show: !1
					},
					zoom: {
						enabled: !1
					},
					dropShadow: {
						enabled: !0,
						top: 3,
						left: 14,
						blur: 4,
						opacity: .12,
						color: "#0d6efd"
					},
					sparkline: {
						enabled: !0
					}
				},
				markers: {
					size: 0,
					colors: ["#0d6efd"],
					strokeColors: "#fff",
					strokeWidth: 2,
					hover: {
						size: 7
					}
				},
				plotOptions: {
					bar: {
						horizontal: !1,
						columnWidth: "45%",
						endingShape: "rounded"
					}
				},
				dataLabels: {
					enabled: !1
				},
				stroke: {
					show: !0,
					width: 2.4,
					curve: "smooth"
				},
				colors: ["#0d6efd"],
				xaxis: {
					categories: categories
				},
				fill: {
					opacity: 1
				},
				tooltip: {
					theme: "dark",
					fixed: {
						enabled: !1
					},
					x: {
						show: !1
					},
					y: {
						title: {
							formatter: function (e) {
								return ""
							}
						}
					},
					marker: {
						show: !1
					}
				}
			};

			new ApexCharts(document.querySelector("#w-chart2"), openAlerts).render();


			}
			else {
				$("#w-chart2").html('<h5>No Data to show</h5>');
			}
		}
	});


	$.ajax({
		type: "POST",
		url: "../../vertical/ajaxComponents/getpart2_3.php",
		data: { customer: customer },
		success: function (response) {
			var c = JSON.parse(response);

			// Parse categories from JSON string to array
			var categories = JSON.parse(c.categories);
			var data = c.data.split(',').map(Number);



			var closeAlerts = {
				series: [{
					name: "Bounce Rate",
					data: data
				}],
				chart: {
					type: "bar",
					height: 65,
					toolbar: {
						show: !1
					},
					zoom: {
						enabled: !1
					},
					dropShadow: {
						enabled: !0,
						top: 3,
						left: 14,
						blur: 4,
						opacity: .12,
						color: "#ffb207"
					},
					sparkline: {
						enabled: !0
					}
				},
				markers: {
					size: 0,
					colors: ["#ffb207"],
					strokeColors: "#fff",
					strokeWidth: 2,
					hover: {
						size: 7
					}
				},
				plotOptions: {
					bar: {
						horizontal: !1,
						columnWidth: "35%",
						endingShape: "rounded"
					}
				},
				dataLabels: {
					enabled: !1
				},
				stroke: {
					show: !0,
					width: 0,
					curve: "smooth"
				},
				colors: ["#ffb207"],
				xaxis: {
					categories: categories
				},
				fill: {
					opacity: 1
				},
				tooltip: {
					theme: "dark",
					fixed: {
						enabled: !1
					},
					x: {
						show: !1
					},
					y: {
						title: {
							formatter: function (e) {
								return ""
							}
						}
					},
					marker: {
						show: !1
					}
				}
			};

			new ApexCharts(document.querySelector("#w-chart3"), closeAlerts).render();
		}
	});



	$.ajax({
		type: "POST",
		url: "../../vertical/ajaxComponents/getpart2_4.php",
		data: { customer: customer },
		success: function (response) {
			var d = JSON.parse(response);
			console.table(response)
			if (d.data) {

			// Parse categories from JSON string to array
			var categories = JSON.parse(d.categories);
			var data = d.data.split(',').map(Number);

			var criticalAlerts = {
				series: [{
					name: "Total Orders",
					data: data
				}],
				chart: {
					type: "area",
					height: 65,
					toolbar: {
						show: !1
					},
					zoom: {
						enabled: !1
					},
					dropShadow: {
						enabled: !0,
						top: 3,
						left: 14,
						blur: 4,
						opacity: .12,
						color: "#f41127"
					},
					sparkline: {
						enabled: !0
					}
				},
				markers: {
					size: 0,
					colors: ["#f41127"],
					strokeColors: "#fff",
					strokeWidth: 2,
					hover: {
						size: 7
					}
				},
				plotOptions: {
					bar: {
						horizontal: !1,
						columnWidth: "45%",
						endingShape: "rounded"
					}
				},
				dataLabels: {
					enabled: !1
				},
				stroke: {
					show: !0,
					width: 2.4,
					curve: "smooth"
				},
				colors: ["#f41127"],
				xaxis: {
					categories: categories
				},
				fill: {
					opacity: 1
				},
				tooltip: {
					theme: "dark",
					fixed: {
						enabled: !1
					},
					x: {
						show: !1
					},
					y: {
						title: {
							formatter: function (e) {
								return ""
							}
						}
					},
					marker: {
						show: !1
					}
				}
			};
			new ApexCharts(document.querySelector("#w-chart4"), criticalAlerts).render();
		}else{
			$("#w-chart4").html('<hr><h5>No Data to show</h5>');

		}

		}
	});

	// new ApexCharts(document.querySelector("#w-chart5"), e).render();
	// e = {
	// 	series: [{
	// 		name: "Total Income",
	// 		data: [240, 166, 671, 414, 555, 257, 901, 613, 727, 414, 555, 257]
	// 	}],
	// 	chart: {
	// 		type: "area",
	// 		height: 65,
	// 		toolbar: {
	// 			show: !1
	// 		},
	// 		zoom: {
	// 			enabled: !1
	// 		},
	// 		dropShadow: {
	// 			enabled: !0,
	// 			top: 3,
	// 			left: 14,
	// 			blur: 4,
	// 			opacity: .12,
	// 			color: "#0d6efd"
	// 		},
	// 		sparkline: {
	// 			enabled: !0
	// 		}
	// 	},
	// 	markers: {
	// 		size: 0,
	// 		colors: ["#0d6efd"],
	// 		strokeColors: "#fff",
	// 		strokeWidth: 2,
	// 		hover: {
	// 			size: 7
	// 		}
	// 	},
	// 	plotOptions: {
	// 		bar: {
	// 			horizontal: !1,
	// 			columnWidth: "45%",
	// 			endingShape: "rounded"
	// 		}
	// 	},
	// 	dataLabels: {
	// 		enabled: !1
	// 	},
	// 	stroke: {
	// 		show: !0,
	// 		width: 2.4,
	// 		curve: "smooth"
	// 	},
	// 	colors: ["#0d6efd"],
	// 	xaxis: {
	// 		categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
	// 	},
	// 	fill: {
	// 		opacity: 1
	// 	},
	// 	tooltip: {
	// 		theme: "dark",
	// 		fixed: {
	// 			enabled: !1
	// 		},
	// 		x: {
	// 			show: !1
	// 		},
	// 		y: {
	// 			title: {
	// 				formatter: function (e) {
	// 					return ""
	// 				}
	// 			}
	// 		},
	// 		marker: {
	// 			show: !1
	// 		}
	// 	}
	// };
	// new ApexCharts(document.querySelector("#w-chart6"), e).render();
	// e = {
	// 	series: [{
	// 		name: "Total Users",
	// 		data: [240, 164, 671, 414, 555, 257, 901, 613, 727, 414, 555, 257]
	// 	}],
	// 	chart: {
	// 		type: "area",
	// 		height: 65,
	// 		toolbar: {
	// 			show: !1
	// 		},
	// 		zoom: {
	// 			enabled: !1
	// 		},
	// 		dropShadow: {
	// 			enabled: !0,
	// 			top: 3,
	// 			left: 14,
	// 			blur: 4,
	// 			opacity: .12,
	// 			color: "#ffb207"
	// 		},
	// 		sparkline: {
	// 			enabled: !0
	// 		}
	// 	},
	// 	markers: {
	// 		size: 0,
	// 		colors: ["#ffb207"],
	// 		strokeColors: "#fff",
	// 		strokeWidth: 2,
	// 		hover: {
	// 			size: 7
	// 		}
	// 	},
	// 	plotOptions: {
	// 		bar: {
	// 			horizontal: !1,
	// 			columnWidth: "45%",
	// 			endingShape: "rounded"
	// 		}
	// 	},
	// 	dataLabels: {
	// 		enabled: !1
	// 	},
	// 	stroke: {
	// 		show: !0,
	// 		width: 2.4,
	// 		curve: "smooth"
	// 	},
	// 	colors: ["#ffb207"],
	// 	xaxis: {
	// 		categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
	// 	},
	// 	fill: {
	// 		opacity: 1
	// 	},
	// 	tooltip: {
	// 		theme: "dark",
	// 		fixed: {
	// 			enabled: !1
	// 		},
	// 		x: {
	// 			show: !1
	// 		},
	// 		y: {
	// 			title: {
	// 				formatter: function (e) {
	// 					return ""
	// 				}
	// 			}
	// 		},
	// 		marker: {
	// 			show: !1
	// 		}
	// 	}
	// };
	// new ApexCharts(document.querySelector("#w-chart7"), e).render();
	// e = {
	// 	series: [{
	// 		name: "Comments",
	// 		data: [240, 1120, 671, 414, 555, 257, 901, 613, 727, 414, 555, 257]
	// 	}],
	// 	chart: {
	// 		type: "area",
	// 		height: 65,
	// 		toolbar: {
	// 			show: !1
	// 		},
	// 		zoom: {
	// 			enabled: !1
	// 		},
	// 		dropShadow: {
	// 			enabled: !0,
	// 			top: 3,
	// 			left: 14,
	// 			blur: 4,
	// 			opacity: .12,
	// 			color: "#17a00e"
	// 		},
	// 		sparkline: {
	// 			enabled: !0
	// 		}
	// 	},
	// 	markers: {
	// 		size: 0,
	// 		colors: ["#17a00e"],
	// 		strokeColors: "#fff",
	// 		strokeWidth: 2,
	// 		hover: {
	// 			size: 7
	// 		}
	// 	},
	// 	plotOptions: {
	// 		bar: {
	// 			horizontal: !1,
	// 			columnWidth: "45%",
	// 			endingShape: "rounded"
	// 		}
	// 	},
	// 	dataLabels: {
	// 		enabled: !1
	// 	},
	// 	stroke: {
	// 		show: !0,
	// 		width: 2.4,
	// 		curve: "smooth"
	// 	},
	// 	colors: ["#17a00e"],
	// 	xaxis: {
	// 		categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
	// 	},
	// 	fill: {
	// 		opacity: 1
	// 	},
	// 	tooltip: {
	// 		theme: "dark",
	// 		fixed: {
	// 			enabled: !1
	// 		},
	// 		x: {
	// 			show: !1
	// 		},
	// 		y: {
	// 			title: {
	// 				formatter: function (e) {
	// 					return ""
	// 				}
	// 			}
	// 		},
	// 		marker: {
	// 			show: !1
	// 		}
	// 	}
	// };
	// new ApexCharts(document.querySelector("#w-chart8"), e).render()
});