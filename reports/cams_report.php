<?php include ('../header.php'); ?>

<style>
    .bt {
        border-top: 1px solid #1e1f33;
    }

    .br {
        border-right: 1px solid #282844;
    }

    div.card-body {
        overflow-x: scroll;
    }

    .menu-icon {
        width: 33px;
        margin-right: 7%;
    }

    th,
    td {
        white-space: nowrap;
    }

    .cols_md_2 {
        padding: 10px;
        margin: 10px;
    }

    .colorbox {
        padding: 10px;
        border-radius: 10px;
    }

    aside.left-panel {
        min-width: 220px;
    }

    th {
        background: gray;
        color: white;
    }

    th,
    td {
        border: 1px solid;
    }

    .red {
        background-color: red;
        color: white;
        text-align: center;
        border-radius: 10px;
    }

    .green {
        background-color: green;
        color: white;
        text-align: center;
        border-radius: 10px;
    }

    .white {
        background-color: white;
        color: black;
        text-align: center;
        border-radius: 10px;
        border: 1px solid black;
    }

    .orchid {
        background-color: orchid;
        color: white;
        text-align: center;
        border-radius: 10px;
    }

    /* Hide elements dynamically generated with PHP */
    <?php for ($i = 35; $i < 61; $i++) { ?>
        #tdid<?php echo $i; ?>,
        #thid<?php echo $i; ?> {
            display: none;
        }
    <?php } ?>
</style>

<div class="page-content">
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h6 class="mb-0 text-uppercase">Cams Report</h6>
                <hr>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="col-12 grid-margin">
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
                                    <label for="AtmID">Select PanelID</label>
                                    <select name="AtmID" id="PanelID"
                                        class="form-control form-control-sm col-sm-9 js-example-basic-single w-100"
                                        value="<?php echo $panelid; ?>">
                                        <option value="">All Site</option>
                                        <?php 
                                        $panelsql = mysqli_query($con, "SELECT DISTINCT(NewPanelID) as panelid FROM sites");
                                        while ($panelsql_result = mysqli_fetch_assoc($panelsql)) {
                                            $panelid = $panelsql_result["panelid"];
                                        ?>
                                            <option value="<?php echo $panelid; ?>"><?php echo $panelid; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <button class="btn btn-primary" id="show_detail">Show</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"></h4>

                    <div class="row">
                        <div class="col-12" id="ticketview_tbody">
                            <!-- Content will be dynamically generated here -->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <!-- Additional content here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="js/dashboard.js"></script>
<script src="js/client_bank_circle_atmid.js"></script>
<script src="js/data-table.js"></script>
<script src="js/cams_report.js"></script>

<?php include ('../footer.php'); ?>
