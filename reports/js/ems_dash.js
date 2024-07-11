var table = $('#example').DataTable();
$("#show_detail").click(function(){  ;
//	getPanel_Detail();
var AtmID = $("#AtmID").val();
if(AtmID==''){
	swal("Oops!", "Atm ID Must Required !", "error");
	return false;
}
var obj_data = mac_id_arr.filter(character => character.atmid === AtmID);
if(obj_data.length==0){
	swal("Oops!", "Data Not Found !", "error");
	return false;
}else{
	var macid = obj_data[0].mac_id;
	if(macid!=''){
	   var device_name = obj_data[0].more_details.panel_name;
	   var label_1 = obj_data[0].more_details.label_1;
	   var label_1_value = obj_data[0].more_details.r1_phase_status;
	   var label_1_html = '<i class="fas fa-2x fa-lightbulb"></i>';
	   if(label_1_value==1){
		   label_1_html = '<i class="far fa-2x fa-lightbulb"></i>';
	   }
	   var label_2 = obj_data[0].more_details.label_2;
	   var label_2_value = obj_data[0].more_details.r2_phase_status;
	   var label_2_html = '<i class="fas fa-2x fa-lightbulb"></i>';
	   if(label_2_value==1){
		   label_2_html = '<i class="far fa-2x fa-lightbulb"></i>';
	   }
	   var label_3 = obj_data[0].more_details.label_3;
	   var label_3_value = obj_data[0].more_details.r3_phase_status;
	   var label_3_html = '<i class="fas fa-2x fa-lightbulb"></i>';
	   if(label_3_value==1){
		   label_3_html = '<i class="far fa-2x fa-lightbulb"></i>';
	   }
	   var label_4 = obj_data[0].more_details.label_4;
	   var label_4_value = obj_data[0].more_details.r4_phase_status;
	   var label_4_html = '<i class="fas fa-2x fa-lightbulb"></i>';
	   if(label_4_value==1){
		   label_4_html = '<i class="far fa-2x fa-lightbulb"></i>';
	   }
	   var label_5 = obj_data[0].more_details.label_5;
	   var label_5_value = obj_data[0].more_details.r5_phase_status;
	   var label_5_html = '<i class="fas fa-2x fa-lightbulb"></i>';
	   if(label_5_value==1){
		   label_5_html = '<i class="far fa-2x fa-lightbulb"></i>';
	   }
	   var last_online_at = convert_to_readable_datetime(obj_data[0].more_details.last_online_at);
	   var thead = "<thead><th>Device</th><th>Serial No.</th><th>"+label_1+"</th><th>"+label_2+"</th><th>"+label_3+"</th><th>"+label_4+"</th><th>"+label_5+"</th><th>Last Online</th></thead>";
	   var tbody = "<tbody><tr><td>"+device_name+"</td><td>"+macid+"</td><td>"+label_1_html+"</td><td>"+label_2_html+"</td><td>"+label_3_html+"</td><td>"+label_4_html+"</td><td>"+label_5_html+"</td><td>"+last_online_at+"</td></tr></tbody>";
	   var total_html = thead + tbody;
	   table.destroy();
		$('#example').html(total_html);
		table = $('#example').DataTable();
	  getMac_Detail(macid);
	}
}
})

$("#Bank").change(function(){ 
	getPanel_Detail();
	
})

