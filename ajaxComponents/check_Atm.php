<?php
include 'config.php';
$NewATMID=$_POST['NewATMID'];
//echo $materialid;
//$data=array();
$sql="select ATMID from sites where (ATMID='".$NewATMID."' or ATMID_2='".$NewATMID."')";

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