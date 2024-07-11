<?php
include '../config.php';
$State=$_REQUEST['State'];

$data=array();
$sql="select city from cities where state_id='".$State."'";
$result=mysqli_query($conn,$sql);
while($row=mysqli_fetch_array($result))
{
$data[]=['stateid'=>$row['city']];
}
echo json_encode($data);
?>