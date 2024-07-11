<?php include ('../header.php'); 

function formatDateTime($dateTimeString) {
    return date('d-m-Y D h:i:s A', strtotime($dateTimeString));
}
?>

<div class="page-content">
<?php
$id = $_REQUEST['id'];
	$table = $_REQUEST['table'];
	 ?>

	<table class="table table-hover">
	<thead>
	    <tr>
	      <th scope="col">#</th>
	      <th scope="col">ATMID</th>
	      <th scope="col">Date</th>
	      <th scope="col">User</th>
	      <th scope="col">Status</th>
	    </tr>
	  </thead>
	  <tbody>
	  	<?php

	function get_atmid($id,$table){
		global $conn;

		$sql = mysqli_query($conn,"select * from $table where SN='".$id."'");
		$sql_result = mysqli_fetch_assoc($sql);

		return $sql_result['ATMID'];
	}

	  	$i=1;

// echo "select * from live_info_details where site_id = '".$id."' and `ctable`='".$table."'" ; 
	  	$sql = mysqli_query($conn,"select * from live_info_details where site_id = '".$id."' and `ctable`='".$table."' order by id desc");
	  	while ($sql_result = mysqli_fetch_assoc($sql)) { 

			$atmid = $sql_result['site_id'];
			$atmid = get_atmid($id,$table);
			$datetime = $sql_result['created_at'];
			$datetime = formatDateTime($datetime); 
			$created_by = $sql_result['created_by'];
			$status = $sql_result['status'];

			$userSql = mysqli_query($conn,"select name from loginusers where id='".$created_by."'");
			$userSqlResult = mysqli_fetch_assoc($userSql);
			$username = $userSqlResult['name'];

	?>
	  	<tr>
	      <th scope="col"><?php echo $i; ?></th>
	      <th scope="col"><?php echo $atmid;  ?></th>
	      <th scope="col"><?php echo $datetime;  ?></th>
	      <th scope="col"><?php echo $username;  ?></th>
	      <th scope="col"><?php echo $status; ?></th>
	  	</tr>

	<?php $i++; } ?>
	  </tbody>
	</table>



</div>
<?php include ('../footer.php'); ?>