var mac_id_arr = "";
        function getPanel_Detail(){
	        var Client = $("#Client").val();
			var Bank = $("#Bank").val();
			var AtmID = $("#AtmID").val();
			var Circle = $("#Circle").val();
			var userid = $("#usr").val();
			//AtmID = "P1DCHY03";
			
			if(userid==""){
				window.location.href="login.php";
			}
			if(Client==''){
				swal("Oops!", "Client Must Required !", "error");
				return false;
			}
			
			/*if(AtmID==''){
				swal("Oops!", "AtmID Must Required !", "error");
				return false;
			}*/
			$("#load").show();
			
			$.ajax({
				url: "api/get_ems_devicelist.php", 
				type: "POST",
				data: {client:Client,bank:Bank,user_id:userid},
				success: (function (result) { ;
				   $("#load").hide();
				   
				   console.log(result);
				   var obj = JSON.parse(result);
				   mac_id_arr = obj[0].res_data;
				//   const test = obj[0].res_data.more_details;
				    var html_data = "";
				   for (const [key, value] of Object.entries(mac_id_arr)) {
					   if(key==0){
						   
							   var label_1 = value.more_details.label_1;
							   $("#label_1").html(label_1);
						       var label_2 = value.more_details.label_2;
							   $("#label_2").html(label_2);
							   var label_3 = value.more_details.label_3;
							   $("#label_3").html(label_3);
							   var label_4 = value.more_details.label_4;
							   $("#label_4").html(label_4);
							   var label_5 = value.more_details.label_5;
							   $("#label_5").html(label_5);
							   var thead = "<thead><tr><th>Devices</th><th>Serial No.</th><th>"+label_1+"</th><th>"+label_2+"</th><th>"+label_3+"</th><th>"+label_4+"</th><th>"+label_5+"</th><th>last online</th></tr></thead>";
					   }
					   html_data += "<tr>";
					   html_data += "<td>"+value.more_details.panel_name+"</td>";
                       html_data += "<td>"+value.more_details.mac_id+"</td>"; 
					   var r1_phase_status = '<i class="fas fa-2x fa-lightbulb"></i>';
					   if(value.more_details.r1_phase_status==1){
						   r1_phase_status = '<i class="far fa-2x fa-lightbulb"></i>';
					   }
					   html_data += "<td>"+r1_phase_status+"</td>"; 
					   
					    var r2_phase_status = '<i class="fas fa-2x fa-lightbulb"></i>';
					   if(value.more_details.r2_phase_status==1){
						   r2_phase_status = '<i class="far fa-2x fa-lightbulb"></i>';
					   }
					   html_data += "<td>"+r2_phase_status+"</td>"; 
					   
					    var r3_phase_status = '<i class="fas fa-2x fa-lightbulb"></i>';
					   if(value.more_details.r3_phase_status==1){
						   r3_phase_status = '<i class="far fa-2x fa-lightbulb"></i>';
					   }
					   html_data += "<td>"+r3_phase_status+"</td>"; 
					   
					   var r4_phase_status = '<i class="fas fa-2x fa-lightbulb"></i>';
					   if(value.more_details.r4_phase_status==1){
						   r4_phase_status = '<i class="far fa-2x fa-lightbulb"></i>';
					   }
					   html_data += "<td>"+r4_phase_status+"</td>"; 
					   
					   var r5_phase_status = '<i class="fas fa-2x fa-lightbulb"></i>';
					   if(value.more_details.r5_phase_status==1){
						   r5_phase_status = '<i class="far fa-2x fa-lightbulb"></i>';
					   }
					   html_data += "<td>"+r5_phase_status+"</td>"; 
					   
					   var last_online_at = convert_to_readable_datetime(value.more_details.last_online_at);
					   html_data += "<td>"+last_online_at+"</td>"; 
					   html_data += "</tr>";
					  
					}
					var total_html = thead + html_data;
					table.destroy();
					$('#example').html(total_html);
		            table = $('#example').DataTable();
					
				 //  $('#order-listing').DataTable().ajax.reload();
				//   $("#device_heading").html('');
				//  $("#device_heading").html("<tr><th>Device</th><th>No</th></tr>");
				 // $("#device_heading").css('display','block');
				//  $('#device_detail').html('');
				//  $('#device_detail').html('<tr><th>1</th><th>T</th></tr>');
				//  $('#order-listing').DataTable().ajax.reload();
				  
				  /* $('#order-listing').dataTable().fnClearTable();
			       $('#device_heading').html('');
				   $('#device_heading').html('<th>Device</th><th>No</th>');
					
					$('#order-listing').DataTable().ajax.reload();  */
						    
                        //    $('#order-listing').dataTable().fnDestroy();
                     //    $('#order-listing').DataTable();
				   
				})
		    });
		} 

    function convert_to_readable_datetime(timestamp){
		const milliseconds = timestamp * 1000;
		const dateObject = new Date(milliseconds)

		const humanDateFormat = dateObject.toLocaleString()
		
		const day = dateObject.toLocaleString("en-US", {weekday: "long"}) // Monday
		const month = dateObject.toLocaleString("en-US", {month: "long"}) // December
		const dt = dateObject.toLocaleString("en-US", {day: "numeric"}) // 9
		const year = dateObject.toLocaleString("en-US", {year: "numeric"}) // 2019
		//dateObject.toLocaleString("en-US", {hour: "numeric"}) // 10 AM
		//dateObject.toLocaleString("en-US", {minute: "numeric"}) // 30
		//dateObject.toLocaleString("en-US", {second: "numeric"}) // 15
		 //var date = convertEpochToSpecificTimezone(timestamp * 1000, +3);
		 const splitarr = humanDateFormat.split(",");
		 var date = day +" "+ dt +" "+ month +" "+ year +", "+ splitarr[1];
		 return date;
	}		
		
		function convertEpochToSpecificTimezone(timeEpoch, offset) {
			 var d = new Date(timeEpoch);
		 var utc = d.getTime() + (d.getTimezoneOffset() * 60000); //This converts to UTC 00:00
		 var nd = new Date(utc + (3600000 * offset));
		 //  return nd.toLocaleDateString();
		 return nd.toLocaleString();
		 //  return nd.toUTCString();
		}

 function getMac_Detail(macid){
	       
			if(macid==""){
				swal("Oops!", "Data Not Found !", "error");
				return false;
			}
			
			
			/*if(AtmID==''){
				swal("Oops!", "AtmID Must Required !", "error");
				return false;
			}*/
			$("#load").show();
			
			$.ajax({
				url: "api/ems_device.php", 
				type: "POST",
				data: {mac_id:macid},
				success: (function (result) { ;
				   $("#load").hide();
				   
				   console.log(result);
				   var obj = JSON.parse(result);
				   if(obj.statusCode==200){
					   $('#r_v').val(obj.result.r_v);
					    $('#y_v').val(obj.result.y_v);
						 $('#b_v').val(obj.result.b_v);
						$('#r_c').val(obj.result.r_c);
					    $('#y_c').val(obj.result.y_c);
						 $('#b_c').val(obj.result.b_c);
						 
						 $('#r_real_kw').val(obj.result.r_real_kw);
					    $('#y_real_kw').val(obj.result.y_real_kw);
						 $('#b_real_kw').val(obj.result.b_real_kw);
						$('#r_pf').val(obj.result.r_pf);
					    $('#y_pf').val(obj.result.y_pf);
						 $('#b_pf').val(obj.result.b_pf);
						 
						 $('#fr').val(obj.result.fr);
					    $('#real_kwh').val(obj.result.real_kwh);
						 $('#e_v').val(obj.result.e_v);
						 
						 var timestamp = parseInt(obj.result.tm_stamp);
						
						var last_online_at = convert_to_readable_datetime(timestamp);
						 $('#tm_stamp').val(last_online_at);
						  
						 $('#temp').val(obj.result.temp);
					    $('#hum').val(obj.result.hum);
						 $('#earth_volt').val(obj.result.e_v);
						 $('#acc_c').val(obj.result.acc_c);
						 $('#bb_v').val(obj.result.bb_v);
				   } 
				   
				 //  var onlinepercent = obj[0].total_online_percent;
				  
				   
				})
		    });
		}  	
