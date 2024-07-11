<?php include ('../config.php');
$siteid = $_REQUEST['siteid'];
$sql = "select * from sites_log where site_id='" . $siteid . "' order by current_dt desc";

$result = mysqli_query($conn, $sql);
$Num_Rows = mysqli_num_rows($result);


?>


<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
    table {
      width: 100%;
    }

    td {
      padding: 10px;
      font-size: 12px;
      font-weight: bold;
      color: #000;
    }

    tr:hover {
      background-color: #eee !important;
    }

    tr,
    th {
      padding: 10px;
      background-color: #8cb77e;
      color: #fff;
      font-size: 12px;
    }
  </style>
</head>

<body>


</body>

<center>
  <div>Total Records:<?php echo $Num_Rows ?></div>
</center>
<table border=1 style="margin-top:30px">
  <tr>
    <th>Sr No</th>

    <th>Customer</th>
    <th>Bank</th>

    <th>ATMID</th>
    <th>ATMID_2</th>
    <th>ATMShortName</th>
    <th>SiteAddress</th>
    <th>City</th>
    <th>State</th>

    <th>Panel_Make</th>
    <th>OldPanelID</th>
    <th>NewPanelID</th>
    <th>DVRIP</th>
    <th>DVRName</th>

    <th>Live</th>
    <th>Engineer Name</th>
    <th>Entry Date</th>
    <th>Site Add By</th>
    <th>Site Edit By</th>
    <th>Remark</th>


  </tr>
  <?php
  $srno = 1;
  while ($row = mysqli_fetch_array($result)) {

    ?>



    <tr style="background-color:#cfe8c7">
      <td><?php echo $srno; ?></td>

      <td><?php echo $row["Customer"]; ?></td>
      <td><?php echo $row["Bank"]; ?></td>

      <td><?php echo $row["ATMID"]; ?></td>

      <td><?php echo $row["ATMID_2"]; ?></td>

      <td><?php echo $row["ATMShortName"]; ?></td>
      <td><?php echo $row["SiteAddress"]; ?></td>
      <td><?php echo $row["City"]; ?></td>
      <td><?php echo $row["State"]; ?></td>

      <td><?php echo $row["Panel_Make"]; ?></td>
      <td><?php echo $row["OldPanelID"]; ?></td>
      <td><?php echo $row["NewPanelID"]; ?></td>
      <td><?php echo $row["DVRIP"]; ?></td>

      <td><?php echo $row["DVRName"]; ?></td>

      <td><?php echo $row["live"]; ?></td>
      <td><?php echo $row["eng_name"]; ?></td>


      <td><?php echo $row["current_dt"]; ?></td>
      <td><?php echo $row["addedby"]; ?></td>
      <td><?php echo $row["editby"]; ?></td>
      <td><?php echo $row["site_remark"]; ?></td>

    </tr>


    <?php
    $srno++;
  }
  ?>


</table>

</form>
<div>


</div>




</body>

</html>