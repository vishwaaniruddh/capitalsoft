function getTicketDetails(){
	theft_ticket();
	//get_ticket_list();
}


function theft_ticket(){
	 var Client= $("#Client").val(); 
	 var Bank= $("#Bank").val(); 
	 var AtmID= $("#AtmID").val(); 
	 var Circle= $("#Circle").val(); 
    // AtmID = "P1DCHY03";
	 if(Client=='')
    {
    	//swal("Oops!", "AtmID Must Required !", "error");
    	return false;
    }
	  $.ajax({
				url: "theft_ticket_count.php", 
				type: "POST",
				data: {atmid:AtmID,client:Client,bank:Bank,circle:Circle},
				success: (function (result) { ;
				   var res = JSON.parse(result);
					console.log(res);
					$('#theft_ticket_count').html(res[0].theft_count);
					get_ticket_list();
				})
			});
}

function get_ticket_list()
{ ;
	//var Status= $("#status").val();
	var Status = "all";
	var Client= $("#Client").val(); 
	var Bank= $("#Bank").val(); 
   var AtmID= $("#AtmID").val(); 
   var Circle= $("#Circle").val(); 
 //  AtmID = "P1DCHY03";
   var user = "comfort";
   if(Client=='')
    {
    	//swal("Oops!", "AtmID Must Required !", "error");
    	return false;
    }
	$('#theft_ticket_body').html('');
   //$("#load").show();
    $.ajax({
        				url: "theft_history_ajax_list.php", 
        				type: "GET",
        				data: {atmid:AtmID,client:Client,bank:Bank,user:user,Status:Status,circle:Circle},
						dataType: "html", 
        				success: (function (result) { ;
        				   console.log(result);
                            $('#order-listing').dataTable().fnClearTable();
                            $('#theft_ticket_body').html('');
                            $('#theft_ticket_body').html(result);
                            $('#order-listing').DataTable(
							{
							   "order": [[ 0, "desc" ]]
							}
							);
							$("#load").hide();
                        })
                    });
}   


