<?php include ('../header.php'); ?>



<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>


<div class="page-content">

    <div class="card">
        <div class="card-body">
            <form id="adddvrForm">
                <div class="row">
                    <div class="col-sm-12">
                        <label for="dvr">DVR Name</label>
                        <input type="text" name="dvr" id="dvr" class="form-control form-control-sm mb-3" required>
                    </div>

                    <div class="col-sm-3">
                        <button type="submit" class="btn btn-primary px-5 rounded-0">Add dvr</button>
                    </div>
                </div>
            </form>
        </div>
    </div>



    <div class="card">
        <div class="card-body">
            <table id="example" class="table table-striped table-hover  js-exportable no-footer" style="width:100%">

                <thead>
                    <tr>
                        <th>Sr No</th>
                        <th>DVR Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $dvrsql = mysqli_query($con, 'SELECT * FROM dvr_name WHERE status=1 ORDER BY name DESC');
                    while ($dvrsqlresult = mysqli_fetch_array($dvrsql)) {
                        $dvr = $dvrsqlresult['name'];
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $dvr; ?></td>
                            <td>
                                <button class="btn btn-danger btn-sm delete-dvr"
                                    data-dvr-id="<?php echo $dvrsqlresult['id']; ?>">Delete</button>
                            </td>
                        </tr>
                        <?php
                        $i++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Delete dvr action
            $('.delete-dvr').on('click', function () {
                var dvrId = $(this).data('dvr-id');
                var confirmation = confirm("Are you sure you want to delete this dvr?");

                if (confirmation) {
                    // AJAX call to delete dvr
                    $.ajax({
                        type: "POST",
                        url: "../ajaxComponents/deletedvr.php",
                        data: { dvr_id: dvrId },
                        success: function (response) {
                            if (response == 1) {
                                alert("dvr deleted successfully.");
                                // Optionally, you can reload the DataTable to reflect changes
                                window.location.reload();
                            } else {
                                alert("Failed to delete dvr.");
                            }
                        },
                        error: function () {
                            alert("Error in deleting dvr.");
                        }
                    });
                } else {
                    alert("Your dvr is safe.");
                }
            });

            // Handle form submission via AJAX
            $('#adddvrForm').submit(function (event) {
                event.preventDefault(); // Prevent default form submission

                // Get form data
                var dvr = $('#dvr').val();


                // AJAX request to add dvr
                $.ajax({
                    type: 'POST',
                    url: '../ajaxComponents/adddvr.php',
                    data: {
                        dvr: dvr
                    },
                    success: function (response) {
                        if (response == 1) {
                            alert("dvr added successfully.");
                            // Clear form inputs
                            $('#dvr').val('');
                            window.location.reload();

                            
                        } else {
                            alert("Failed to add dvr.");
                        }
                    },
                    error: function () {
                        alert("Error adding dvr.");
                    }
                });
            });
        });
    </script>


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