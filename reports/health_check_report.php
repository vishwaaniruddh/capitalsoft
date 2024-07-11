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

    /* Hide columns 7-33 */
    <?php for ($i = 7; $i <= 33; $i++) { ?>
        #thid<?php echo $i; ?>,
        #tdid<?php echo $i; ?> {
            display: none;
        }
    <?php } ?>
</style>

<div class="page-content">
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h6 class="mb-0 text-uppercase">Health Check</h6>
                <hr />    
            </div>
            <?php include ("./sitehealth_filter.php"); ?>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"></h4>
                    <div class="row">
                        <div class="col-12" id="ticketview_tbody">
                            <!-- Content dynamically loaded here -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <!-- Additional content if needed -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="js/health_check_report.js"></script>

<?php include ('../footer.php'); ?>
