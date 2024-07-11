<?php session_start();
if(isset($_SESSION['login_user']) && isset($_SESSION['id']))
{
include ('config.php');
date_default_timezone_set('Asia/Kolkata');
$entryDate = date('Y-m-d H:i:s');


$value=$_POST["val"];
$id=$_POST["id"];
$Atm=$_POST["Atm"];

$Query="update sites set live='".$value."' where SN='".$id."' ";
$qry=mysqli_query($conn,$Query);
//$resultcpy=mysqli_query($cn,$Query);
//$qry3=mysqli_query($cont,$Query);


$insrt=mysqli_query($conn,"insert into testingCount (Atmid,name,Action,engiName) value('".$Atm."','".$_SESSION['name']."','".$value."','')");
$last=mysqli_insert_id($conn);


$dataQry=mysqli_query($conn,"Select * from sites where ATMID='".$Atm."' and live='".$value."' ");
$fetchdata=mysqli_fetch_array($dataQry);

$sql="insert into sites_log(Status,Phase,Customer,Bank,ATMID,ATMID_2,ATMID_3,ATMID_4,TrackerNo,ATMShortName,SiteAddress,City,State,Zone,Panel_Make,OldPanelID,NewPanelID,DVRIP,DVRName,UserName,Password,live,current_dt,eng_name,addedby,site_remark,site_id,editby)
values('".$fetchdata['Status']."','".$fetchdata['Phase']."','".$fetchdata['Customer']."','".$fetchdata['Bank']."','".$fetchdata['ATMID']."','".$fetchdata['ATMID_2']."','".$fetchdata['ATMID_3']."','".$fetchdata['ATMID_4']."','".$fetchdata['TrackerNo']."','".$fetchdata['ATMShortName']."','".$fetchdata['SiteAddress']."','".$fetchdata['City']."','".$fetchdata['State']."','".$fetchdata['Zone']."','".$fetchdata['Panel_Make']."','".$fetchdata['OldPanelID']."','".$fetchdata['NewPanelID']."','".$fetchdata['DVRIP']."','".$fetchdata['DVRName']."','".$fetchdata['UserName']."','".$fetchdata['Password']."','".$fetchdata['live']."','".$entryDate."','".$fetchdata['eng_name']."','".$fetchdata['addedby']."','','".$fetchdata['SN']."','".$_SESSION['name']."')";
$querdata=mysqli_query($conn,$sql);

//echo $sql;

if($value=='T'){
$insrtss=mysqli_query($conn,"insert into TestingSites (atmid,status) value('".$Atm."','T' )");
}else if($value=='Y'){
	$insrts=mysqli_query($conn,"Delete from TestingSites where atmid='".$Atm."' ");
}

if($qry){
	echo $last;
}else{
	echo "0";
}

}else
{ 
 header("location: index.php");
}
?>

