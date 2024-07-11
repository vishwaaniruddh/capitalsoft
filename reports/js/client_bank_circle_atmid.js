function onchange_atmid() { ;
		var bank = $("#Bank").val();
		var client = $("#Client").val();
		$("#AtmID").html('');
		$("#AtmID").html('<option value="">All Site</option>');
		$.ajax({
			type: "GET",
			url: "getMasterData.php", 
			data: {bankname:bank,clientname:client},
			dataType: "html",
			success: (function (result) { ;
				$("#AtmID").html('');
				$("#AtmID").html(result);
				//$("#load").show();
			//	getPanel_Detail();
	           
			})
		})
	}
	function onchangeatmid() { ;
	    var circle = $("#Circle").val();
		var bank = $("#Bank").val();
		
		$("#AtmID").html('');
		$("#AtmID").html('<option value="">All Site</option>');
		$.ajax({
			type: "GET",
			url: "getMasterData.php", 
			data: {circlebankname:bank,circlename:circle},
			dataType: "html",
			success: (function (result) { ;
				$("#AtmID").html('');
				$("#AtmID").html(result);
				//$("#load").show();
			//	getPanel_Detail();
	           
			})
		})
	}
function onchangebank() { 
		var client = $("#Client").val();
		//$("#online_percent_table_load").show();
		$("#Bank").html('');
		$("#Bank").html('<option value="">Select</option>');
		$("#Circle").html('');
		$("#Circle").html('<option value="">All Circle</option>');
		$("#AtmID").html('');
		$("#AtmID").html('<option value="">All Site</option>');
		$.ajax({
			type: "GET",
			url: "getMasterData.php", 
			data: {client:client},
			dataType: "html",
			success: (function (result) {
				$("#Bank").html('');
				$("#Bank").html(result);
			//	getPanel_Detail();
	            
			})
		})
	}	
function onchangecircle() { 
		var bank = $("#Bank").val();
		//$("#online_percent_table_load").show();
		$("#Circle").html('');
		$("#Circle").html('<option value="">All Circle</option>');
		$("#AtmID").html('');
		$("#AtmID").html('<option value="">All Site</option>');
		if(bank=='PNB'){
			
			
			$.ajax({
				type: "GET",
				url: "getMasterData.php", 
				data: {bankcircle:bank},
				dataType: "html",
				success: (function (result) { ;
					$("#Circle").html('');
					$("#Circle").html(result);
				//	getPanel_Detail();
					
				})
			})
		}
		onchange_atmid();
	}	
	


