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
        				url: "ai_ticket_view_ajax.php", 
        				type: "GET",
        				data: {client:Client,bank:Bank,atmid:AtmCode,start:start,end:end,portal:portal},
						dataType: "html", 
        				success: (function (result) { ;
        				   console.log(result);
                         /*  var obj = JSON.parse(result);
                           var atmcode = obj.ATMCode;
                            var aid = obj.aid;
                            var datetime = obj.DateTime;
                           aiticketview = "<tr> <td>" +atmcode+ "</td> <td></td> <td></td> <td></td>  <td> " +datetime+ " </td> <td></td> <td></td> <td> </td> <td> </td> <td> "+aid+" </td> <td> </td> </tr>";
                            */
							$('#order-listing').dataTable().fnClearTable();
							$("#aiticketview_tbody").html('');
							$("#aiticketview_tbody").html(result);
							//$('#order-listing').DataTable().ajax.reload(); 
								
							//    $('#order-listing').dataTable().fnDestroy();
							$('#order-listing').DataTable(
							    {
									"order": [[ 0, "desc" ]]
								}
							);
							
                           $("#load").hide();
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
									   if(data[i].ticket_id==''){
										   
									   }else{
										   src = '<button type="button" class="btn btn-primary btn-sm large-modal" data-id="'+data[i].ticket_id+'" data-toggle="modal" data-target="#largeModal">View<i class="fa fa-eye ml-1"></i></button>';
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

