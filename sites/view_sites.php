<?php include ('../header.php'); ?>

<style>
    .spinner-grow {
        --bs-spinner-width: 10rem;
        --bs-spinner-height: 10rem;
    }

    th,
    td {
        white-space: nowrap;
    }

    
</style>

<div class="page-content">


    <?php


    ?>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script type="text/javascript">
        var tableToExcel = (function () {
            //alert("hii");
            var uri = 'data:application/vnd.ms-excel;base64,',
                template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
                base64 = function (s) {
                    return window.btoa(unescape(encodeURIComponent(s)))
                },
                format = function (s, c) {
                    return s.replace(/{(\w+)}/g, function (m, p) {
                        return c[p];
                    })
                }
            return function (table, name) {
                if (!table.nodeType) table = document.getElementById(table)
                var ctx = {
                    worksheet: name || 'Worksheet',
                    table: table.innerHTML
                }
                window.location.href = uri + base64(format(template, ctx))
            }
        })()
    </script>




    <script>
        function TestingAction1(val, id, Atm) {

            if (val == "T") {
                $('#testing' + id).hide();
            } else {
                $('#Live' + id).hide();
            }

            $.ajax({
                type: 'POST',
                url: '<?php echo BASE_URL; ?>ajaxComponents/TestingActions.php',
                data: 'val=' + val + '&id=' + id + '&Atm=' + Atm,
                success: function (msg) {
                    //alert(msg)
                    if (msg != "0") {
                        alert("Update Successfully");

                        if (val == "T") {
                            $('#testing' + id).hide();
                            window.open("<?php echo BASE_URL; ?>ajaxComponents/testing_alert.php?atmid=" + Atm + "&lastid=" + msg, "_blank");
                        } else {
                            $('#Live' + id).hide();
                        }

                    } else {
                        alert("Error")
                    }
                }
            })
        }




        function a(strPage, perpg) {
            var DVRIP = document.getElementById("DVRIP").value;

            var atmid = document.getElementById("atmid").value;
            var project = document.getElementById("project").value;

            // alert(project)

            if (project == 1) {
                url = 'viewsite_process.php'
            } else if(project == 2){
                url = 'viewsite_dvr_process.php'

            }


            var lstatus = document.getElementById("lstatus").value;
            var bank = document.getElementById("bank").value;
            var cust = document.getElementById("cust").value;
            var track = document.getElementById("track").value;
            var cities = document.getElementById("cities").value;
            var F_date = document.getElementById("F_date").value;
            var T_date = document.getElementById("T_date").value;

            var Page = "";
            if (strPage != "") {
                Page = strPage;
            }
            $('#loadingmessage').show(); // show the loading message.
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    DVRIP: DVRIP,
                    atmid: atmid,
                    track: track,
                    lstatus: lstatus,
                    cust: cust,
                    cities: cities,
                    Page: Page,
                    perpg: perpg, // Use the perpg variable passed into the function
                    project: project,
                    F_date: F_date,
                    T_date: T_date,
                    bank: bank
                },
                success: function (msg) {
                    $('#loadingmessage').hide(); // hide the loading message
                    document.getElementById("show").innerHTML = msg;
                }
            });
        }

        function transfer_site(sn) {

            $('#loadingmessage').show();
            $.ajax({

                type: 'POST',
                url: '<?php echo BASE_URL; ?>ajaxComponents/transfer_site_data.php',
                data: 'sn=' + sn,
                success: function (msg) {
                    // debugger;
                    console.log(msg)
                    $('#loadingmessage').hide(); // hide the loading message
                    var obj = JSON.parse(msg);
                    console.log(obj);



                    if (obj.Code == 200) {
                        alert("Site Inserted to Server Successfully");
                    }
                    if (obj.Code == 201) {
                        alert("Site Inserted to Server UnSuccessfully. Something Went Wrong" + obj.error);

                    }
                    if (obj.Code == 202) {
                        alert("Site Updated to Server Successfully");
                    }
                    if (obj.Code == 203) {
                        alert("Site Updated to Server UnSuccessfully. Something Went Wrong");
                    }
                    if (obj.Code == 205) {
                        alert("Site Not Found. Something Went Wrong");
                    }

                    //   document.getElementById("show").innerHTML=msg;

                }
            });
        }
    </script>





    <div>



        <style>
            .blink_me {
                animation: blinker 1s linear infinite;
                color: red;
                border: 1px solid;
                padding: 10px;
                border-radius: 50px;
            }

            @keyframes blinker {
                50% {
                    opacity: 0;
                }
            }
        </style>


