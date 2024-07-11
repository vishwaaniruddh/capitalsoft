//var table = $('#example').DataTable();
function getTicketDetails()
{
	get_ai_ticket_1();
   
}
$("#Bank").change(function(){ 
	var bank = $("#Bank").val();
	$("#excel_bank").val(bank);
})
$("#Client").change(function(){ 
	var client = $("#Client").val();
	$("#excel_client").val(client);
})
$("#Circle").change(function(){ 
	var circle = $("#Circle").val();
	$("#excel_circle").val(circle);
})
$("#AtmID").change(function(){ 
	var atmid = $("#AtmID").val();
	$("#excel_atmid").val(atmid);
})
$("#portal").change(function(){ 
	var portal = $("#portal").val();
	$("#excel_portal").val(portal);
})

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
  //table.destroy();
  $('#example').DataTable({
		 "bDestroy": true,
		 "bProcessing": true,
         "serverSide": true,
		 "lengthMenu": [
		   [10, 25, 50, -1],
		   [10, 25, 50, "All"]
		],
		 "order": [[ 0, "desc" ]],
					"dom": 'Bfrtip',
					  "buttons": [
                        {
                            "extend": 'excel',
                            "text": '<button class="btn"><i class="fa fa-file-excel-o" style="color: green;"></i>  Excel</button>',
                            "titleAttr": 'Excel',
                            "action": newexportaction
                        },
						{
						"text": 'Export All to Excel',
						"action": function (e, dt, button, config)
						{
							dt.one('preXhr', function (e, s, data)
							{
								data.length = -1;
							}).one('draw', function (e, settings, json, xhr)
							{
								var excelButtonConfig = $.fn.DataTable.ext.buttons.excelHtml5;
								var addOptions = { exportOptions: { 'columns': ':all'} };

								$.extend(true, excelButtonConfig, addOptions);
								excelButtonConfig.action(e, dt, button, excelButtonConfig);
							}).draw();
						}
					}
                    ],
         "ajax":{
            url :"ai_ticket_view_ajax_2.php", // json datasource
            type: "post",  // type of method  ,GET/POST/DELETE
			data: {client:Client,bank:Bank,atmid:AtmCode,circle:Circle,start_date:start,end_date:end,portal:portal},
            error: function(){
             // $("#employee_grid_processing").css("display","none");
            },
		 columns: [
					{ data: "id" },
					{ data: "location" },
					{ data: "atmid" },
					{ data: "alert_type" },
					{ data: "createdatetime" },
					{ data: "dvrip" },
					{ data: "alarm_status" },
					{ data: "action" }
				  ]	
          }
        });   
  /*
    $.ajax({
        				url: "ai_ticket_view_ajax_2.php", 
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
                    }); */
					
					 $("#load").hide();
}   

