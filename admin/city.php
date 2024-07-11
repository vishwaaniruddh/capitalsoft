<?php include ('../header.php'); ?>



<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>


<div class="page-content">

<div class="card">
    <div class="card-body">
        <form id="addCityForm">
            <div class="row">
                <div class="col-sm-6">
                    <label for="city">Add City</label>
                    <input type="text" name="city" id="city" class="form-control form-control-sm mb-3" required>
                </div>
                <div class="col-sm-6">
                    <label for="state">Select State</label>
                    <select name="state" id="state" class="form-control form-control-sm mb-3" required>
                        <option value="">Select</option>
                        <?php
                        $statesql = mysqli_query($con, "SELECT * FROM state ORDER BY state ASC");
                        while ($stateresult = mysqli_fetch_array($statesql)) {
                            $state = $stateresult["state"];
                            $state_id = $stateresult["state_id"];
                        ?>
                            <option value="<?php echo $state_id . '-' . $state; ?>"><?php echo $state; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-sm-3">
                    <button type="submit" class="btn btn-primary px-5 rounded-0">Add City</button>
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
                    <th>City Name</th>
                    <th>State Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $i = 1; 
                $citysql = mysqli_query($con, 'SELECT * FROM cities WHERE status=1 ORDER BY city_id DESC');
                while ($cityresult = mysqli_fetch_array($citysql)) {
                    $city = $cityresult['city'];
                    $state = $cityresult['state'];
                ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $city; ?></td>
                    <td><?php echo $state; ?></td>
                    <td>
                        <button class="btn btn-danger btn-sm delete-city" data-city-id="<?php echo $cityresult['city_id']; ?>">Delete</button>
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
$(document).ready(function() {
    // Delete city action
    $('.delete-city').on('click', function() {
        var cityId = $(this).data('city-id');
        var confirmation = confirm("Are you sure you want to delete this city?");

        if (confirmation) {
            // AJAX call to delete city
            $.ajax({
                type: "POST",
                url: "../ajaxComponents/deletecity.php",
                data: { city_id: cityId },
                success: function(response) {
                    if (response == 1) {
                        alert("City deleted successfully.");
                        // Optionally, you can reload the DataTable to reflect changes
                        $('#example').DataTable().ajax.reload();
                    } else {
                        alert("Failed to delete city.");
                    }
                },
                error: function() {
                    alert("Error in deleting city.");
                }
            });
        } else {
            alert("Your city is safe.");
        }
    });

    // Handle form submission via AJAX
    $('#addCityForm').submit(function(event) {
        event.preventDefault(); // Prevent default form submission
        
        // Get form data
        var city = $('#city').val();
        var state = $('#state').val();
        
        // Split state value to get state_id and state_name
        var stateParts = state.split('-');
        var state_id = stateParts[0];
        var state_name = stateParts[1];
        
        // AJAX request to add city
        $.ajax({
            type: 'POST',
            url: '../ajaxComponents/addcity.php',
            data: {
                city: city,
                state_id: state_id,
                state_name: state_name
            },
            success: function(response) {
                if (response == 1) {
                    alert("City added successfully.");
                    // Clear form inputs
                    $('#city').val('');
                    $('#state').val('');
                    // Reload DataTable (if necessary)
                    $('#example').DataTable().ajax.reload();
                } else {
                    alert("Failed to add city.");
                }
            },
            error: function() {
                alert("Error adding city.");
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