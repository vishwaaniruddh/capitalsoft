var table = $('#example').DataTable();
function onload()
{
   // get_ai_ticket();
}

$("#show_detail").click(function(){ 
	getPanel_Detail();
	//get_ticketview();
})

        function getPanel_Detail(){
	        var Client = $("#Client").val();
			var Bank = $("#Bank").val();
			var AtmID = $("#AtmID").val();
			var Circle = $("#Circle").val();
			//AtmID = "P1DCHY03";
			if(Client==''){
				swal("Oops!", "Bank Must Required !", "error");
				return false;
			}
			/*if(AtmID==''){
				swal("Oops!", "AtmID Must Required !", "error");
				return false;
			}*/
			$("#load").show();
			$.ajax({
				url: "dash_board_table_ajax.php", 
				type: "POST",
				data: {client:Client,bank:Bank,atmid:AtmID,circle:Circle},
				success: (function (result) { 
				   $("#load").hide();
				   ;
				
				   console.log(result);
				   var obj = JSON.parse(result);
				   if(obj[0].code==200){
					   var totalsites_count = obj[0].tot_sites;
					   $("#totalsites_count").html(totalsites_count);
					   var camera_working_count = obj[0].camera_working_count;
					   $("#camera_working_count").html(camera_working_count);
					   var camera_notworking_count = obj[0].camera_notworking_count;
					   $("#camera_notworking_count").html(camera_notworking_count);
					   
					   var data = obj[0].res_data; console.log(data);
					   var count = 1;
					   if(data.length>0){
						   var tbody = "<tbody>";
						   for(i=0;i<data.length;i++){
							  var src = "";
							   if(data[i].src==''){
								   
							   }else{
								   var path = data[i].path;
								   src = '<button type="button" class="btn btn-primary btn-sm large-modal" data-check="'+path+'" data-id="'+data[i].src+'" data-toggle="modal" data-target="#largeModal">View<i class="fa fa-eye ml-1"></i></button>';
							   }
							   tbody += '<tr><td>'+count+'</td><td>'+data[i].atm_id+'</td><td>'+data[i].ip+'</td><td>'+data[i].state+'</td><td>'+data[i].camera_status+'</td><td>'+data[i].site_address+'</td><td>'+data[i].createdatetime+'</td><td>'+src+'</td></tr>';
						     count++;
						   }
						   tbody += '</tbody>';
						   var thead = '<thead><tr><th>S.N</th><th>ATM-ID</th><th>IP</th><th>State</th><th>Camera1</th><th>Address</th><th>Last Communication</th><th>Last File Uploaded</th> </tr></thead>';
							
							var total_html = thead + tbody;
							table.destroy();
							$('#example').html(total_html);
				            table = $('#example').DataTable(
								{
									dom: 'Bfrtip',
									  buttons: [
										  'excelHtml5'
									  ]
								}
							);
							
					   }
				   }
				})
		    });
		}  
		
		function get_ticketview()
		{
		    var Client = $("#Client").val();
			var Bank = $("#Bank").val();
			var AtmID = $("#AtmID").val();
			var Circle = $("#Circle").val();
			if(Client==''){
				swal("Oops!", "Bank Must Required !", "error");
				return false;
			}
			//$("#load").show();
			$.ajax({
				url: "dash_board_table_ajax_1.php", 
				type: "POST",
				dataType: "json",
				data: {client:Client,bank:Bank,atmid:AtmID,circle:Circle},
				success: (function (result) { ;
				    $("#load").hide();
				   console.log(result);
				   var obj = JSON.parse(result);
				   if(obj[0].code==200){
					   var data = obj[0].res_data; console.log(data);
					   var count = 1;
					   if(data.length>0){
						   var tbody = "<tbody>";
						   for(i=0;i<data.length;i++){
							  var src = "";
							   if(data[i].src==''){
								   
							   }else{
								   var path = data[i].path;
								   src = '<button type="button" class="btn btn-primary btn-sm large-modal" data-check="'+path+'" data-id="'+data[i].src+'" data-toggle="modal" data-target="#largeModal">View<i class="fa fa-eye ml-1"></i></button>';
							   
							   }
							   tbody += '<tr><td>'+count+'</td><td>'+data[i].atm_id+'</td><td>'+data[i].ip+'</td><td>'+data[i].state+'</td><td>'+data[i].camera_status+'</td><td>'+data[i].site_address+'</td><td>'+data[i].createdatetime+'</td><td>'+src+'</td></tr>';
						     count++;
						   }
						   tbody += '</tbody>';
						   var thead = '<thead><tr><th>S.N</th><th>ATM-ID</th><th>IP</th><th>State</th><th>Camera1</th><th>Address</th><th>Last Communication</th><th>Last File Uploaded</th> </tr></thead>';
							
							var total_html = thead + tbody;
							table.destroy();
							$('#example').html(total_html);
				            table = $('#example').DataTable(
								{
									dom: 'Bfrtip',
									  buttons: [
										  'excelHtml5'
									  ]
								}
							);
							
					   }
				   }
				   
					 $("#load").hide();
				})
			});
		}