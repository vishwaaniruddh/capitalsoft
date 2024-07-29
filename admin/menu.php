<?php include('../header.php'); ?>


<style>
    .menuList-item {
        /* background:limegreen; */
        margin: 15px auto;
    }
</style>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    function disable(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Think twice to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Proceed it!'
        }).then((result) => {
            if (result.isConfirmed) {

                jQuery.ajax({
                    type: "POST",
                    url: 'disable_menu.php',
                    data: 'id=' + id,
                    success: function(msg) {

                        if (msg == 1) {
                            Swal.fire(
                                'Updated!',
                                'Status has been changed.',
                                'success'
                            );

                            setTimeout(function() {
                                window.location.reload();
                            }, 2000);

                        } else if (msg == 0 || msg == 2) {

                            Swal.fire(
                                'Cancelled',
                                'Your submenu is safe :)',
                                'error'
                            );



                        }

                    }
                });


            }
        })

    }
</script>



<!-- <link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css"> -->
<div class="page-content">


    <!--Menu-->
    <?php
    if (isset($_POST['menu_submit'])) {
        $menu = $_POST['menu'];

        $sql = "insert into main_menu(name,status) values('" . $menu . "','1')";

        if (mysqli_query($con, $sql)) { ?>
            <script>
                alert('Menu Added');
            </script>
        <?php } else {
        ?>
            <script>
                alert('Menu Added Error !');
            </script>
    <?php
        }
    }


    ?>
    <!--End Menu-->




    <!--Sub Menu-->

    <?php
    if (isset($_POST['submenu_submit'])) {
        $menu = $_POST['menu'];
        $submenu = $_POST['submenu'];
        $page = $_POST['page'];
        $folder = $_POST['folder'];
        $sql = "insert into sub_menu(main_menu,sub_menu,page,status,folder) values('" . $menu . "','" . $submenu . "','" . $page . "','1','" . $folder . "')";

        if (mysqli_query($con, $sql)) { ?>
            <script>
                alert('SubMenu Added');
            </script>
        <?php } else {
            echo mysqli_error($con);
        ?>
            <script>
                alert('Sub Menu Added Error !');
            </script>
    <?php
        }
    }


    ?>


    <!--End Sub Menu-->




    <div class="row">
        <div class="col-sm-6">

            <div class="card">
                <div class="card-body">

                    <div class="cardHeader" style="display: flex; justify-content:space-between;">

                        <h5 class="card-title">Menu - Control </h5>
                        <div class="actionButtons" style="display: flex; justify-content:flex-end;">
                            <button id="openAll" class="badge bg-primary">Open All</button> &nbsp;&nbsp;&nbsp;
                            <button id="closeAll" class="badge bg-danger">Close All</button>
                        </div>
                    </div>
                    <hr>
                    <div class="accordion accordion-flush" id="accordionFlushMenu">
                        <?php
                        $mainsql = mysqli_query($con, "SELECT * FROM main_menu");
                        $count = 0; // Counter for unique IDs
                        while ($mainsql_result = mysqli_fetch_assoc($mainsql)) {
                            $main_id = $mainsql_result['id'];
                            $count++;
                        ?>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-heading-<?php echo $count; ?>">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse-<?php echo $count; ?>" aria-expanded="false" aria-controls="flush-collapse-<?php echo $count; ?>">
                                        <?php echo $mainsql_result['name']; ?>
                                    </button>
                                </h2>
                                <div id="flush-collapse-<?php echo $count; ?>" class="accordion-collapse collapse" aria-labelledby="flush-heading-<?php echo $count; ?>" data-bs-parent="#accordionFlushMenu">
                                    <div class="accordion-body">
                                        <ul class="list-unstyled">
                                            <?php
                                            $sub_sql = mysqli_query($con, "SELECT * FROM sub_menu WHERE main_menu='" . $main_id . "'");
                                            while ($sub_sql_result = mysqli_fetch_assoc($sub_sql)) {
                                                $sub_id = $sub_sql_result['id'];
                                                $weight = $sub_sql_result['weight'];
                                                $activityStatus = $sub_sql_result['status'];
                                            ?>
                                                <li style="display: flex; justify-content: space-between;" class="menuList-item">
                                                    <span><?php echo $sub_sql_result['sub_menu']; ?></span>
                                                    <div class="menuActions" style="display: flex; justify-content: end;">
                                                        <div class="editName" style="margin:auto;">
                                                            <button type="button" class="badge bg-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-submenuid="<?php echo $sub_id; ?>" data-submenuname="<?php echo htmlspecialchars($sub_sql_result['sub_menu']); ?>">Edit</button>
                                                        </div>
                                                        <div class="deleteMenu" style="margin:auto 10px;">
                                                            <?php
                                                            if ($activityStatus == '1') {
                                                                echo '<a href="javascript:void(0);" class="badge bg-danger" onclick="disable(' . $sub_id . ')">Delete</a>';
                                                            } else {
                                                                echo '<a href="javascript:void(0);" class="badge bg-success" onclick="disable(' . $sub_id . ')">Restore</a>';
                                                            }
                                                            ?>
                                                        </div>
                                                        <div class="weight" style="margin:auto;">
                                                            <input type="number" class="menu_weight" data-submenuid="<?php echo $sub_id; ?>" name="menu_weight" value="<?php echo $weight; ?>" style="width:40px;">
                                                        </div>
                                                    </div>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <script>
                document.getElementById('openAll').addEventListener('click', function() {
                    var accordionItems = document.querySelectorAll('.accordion-collapse');
                    accordionItems.forEach(function(item) {
                        var collapseInstance = new bootstrap.Collapse(item, {
                            toggle: false
                        });
                        collapseInstance.show();
                    });
                });

                document.getElementById('closeAll').addEventListener('click', function() {
                    var accordionItems = document.querySelectorAll('.accordion-collapse');
                    accordionItems.forEach(function(item) {
                        var collapseInstance = new bootstrap.Collapse(item, {
                            toggle: false
                        });
                        collapseInstance.hide();
                    });
                });
            </script>


        </div>
        <div class="col-sm-6">


            <div class="card">
                <div class="card-body">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <div class="row">
                            <div class="col">
                                <label>Create Menu</label>
                                <input type="text" name="menu" class="form-control form-control-sm mb-3" required>
                            </div>
                            <div class="col">
                                <br>
                                <button type="submit" name="menu_submit" class="badge bg-primary">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>


                </div>
            </div>

            <div class="card">
                <div class="card-body">

                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <div class="row">
                            <div class="col-sm-12 grid-margin">
                                <label>Select Under</label>
                                <select name="menu" class="form-control form-control-sm mb-3" id="main_menu" required>
                                    <option value="">Select</option>
                                    <?php
                                    $main_sql = mysqli_query($con, "select * from main_menu where status=1");
                                    while ($main_sql_result = mysqli_fetch_assoc($main_sql)) { ?>
                                        <option value="<?php echo $main_sql_result['id']; ?>">
                                            <?php echo $main_sql_result['name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-sm-12 grid-margin">
                                <label>Submenu</label>
                                <input type="text" name="submenu" class="form-control form-control-sm mb-3" required>
                            </div>
                            <div class="col-sm-12 grid-margin">
                                <label>Page</label>
                                <input type="text" name="page" class="form-control form-control-sm mb-3" placeholder="like index.php" required>
                            </div>

                            <div class="col-sm-12 grid-margin">
                                <label>Folder</label>
                                <input type="text" name="folder" class="form-control form-control-sm mb-3">
                            </div>


                            <div class="col-sm-12 grid-margin">
                                <button type="submit" name="submenu_submit" class="badge bg-primary">
                                    Submit
                                </button>

                            </div>


                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Submenu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="submenu_name" name="submenu_name" value="" class="form-control form-control-sm mb-3">
                    <input type="hidden" id="submenu_id" name="submenu_id" value="">
                    <button type="button" id="saveChanges" class="badge bg-primary">Save Changes</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="badge bg-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>



    <script>
        $(document).on('change', '.menu_weight', function() {
            // Get the new weight value and submenu ID
            var newWeight = $(this).val();
            var submenuId = $(this).data('submenuid');

            // alert(submenuId);
            // Send the AJAX request
            $.ajax({
                url: 'update_weight.php', // PHP file that handles the weight update
                type: 'POST',
                data: {
                    submenu_id: submenuId,
                    weight: newWeight
                },
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.status === 'success') {
                        // alert('Weight updated successfully.');
                    } else {
                        alert('Failed to update weight.');
                    }
                },
                error: function() {
                    alert('An error occurred while updating the weight.');
                }
            });
        });

        $(document).ready(function() {
            // Event listener for when the modal is shown
            $('#exampleModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var submenuName = button.data('submenuname'); // Extract info from data-* attributes
                var submenuId = button.data('submenuid'); // Extract submenu ID

                // Update the modal's input fields
                $('#submenu_name').val(submenuName);
                $('#submenu_id').val(submenuId);
            });

            // Event listener for the Save Changes button
            $('#saveChanges').on('click', function() {
                var submenuName = $('#submenu_name').val();
                var submenuId = $('#submenu_id').val();

                // AJAX request to update submenu name
                $.ajax({
                    url: 'update_submenu.php', // Replace with your PHP file that handles the update
                    type: 'POST',
                    data: {
                        submenu_name: submenuName,
                        submenu_id: submenuId
                    },
                    success: function(response) {
                        // Handle success response
                        var result = JSON.parse(response);
                        if (result.status === 'success') {
                            alert('Submenu name updated successfully.');
                            location.reload(); // Optionally reload the page to reflect changes
                        } else {
                            alert('Failed to update submenu name.');
                        }
                        $('#exampleModal').modal('hide'); // Close the modal
                    },
                    error: function() {
                        alert('An error occurred while updating the submenu name.');
                    }
                });
            });
        });
    </script>




</div>
<?php include('../footer.php'); ?>