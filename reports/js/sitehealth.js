$("#show_detail").click(function(){
	count_online_offline();
});


function test(){
	 var Client= $("#Client").val(); 
	 var Bank= $("#Bank").val(); 
	 var AtmID= $("#AtmID").val(); 
    // AtmID = "P1DCHY03";
	  $.ajax({
				url: "api/dvrdashboard_alerts_ajax.php", 
				type: "POST",
				data: {atmid:AtmID,client:Client,bank:Bank,user_id:24},
				success: (function (result) { ;
				   var res = JSON.parse(result);
					console.log(res);
				})
			});
}

function onload()
{
    // get_dvr_health_online();
    // get_dvr_health_offline();
	// count_online_offline();
}
function count_online_offline(){
	 var Client= $("#Client").val(); 
	 var Bank= $("#Bank").val(); 
	 var AtmID= $("#AtmID").val(); 
	 var Circle= $("#Circle").val(); 
	 if(Client==''){
					swal("Oops!", "Client Must Required !", "error");
					return false;
				}
	 $('#dvr_online').html('0');
	 $('#dvr_offline').html('0');
	 $('#panel_online').html('0');
	 $('#panel_offline').html('0');
    // AtmID = "P1DCHY03";
	  $.ajax({
				url: "site_health_online_offline_count.php", 
				type: "POST",
				data: {atmid:AtmID,client:Client,bank:Bank,circle:Circle},
				success: (function (result) { ;
				   console.log(result);
					var data = result.split("_");
					$('#dvr_online').html('');
					$('#dvr_online').html(data[0]);
					$('#dvr_offline').html('');
					$('#dvr_offline').html(data[1]);
					$('#panel_online').html('');
					$('#panel_online').html(data[2]);
					$('#panel_offline').html('');
					$('#panel_offline').html(data[3]);
					get_dvr_health_online();
				})
			});
}

function test(){
	var settings = {
	  "url": "https://timer.lightingmanager.in/panelmeterlatestlog?org_id=147&mac_id=18001813",
	  "method": "GET",
	  "timeout": 0,
	  "headers": {
		"access_token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjYwYmRkNDc2OWMwNzJlNzJmNzhmOGNjMiIsImVtYWlsIjoiYXNoaXNoQGNzc2luZGlhLmluIiwib3JnX2lkIjoxNDcsImdyb3VwX2lkcyI6WyIwIiwiMSIsIjIiXSwicmVhZCI6ODE4NSwid3JpdGUiOjgxODUsInJvbGVfaWQiOjExLCJpYXQiOjE2NDEyMjYxOTgsImV4cCI6MTY0MTMxMjU5OH0.sY-EHPqIQpAZALc46EICQTRVvnDJi61gHaxkiO9crNU"
	  },
	};

	$.ajax(settings).done(function (response) {
	  console.log(response);
	});
}

function get_dvr_health_online()
{
	
	//test();
	
	var Client= $("#Client").val(); 
	var Bank= $("#Bank").val(); 
   var AtmID= $("#AtmID").val(); 
   var Circle= $("#Circle").val(); 
   if(Client=='')
    {
    	swal("Oops!", "Client Must Required !", "error");
    	return false;
    }
   $('#sitehealth_tbody').html('');
   $("#load").show();
 //  AtmID = "P1DCHY03";
   
    $.ajax({
			url: "site_views_dvrhealth_online.php", 
			type: "GET",
			data: {atmid:AtmID,client:Client,bank:Bank,circle:Circle},
			dataType: "html", 
			success: (function (result) { ;
			   console.log(result);
			   $("#load").hide();
				$('#order-listing').dataTable().fnClearTable();
				$('#sitehealth_tbody').html('');
				$('#sitehealth_tbody').html(result);
				$('#order-listing').DataTable();
				
				
				get_dvr_health_offline();
			})
		});
}   

function get_dvr_health_offline()
{
	var Client= $("#Client").val(); 
	 var Bank= $("#Bank").val(); 
   var AtmID= $("#AtmID").val(); 
   var Circle= $("#Circle").val(); 
  // AtmID = "P3ENCP01";
   if(Client=='')
    {
    	swal("Oops!", "Client Must Required !", "error");
    	return false;
    }
	$("#load").show();
    $.ajax({
        				url: "site_views_dvrhealth_offline.php", 
        				type: "GET",
        				data: {atmid:AtmID,client:Client,bank:Bank,circle:Circle},
						dataType: "html", 
        				success: (function (result) { ;
        				   console.log(result);
                           $('#order-listing2').dataTable().fnClearTable();
                            $('#sitehealth_tbody_offline').html('');
                            $('#sitehealth_tbody_offline').html(result);
                            $('#order-listing2').DataTable();
                           $("#load").hide();
                           
                        })
                    });
} 