<div class="card">
    <div class="card-body">

    <div class="row">
            <div class="col-sm-3">
            <label for="">Project:</label>    
            <select name="project" id="project" class="form-control form-control-sm mb-3">
                    <option value="">Select</option>

                    <?php $Qproj = "select * from projectsites ";
                    $runQproj = mysqli_query($conn, $Qproj);
                    while ($Qprojfetch = mysqli_fetch_array($runQproj)) {

                        ?>
                        <option value="<?php echo $Qprojfetch['id']; ?>" <?php if ($_REQUEST['project'] == $Qprojfetch['id']) {
                               echo 'selected';
                           } else if ($Qprojfetch['id'] == '1') {
                               echo 'selected';
                           } ?>>
                            <?php echo $Qprojfetch['Name']; ?>
                        </option>

                    <?php
                    } ?>

                </select>



            </div>

            <div class="col-sm-3">
                <label for="">Status:</label><select name="lstatus" id="lstatus" class="form-control form-control-sm mb-3">
                    <option value=""> Select</option>
                    <option value="Y" <?php if ($_REQUEST['searchTye'] != 'auto') {
                        echo 'selected';
                    } ?>> Active</option>
                    <option value="N">In Active</option>
                    <option value="P">Pending</option>
                    <option value="T">Testing</option>
                    <option value="PL">Partial Live</option>

                </select>
            </div>

            <div class="col-sm-3">
                <label for="">Site Code:</label><input type="text" class="form-control form-control-sm mb-3" name="atmid" id="atmid"
                    value="<?php echo $_REQUEST['atmid']; ?>">

            </div>

            <div class="col-sm-3">
                <label for="">Tracker No:</label><input type="text" class="form-control form-control-sm mb-3" name="track" id="track">

            </div>

            <div class="col-sm-3">

                <label for="">DVRIP:</label><input type="text" class="form-control form-control-sm mb-3" name="DVRIP" id="DVRIP">
            </div>

            <div class="col-sm-3">
<label for="">Bank:</label>
                <select name="bank" class="form-control form-control-sm mb-3" id="bank">
                    <option value="">Select Bank Name</option>
                    <?php
                    $xyzz = "select name from bank ";
                    $runxyzz = mysqli_query($conn, $xyzz);
                    while ($xyzfetchcus = mysqli_fetch_array($runxyzz)) {

                        ?>
                        <option value="<?php echo $xyzfetchcus['name']; ?>" />
                        <?php echo $xyzfetchcus['name']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-sm-3">
                <label for="">City:</label><input type="text" class="form-control form-control-sm mb-3" name="cities" id="cities">

            </div>
            <div class="col-sm-3">
                <label for="">Customer:</label><select name="cust" class="form-control form-control-sm mb-3" id="cust">
                    <option value="">Select Customer Name</option>
                    <?php

                    $xyzz = "select name from customer ";
                    $runxyzz = mysqli_query($conn, $xyzz);
                    while ($xyzfetchcus = mysqli_fetch_array($runxyzz)) {

                        ?>
                        <option value="<?php echo $xyzfetchcus['name']; ?>" />
                        <?php echo $xyzfetchcus['name']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-sm-3">
                <label for="">From LiveDate:</label><input type="date" class="form-control form-control-sm mb-3" id="F_date" name="F_date">

            </div>

            <div class="col-sm-3">
                <label for="">To LiveDate:</label>
                <input type="date" class="form-control form-control-sm mb-3" id="T_date" name="T_date">

            </div>

            <div class="col-sm-3">
                <br>
                <input type="button" class="badge bg-primary" id="submitForm" name="submit"
                    onclick="a('','')" value="search"></button>

            </div>

        </div>
    </div>
</div>



    </div>

    <div id='loadingmessage' style='display:none;'>
        <div class="spinner-grow" role="status" style="margin: auto;
    display: block;"> <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div id="show"></div>


</div>



</div>
<?php include ('../footer.php'); ?>