<?php include ('../header.php'); ?>

<div class="page-content">


    <h2>Edit - Permission</h2>

    <div class="card">
        <div class="card-body" style="overflow:auto;">


            <?php

            $id = $_REQUEST['userid'];

            $sql = mysqli_query($con, "select * from loginusers where id='" . $id . "'");
            if ($sql_result = mysqli_fetch_assoc($sql)) {



                $user_permission = $sql_result['permission'];
                $user_permission = explode(",", $user_permission);


                if (isset($_POST['submit'])) {

                    $sub_menu = $_REQUEST['sub_menu'];

                    $sub_menu_str = implode(',', $sub_menu);

                    echo
                        $update = "update loginusers set permission='" . $sub_menu_str . "' where id='" . $id . "'";

                    if (mysqli_query($con, $update)) {
                        ?>
                        <script>
                            alert('Permission Updated Successfully !');
                            window.location.href = "./viewUser.php";
                        </script>
                    <?
                    } else {
                        ?>
                        <script>
                            alert('Permission Updated Error !');
                            window.location.href = "./viewUser.php";
                        </script>
                    <?php
                    }

                }



                ?>

                <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
                    <ul style="">
                        <?php
                        $statusColumn = 'status';
                        $mainsql = mysqli_query($con, "select * from main_menu where $statusColumn=1");
                        while ($mainsql_result = mysqli_fetch_assoc($mainsql)) {
                            $main_id = $mainsql_result['id'];
                            ?>
                            <li class="card-block">
                                <input type="checkbox" class="main_menu" value="<?php echo $main_id; ?>">
                                <span class="strong">
                                    <?php echo $mainsql_result['name']; ?>
                                </span>
                                <ul class="showsubmenu">
                                    <?php
                                    $sub_sql = mysqli_query($con, "select * from sub_menu where main_menu='" . $main_id . "' and $statusColumn=1");
                                    while ($sub_sql_result = mysqli_fetch_assoc($sub_sql)) {
                                        $sub_id = $sub_sql_result['id'];
                                        ?>
                                        <li>
                                            <input class="submenu" type="checkbox" data-main_id="<?php echo $main_id ?>"
                                                name="sub_menu[]" value="<?php echo $sub_id; ?>" <?php if (in_array($sub_id, $user_permission)) {
                                                       echo 'checked';
                                                   } ?>>
                                            <?php echo $sub_sql_result['sub_menu']; ?>
                                        </li>
                                    <?php } ?>
                                </ul>
                                <hr />
                            </li>
                        <?php } ?>


                    </ul>
                    <br />
                    <button type="submit" name="submit" class="badge bg-primary">Submit</button>

                </form>


<script>
       $(document).on('change', '.main_menu', function () {
        var isChecked = $(this).prop("checked");
        $(this).siblings(".showsubmenu").find(".submenu").prop("checked", isChecked);
    });
</script>


            <?php



            } else {
                echo 'User NOt Found ! ';
            }


            ?>




        </div>
    </div>



</div>
<?php include ('../footer.php'); ?>