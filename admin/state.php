<?php include ('../header.php'); ?>



<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>


<div class="page-content">

    <div class="card">
        <div class="card-body">
            <table id="example" class="table table-striped table-hover  js-exportable no-footer" style="width:100%">

                <thead>
                    <tr>
                        <th>Sr No</th>
                        <th>State Name</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $citysql = mysqli_query($con, 'SELECT * FROM state ORDER BY state DESC');
                    while ($cityresult = mysqli_fetch_array($citysql)) {
                        
                        $state = $cityresult['state'];
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $state; ?></td>
                          
                        </tr>
                        <?php
                        $i++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>


</div>

<?php include ('../footer.php'); ?>


<script src="../datatable/jquery.dataTables.js"></script>
<script src="../datatable/dataTables.bootstrap.js"></script>
<script src="../datatable/dataTables.buttons.min.js"></script>
<script src="../datatable/buttons.flash.min.js"></script>
<script src="../datatable/jszip.min.js"></script>

<script src="../datatable/pdfmake.min.js"></script>
<script src="../datatable/vfs_fonts.js"></script>
<script src="../datatable/buttons.html5.min.js"></script>
<script src="../datatable/buttons.print.min.js"></script>
<script src="../datatable/jquery-datatable.js"></script>