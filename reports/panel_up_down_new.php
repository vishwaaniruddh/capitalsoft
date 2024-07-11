<?php
include ('../config.php');


// $bank = "";
// $circle = "";

// $atmid = "";

// if (isset ($_GET['atmid'])) {
//     $atmid = $_GET['atmid'];
// }
$atmid = $_GET['atmid'];



// var_dump($_GET);
// die;
$panelsql = "select * from sites where ATMID = '" . $atmid . "'";

$panelsql .= " order by sn asc";


$sql = mysqli_query($con, $panelsql);


if (!$sql || mysqli_num_rows($sql) == 0) { ?>
    <span>No Data Found</span>
<?php } else {
    $sql_result = mysqli_fetch_assoc($sql);
    $customer = $sql_result['Customer'];
    $bank = $sql_result['Bank'];
    $atmid = $sql_result['ATMID'];
    $city = $sql_result['City'];
    $state = $sql_result['State'];
    $address = $sql_result['SiteAddress'];

    ?>
    <div class="table-responsive">
        <table id="order-listing" class="table">
            <thead>
                <tr>
                    <th>Client</th>
                    <th>Bank</th>
                    <th>ATMID</th>

                    <th>State</th>
                    <th>City</th>
                    <th>Site Address</th>


                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <?= $client ?>
                    </td>
                    <td>
                        <?= $bank ?>
                    </td>

                    <td>
                        <?= $atmid; ?>
                    </td>
                    <td>
                        <?= $state ?>
                    </td>
                    <td>
                        <?= $city ?>
                    </td>
                    <td>
                        <?= $address ?>
                    </td>



                </tr>
            </tbody>
        </table>
    </div>



<?php } ?>