function getTicketDetails()
{
    get_ai_ticket();
}
$("#portal").change(function(){ ;
	//get_ai_ticket();
});
$("#AtmID").change(function(){ ;
	//get_ai_ticket();
})
function get_ai_ticket()
{
   var Client= $("#Client").val();
   var Bank= $("#Bank").val();   
   var AtmCode= $("#AtmID").val(); 
   var start= $("#start").val(); 
   var end= $("#end").val(); 
   var portal = $("#portal").val();
  // AtmCode = "B1088910";
  if(Client==''){
	//  swal("Client must required");
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


