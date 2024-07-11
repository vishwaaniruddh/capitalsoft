function getTicketDetails()
{
  get_ticketview();
}
$("#portal").change(function(){ 
	get_ticketview();
});

function get_ticketview()
{
    var Client= $("#Client").val();
    var Bank= $("#Bank").val();   	
    var Atmid= $("#AtmID").val(); 
	var Circle= $("#Circle").val(); 
    var start= $("#start").val(); 
    var end= $("#end").val(); 
    var portal = $("#portal").val();
   
    if(Client=='' )
    {
    	//swal("Oops!", "AtmID Must Required !", "error");
    	return false;
    }
	 $('#ticketview_tbody').html('');
	$("#load").show();
    $.ajax({
        url: "ticketview_ajax.php", 
        type: "GET",
        data: {client:Client,bank:Bank,atmid:Atmid,start:start,end:end,portal:portal,circle:Circle},
        dataType: "html", 
        success: (function (result) { 
           console.log(result);
          $("#load").hide();
          // $('#order-listing').dataTable().fnClearTable();

            $('#ticketview_tbody').html('');
            $('#ticketview_tbody').html(result); 
            
            
            //$('#order-listing').DataTable().ajax.reload(); 
                
            //    $('#order-listing').dataTable().fnDestroy();
            $('#order-listing').DataTable(
			    {
					"order": [[ 0, "desc" ]],
					dom: 'Bfrtip',
					  buttons: [
						  'excelHtml5'
					  ]
				}
			);
			
        })
    });
}

