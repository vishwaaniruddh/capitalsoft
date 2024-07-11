<?php
include 'config.php';
$PanelsIP=$_POST['PanelsIP'];
//echo $materialid;
$data=array();
$sql="select PanelIP from sites where PanelIP='".$PanelsIP."' and live!='N'";

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