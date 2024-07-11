<?php
include("config.php");
// include("db_connection.php");
// $newcn = OpenNewCon();


$dbhost = "192.168.100.23";
$dbuser = "esurv";
$dbpass = "Esurv123*";
$db = "esurv";
$newcn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);


$sn = $_REQUEST['sn'];

$sql = mysqli_query($conn,"select * from sites where SN='".$sn."'");
if(mysqli_num_rows($sql)>0){
	$_result = mysqli_fetch_assoc($sql);

	$Status = $_result['Status'];
	$Phase = $_result['Phase'];
	$Customer = $_result['Customer'];
	$Bank = $_result['Bank'];
	$ATMID = $_result['ATMID'];
	$ATMID_2 = $_result['ATMID_2'];
	$ATMID_3 = $_result['ATMID_3'];
	$ATMID_4 = $_result['ATMID_4'];
	$TrackerNo = $_result['TrackerNo'];
	$ATMShortName = $_result['ATMShortName'];
	$SiteAddress = $_result['SiteAddress'];
	$City = $_result['City'];
	$State = $_result['State'];
	$Zone = $_result['Zone'];
	$Panel_Make = $_result['Panel_Make'];
	$OldPanelID = $_result['OldPanelID'];
	$NewPanelID = $_result['NewPanelID'];
	$DVRIP = $_result['DVRIP'];
	$DVRName = $_result['DVRName'];
	$DVR_Model_num = $_result['DVR_Model_num'];
	
	$Router_Model_num = $_result['Router_Model_num'];
	$UserName = $_result['UserName'];
	$Password = $_result['Password'];
	$live = $_result['live'];
	$current_dt = $_result['current_dt'];
	if($current_dt==''){
		$current_dt = date('Y-m-d H:i:s');
	}
	$mailreceive_dt = $_result['mailreceive_dt'];
	if($mailreceive_dt==''){
		$mailreceive_dt = date('Y-m-d H:i:s');
	}
	$eng_name = $_result['eng_name'];
	$addedby = $_result['addedby'];
	$editby = $_result['editby'];
	$site_remark = $_result['site_remark'];
	$PanelIP = $_result['PanelIP'];
	$AlertType = $_result['AlertType'];
	$live_date = $_result['live_date'];
	if($live_date==''){
		$live_date = date('Y-m-d');
	}
	$CTS_LocalBranch = $_result['CTS_LocalBranch'];
	$RouterIp = $_result['RouterIp'];
	$last_modified = $_result['last_modified'];
	$partial_live = $_result['partial_live'];
		
	$transfersql = mysqli_query($newcn,"select * from sites where SN='".$sn."'");
	if(mysqli_num_rows($transfersql)>0){




		//		values('".$Status."','".$Phase."','".$Customer."','".$Bank."','".$TrackerNo."','".$ATMID."','".$ATMID_2."','".$ATMID_3."','".$ATMID_4."','".$ATMShortName."','".$SiteAddress."','".$City."','".$State."','".$Zone."','".$Panel_Make."','".$OldPanelID."','".$NewPanelID."','".$DVRIP."','".$DVRName."','".$UserName."','".$Password."','".$live."','".$curentdt."','".$instdt.$t."','".$engname."','".$username."','".$remark."','".$DVR_Model_num."','".$Router_Model_num."','".$PanelsIP."','".$RouterIp."','1')";
		
		
		$updatesql= " UPDATE `sites` SET `Status`='".$Status."',`Phase`='".$Phase."',`Customer`='".$Customer."',`Bank`='".$Bank."',`ATMID`='".$ATMID."',`ATMID_2`='".$ATMID_2."',`ATMID_3`='".$ATMID_3."',`ATMID_4`='".$ATMID_4."',`TrackerNo`='".$TrackerNo."',`ATMShortName`='".$ATMShortName."',
		`SiteAddress`='".$SiteAddress."',`City`='".$City."',`State`='".$State."',`Zone`='".$Zone."',`Panel_Make`='".$Panel_Make."',`OldPanelID`='".$OldPanelID."',`NewPanelID`='".$NewPanelID."',`DVRIP`='".$DVRIP."',`DVRName`='".$DVRName."',`DVR_Model_num`='".$DVR_Model_num."',`Router_Model_num`='".$Router_Model_num."',`UserName`='".$UserName."',`Password`='".$Password."',`live`='".$live."',`current_dt`='".$current_dt."',`mailreceive_dt`='".$mailreceive_dt."',`eng_name`='".$eng_name."',`addedby`='".$addedby."',`editby`='".$editby."',`site_remark`='".$site_remark."',`PanelIP`='".$PanelIP."',`AlertType`='".$AlertType."',`CTS_LocalBranch`='".$CTS_LocalBranch."',`RouterIp`='".$RouterIp."',`last_modified`='".$last_modified."',`partial_live`='".$partial_live."' where `SN`='".$sn."' ";
        
		if($Bank=='PNB'){
			$_transfer_site_circle_sql = mysqli_query($newcn,"select * from site_circle where ATMID='".$ATMID."'");
			if(mysqli_num_rows($_transfer_site_circle_sql)>0){
				$_transfer_site_circle_data = mysqli_fetch_assoc($_transfer_site_circle_sql);
				
				$_local_site_circle_sql = mysqli_query($conn,"select * from site_circle where ATMID='".$ATMID."'");
				if(mysqli_num_rows($_local_site_circle_sql)>0){
				    $_local_site_circle_data = mysqli_fetch_assoc($_local_site_circle_sql);
					$_site_type = $_local_site_circle_data['site_type'];
					$_zonal = $_local_site_circle_data['Zonal'];
					$_circle = $_local_site_circle_data['Circle'];
					$update_site_circle_sql="update site_circle SET site_type='".$_site_type."',Zonal='".$_zonal."',Circle='".$_circle."' where ATMID='".$ATMID."'";
                    $updatesite_circle_result=mysqli_query($newcn,$update_site_circle_sql);
				}
				
			}else{
				$_local_site_circle_sql = mysqli_query($conn,"select * from site_circle where ATMID='".$ATMID."'");
				if(mysqli_num_rows($_local_site_circle_sql)>0){
				    $_local_site_circle_data = mysqli_fetch_assoc($_local_site_circle_sql);
					$_site_type = $_local_site_circle_data['site_type'];
					$_zonal = $_local_site_circle_data['Zonal'];
					$_circle = $_local_site_circle_data['Circle'];
					$insert_site_circle_sql="insert into site_circle(ATMID,site_type,Bank,Zonal,Circle)
                                             values('".$ATMID."','".$_site_type."','".$Bank."','".$_zonal."','".$_circle."')";
                    $insertsite_circle_result=mysqli_query($newcn,$insert_site_circle_sql);
				}
			}
		}
		
	                 
       $updateresult=mysqli_query($newcn,$updatesql);
	   if($updateresult){
	     $data=['Code'=> 202];
	   }else{
		  $data=['Code'=> 203]; 
	   }
	}
	
	else{
		$insertsql="insert into sites(SN,Status,Phase,Customer,Bank,ATMID,ATMID_2,ATMID_3,ATMID_4,TrackerNo,ATMShortName,SiteAddress,City,State,Zone,Panel_Make,OldPanelID,NewPanelID,DVRIP,DVRName,DVR_Model_num,Router_Model_num,UserName,Password,live,current_dt,mailreceive_dt,eng_name,addedby,editby,site_remark,PanelIP,AlertType,live_date,CTS_LocalBranch,RouterIp,last_modified,partial_live)
        values('".$sn."','".$Status."','".$Phase."','".$Customer."','".$Bank."','".$ATMID."','".$ATMID_2."','".$ATMID_3."','".$ATMID_4."','".$TrackerNo."','".$ATMShortName."','".$SiteAddress."','".$City."','".$State."','".$Zone."','".$Panel_Make."','".$OldPanelID."','".$NewPanelID."','".$DVRIP."','".$DVRName."','".$DVR_Model_num."','".$Router_Model_num."','".$UserName."','".$Password."','".$live."','".$current_dt."','".$mailreceive_dt."','".$eng_name."','".$addedby."','".$editby."','".$site_remark."','".$PanelIP."','".$AlertType."','".$live_date."','".$CTS_LocalBranch."','".$RouterIp."','".$last_modified."','".$partial_live."')";
$insertresult=mysqli_query($newcn,$insertsql);

        
		 if($Bank=='PNB'){
			$_transfer_site_circle_sql = mysqli_query($newcn,"select * from site_circle where ATMID='".$ATMID."'");
			if(mysqli_num_rows($_transfer_site_circle_sql)>0){
				$_local_site_circle_sql = mysqli_query($conn,"select * from site_circle where ATMID='".$ATMID."'");
				if(mysqli_num_rows($_local_site_circle_sql)>0){
				    $_local_site_circle_data = mysqli_fetch_assoc($_local_site_circle_sql);
					$_site_type = $_local_site_circle_data['site_type'];
					$_zonal = $_local_site_circle_data['Zonal'];
					$_circle = $_local_site_circle_data['Circle'];
					$update_site_circle_sql="update site_circle SET site_type='".$_site_type."',Zonal='".$_zonal."',Circle='".$_circle."' where ATMID='".$ATMID."'";
                    $updatesite_circle_result=mysqli_query($newcn,$update_site_circle_sql);
				}
			}else{
				$_local_site_circle_sql = mysqli_query($conn,"select * from site_circle where ATMID='".$ATMID."'");
				if(mysqli_num_rows($_local_site_circle_sql)>0){
				    $_local_site_circle_data = mysqli_fetch_assoc($_local_site_circle_sql);
					$_site_type = $_local_site_circle_data['site_type'];
					$_zonal = $_local_site_circle_data['Zonal'];
					$_circle = $_local_site_circle_data['Circle'];
					$insert_site_circle_sql="insert into site_circle(ATMID,site_type,Bank,Zonal,Circle)
                                             values('".$ATMID."','".$_site_type."','".$Bank."','".$_zonal."','".$_circle."')";
                    $insertsite_circle_result=mysqli_query($newcn,$insert_site_circle_sql);
				}
			}
		} 

        if($insertresult){
		 $data=['Code'=> 200];
		}else{
		  $data=['Code'=> 201,'query'=>$insertsql,'error'=>mysqli_error($newcn)];	
		}
	}
}else{
  $data=['Code'=> 205];
}

    echo json_encode($data);

?>