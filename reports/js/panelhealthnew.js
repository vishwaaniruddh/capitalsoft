function onload() {
  //  get_ticketview();
}
$("#portal").change(function () {
  ;
  get_ticketview();
});
$("#show_detail").click(function () {

  get_ticketview();
});

function get_ticketview() {
  ;
  var Atmid = $("#AtmID").val();
  var Client = $("#Client").val();
  var Bank = $("#Bank").val();
  $('#ticketview_tbody').html('');

  if (Atmid == '') {
    swal("Oops!", "AtmID Must Required !", "error");
    return false;
  }
  $.ajax({
    url: "panel_health_data_new.php",
    type: "GET",
    data: { atmid: Atmid, bank: Bank, client: Client },
    dataType: "html",
    success: (function (result) {
      ;
      console.log(result);
      /*  var obj = JSON.parse(result);
        var atmcode = obj.ATMCode;
         var aid = obj.aid;
         var datetime = obj.DateTime;
        aiticketview = "<tr> <td>" +atmcode+ "</td> <td></td> <td></td> <td></td>  <td> " +datetime+ " </td> <td></td> <td></td> <td> </td> <td> </td> <td> "+aid+" </td> <td> </td> </tr>";
         */
      $('#order-listing').dataTable().fnClearTable();

      $('#ticketview_tbody').html('');
      $('#ticketview_tbody').html(result);


      //$('#order-listing').DataTable().ajax.reload(); 

      //    $('#order-listing').dataTable().fnDestroy();
      $('#order-listing').DataTable(
        {
          "order": [[0, "desc"]]
        }
      );
      $("#load").hide();
    })
  });
}

