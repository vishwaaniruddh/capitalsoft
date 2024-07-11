<div class="card">
    <div class="col-12 grid-margin">

        <div class="row">
            <!-- <div class="col-md-3">
                <div class="form-group row">
                    <label class="col-sm-6 col-form-label">Select Client<br></label>
                    <div class="col-sm-8">
                        <select name="Client" id="Client" class="form-control" onchange="onchangebank()">
                            <option value="">Select</option>
                            <?php if ($_SESSION['client'] == 'All') { ?>

                            <?php echo getClients();
                            } else {
                                $clients = explode(",", $_SESSION['client']);
                                for ($i = 0; $i < count($clients); $i++) {
                                    echo $clients[$i]; ?>
                            <option value="<?php echo $clients[$i]; ?>"><?php echo $clients[$i]; ?></option>
                            <?php }
                            } ?>
                        </select>
                    </div>
                </div>
            </div> -->
            <!-- <div class="col-md-3">
                <div class="form-group row">
                    <label class="col-sm-6 col-form-label">Select Bank<br></label>
                    <div class="col-sm-8">
                        <select name="Bank" id="Bank" class="form-control" onchange="onchangecircle()">
                            <option value="">Select</option>
                        </select>
                    </div>
                </div>
            </div> -->
            <!-- <div class="col-md-3">
                <div class="form-group row">
                    <label class="col-sm-6 col-form-label">Select Circle<br></label>
                    <div class="col-sm-8">
                        <select name="Circle" id="Circle" class="form-control" onchange="onchangeatmid()">
                            <option value="">All Circle</option>
                        </select>
                    </div>
                </div>
            </div> -->
            <div class="col-md-4">
                <div class="form-group row">
                    <label class="col-sm-6 col-form-label">Select Atm<br></label>
                    <div class="col-sm-8">
                        <select name="AtmID" id="AtmID" class="form-control js-example-basic-single w-100">
                            <option value="">All Site</option>
                            <option value="B1189420">B1189420</option>
                        </select>
                    </div>
                </div>
            </div>
            <?php $currentyear = date('Y');
            $currentmonth = date('m');
            $month_array = array("Select Month", "Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug", "Sept", "Oct", "Nov", "Dec"); ?>
            <div class="col-md-4">
                <div class="form-group row">
                    <label class="col-sm-6 col-form-label">Select Month<br></label>
                    <div class="col-sm-8">
                        <select class="form-control" id="month" name="month">
                            <option value="3">Mar</option>
                            <?php
                            for ($i = 0; $i < count($month_array); $i++) {
                                if ($i == $currentmonth) { ?>
                                    <option value="<?php echo $currentmonth; ?>" selected>
                                        <?php echo $month_array[$i]; ?>
                                    </option>
                                <?php }
                            }
                            ?>

                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group row">
                    <label class="col-sm-6 col-form-label">Select Year<br></label>
                    <div class="col-sm-8">
                        <select class="form-control" id="year" name="year">
                            <option value="0">Select Year</option>

                            <option value="2023" <?php if ($currentyear == '2024') {
                                echo 'selected';
                            } ?>>2024</option>

                        </select>
                    </div>
                </div>
            </div>
            <br>

            <div class="col-sm-3">
                <div>
                    <label class="col-sm-6 col-form-label"><br></label>
                    <div class="col-sm-3">
                        <button class="btn btn-primary" id="show_detail" onclick="getTicketDetails()">Show</button>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
<br>