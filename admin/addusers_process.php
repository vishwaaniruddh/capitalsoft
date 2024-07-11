<?php include ('../header.php'); ?>

<div class="page-content">


    <?php
    $empid = $_POST['empid'];
    $fn = $_POST['fn'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $drop = $_POST['drop'];
    $drop = $_POST['drop'];
    $degi = $_POST['degi'];
    if (isset($_POST['sub'])) {

        $sql = "insert into LoginUsers(name,uname,pwd,permission,designation,level,cust_id,bank_id,branch,zone,empid)
                     values('$fn','$name','$password','$drop',$degi,'','','','','','$empid')";
        
                     $result = mysqli_query($conn, $sql);
        if ($result) {
            ?>
            <script>
                /*
                swal({
                  title: "Register Successfull!",
                  text: "done!",
                  icon: "success",
                  button: "OK",
                });
                window.open("addusers.php","_self");
 
                */
                alert("User Registered Successfull!");
                window.open("viewusers.php", "_self");
            </script>
        <?php } else {

            echo mysqli_error($conn);
?>
<a href="./adduser.php">Go Back</a>
<?php
        } ?>


    <?php } ?>


</div>
<?php include ('../footer.php'); ?>