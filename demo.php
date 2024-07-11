<?php include('./config.php');

// For Panel

$sql = mysqli_query($con,"select * from sites where NewPanelID <> '-'");

while ($row = mysqli_fetch_array($sql)) {

    $panel_id = $row["NewPanelID"];
    $panelName = $row["Panel_Make"];
    $ip = $row["PanelIP"];
    $atmid = $row["ATMID"];
    $random_number = rand(0, 1);


echo "INSERT INTO panel_health(panelName,ip,panelid,atmid,status) 
    values('".$panelName."','".$ip."','".$panel_id."','".$atmid."','".$random_number."')" ; 

    $insert = mysqli_query($con,"INSERT INTO panel_health(panelName,ip,panelid,atmid,status) 
    values('".$panelName."','".$ip."','".$panel_id."','".$atmid."','".$random_number."')");


echo '<br />';



}


return ; 


// $sql = mysqli_query($con,"select * from dvrsite");
// while ($row = mysqli_fetch_array($sql)) {
//     $username = $row["UserName"];
//     $password = $row["Password"];
//     $DVRName = $row["DVRName"];
//     $DVRIP = $row["DVRIP"];
//     $Customer = $row["Customer"];
//     $ATMID = $row["ATMID"];
//     $live = $row["live"];
//     $port = $row['port'];
//     // $port = 80;
// echo
//     $insert = "insert into all_dvr_live(UserName,Password,dvrname,IPAddress,port,customer,live,atmid) 
//     VALUES('".$username."','".$password."','".$DVRName."','".$DVRIP."','".$port."','".$Customer."','".$live."','".$ATMID."')" ;

// echo '<br />';
//     mysqli_query($con, $insert);



// }







// return ; 


// return;
// http://192.168.0.27:8080/vertical/demo.php
// $sql = mysqli_query($con,"select * from hitachi_cash");
// while ($row = mysqli_fetch_array($sql)) {
//     $username = $row["UserName"];
//     $password = $row["Password"];
//     $DVRName = $row["DVRName"];
//     $DVRIP = $row["DVRIP"];
//     $Customer = $row["Customer"];
//     $ATMID = $row["ATMID"];
//     $live = 'Y';
//     $port = $row['port'];
//     // $port = 80;
// echo
//     $insert = "insert into all_dvr_live(UserName,Password,dvrname,IPAddress,port,customer,live,atmid) 
//     VALUES('".$username."','".$password."','".$DVRName."','".$DVRIP."','".$port."','".$Customer."','".$live."','".$atmid."')" ;

// echo '<br />';
//     // mysqli_query($con, $insert);



// }
// return ; 


// $sql = mysqli_query($con,"select * from dvronline");
// while ($row = mysqli_fetch_array($sql)) {
//     $username = $row["UserName"];
//     $password = $row["Password"];
//     $DVRName = $row["dvrname"];
//     $DVRIP = $row["IPAddress"];
//     $Customer = $row["customer"];
//     $ATMID = $row["ATMID"];
//     $live = 'Y';
//     // $port = $row['dvr_port'];
//     $port = 80;
// echo
//     $insert = "insert into all_dvr_live(UserName,Password,dvrname,IPAddress,port,customer,live,atmid) 
//     VALUES('".$username."','".$password."','".$DVRName."','".$DVRIP."','".$port."','".$Customer."','".$live."','".$atmid."')" ;

// echo '<br />';
//     mysqli_query($con, $insert);



// }





// return ; 
$sql = mysqli_query($con,"select * from sites ");

while ($row = mysqli_fetch_array($sql)) {


    $username = $row["UserName"];
    $password = $row["Password"];
    $DVRName = $row["DVRName"];
    $DVRIP = $row["DVRIP"];
    $Customer = $row["Customer"];
    $ATMID = $row["ATMID"];
    $live = $row["live"];
    $port = $row['dvr_port'];
echo
    $insert = "insert into all_dvr_live(UserName,Password,dvrname,IPAddress,port,customer,live,atmid) 
    VALUES('".$username."','".$password."','".$DVRName."','".$DVRIP."','".$port."','".$Customer."','".$live."','".$ATMID."')" ;

echo '<br />';
    mysqli_query($con, $insert);



}

?>