<?php include ('../header.php'); ?>

<style>
     #tabletop th:nth-child(5), /* Adjust for the correct column index if needed */
    #tabletop td:nth-child(5) {
        width: 300px;
    }
</style>
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



        var Page = "";
        if (strPage != "") {
            Page = strPage;
        }
        $('#loadingmessage').show(); // show the loading message.


        $.ajax({
            type: 'POST',
            url: './viewalert_process.php',
            data: {
                panelid: panelid,
                ATMID: ATMID,
                DVRIP: DVRIP,
                from: from,
                to: to,
                Page: Page,
                perpg: perpg, // Use the perpg variable passed into the function
                compy: compy,
                viewalert: viewalert,
                panelmak: panelmak,
            },
            success: function (msg) {
                $('#loadingmessage').hide(); // hide the loading message
                document.getElementById("show").innerHTML = msg;
            }
        })
    }
</script>




<div class="page-content">


    <div class="card">
        <div class="card-body">




            <div class="row">
                <div class="col-sm-3">

                    View :<select class="form-control form-control-sm mb-3" id="viewalert" name="viewalert">

                        <option value="1">All alert</option>
                        <option value="2">Open alert</option>
                        <option value="3">Close alert</option>
                        <option value="4">ATM Chest Door Alert</option>
                        <option value="12">Hood Door</option>
                        <option value="5">AC Mains Fail</option>
                        <option value="6">Backroom Door Open Sensor</option>
                        <option value="7">Panic Switch</option>
                        <option value="8">UPS Fail</option>
                        <option value="9">Low Battery</option>
                        <option value="10">Shutter Sensor</option>
                        <option value="11">Lobby Temperature</option>
                        <option value="13">ATM Vibration Sensor</option>
                        <option value="14">ATM Thermal Sensor</option>
                        <option value="15">ATM Removal Sensor</option>
                        <option value="16">Glass break sensor</option>
                        <option value="17">Motion Sensor</option>
                        <option value="18">Hooter Sensor</option>
                        <option value="19">Smoke Detector</option>
                    </select>

                </div>

                <div class="col-sm-3">

                    Panel id :<input class="form-control form-control-sm mb-3" type="text" name="panelid" id="panelid">
                </div>


                <div class="col-sm-3">
                    DVRIP:<input class="form-control form-control-sm mb-3" type="text" name="DVRIP" id="DVRIP">

                </div>


                <div class="col-sm-3">
                    Company:<select class="form-control form-control-sm mb-3" id="compy" name="compy">
                        <option value="">--Select Company--</option>

                        <?php

                        $qcompname = mysqli_query($conn, "select DISTINCT Customer from sites");
                        while ($datas = mysqli_fetch_array($qcompname)) {
                            ?>
                            <option value="<?php echo $datas[0]; ?>" <?php if($_REQUEST['customer']==$datas[0]){ echo 'selected';}?>><?php echo $datas[0]; ?></option>
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
                    From Date:<input class="form-control form-control-sm mb-3" name="from" type="date" id="fromdate">

                </div>

                <div class="col-sm-3">
                    To Date:<input class="form-control form-control-sm mb-3" name="to" type="date" id="todate">
                </div>
            </div>
            <input class="badge bg-primary" type="button" name="submit" onclick="a('','')"
                value="search"></button>

            <div id='loadingmessage' style='display:none;'>
                <div class="spinner-grow" role="status" style="margin: auto;
    display: block;"> <span class="visually-hidden">Loading...</span>
                </div>
            </div>








        </div>
    </div>

    <div id="show"></div>

</div>
<?php include ('../footer.php'); ?>