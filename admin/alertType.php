<?php include ('../header.php'); ?>



<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>


<div class="page-content">

    <div class="card">
        <div class="card-body">
            <form id="addalerttypeForm">
                <div class="row">
                    <div class="col-sm-6">
                        <label for="alerttype">Add alerttype</label>
                        <input type="text" name="alerttype" id="alerttype" class="form-control form-control-sm mb-3"
                            required>
                    </div>
                    <div class="col-sm-6">
                        <label for="isCritical">Is Critical</label>
                        <select name="isCritical" id="isCritical" class="form-control form-control-sm mb-3">
                            <option value="">Select</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <button type="submit" class="btn btn-primary px-5 rounded-0">Add alerttype</button>
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
                        <th>alerttype Name</th>
                        <th>Is Critical</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $alerttypesql = mysqli_query($con, 'SELECT * FROM alertType WHERE status=1 ORDER BY id DESC');
                    while ($alerttyperesult = mysqli_fetch_array($alerttypesql)) {
                        $alertid = $alerttyperesult['id'];
                        $alerttype = $alerttyperesult['alertType'];
                        $isCritical = $alerttyperesult['isCritical'] ? 'Yes' : 'No';
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>

                            <td><?php echo $alerttype; ?></td>
                            <td><?php echo $isCritical; ?></td>
                            
                            <td>
                            <button class="btn btn-danger btn-sm delete-alerttype"
    data-alerttype-id="<?php echo $alertid ; ?>">Delete</button>


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
            // Delete alerttype action
            $('.delete-alerttype').on('click', function () {
                var alerttypeId = $(this).data('alerttype-id');
                


                var confirmation = confirm("Are you sure you want to delete this alerttype?");

                if (confirmation) {
                    // AJAX call to delete alerttype
                    $.ajax({
                        type: "POST",
                        url: "../ajaxComponents/deletealerttype.php",
                        data: { alerttype_id: alerttypeId },
                        success: function (response) {
                            if (response == 1) {
                                alert("alerttype deleted successfully.");
                                // Optionally, you can reload the DataTable to reflect changes
                                // $('#example').DataTable().ajax.reload();
                                window.location.reload();
                            } else {
                                alert("Failed to delete alerttype.");
                            }
                        },
                        error: function () {
                            alert("Error in deleting alerttype.");
                        }
                    });
                } else {
                    alert("Your alerttype is safe.");
                }
            });

            // Handle form submission via AJAX
            $('#addalerttypeForm').submit(function (event) {
                event.preventDefault(); // Prevent default form submission

                // Get form data
                var alerttype = $('#alerttype').val();
                var isCritical = $('#isCritical').val();
                
                // AJAX request to add alerttype
                $.ajax({
                    type: 'POST',
                    url: '../ajaxComponents/addalerttype.php',
                    data: {
                        alerttype: alerttype,
                        isCritical: isCritical,
                    },
                    success: function (response) {
                        if (response == 1) {
                            alert("alerttype added successfully.");
                            // Clear form inputs
                            $('#alerttype').val('');
                            $('#state').val('');
                            // Reload DataTable (if necessary)
                            // $('#example').DataTable().ajax.reload();
                            window.location.reload();

                        } else {
                            alert("Failed to add alerttype.");
                        }
                    },
                    error: function () {
                        alert("Error adding alerttype.");
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