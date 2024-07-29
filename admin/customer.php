<?php include ('../header.php'); ?>



<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>


<div class="page-content">

    <div class="card">
        <div class="card-body">
            <form id="addcustomerForm">
                <div class="row">
                    <div class="col">
                        <label for="customer">Cutomer Name</label>
                        <input type="text" name="customer" id="customer" class="form-control form-control-sm mb-3" required>
                    </div>

                    <div class="col">
                    <br>    
                    <button type="submit" class="badge bg-primary">Add Customer</button>
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
                        <th>Customer Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $customersql = mysqli_query($con, 'SELECT * FROM customer WHERE status=1 ORDER BY name DESC');
                    while ($customersqlresult = mysqli_fetch_array($customersql)) {
                        $customer = $customersqlresult['name'];
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $customer; ?></td>
                            <td>
                                <button class="badge bg-danger delete-customer"
                                    data-customer-id="<?php echo $customersqlresult['id']; ?>">Delete</button>
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
            // Delete customer action
            $('.delete-customer').on('click', function () {
                var customerId = $(this).data('customer-id');
                var confirmation = confirm("Are you sure you want to delete this customer?");

                if (confirmation) {
                    // AJAX call to delete customer
                    $.ajax({
                        type: "POST",
                        url: "../ajaxComponents/deletecustomer.php",
                        data: { customer_id: customerId },
                        success: function (response) {
                            if (response == 1) {
                                alert("customer deleted successfully.");
                                // Optionally, you can reload the DataTable to reflect changes
                                window.location.reload();
                            } else {
                                alert("Failed to delete customer.");
                            }
                        },
                        error: function () {
                            alert("Error in deleting customer.");
                        }
                    });
                } else {
                    alert("Your customer is safe.");
                }
            });

            // Handle form submission via AJAX
            $('#addcustomerForm').submit(function (event) {
                event.preventDefault(); // Prevent default form submission

                // Get form data
                var customer = $('#customer').val();


                // AJAX request to add customer
                $.ajax({
                    type: 'POST',
                    url: '../ajaxComponents/addcustomer.php',
                    data: {
                        customer: customer
                    },
                    success: function (response) {
                        if (response == 1) {
                            alert("customer added successfully.");
                            // Clear form inputs
                            $('#customer').val('');
                            window.location.reload();

                            
                        } else {
                            alert("Failed to add customer.");
                        }
                    },
                    error: function () {
                        alert("Error adding customer.");
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