<?php include '../config.php';

$site_id = $sn=$_POST['sn'];
$datetime = date('Y-m-d H:i:s'); 
$userid = $_SESSION['id'];

//echo $sn;


$curentdt=date("Y-m-d H:i:s");
$t=date("H:i:s");

 /*$insdates=$_POST['dates'];
if($insdates==""){
$insdates=date("Y-m-d");	
}*/

$closedDate = $_REQUEST['closedDate'];
$CTSLocalBranch=$_POST['CTSLocalBranch'];
$CTS_BM_Name=$_POST['CTS_BM_Name'];
$CTS_BM_Number=$_POST['CTS_BM_Number'];
$install_Status=$_POST['install_Status'];
$CTS_UserName=$_POST['CTS_UserName'];
$CTS_Password=$_POST['CTS_Password'];


$Status=$_POST['Status'];
$Phase=$_POST['Phase'];
$Customer=$_POST['Customer'];
$Bank=$_POST['Bank'];
$ATMID=$_POST['ATMID'];
$ATMID_2=$_POST['ATMID_2'];
$ATMID_3=$_POST['ATMID_3'];
$ATMID_4=$_POST['ATMID_4'];
$TrackerNo=$_POST['TrackerNo'];
$ATMShortName=$_POST['ATMShortName'];
$SiteAddress=$_POST['SiteAddress'];
$City=$_POST['City'];
$State=$_POST['State'];
$Zone=$_POST['Zone'];


$DVRIP=$_POST['DVRIP'];
$DVRName=$_POST['DVRName'];
$DVR_Model_num=$_POST['DVR_Model_num'];
$DVR_Serial_num=$_POST['DVR_Serial_num'];
$HDD=$_POST['HDD'];
$Camera1=$_POST['Camera1'];
$Camera2=$_POST['Camera2'];
$Camera3=$_POST['Camera3'];
$Remark=$_POST['Remark'];
//$Attachment1=$_POST['Attachment1'];
//$Attachment2=$_POST['Attachment2'];
$liveDate=$_POST['liveDate'];

if($install_Status=='WIP'){
$live = 'P';
}
else if($install_Status=='Provission'){
	$live = 'N';
}
else if($install_Status=='TecLive'){
	$live = 'Y';
}

$live = $_REQUEST['live'];


if($live=='PL'){
    $partial_live='1';
    $live = 'Y' ; 
}else{
    $partial_live='0';
}

$check_live = mysqli_query($conn,"select * from dvrsite where SN='".$site_id."'");
$check_live_result = mysqli_fetch_assoc($check_live);
if($check_live_result['live']!=$live){
    $live_sql = "insert into live_info_details(site_id,ctable,status, created_at,created_by) 
                values('".$site_id."','dvrsite','".$live."','".$datetime."','".$userid."')";
    mysqli_query($conn,$live_sql);
}




$created_at = date('Y-m-d'); 
$routebrand = $_POST['router_brand'];
$router_id = $_POST['router_id'];
$simnumber= $_POST['sim_number'];
$simowner = $_POST['sim_owner'];


$check_sql = mysqli_query($conn,"select * from sites_details where site_id = '".$site_id."' and project='2'");
if($check_sql_result = mysqli_fetch_assoc($check_sql)){

    $query = "update sites_details set routebrand='".$routebrand."' , router_id='".$router_id."' , simnumber='".$simnumber."', simowner='".$simowner."' , closedDate='".$closedDate."' where site_id = '".$site_id."' and project='2'"; 
}else{
    $query = "insert into sites_details(site_id, routebrand, router_id, simnumber, simowner, status, created_at,project,closedDate) values('".$site_id."', '".$routebrand."', '".$router_id."', '".$simnumber."', '".$simowner."', '1', '".$created_at."','2','".$closedDate."')" ; 
}

mysqli_query($conn,$query);





$abc="select state from state where state_id='".$State."'";
$runabc=mysqli_query($conn,$abc);
$fetch=mysqli_fetch_array($runabc);




//DVRIP DVRName DVR_Model_num DVR_Serial_num HDD Camera1 Camera2 Camera3 Remark Attachment1 Attachment2 liveDate


	
	$sql="update dvrsite set Status='$Status',Phase='$Phase',Customer='$Customer',Bank='$Bank',ATMID='$ATMID',ATMID_2='$ATMID_2',ATMID_3='$ATMID_3',ATMID_4='$ATMID_4',
          TrackerNo='$TrackerNo',ATMShortName='$ATMShortName',SiteAddress='$SiteAddress',City='$City',State='$fetch[0]',Zone='$Zone',CTSLocalBranch='$CTSLocalBranch',CTS_BM_Name='$CTS_BM_Name',CTS_BM_Number='$CTS_BM_Number',install_Status='$install_Status',UserName='$CTS_UserName',Password='$CTS_Password'  
		  , DVRIP='$DVRIP',DVRName='$DVRName',DVR_Model_num='$DVR_Model_num', DVR_Serial_num='$DVR_Serial_num',HDD ='$HDD',Camera1 ='$Camera1'
		   , Camera2 ='$Camera2',Camera3 ='$Camera3',site_remark  ='$Remark',liveDate ='$liveDate', editby='".$_SESSION['name']."',live='".$live."' where SN='$sn'";
		 
//echo	$sql;	 
//return;
  //  $result=mysqli_query($conn,$sql);
	
$result2=mysqli_query($conn,$sql);
$result1=mysqli_query($cn,$sql);
if(!$result1) {
	mysqli_query($conn,"update dvrsite set modify=2 where ATMID='".$ATMID."'");
}
$sqlaxis="update axissite set Status='$Status',Phase='$Phase',Customer='$Customer',Bank='$Bank',ATMID='$ATMID',ATMID_2='$ATMID_2',ATMID_3='$ATMID_3',ATMID_4='$ATMID_4',
          TrackerNo='$TrackerNo',ATMShortName='$ATMShortName',SiteAddress='$SiteAddress',City='$City',State='$fetch[0]',Zone='$Zone',CTSLocalBranch='$CTSLocalBranch',CTS_BM_Name='$CTS_BM_Name',CTS_BM_Number='$CTS_BM_Number',install_Status='$install_Status',UserName='$CTS_UserName',Password='$CTS_Password'  
		  , DVRIP='$DVRIP',DVRName='$DVRName',DVR_Model_num='$DVR_Model_num', DVR_Serial_num='$DVR_Serial_num',HDD ='$HDD',Camera1 ='$Camera1'
		   , Camera2 ='$Camera2',Camera3 ='$Camera3',site_remark  ='$Remark',liveDate ='$liveDate', editby='".$_SESSION['name']."' where SN='$sn'";
//$result3=mysqli_query($cont,$sqlaxis);

if($result2!=""){
	?>
<script>
          alert("Update successfully");
         window.open("view_sites.php", "_self");
        </script>
		<?php 
}
?>