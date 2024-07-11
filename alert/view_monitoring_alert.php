<?php include ('../header.php'); ?>

<div class="page-content">








    <script>

        function a(strPage, perpg) {

            var panelid = document.getElementById("panelid").value;
            var ATMID = document.getElementById("ATMID").value;
            var compy = document.getElementById("compy").value;
            var DVRIP = document.getElementById("DVRIP").value;
            var from = document.getElementById("fromdate").value;
            var to = document.getElementById("todate").value;
            var viewalert = document.getElementById("viewalert").value;
            var panelmak = document.getElementById("panelmak").value;

            $('#loadingmessage').show();  // show the loading message.

            perp = '30';

            var Page = "";
            if (strPage != "") {
                Page = strPage;
            }


            $.ajax({

                type: 'POST',
                url: 'vmalert_process.php',
                data: 'panelid=' + panelid + '&ATMID=' + ATMID + '&DVRIP=' + DVRIP + '&from=' + from + '&to=' + to + '&Page=' + Page + '&perpg=' + perp + '&compy=' + compy + '&viewalert=' + viewalert + '&panelmak=' + panelmak,

                success: function (msg) {
                    // alert(msg);
                    $('#loadingmessage').hide(); // hide the loading message
                    document.getElementById("show").innerHTML = msg;


                }
            })
        }
    </script>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script type="text/javascript">

        var tableToExcel = (function () {
            //alert("hii");
            var uri = 'data:application/vnd.ms-excel;base64,'
                , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
                , base64 = function (s) { return window.btoa(unescape(encodeURIComponent(s))) }
                , format = function (s, c) { return s.replace(/{(\w+)}/g, function (m, p) { return c[p]; }) }
            return function (table, name) {
                if (!table.nodeType) table = document.getElementById(table)
                var ctx = { worksheet: name || 'Worksheet', table: table.innerHTML }
                window.location.href = uri + base64(format(template, ctx))
            }
        })()
    </script>

    <div>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-3">
                        view

                        <select class="form-control form-control-sm mb-3" id="viewalert" name="viewalert">
                            <option value="1">All alert</option>
                        </select>
                    </div>

                    <div class="col-sm-3">
                        panel id :<input class="form-control form-control-sm mb-3" type="text" name="panelid"
                            id="panelid">
                    </div>

                    <div class="col-sm-3">
                        DVRIP:<input class="form-control form-control-sm mb-3" type="text" name="DVRIP" id="DVRIP">

                    </div>

                    <div class="col-sm-3">
                        Company:<select class="form-control form-control-sm mb-3" id="compy" name="compy">
                            <option value="">--Select Company--</option>

                            <?php $qcompname = mysqli_query($conn, "select DISTINCT Customer from sites");
                            while ($datas = mysqli_fetch_array($qcompname)) {
                                ?>
                                <option value="<?php echo $datas[0]; ?>"><?php echo $datas[0]; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-sm-3">
                        Panel Make:<select class="form-control form-control-sm mb-3" id="panelmak" name="panelmak">
                            <option value="">--Select Panel--</option>

                            <?php
                            $qpanel = mysqli_query($conn, "select DISTINCT Panel_Make from sites");
                            while ($panels = mysqli_fetch_array($qpanel)) {
                                ?>
                                <option value="<?php echo $panels[0]; ?>"><?php echo $panels[0]; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-sm-3">
                        ATMID:<input class="form-control form-control-sm mb-3" type="text" name="ATMID" id="ATMID">

                    </div>
                    <div class="col-sm-3">
                        From Date:<input class="form-control form-control-sm mb-3" type="date" id="fromdate">

                    </div>

                    <div class="col-sm-3">
                        To Date:<input class="form-control form-control-sm mb-3" type="date" id="todate">

                    </div>

                </div>
                <div class="col-sm-12">
                    <input class="btn btn-primary px-5 rounded-0" type="button" name="submit" onclick="a('','')"
                        value="search"></button>
                </div>
            </div>

        </div>


        <br>





    </div>
    <!--============== code for loader (Start)===================-->

    <div id='loadingmessage' style='display:none;'>
        <div class="spinner-grow" role="status" style="margin: auto;
    display: block;"> <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <!--============== code for loader (End) =====================-->


    <div id="show"></div>




    <script>
        function myFunction() {
            window.print();
        }
    </script>


</div>

</div>


</script>





</div>
<?php include ('../footer.php'); ?>