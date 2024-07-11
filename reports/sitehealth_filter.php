<div class="card">
    <div class="card-body">
        <div class="col-12 grid-margin">
            <?php
			if($_GET){ $atmid = $_GET['atmid']; }
		?>
            <div class="row">
                <input type="hidden" id="Client" name="Client" value="Hitachi">
                <input type="hidden" id="Bank" name="Bank" value="PNB">
           
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="Circle">Select Circle</label>
                        <select name="Circle" id="Circle" class="form-control form-control-sm col-sm-9"
                            onchange="onchangeatmid()">
                            <option value="">All Circle</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="AtmID">Select AtmID</label>
                        <select name="AtmID" id="AtmID"
                            class="form-control form-control-sm col-sm-9 js-example-basic-single w-100"
                            value="<?php echo $atmid;?>">
                            <option value="">All Site</option>
                            <option value="10369607">10369607</option>
                        </select>
                    </div>
                </div>


            </div>
            <div class="row">
                <div class="col-sm-3">
                    <button class="btn btn-primary" id="show_detail">Show</button>
                </div>
                <!--<a href="" class="btn btn-primary" id="Button">Clear</a>-->

            </div>
        </div>
    </div>
</div>
<br>