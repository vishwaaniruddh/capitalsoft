<?php
if ($_SESSION['userid']) {



    $id = $_SESSION['userid'];

    $user = "select * from loginusers where id=" . $id;
    $usersql = mysqli_query($con, $user);
    $usersql_result = mysqli_fetch_assoc($usersql);

    $level = $usersql_result['level'];
    $permission = $usersql_result['permission'];
    $permission = explode(',', $permission);
    sort($permission);

    $cpermission = json_encode($permission);
    $cpermission = str_replace(array('[', ']', '"'), '', $cpermission);
    $cpermission = explode(',', $cpermission);
    $cpermission = "'" . implode("', '", $cpermission) . "'";
    $mainmenu = [];
    foreach ($permission as $key => $val) {
        $sub_menu_sql = mysqli_query($con, "select * from sub_menu where id='" . $val . "' and status=1");

        if (mysqli_num_rows($sub_menu_sql) > 0) {
            $sub_menu_sql_result = mysqli_fetch_assoc($sub_menu_sql);
            $mainmenu[] = $sub_menu_sql_result['main_menu'];
        }
    }
    $mainmenu = array_unique($mainmenu);
    sort($mainmenu);


}

?>


<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header" style="
    background: white;">
        <a href="<?php echo BASE_URL; ?>">
            <div style="text-align: center;">
                <img src="<?php echo BASE_URL; ?>assets/images/logo.jpg" class="logo-icon" alt="logo icon"
                    style="filter:none;width: 75%;">
            </div>
        </a>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu mm-show" id="menu">









        <?php
        foreach ($mainmenu as $menu => $menu_id) {
            $menu_sql = mysqli_query($con, "select * from main_menu where id='" . $menu_id . "' and status=1");
            $menu_sql_result = mysqli_fetch_assoc($menu_sql);
            $main_name = $menu_sql_result['name'];
            $targetDiv = str_replace(' ', '', $main_name);
            $icon = $menu_sql_result['icon'];
            ?>

            <li>
                <a href="javascript:;" class="has-arrow">

                    <div class="parent-icon">


                        <!-- <div class="parent-icon"><i class='bx bx-home-alt'></i>
                        </div>
                        <div class="menu-title">Dashboard</div>
                    </a> -->



                        <!-- <i class="mdi mdi-security"></i> -->
                        <?php

                        if ($main_name == 'Dashboard') {
                            echo '<i class="bx bx-home-alt" ></i>';
                            // echo '<i class="fa fa-american-sign-language-interpreting"></i>';                                                
                        } else if ($main_name == 'Admin') {
                            echo '<i class="bx bx-lock"></i></span>';
                        } else if ($main_name == 'Sites') {
                            echo '<i class="bx bx-repeat" style="color: #FFB64D;"></i>';
                        } else if ($main_name == 'Alerts') {
                            echo '<i class="bx bx-error" style="color: #8df3ff;"></i>';
                        } else if ($main_name == 'DVR') {
                            echo '<i class="bx bx-donate-blood"></i>';
                        } else if ($main_name == 'Panel') {
                            echo '<i class="bx bx-bookmark-heart" style="color: #23ff23;"></i>';
                        } else if ($main_name == 'All Reports') {
                            echo '<i class="bx bx-category" style="color: #23ff23;"></i>';
                        } 
                        // else if ($main_name == 'Reports') {
                        //     echo '<i class="mdi mdi-file-chart align-center" style="color: #23ff23;"></i>';
                        // } else if ($main_name == 'Bulk Process') {
                        //     echo '<i class="mdi mdi-forum align-center"></i>';
                        // }
                        ?>
                    </div>
                    <div class="menu-title"><?php echo $main_name; ?></div>
                </a>



                <ul class="mm-collapse">

                    <?php
                    $submenu_sql = mysqli_query($con, "
                     SELECT * 
    FROM sub_menu 
    WHERE main_menu = '" . $menu_id . "' 
    AND id IN ($cpermission) 
    AND status = 1 
    ORDER BY 
        CASE 
            WHEN weight = 0 THEN 1 
            ELSE 0 
        END, 
        weight ASC
                    ");
                    while ($submenu_sql_result = mysqli_fetch_assoc($submenu_sql)) {

                        $page = $submenu_sql_result['page'];
                        $submenu_name = $submenu_sql_result['sub_menu'];
                        $folder = $submenu_sql_result['folder'];

                        if (basename($_SERVER['PHP_SELF'], PATHINFO_BASENAME) == $page) {
                            $className = 'active';
                        } else {
                            $className = '';
                        }
                        ?>


                        <li> <a href="<?php echo $base_url . $folder . '/' . $page; ?>"><i
                                    class="bx bx-radio-circle"></i><?php echo $submenu_name; ?></a>
                        </li>

                        <?php
                    }
                    ?>
                </ul>
    
    </li>

<?php } ?>


















</ul>
<!--end navigation-->
</div>
