<?php include ('./config.php');

$atmid = $_REQUEST['atmid'];
$customer = $_REQUEST['customer'];


if ($customer && $atmid) { ?>


    <style>
        .custom_box {
            height: 50px: width:50px;
            border: 1px solid;
            padding: 10px;
            margin : 5px auto ; 
        }
    </style>
    <br> <br>
    <div class="row">
        <div class="col">
            <h6 class="mb-0 text-uppercase">Panel Dashboard</h6>


            <hr />
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs nav-primary" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" data-bs-toggle="tab" href="#primaryhome" role="tab"
                                aria-selected="true">
                                <div class="d-flex align-items-center">
                                    <div class="tab-icon"><i class='bx bx-home font-18 me-1'></i>
                                    </div>
                                    <div class="tab-title">Panel</div>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#primaryprofile" role="tab"
                                aria-selected="false">
                                <div class="d-flex align-items-center">
                                    <div class="tab-icon"><i class='bx bx-user-pin font-18 me-1'></i>
                                    </div>
                                    <div class="tab-title">Dvr</div>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#primarycontact" role="tab"
                                aria-selected="false">
                                <div class="d-flex align-items-center">
                                    <div class="tab-icon"><i class='bx bx-microphone font-18 me-1'></i>
                                    </div>
                                    <div class="tab-title">Alert</div>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content py-3">
                        <div class="tab-pane fade show active" id="primaryhome" role="tabpanel">

                            <?php

                            $sitesql = mysqli_query($con, "Select * from sites where ATMID='" . $atmid . "'");
                            if ($sitesql_result = mysqli_fetch_array($sitesql)) {
                                $panelid = $sitesql_result['NewPanelID'];
                                $panelip = $sitesql_result['PanelIP'];
                                $panel_port = $sitesql_result['panel_port'];
                                $panel_make = $sitesql_result['Panel_Make'];





                                ?>


                                <div class="row">
                                    <div class="col-sm-3">
                                        <label>Panel ID : </label>
                                        <span><?php echo $panelid; ?></span>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Panel IP :</label>
                                        <span><?php echo $panelip; ?></span>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Panel Port : </label>
                                        <span><?php echo $panel_port; ?></span>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Panel Make : </label>
                                        <span><?php echo $panel_make; ?></span>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Panel MacID : </label>
                                        <span></span>
                                    </div>

                                    <div class="col-sm-3">
                                        <label>Panel Model : </label>
                                        <span></span>
                                    </div>



                                </div>


                                <hr>


                                <div class="row">

                                    <?php

                                    $panelsql = mysqli_query($con, "select * from $panel_make");
                                    while ($panelsql_result = mysqli_fetch_array($panelsql)) {

                                        $zone = $panelsql_result['ZONE'];
                                        ?>
                                        <div class="col-sm-1 ">
                                            <div class="custom_box">

                                                <?php echo $zone; ?>
                                            </div>
                                        </div>
                                        <?php


                                    }
                                    ?>

                                </div>
                                <?php
                            }




                            ?>




                        </div>
                        <div class="tab-pane fade" id="primaryprofile" role="tabpanel">
                            <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid.
                                Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan
                                four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft
                                beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda
                                labore aesthetic magna delectus mollit. Keytar helvetica VHS salvia yr, vero magna velit
                                sapiente labore stumptown. Vegan fanny pack odio cillum wes anderson 8-bit, sustainable jean
                                shorts beard ut DIY ethical culpa terry richardson biodiesel. Art party scenester stumptown,
                                tumblr butcher vero sint qui sapiente accusamus tattooed echo park.</p>
                        </div>
                        <div class="tab-pane fade" id="primarycontact" role="tabpanel">
                            <p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic
                                lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork
                                tattooed craft beer, iphone skateboard locavore carles etsy salvia banksy hoodie helvetica.
                                DIY synth PBR banksy irony. Leggings gentrify squid 8-bit cred pitchfork. Williamsburg banh
                                mi whatever gluten-free, carles pitchfork biodiesel fixie etsy retro mlkshk vice blog.
                                Scenester cred you probably haven't heard of them, vinyl craft beer blog stumptown.
                                Pitchfork sustainable tofu synth chambray yr.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


























<?php } else {
    echo 'Select ATMID to get data...';
}


?>