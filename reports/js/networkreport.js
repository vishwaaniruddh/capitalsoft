function onload()
{
   // get_ai_ticket();
}
$("#AtmID").change(function(){ ;
//	get_Detail();
//	get_view();
})
$("#Bank").change(function(){ ;
	//get_Detail();
	//get_view();
})
$("#Client").change(function(){ ;
	
})

$("#show_detail").click(function(){ ;
	get_Detail();
	get_view();
})

        function get_Detail(){ ;
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
			$("#dvr_online_count").html(0);
			$("#dvr_offline_count").html(0);
			$("#router_online_count").html(0);
			$("#router_offline_count").html(0);
			$("#panel_online_count").html(0);
			$("#panel_offline_count").html(0);
			$("#load").show();
			$.ajax({
				url: "networkreport_count_ajax.php", 
				type: "POST",
				data: {client:Client,bank:Bank,atmid:AtmID,circle:Circle},
				success: (function (result) { 
				   
				   ;
				
				   console.log(result);
				   var obj = JSON.parse(result);
				   var dvr_online_count = obj[0].dvr_online_count;
				   if(dvr_online_count>0){
					   var dvr_online_counthtml = '<a target="_blank" href="networkreport_details.php?client='+Client+'&bank='+Bank+'&atmid='+AtmID+'&status=0&device=D">'+dvr_online_count+'</a>';
					   $("#dvr_online_count").html(dvr_online_counthtml);
				   }else{
				      $("#dvr_online_count").html(dvr_online_count);
				   }
				   
				   
				   var dvr_offline_count = obj[0].dvr_offline_count;
				    if(dvr_offline_count>0){
					   var dvr_offline_counthtml = '<a target="_blank" href="networkreport_details.php?client='+Client+'&bank='+Bank+'&atmid='+AtmID+'&status=1&device=D">'+dvr_offline_count+'</a>';
					   $("#dvr_offline_count").html(dvr_offline_counthtml);
				   }else{
				      $("#dvr_offline_count").html(dvr_offline_count);
				   }
				   
				   var router_online_count = obj[0].router_online_count;
				   if(router_online_count>0){
					   var router_online_counthtml = '<a target="_blank" href="networkreport_details.php?client='+Client+'&bank='+Bank+'&atmid='+AtmID+'&status=0&device=R">'+router_online_count+'</a>';
					   $("#router_online_count").html(router_online_counthtml);
				   }else{
				      $("#router_online_count").html(router_online_count);
				   }
				   
				   var router_offline_count = obj[0].router_offline_count;
				   if(router_offline_count>0){
					   var router_offline_counthtml = '<a target="_blank" href="networkreport_details.php?client='+Client+'&bank='+Bank+'&atmid='+AtmID+'&status=1&device=R">'+router_offline_count+'</a>';
					   $("#router_offline_count").html(router_offline_counthtml);
				   }else{
				      $("#router_offline_count").html(router_offline_count);
				   }
				   
				   var panel_online_count = obj[0].panel_online_count;
				    if(panel_online_count>0){
					   var panel_online_counthtml = '<a target="_blank" href="networkreport_details.php?client='+Client+'&bank='+Bank+'&atmid='+AtmID+'&status=0&device=P">'+panel_online_count+'</a>';
					   $("#panel_online_count").html(panel_online_counthtml);
				   }else{
				      $("#panel_online_count").html(panel_online_count);
				   }
				   
				   var panel_offline_count = obj[0].panel_offline_count;
				   if(panel_offline_count>0){
					   var panel_offline_counthtml = '<a target="_blank" href="networkreport_details.php?client='+Client+'&bank='+Bank+'&atmid='+AtmID+'&status=1&device=P">'+panel_offline_count+'</a>';
					   $("#panel_offline_count").html(panel_offline_counthtml);
				   }else{
				      $("#panel_offline_count").html(panel_offline_count);
				   }
				  
				   
				})
		    });
		}  
		
		function get_view()
		{
		    var Client = $("#Client").val();
			var Bank = $("#Bank").val();
			var AtmID = $("#AtmID").val();
			var Circle = $('#Circle').val();
			if(Client==''){
				swal("Oops!", "Bank Must Required !", "error");
				return false;
			}
			$('#ticketview_tbody').html('');
			$.ajax({
				url: "networkreport_table_ajax.php", 
				type: "GET",
				data: {client:Client,bank:Bank,atmid:AtmID,circle:Circle},
				dataType: "html", 
				success: (function (result) { ;
				   console.log(result);
				 
				   $('#order-listing').dataTable().fnClearTable();

					
					$('#ticketview_tbody').html(result); 
					
					
					//$('#order-listing').DataTable().ajax.reload(); 
						
					//    $('#order-listing').dataTable().fnDestroy();
					$('#order-listing').DataTable(
						{
						//	"order": [[ 0, "desc" ]]
                            dom: 'Bfrtip',
							buttons: [
								  'excelHtml5'
							]
						}
					);
					 $("#load").hide();
				})
			});
		}


