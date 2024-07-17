<?php include('./config.php');

$atmid = $_REQUEST['atmid'];
$customer = $_REQUEST['customer'];

if ($customer && $atmid) {
    $sitesql = mysqli_query($con, "SELECT * FROM sites WHERE ATMID = '$atmid'");
    if ($sitesql_result = mysqli_fetch_array($sitesql)) {

echo $atmid . ' DVR DATA'  ; 
    }
}
?>