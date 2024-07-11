<?php
include 'config.php';
$dv_ip=$_POST['dv_ip'];
//echo $materialid;
$data=array();
$sql="select DVRIP from sites where DVRIP='".$dv_ip."' and live!='N'";

$result=mysqli_query($conn,$sql);
$row=mysqli_num_rows($result);
echo $row;
/*
while($row=mysqli_fetch_array($result))
{
$data[]=['DVR'=>$row['DVRIP']];
}
echo json_encode($data);
*/
?>