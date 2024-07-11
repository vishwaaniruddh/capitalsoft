<?php
include 'config.php';
$NewPanelID=$_POST['NewPanelID'];
//echo $materialid;
$data=array();
$sql="select NewPanelID from sites where NewPanelID='".$NewPanelID."'";

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