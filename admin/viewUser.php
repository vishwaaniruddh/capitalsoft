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
                        <th>Name</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Contact</th>
                        <th>Status</th>
                        <th>Edit</th>
                        <th>Active / Inactive</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $citysql = mysqli_query($con, 'select e.name,e.lname,l.uname,l.pwd, e.mob1,l.user_status from employee e INNER JOIN loginusers l ON e.id = l.empid order by e.id ASC');
                    while ($cityresult = mysqli_fetch_array($citysql)) {

                        $name = $cityresult['name'];
                        $lname = $cityresult['lname'];
                        $uname = $cityresult['uname'];
                        $pwd = $cityresult['pwd'];
                        $contact = $cityresult['mob1'];
                        $user_status = $cityresult['user_status'];


                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $name . '' . $lname; ?></td>
                            <td><?php echo $uname; ?></td>
                            <td><?php echo $pwd; ?></td>
                            <td><?php echo $contact; ?></td>
                            <td><?php
                            if ($user_status == 1) {
                                echo 'Active';
                            } else {
                                echo 'Disable';
                            }
                            ?></td>
                            <td>
                                <button type="button" class="text-primary" data-bs-toggle="modal" data-bs-target="#edituser"
                                    id="edituserbutton" data-act="add" data-value="1"
                                    style="color: #000;background-color: #e4eaec;border-color: #e4eaec;">
                                    <i class="fadeIn animated bx bx-edit-alt"></i> &nbsp; Edit
                                </button>

                            </td>
                            <td>
                                <button type="button" class="custom_button"  data-bs-toggle="modal" data-bs-target="#edituser"
                                    id="edituserbutton" data-act="add" data-value="1"
                                    style="color: #000;background-color: #e4eaec;border-color: #e4eaec;">
                                    <i class="fadeIn animated bx bx-trash-alt"></i> &nbsp; Make Inactive
                                </button>


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