<?php include ('../header.php'); ?>

<div class="page-content">

<?php
$project = $_REQUEST['project'];


$routebrand = $_REQUEST['router_brand'];
$router_id = $_REQUEST['router_id'];
$simnumber = $_REQUEST['sim_number'];
$simowner = $_REQUEST['sim_owner'];



if ($project == "1" || $project == "10") {

	if (isset($_REQUEST['port'])) {
		$port = $_REQUEST['port'];
	} else {
		$port = "";
	}
	$created_at = date('Y-m-d');
	$RouterIP = $_REQUEST['AddSite_RouterIP'];
	$CtsLocalBranch = $_REQUEST['AddSite_CtsLocalBranch'];
	$Status = $_REQUEST['AddSite_Status'];
	$Phase = $_REQUEST['AddSite_Phase'];
	$Customer = $_REQUEST['AddSite_Customer'];
	$DVRIP = $_REQUEST['AddSite_DVRIP'];
	$DVRName = $_REQUEST['AddSite_DVRName'];
	$UserName = $_REQUEST['AddSite_UserName'];
	$Password = $_REQUEST['AddSite_Password'];

	$ATMID = $_REQUEST['AddSite_ATMID'];
	$ATMID_2 = $_REQUEST['AddSite_ATMID_2'];
	$ATMID_3 = $_REQUEST['AddSite_ATMID_3'];
	$ATMID_4 = $_REQUEST['AddSite_ATMID_4'];
	$TrackerNo = $_REQUEST['AddSite_TrackerNo'];
	$ATMShortName = $_REQUEST['AddSite_ATMShortName'];
	$SiteAddress = $_REQUEST['AddSite_SiteAddress'];
	$City = $_REQUEST['AddSite_City'];
	$GSM = $_REQUEST['AddSite_GSM'];
	$State = $_REQUEST['AddSite_State'];
	$Zone = $_REQUEST['AddSite_Zone'];
	$Panel_Make = $_REQUEST['AddSite_Panel_Make'];
	$OldPanelID = $_REQUEST['AddSite_OldPanelID'];
	$NewPanelID = $_REQUEST['AddSite_NewPanelID'];
	$PanelsIP = $_REQUEST['AddSite_PanelsIP'];
	$DVR_Model_num = $_REQUEST['AddSite_DVR_Model_num'];
	$Router_Model_num = $_REQUEST['AddSite_Router_Model_num'];
	$engname = $_REQUEST['AddSite_engname'];

	$Bank = $_REQUEST['AddSite_Bank'];

	$installationDate = $_REQUEST['installationDate'];

	date_default_timezone_set('Asia/Kolkata');
	$curentdt = date("Y-m-d H:i:s");
	$t = date("H:i:s");

	$instdt = $_REQUEST['AddSite_date'];
	if ($instdt == "") {
		$instdt = date("Y-m-d");
	}
	$remark = $_REQUEST['AddSite_Remark'];

	$abc = "select state from state where state_id='" . $State . "'";
	$runabc = mysqli_query($conn, $abc);
	$fetch = mysqli_fetch_array($runabc);

	$newname = "";
	$image_name = '';
	$maxsize = '2140';
	//$_FILES['email_cpy']['name'];
	$size = ($_FILES['AddSite_email_cpy']['size'] / 1024);

	if ($_FILES['AddSite_email_cpy']['name'] != '') {
		//echo $size." *** ".$maxsize;
		if ($size > $maxsize) {
			echo "Your file size is " . $size . "File is too large to be uploaded. You can only upload " . $maxsize . " KB of data. Please go back and try again";
			$error++;
		} else {

			define("MAX_SIZE", "100");

			$fichier = $_FILES['AddSite_email_cpy']['name'];

			//echo $fichier;
			function getExtension1($str)
			{
				$i = strrpos($str, ".");
				if (!$i) {
					return "";
				}
				$l = strlen($str) - $i;
				$ext = substr($str, $i + 1, $l);
				return $ext;
			}

			//echo $fichier;

			if ($fichier) {
				//echo "hi" ;
				$filename = stripslashes($_FILES['AddSite_email_cpy']['name']);
				//echo $filename;
				//get the extension of the file in a lower case format
				$extension = getExtension1($filename);
				$extension = strtolower($extension);
				//echo $extension;
				$image_name = time() . '.' . $extension;
				//echo $image_name;
				$newname = "ram/" . $image_name;
				//echo $newname;	

				$copied = copy($_FILES['AddSite_email_cpy']['tmp_name'], $newname);


				if (!$copied) {
					echo "<h1>Copy unsuccessfull!</h1>";
					$error++;
				}
			}

			//echo $newname;
		}
	}

	//mysqli_query($conn,"LOCK TABLES Sites WRITE");


	//$chkAvailable= mysqli_query($conn,"select ATMID from Sites where ATMID='".$ATMID."' or NewPanelID='".$NewPanelID."' or PanelIP='".$PanelsIP."' or DVRIP='".$DVRIP."' and live Not IN ('N','Y') ");
// echo "select ATMID from Sites where ATMID='".$ATMID."' or NewPanelID='".$NewPanelID."' or PanelIP='".$PanelsIP."' or DVRIP='".$DVRIP[0]."'";

	echo "select ATMID from Sites where ATMID='" . $ATMID . "' or NewPanelID='" . $NewPanelID . "' or PanelIP='" . $PanelsIP . "' or DVRIP='" . $DVRIP[0] . "'";
	$chkAvailable = mysqli_query($conn, "select ATMID from Sites where ATMID='" . $ATMID . "' or NewPanelID='" . $NewPanelID . "' or PanelIP='" . $PanelsIP . "' or DVRIP='" . $DVRIP[0] . "'");
	$n = mysqli_num_rows($chkAvailable);


	if ($n > "0") {
		echo "<script>alert('Error : Duplicate Site ! ')</script>";
	} else {

		echo $sql = "insert into sites(Status,Phase,Customer,Bank,ATMID,ATMID_2,ATMID_3,ATMID_4,TrackerNo,ATMShortName,SiteAddress,City,State,Zone,Panel_Make,OldPanelID,NewPanelID,DVRIP,DVRName,UserName,Password,live,current_dt,mailreceive_dt,eng_name,addedby,site_remark,DVR_Model_num,Router_Model_num,PanelIP,CTS_LocalBranch,RouterIp,last_modified,installationDate)
values('$Status','$Phase','$Customer','$Bank','$ATMID','$ATMID_2','$ATMID_3','$ATMID_4','$TrackerNo','$ATMShortName','$SiteAddress','$City','" . $fetch[0] . "','$Zone','$Panel_Make','$OldPanelID','$NewPanelID','$DVRIP[0]','$DVRName[0]','$UserName[0]','$Password[0]','P','$curentdt','$instdt.$t','$engname','" . $_SESSION['name'] . "','$remark','$DVR_Model_num','$Router_Model_num','$PanelsIP','$CtsLocalBranch','$RouterIP',1,'" . $installationDate . "')";
		//echo $sql;
		$result2 = mysqli_query($conn, $sql);
		$last2 = mysqli_insert_id($conn);

		$site_details = "insert into sites_details(site_id, routebrand, router_id, simnumber, simowner, status, created_at,project) values('" . $last2 . "', '" . $routebrand . "', '" . $router_id . "', '" . $simnumber . "', '" . $simowner . "', '1', '" . $created_at . "','" . $project . "')";

		mysqli_query($conn, $site_details);


		if ($last2) {
			echo 'Success<br>';
			$sql_dvrhealth = "insert into `dvr_health`(ip,atmid,dvrtype,live) values('$DVRIP[0]','$ATMID','$DVRName[0]','P')";
			// echo "insert into `dvr_health`(ip,atmid,dvrtype,live) values('$DVRIP','$ATMID','$DVRName','P')<br>";
			mysqli_query($conn, $sql_dvrhealth);

			//	$sql_panelhealth="insert into `panel_health`(ip,atmid,panelName,panelid) values('$PanelsIP','$ATMID','$Panel_Make','$NewPanelID')";
//	echo "insert into `panel_health`(ip,atmid,panelName,panelid) values('$PanelsIP','$ATMID','$Panel_Make','$NewPanelID')<br>";
//	mysqli_query($conn,$sql_panelhealth);

			$sql2 = "insert into site_Attachment(site_id,mail_attachment) values('" . $last2 . "','" . $newname . "')";
			$result2 = mysqli_query($conn, $sql2);

			$sql3 = "insert into sites_log(Status,Phase,Customer,Bank,ATMID,ATMID_2,ATMID_3,ATMID_4,TrackerNo,ATMShortName,SiteAddress,City,State,Zone,Panel_Make,OldPanelID,NewPanelID,DVRIP,DVRName,UserName,Password,live,current_dt,mailreceive_dt,eng_name,addedby,site_remark,site_id)
values('$Status','$Phase','$Customer','$Bank','$ATMID','$ATMID_2','$ATMID_3','$ATMID_4','$TrackerNo','$ATMShortName','$SiteAddress','$City','" . $fetch[0] . "','$Zone','$Panel_Make','$OldPanelID','$NewPanelID','$DVRIP[0]','$DVRName[0]','$UserName[0]','$Password[0]','P','$curentdt','$instdt.$t','$engname','" . $_SESSION['name'] . "','$remark','" . $last2 . "')";
			$result3 = mysqli_query($conn, $sql3);

			$sql4 = "insert into esurvsites(ATM_ID,TwoWayNumber) values('" . $ATMID . "','" . $GSM . "')";
			$runsql4 = mysqli_query($conn, $sql4);
		}

		if ($last2) {

			?>
			<script>
				alert("registered successfully");
				window.open("./add_sites.php", "_self");
			</script>
		<?php }

	}

} else if ($project == "2") {

	$datetime = date('Y-m-d h:i:s');
	$userid = $_SESSION['id'];
	$Status = $_REQUEST['AddDVR_Status'];
	$Phase = $_REQUEST['AddDVR_Phase'];
	$Customer = $_REQUEST['AddDVR_Customer'];
	$Bank = $_REQUEST['AddDVR_Bank'];
	$ATMID = $_REQUEST['AddDVR_ATMID'];
	$ATMID_2 = $_REQUEST['AddDVR_ATMID_2'];
	$ATMID_3 = $_REQUEST['AddDVR_ATMID_3'];
	$ATMID_4 = $_REQUEST['AddDVR_ATMID_4'];
	$TrackerNo = $_REQUEST['AddDVR_TrackerNo'];
	$ATMShortName = $_REQUEST['AddDVR_ATMShortName'];
	$SiteAddress = $_REQUEST['AddDVR_SiteAddress'];
	$City = $_REQUEST['AddDVR_City'];
	$CTS_UserName = $_REQUEST['AddDVR_UserName'];
	$CTS_Password = $_REQUEST['AddDVR_Password'];
	$State = $_REQUEST['AddDVR_State'];
	$Zone = $_REQUEST['AddDVR_Zone'];
	$CTSLocalBranch = $_REQUEST['AddDVR_LocalBranch'];
	$CTS_BM_Name = $_REQUEST['AddDVR_BM_Name'];
	$CTS_BM_Number = $_REQUEST['AddDVR_BM_Number'];
	$install_Status = $_REQUEST['AddDVR_install_Status'];
	$Cloud_engineerName = $_REQUEST['Cloud_engineerName'];
	$Cloud_livesnapshots = $_REQUEST['Cloud_livesnapshots'];
	date_default_timezone_set('Asia/Kolkata');
	$curentdt = date("Y-m-d H:i:s");
	$t = date("H:i:s");


	$installationDate = $_POST['installationDate'];
	$old_atmid = $_REQUEST['old_atmid'];

	$instdt = $_REQUEST['AddDVR_date'];
	if ($instdt == "") {
		$instdt = date("Y-m-d");
	}


	$abc = "select state from state where state_id='" . $State . "'";
	$runabc = mysqli_query($conn, $abc);
	$fetch = mysqli_fetch_array($runabc);



	$chkAvailable = mysqli_query($conn, "select ATMID from dvrsite where ATMID='" . $ATMID . "' ");
	$n = mysqli_num_rows($chkAvailable);

	if ($n > "0") {
		echo "<script>alert('Error : Duplicate Site ! ')</script>";
	} else {


 		$sql = "insert into dvrsite(Status,Phase,Customer,Bank,ATMID,ATMID_2,ATMID_3,ATMID_4,TrackerNo,ATMShortName,SiteAddress,City,State,Zone,UserName,Password,live,current_dt,mailreceive_dt,addedby,site_remark,DVR_Model_num,DVR_Serial_num,HDD,Camera1,Camera2,Camera3,Attachment1,Attachment2,CTSLocalBranch,CTS_BM_Name,CTS_BM_Number,install_Status,last_modified,installationDate,old_atmid)
values('$Status','$Phase','$Customer','$Bank','$ATMID','$ATMID_2','$ATMID_3','$ATMID_4','$TrackerNo','$ATMShortName','$SiteAddress','$City','" . $fetch[0] . "','$Zone','" . $CTS_UserName . "','" . $CTS_Password . "','P','$curentdt','$instdt.$t','" . $_SESSION['name'] . "','','','','','','','','','','" . $CTSLocalBranch . "','" . $CTS_BM_Name . "','" . $CTS_BM_Number . "','" . $install_Status . "','$curentdt','$installationDate','$old_atmid')";


		//$sql="insert into sitesd(Status,Phase,Customer,Bank,ATMID,ATMID_2,ATMID_3,ATMID_4,TrackerNo,ATMShortName,SiteAddress,City,State,Zone,UserName,Password,live,current_dt,mailreceive_dt,addedby,site_remark,DVR_Model_num,DVR_Serial_num,HDD,Camera1,Camera2,Camera3,Attachment1,Attachment2,CTSLocalBranch,CTS_BM_Name,CTS_BM_Number,install_Status,Project_Id)
//values('$Status','$Phase','$Customer','$Bank','$ATMID','$ATMID_2','$ATMID_3','$ATMID_4','$TrackerNo','$ATMShortName','$SiteAddress','$City','".$fetch[0]."','$Zone','".$CTS_UserName."','".$CTS_Password."','P','$curentdt','$instdt.$t','".$_SESSION['name']."','','','','','','','','','','".$CTSLocalBranch."','".$CTS_BM_Name."','".$CTS_BM_Number."','".$install_Status."','$project')";
//$resultcpy=mysqli_query($cn,$sql);

// echo $sql ; 

		$result = mysqli_query($conn, $sql);

		$last = mysqli_insert_id($conn);

		$site_details = "insert into sites_details(site_id, routebrand, router_id, simnumber, simowner, status, created_at) values('" . $last . "', '" . $routebrand . "', '" . $router_id . "', '" . $simnumber . "', '" . $simowner . "', '1', '" . $created_at . "')";

		mysqli_query($conn, $site_details);


		$allfiles = array();

		if (!empty($_FILES['Cloud_livesnapshots']['name'][0])) {
			$destinationFolder = 'dvrdetails/';
			$totalFiles = count($_FILES['Cloud_livesnapshots']['name']);
			$allfiles = array();

			for ($i = 0; $i < $totalFiles; $i++) {
				$fileName = $_FILES['Cloud_livesnapshots']['name'][$i];
				$fileTmpPath = $_FILES['Cloud_livesnapshots']['tmp_name'][$i];

				if ($fileName !== '') {
					$newFileName = uniqid() . '_' . $fileName;

					$destinationFilePath = $destinationFolder . $newFileName;
					if (move_uploaded_file($fileTmpPath, $destinationFilePath)) {
						$allfiles[] = $destinationFilePath;
					}
				}
			}
		}

		$allfiles = json_encode($allfiles);
		$Cloud_livesnapshots = $allfiles;

		$details_sql = "insert into dvronline_details(dvrid,tracker,bmName,engineerName,snapshots,status,created_at,created_by,statusDate) values('" . $last . "','" . $TrackerNo . "','" . $CTS_BM_Name . "','" . $Cloud_engineerName . "','" . $Cloud_livesnapshots . "',1,'" . $datetime . "','" . $userid . "','" . $installationDate . "')";

		mysqli_query($conn, $details_sql);

		if ($last) {
			?>
				<script>
					alert("Added successfully");
					window.open("./add_sites.php", "_self");
				</script>
		<?php } else { ?>
				<script>
					alert("error");
				</script>
				</body>

				</html>
		<?php }
	} ?>

		<!--////////////////////////////////////////////////// DVR Form Code End //////////////////////////////////////////////-->



		<!--///////////////////////////////////////////////// DVR Online Form Code Start ////////////////////////////////////////////-->










<?php }


?>

</div>
<?php include ('../footer.php'); ?>



