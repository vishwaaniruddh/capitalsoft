var table = $('#example').DataTable();
function getTicketDetails()
{
	get_ai_ticket_1();
   // get_ai_ticket();
}

function get_ai_ticket()
{
   var Client= $("#Client").val();
   var Bank= $("#Bank").val();   
   var Circle= $("#Circle").val();   
   var AtmCode= $("#AtmID").val(); 
   var start= $("#start").val(); 
   var end= $("#end").val(); 
   var portal = $("#portal").val();
  
  if(Client==''){
	  swal("Client must required");
	  return false;
  }
  $("#load").show();
    $.ajax({
        				url: "ai_ticket_view_ajax_new.php", 
        				type: "POST",
        				data: {client:Client,bank:Bank,atmid:AtmCode,start:start,end:end,portal:portal},
						success: (function (result) { ;
        				   $("#load").hide();
						   
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
									   tbody += '<tr><td>'+count+'</td><td>'+data[i].id+'</td><td>'+data[i].site_address+'</td><td>'+data[i].atm_id+'</td><td>'+data[i].alert_type+'</td><td></td><td>'+data[i].camera_status+'</td><td>'+data[i].site_address+'</td><td>'+data[i].createdatetime+'</td><td>'+src+'</td></tr>';
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


function get_ai_ticket_1()
{
   var Client= $("#Client").val();
   var Bank= $("#Bank").val();   
   var Circle= $("#Circle").val();   
   var AtmCode= $("#AtmID").val(); 
   var start= $("#start").val(); 
   var end= $("#end").val(); 
   var portal = $("#portal").val();
  
  if(Client==''){
	  swal("Client must required");
	  return false;
  }
  $("#load").show();
    $.ajax({
        				url: "ai_ticket_view_ajax_1.php", 
        				type: "GET",
        				data: {client:Client,bank:Bank,atmid:AtmCode,circle:Circle,start:start,end:end,portal:portal},
						success: (function (result) { ;
        				    console.log(result);
                            var obj = JSON.parse(result);
						    if(obj[0].code==200){
							   var data = obj[0].res_data; 
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
									   tbody += '<tr><td>'+data[i].ticket_id+'</td><td>'+data[i].site_address+'</td><td>'+data[i].atm_id+'</td><td>'+data[i].alert_type+'</td><td>'+data[i].createdatetime+'</td><td>'+data[i].dvr_ip+'</td><td>'+data[i].alarm_status+'</td><td>'+src+'</td></tr>';
									 count++;
								   }
								   tbody += '</tbody>';
								   var thead = '<thead><tr><th>Ticket ID</th><th>Location</th><th>ATMID</th><th>Alert Type</th><th>Ticket DateTime</th><th>DVR IP</th><th>Alarm Status</th><th> Action </th></tr></thead>';
								   
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

