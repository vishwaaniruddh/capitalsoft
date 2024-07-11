<?php include ('../header.php'); ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


<div class="page-content">

    <form id="forms" action="e_process.php" method="POST" class="form1" enctype="multipart/form-data"
        onsubmit="return finalval()" autocomplete="off">

        <div class="row hed" id="hd_AddSite">
            <div class="col-md-12">
                <h6 class="mb-0 text-uppercase">Add RMS Site</h6>
                <hr />
            </div>
        </div>
        <div class="row hed" id="hd_DVR" style="display:none">
            <div class="col-md-12">
            <h6 class="mb-0 text-uppercase">Add DVR Site</h6>
                <hr />    
            </div>
        </div>
        <div class="row hed" id="hd_Cloud" style="display:none">
            <div class="col-md-12">
                <center>
                    <h2>ADD ONLINE DVR SITE</h2>
                </center>
            </div>
        </div>
        <div class="row div1">

            <div class="col-md-4">
                <label>Project</label>
            </div>
            <div class="col-md-8">
                <select class="form-control form-control-sm mb-3" name="project" id="project"
                    onchange="ChangeSitesForm()">
                    <option value=""> Select </option>

                    <?php
                    $runQproj = mysqli_query($conn, "select * from projectsites");
                    while ($Qprojfetch = mysqli_fetch_array($runQproj)) {
                        ?>
                        <option value="<?php echo $Qprojfetch['id']; ?>"><?php echo $Qprojfetch['Name']; ?></option>

                    <?php } ?>

                </select>

            </div>
        </div>
        <div id="resultsection"></div>
        <script>
            $(document).ready(function () {
                $('#project').trigger("change");

            })

            $(document).on('change', '#project', function () {
                $("#resultsection").html('');
                let project = $("#project").val();
                if (project == 1 || project == 10) {
                    let a = `
 <div id="AddSite"> 
   

<div class="row div1">
     
    <div  class="col-md-4"><label>Actual Installation Date</label></div>
     <div  class="col-md-8"> <input class="form-control form-control-sm mb-3" type="date" name="installationDate" id="installationDate" value="<?php echo date('Y-m-d'); ?>" /></div>
      
</div>


<div class="row div1">
    
    <div  class="col-md-4"><label> mail receive  Date</label></div>
     <div  class="col-md-8"> <input class="form-control form-control-sm mb-3" type="date" name="AddSite_date" id="AddSite_date" /></div>
      
</div>

<div class="row div1 ">
     
    <div  class="col-md-4"><label>Status</label></div>
     <div  class="col-md-8"><select class="form-control form-control-sm mb-3" name="AddSite_Status" id="AddSite_Status" >
     <option value="E-Surveillance - CapitalSoft">E-Surveillance - CapitalSoft </option></select></div>
      
</div>


<div class="row div1">
     
    <div  class="col-md-4"><label>Phase</label></div>
     <div  class="col-md-8">   <select class="form-control form-control-sm mb-3" name="AddSite_Phase" id="AddSite_Phase" >
     <option>Phase 1</option>
     <option>Phase 2</option>
     <option>Phase 3</option>
     <option>Phase 4</option>
     <option>Phase 5</option>
     <option>Phase 6</option>
     <option>Phase 7</option>
     <option>Phase 8</option>
     <option>Phase 9</option>
     <option>Phase 10</option></select></div>
      
</div>

<div class="row div1">
     
    <div  class="col-md-4"><label>Customer</label></div>
     <div  class="col-md-8"> <select class="form-control form-control-sm mb-3" name="AddSite_Customer" id="AddSite_Customer" >
     <option value="">Select</option>
    <?php
    $cust = "select name from customer where status=1";
    $runcust = mysqli_query($conn, $cust);
    while ($rowcust = mysqli_fetch_array($runcust)) { ?>
            <option value="<?php echo $rowcust['name']; ?>"><?php echo $rowcust['name']; ?></option>
                       <br/>
      <?php } ?>
   
</select></div>
      
</div>


<div class="row div1">
     
    <div  class="col-md-4"><label>Bank</label></div>
     <div  class="col-md-8"> <select class="form-control form-control-sm mb-3" name="AddSite_Bank" id="AddSite_Bank" >
     <option value="">Select</option>
    <?php
    $bank = "select name from bank";

    $runbank = mysqli_query($conn, $bank);
    while ($rowbank = mysqli_fetch_array($runbank)) { ?>
            <option value="<?php echo $rowbank['name']; ?>"><?php echo $rowbank['name']; ?></option>
                       <br/>
      <?php } ?>
   
</select>
     </div>
      
</div>

<div class="row div1">
     
    <div  class="col-md-4"><label>ATM ID</label></div>
     <div  class="col-md-8"> <input class="form-control form-control-sm mb-3" type="text" name="AddSite_ATMID" id="AddSite_ATMID" onblur="checkpanel()"/></div>
      
</div>

<div class="row div1">
     
    <div  class="col-md-4"><label>ATMID_2</label></div>
     <div  class="col-md-8">  <input class="form-control form-control-sm mb-3" type="text" name="AddSite_ATMID_2" id="AddSite_ATMID_2" value="-"/></div>
      
</div>

<div class="row div1">
    
    <div  class="col-md-4"><label>ATMID_3</label></div>
     <div  class="col-md-8"> <input class="form-control form-control-sm mb-3" type="text" name="AddSite_ATMID_3" id="AddSite_ATMID_3" value="-" /></div>
      
</div>

<div class="row div1">
    
    <div  class="col-md-4"><label>ATMID_4</label></div>
     <div  class="col-md-8">  <input class="form-control form-control-sm mb-3" type="text" name="AddSite_ATMID_4" id="AddSite_ATMID_4" value="-" /></div>
    
</div>

<div class="row div1">
     
    <div  class="col-md-4"><label>Tracker No</label></div>
     <div  class="col-md-8"> <input class="form-control form-control-sm mb-3" type="text" name="AddSite_TrackerNo" id="AddSite_TrackerNo" value="-"/></div>
      
</div>


<div class="row div1">
    
    <div  class="col-md-4"><label>ATMShort Name</label></div>
     <div  class="col-md-8"> <input class="form-control form-control-sm mb-3" type="text" name="AddSite_ATMShortName" id="AddSite_ATMShortName" value="-"/></div>
     
</div>

<div class="row div1">
    
    <div  class="col-md-4"><label>Site Address</label></div>
     <div  class="col-md-8"> <input class="form-control form-control-sm mb-3" type="text" name="AddSite_SiteAddress" id="AddSite_SiteAddress" /></div>
    
</div>

<div class="row div1">
    
    <div  class="col-md-4"><label>State</label></div>
     <div  class="col-md-8"> 
     <select class="form-control form-control-sm mb-3" name="AddSite_State" id="AddSite_State" onchange="states('AddSite_')" >
     <option value="">Select</option>
    <?php
    $qry = "select state_id,state from state";

    $result = mysqli_query($conn, $qry);
    while ($row = mysqli_fetch_array($result)) { ?>
            <option value="<?php echo $row['state_id']; ?>"><?php echo $row['state']; ?></option>
                       <br/>
      <?php } ?>
   
</select></div>
    
</div>

<div class="row div1">
    
    <div  class="col-md-4"><label>City</label></div>
     <div  class="col-md-8"> <select class="form-control form-control-sm mb-3" name="AddSite_City" id="AddSite_City" >
     <option value="">Select</option></select>
</div>

    
    
</div>



<div class="row div1">
    
    <div  class="col-md-4"><label>Zone</label></div>
     <div  class="col-md-8"> <select class="form-control form-control-sm mb-3"  name="AddSite_Zone" id="AddSite_Zone" >
     <option value="">Select</option>
     <option value="West">West</option>
     <option value="East">East</option>
     <option value="South">South</option>
     <option value="North">North</option></div>
     <div  class="col-md-2"></select></div>
</div>



<div class="row div1">
    
    <div  class="col-md-4"><label>CTS Local Branch</label></div>
     <div  class="col-md-8"> <select class="form-control form-control-sm mb-3"  name="AddSite_CtsLocalBranch" id="AddSite_CtsLocalBranch" >
     <option value="">Select</option>
   
   <?php
   $CTSQ = mysqli_query($conn, "SELECT * FROM `cts_branch`");
   while ($fetchCTS = mysqli_fetch_assoc($CTSQ)) {

       ?>
   
             <option value="<?php $fetchCTS['branch']; ?>">
                <?php echo $fetchCTS['branch']; ?>
                </option>
   <?php } ?>
   
    </select></div>
</div>



<div class="row div1">
     
    <div  class="col-md-4"><label>Panel Make</label></div>
     <div  class="col-md-8"> <select class="form-control form-control-sm mb-3" name="AddSite_Panel_Make" id="AddSite_Panel_Make" >
     <option value="">Select</option>
    <?php
    $panel = "select distinct(Panel_Make) from sites";

    $runpanel = mysqli_query($conn, $panel);
    while ($rowpanel = mysqli_fetch_array($runpanel)) { ?>
            <option value="<?php echo $rowpanel['Panel_Make']; ?>"><?php echo $rowpanel['Panel_Make']; ?></option>
                       <br/>
      <?php } ?>
   
</select>
     </div>
    
</div>

<div class="row div1">
    
    <div  class="col-md-4"><label>Old Panel ID</label></div>
     <div  class="col-md-8"><input class="form-control form-control-sm mb-3" type="text" name="AddSite_OldPanelID" id="AddSite_OldPanelID" value="-"/></div>
    
</div>

<?php
$max = "select max(SN) from sites  ";
$runmax = mysqli_query($conn, $max);
$maxfetch = mysqli_fetch_array($runmax);

$max2 = "select NewPanelID  from sites where SN='" . $maxfetch[0] . "'";
$runmax2 = mysqli_query($conn, $max2);
$maxfetch2 = mysqli_fetch_array($runmax2);
$np = $maxfetch2[0] += 1;
?>
<div class="row div1">
   
    <div  class="col-md-4"><label>New Panel ID</label></div>
     <div  class="col-md-8"> <input class="form-control form-control-sm mb-3" type="text" name="AddSite_NewPanelID" id="AddSite_NewPanelID" value="<?php echo "0" . $np ?>" readonly /></div>
     
</div>



<div class="row div1">
 
    <div  class="col-md-4"><label>Router IP</label></div>
     <div  class="col-md-8"> <input class="form-control form-control-sm mb-3" type="text" name="AddSite_RouterIP" id="AddSite_RouterIP" /></div>
 
</div>

<div class="row div1">
 
    <div  class="col-md-4"><label>DVR IP</label></div>
     <div  class="col-md-8"> <input class="form-control form-control-sm mb-3" type="text" name="AddSite_DVRIP[]" id="AddSite_DVRIP" onblur="checkip('AddSite_')"/></div>
 
</div>




<div class="row div1">
 
    <div  class="col-md-4"><label>Panels IP</label></div>
     <div  class="col-md-8"> <input class="form-control form-control-sm mb-3" type="text" name="AddSite_PanelsIP" id="AddSite_PanelsIP" onblur="checkPanIP('AddSite_')" /></div>
 
</div>






<div class="row div1">
    
    <div  class="col-md-4"><label>DVR Name</label></div>
     <div  class="col-md-8"><select class="form-control form-control-sm mb-3" name="AddSite_DVRName[]" id="AddSite_DVRName" >
     <option value="">Select</option>
    <?php
    $dvr = "select name from dvr_name where status=1";

    $rundvr = mysqli_query($conn, $dvr);
    while ($rowdvr = mysqli_fetch_array($rundvr)) { ?>
            <option value="<?php echo $rowdvr['name']; ?>"><?php echo $rowdvr['name']; ?></option>
                       <br/>
      <?php } ?>
   
</select>
     </div>
     
</div>

<div class="row div1">
    
    <div  class="col-md-4"><label>DVR Model Number</label></div>
     <div  class="col-md-8"><input class="form-control form-control-sm mb-3" type="text" name="AddSite_DVR_Model_num" id="AddSite_DVR_Model_num" ></div>
     
</div>

<div class="row div1">
    
    <div  class="col-md-4"><label>Router Model Number</label></div>
     <div  class="col-md-8"><input class="form-control form-control-sm mb-3" type="text" name="AddSite_Router_Model_num" id="AddSite_Router_Model_num" ></div>
     
</div>


<div class="row div1">
    
    <div  class="col-md-4"><label>UserName</label></div>
     <div  class="col-md-8"><input class="form-control form-control-sm mb-3" type="text" name="AddSite_UserName[]" id="AddSite_UserName" value="admin" readonly></div>
     
</div>

<div class="row div1">
     
    <div  class="col-md-4"><label>Password</label></div>
     <div  class="col-md-8"><input class="form-control form-control-sm mb-3" type="text" name="AddSite_Password[]" maxlength=10 id="AddSite_Password" /></div>
      
</div>


<div id="bankcondition" class="row div1"></div>
<style type="text/css">
    #bankcondition input, #bankcondition select {
        width: 100%;
    }
</style>


<div class="row div1 ">
     
    <div class="col-md-4"><label>Engineer Name</label></div>
     <div class="col-md-8">
     <input class="form-control form-control-sm mb-3" type="text" name="AddSite_engname" required />
</div>
      
</div>


<div class="row div1">
     
    <div  class="col-md-4"><label>GSM Number</label></div>
     <div  class="col-md-8"><input class="form-control form-control-sm mb-3" type="text" name="AddSite_GSM" id="AddSite_GSM" onkeypress="return isNumberKey(event)" maxlength="10" required></div>
      
</div>

<div class="row div1">
     
    <div  class="col-md-4"><label>Remark</label></div>
     <div  class="col-md-8"><textarea class="form-control form-control-sm mb-3" rows="4" cols="25" id="AddSite_Remark" name="AddSite_Remark" required></textarea></div>
      
</div>

<div class="row div1">
     
    <div  class="col-md-4" id="up1"><label>Choosefile</label></div>
     <div  class="col-md-8"><input class="form-control form-control-sm mb-3" type="file" name="AddSite_email_cpy" id="AddSite_email_cpy" /></div>
      

</div>




     </div>   
     <div class="row div1 ">
     
    <div class="col-md-4"><label>Router Brand</label></div>
     <div class="col-md-8">
       <select class="form-control form-control-sm mb-3" name="router_brand" id="router_brand"  required>
          <option value="">Select </option>
          <option value="Gigatek">Gigatek </option>
          <option value="Credo">Credo</option>
          <option value="Techroute 3G">Techroute 3G </option>
          <option value="Techroute 4G">Techroute 4G </option>
          <option value="Techroute 4G">Maipu </option>
      </select></div>
      
</div>

<div class="row div1">
     
    <div class="col-md-4"><label>Router ID</label></div>
     <div class="col-md-8"> <input class="form-control form-control-sm mb-3" type="text" name="router_id" id="router_id" required></div>
      
</div>

<div class="row div1">
     
    <div class="col-md-4"><label>SIM Number</label></div>
     <div class="col-md-8"> <input class="form-control form-control-sm mb-3" type="text" name="sim_number" id="sim_number" required></div>
      
</div>


<div class="row div1 ">
     
    <div class="col-md-4"><label>SIM Owner</label></div>
     <div class="col-md-8">
       <select class="form-control form-control-sm mb-3" name="sim_owner" id="sim_owner"  required>
          <option value="">Select </option>
          <option value="CapitalSofts">CapitalSofts </option>
          <option value="IFIBER">IFIBER</option>
      </select></div>
      
</div>
            `;

                    $("#resultsection").html(a);
                } else if (project == 2) {
                    let a = `
<div id="AddDVR">



<div class="row div1">
     
    <div  class="col-md-4"><label>Actual Installation Date</label></div>
     <div  class="col-md-8"> <input class="form-control form-control-sm mb-3" type="date" name="installationDate" id="installationDate" value="<?php echo date('Y-m-d'); ?>" /></div>
      
</div>


<div class="row div1">
    
    <div  class="col-md-4"><label> mail receive  Date</label></div>
     <div  class="col-md-8"> <input class="form-control form-control-sm mb-3" type="date" name="AddDVR_date" id="AddDVR_date" /></div>
      
</div>

<div class="row div1 ">
      
      <div  class="col-md-4"><label>Status</label></div>
      <div  class="col-md-8">  <select class="form-control form-control-sm mb-3" name="AddDVR_Status" id="AddDVR_Status" >
      <option value="E-Surveillance - CapitalSofts">E-Surveillance - DVR</option></select></div>
      
</div>


<div class="row div1">
     
    <div  class="col-md-4"><label>Phase</label></div>
     <div  class="col-md-8">   <select class="form-control form-control-sm mb-3" name="AddDVR_Phase" id="AddDVR_Phase" >
     <option>Phase 1</option>
     <option>Phase 2</option>
     <option>Phase 3</option>
     <option>Phase 4</option>
     <option>Phase 5</option>
     <option>Phase 6</option>
     <option>Phase 7</option>
     <option>Phase 8</option>
     <option>Phase 9</option>
     <option>Phase 10</option></select></div>
      
</div>

<div class="row div1">
     
    <div  class="col-md-4"><label>Customer</label></div>
     <div  class="col-md-8"> <select class="form-control form-control-sm mb-3" name="AddDVR_Customer" id="AddDVR_Customer" >
     <option value="">Select</option>
    <?php
    $cust = "select name from customer where status=1";

    $runcust = mysqli_query($conn, $cust);
    while ($rowcust = mysqli_fetch_array($runcust)) { ?>
            <option value="<?php echo $rowcust['name']; ?>"><?php echo $rowcust['name']; ?></option>
                       <br/>
      <?php } ?>
   
</select></div>
      
</div>


<div class="row div1">
     
    <div  class="col-md-4"><label>Bank</label></div>
     <div  class="col-md-8"> <select class="form-control form-control-sm mb-3" name="AddDVR_Bank" id="AddDVR_Bank" style="width:180px;">
     <option value="">Select</option>
    <?php
    $bank = "select name from bank";

    $runbank = mysqli_query($conn, $bank);
    while ($rowbank = mysqli_fetch_array($runbank)) { ?>
            <option value="<?php echo $rowbank['name']; ?>"><?php echo $rowbank['name']; ?></option>
                       <br/>
      <?php } ?>
   
</select>
     </div>
      
</div>

<div class="row div1">
     
    <div  class="col-md-4"><label>ATM ID</label></div>
     <div  class="col-md-8"> <input class="form-control form-control-sm mb-3" type="text" name="AddDVR_ATMID" id="AddDVR_ATMID" onkeyup="checkpanel('AddDVR_')"/></div>
      
</div>

<div class="row div1">
     
    <div  class="col-md-4"><label>ATMID_2</label></div>
     <div  class="col-md-8">  <input class="form-control form-control-sm mb-3" type="text" name="AddDVR_ATMID_2" id="AddDVR_ATMID_2" value="-"/></div>
      
</div>

<div class="row div1">
    
    <div  class="col-md-4"><label>ATMID_3</label></div>
     <div  class="col-md-8"> <input class="form-control form-control-sm mb-3" type="text" name="AddDVR_ATMID_3" id="AddDVR_ATMID_3" value="-" /></div>
      
</div>

<div class="row div1">
    
    <div  class="col-md-4"><label>ATMID_4</label></div>
     <div  class="col-md-8">  <input class="form-control form-control-sm mb-3" type="text" name="AddDVR_ATMID_4" id="AddDVR_ATMID_4" value="-" /></div>
    
</div>

<div class="row div1">
     
    <div  class="col-md-4"><label>OLD ATMID</label></div>
     <div  class="col-md-8"> <input class="form-control form-control-sm mb-3" type="text" name="old_atmid" id="old_atmid" /></div>
      
</div>

<div class="row div1">
     
    <div  class="col-md-4"><label>Tracker No</label></div>
     <div  class="col-md-8"> <input class="form-control form-control-sm mb-3" type="text" name="AddDVR_TrackerNo" id="AddDVR_TrackerNo" value="-"/></div>
      
</div>


<div class="row div1">
    
    <div  class="col-md-4"><label>ATMShort Name</label></div>
     <div  class="col-md-8"> <input class="form-control form-control-sm mb-3" type="text" name="AddDVR_ATMShortName" id="AddDVR_ATMShortName" value="-"/></div>
     
</div>

<div class="row div1">
    
    <div  class="col-md-4"><label>Site Address</label></div>
     <div  class="col-md-8"> <input class="form-control form-control-sm mb-3" type="text" name="AddDVR_SiteAddress" id="AddDVR_SiteAddress" /></div>
    
</div>

<div class="row div1">
    
    <div  class="col-md-4"><label>State</label></div>
     <div  class="col-md-8"> <select class="form-control form-control-sm mb-3" name="AddDVR_State" id="AddDVR_State" onchange="states('AddDVR_')" >
     <option value="">Select</option>
    <?php
    $qry = "select state_id,state from state";

    $result = mysqli_query($conn, $qry);
    while ($row = mysqli_fetch_array($result)) { ?>
            <option value="<?php echo $row['state_id']; ?>"><?php echo $row['state']; ?></option>
                       <br/>
      <?php } ?>
   
</select></div>
    
</div>

<div class="row div1">
    
    <div  class="col-md-4"><label>City</label></div>
     <div  class="col-md-8"> <select class="form-control form-control-sm mb-3" name="AddDVR_City" id="AddDVR_City" >
     <option value="">Select</option>
   
</select></div>

    
    
</div>



<div class="row div1">
    
    <div  class="col-md-4"><label>Zone</label></div>
     <div  class="col-md-4"> 
   <select class="form-control form-control-sm mb-3"  name="AddDVR_Zone" id="AddDVR_Zone" >
     <option value="">Select</option>
     <option value="West">West</option>
     <option value="East">East</option>
     <option value="South">South</option>
     <option value="North">North</option>
   </select>
   </div>
     
</div>


<?php
$max = "select max(SN) from sites";
$runmax = mysqli_query($conn, $max);
$maxfetch = mysqli_fetch_array($runmax);

$max2 = "select NewPanelID  from sites where SN='" . $maxfetch[0] . "'";
$runmax2 = mysqli_query($conn, $max2);
$maxfetch2 = mysqli_fetch_array($runmax2);
$np = $maxfetch2[0] += 1;
?>



<div class="row div1">
    
    <div  class="col-md-4"><label>CTS Local Branch</label></div>
     <div  class="col-md-8"><input class="form-control form-control-sm mb-3" type="text" name="AddDVR_LocalBranch" id="AddDVR_LocalBranch" ></div>
     
</div>


<div class="row div1">
    
    <div  class="col-md-4"><label>CTS BM Name</label></div>
     <div  class="col-md-8"><input class="form-control form-control-sm mb-3" type="text" name="AddDVR_BM_Name" id="AddDVR_BM_Name" ></div>
     
</div>


<div class="row div1">
    
    <div  class="col-md-4"><label>CTS BM Number</label></div>
     <div  class="col-md-8"><input class="form-control form-control-sm mb-3" type="text" name="AddDVR_BM_Number" id="AddDVR_BM_Number" ></div>
     
</div>


<div class="row div1">
    
    <div  class="col-md-4"><lable>Instalation Status</lable></div>
     <div  class="col-md-4"> 
   <select class="form-control form-control-sm mb-3"  name="AddDVR_install_Status" id="AddDVR_install_Status" >
     <option value="">Select</option>
     <option value="WIP">WIP</option>
     <option value="Provission">Provission</option>
     <option value="TecLive">TecLive</option>
   </select></div>
     
</div>



<div class="row div1" style="display:none">
    
    <div  class="col-md-4"><lable>User Name</lable></div>
     <div  class="col-md-8"><input class="form-control form-control-sm mb-3" type="text" name="AddDVR_UserName" id="AddDVR_UserName" ></div>
     
</div>


<div class="row div1"  style="display:none">
    
    <div  class="col-md-4"><lable>Password</lable></div>
     <div  class="col-md-8"><input class="form-control form-control-sm mb-3" type="Password" name="AddDVR_Password" id="AddDVR_Password" ></div>
     
</div>


<div class="row div1 ">
     
    <div class="col-md-4"><label>Engineer Name</label></div>
     <div class="col-md-8">
     <input class="form-control form-control-sm mb-3" type="text" name="Cloud_engineerName" required />
</div>
      
</div>




<div class="row div1 ">
     
    <div class="col-md-4"><label>Live Snapshots</label></div>
     <div class="col-md-4">
<input class="form-control form-control-sm mb-3" name="Cloud_livesnapshots[]" type="file" multiple/>
</div>
      
</div>


  



</div>
<div class="row div1 ">
     
    <div class="col-md-4"><label>Router Brand</label></div>
     <div class="col-md-8">
       <select class="form-control form-control-sm mb-3" name="router_brand" id="router_brand"  required>
          <option value="">Select </option>
          <option value="Gigatek">Gigatek </option>
          <option value="Credo">Credo</option>
          <option value="Techroute 3G">Techroute 3G </option>
          <option value="Techroute 4G">Techroute 4G </option>
          <option value="Techroute 4G">Maipu </option>
      </select></div>
      
</div>

<div class="row div1">
     
    <div class="col-md-4"><label>Router ID</label></div>
     <div class="col-md-8"> <input class="form-control form-control-sm mb-3" type="text" name="router_id" id="router_id" required></div>
      
</div>

<div class="row div1">
     
    <div class="col-md-4"><label>SIM Number</label></div>
     <div class="col-md-8"> <input class="form-control form-control-sm mb-3" type="text" name="sim_number" id="sim_number" required></div>
      
</div>


<div class="row div1 ">
     
    <div class="col-md-4"><label>SIM Owner</label></div>
     <div class="col-md-8">
       <select class="form-control form-control-sm mb-3" name="sim_owner" id="sim_owner"  required>
          <option value="">Select </option>
          <option value="CapitalSofts">CapitalSofts </option>
          <option value="IFIBER">IFIBER</option>
      </select></div>
      
</div>
            `;
                    $("#resultsection").html(a);
                } else if (project == 3) {
                    let a = `
            
<div id="Cloud">
  

<div class="row div1">
     
    <div  class="col-md-4"><label>Actual Installation Date</label></div>
     <div  class="col-md-8"> <input class="form-control form-control-sm mb-3" type="date" name="installationDate" id="installationDate" value="<?php echo date('Y-m-d'); ?>" /></div>
      
</div>

<div class="row div1">
     
    <div  class="col-md-4"><label>ATM ID</label></div>
     <div  class="col-md-8"> <input class="form-control form-control-sm mb-3" type="text" name="Cloud_ATMID" id="Cloud_ATMID" onkeyup="checkpanel()"/></div>
      
</div>


<div class="row div1">
     
    <div  class="col-md-4"><label>ATMID2</label></div>
     <div  class="col-md-8"> <input class="form-control form-control-sm mb-3" type="text" name="Cloud_ATMID2" id="Cloud_ATMID2" onkeyup="checkpanel()"/></div>
      
</div>

<div class="row div1">
     
    <div  class="col-md-4"><label>OLD ATMID</label></div>
     <div  class="col-md-8"> <input class="form-control form-control-sm mb-3" type="text" name="Cloud_OldATM" id="Cloud_ATMID2" onkeyup="checkpanel()"/></div>
      
</div>


<div class="row div1">
     
    <div  class="col-md-4"><label>Bank</label></div>
     <div  class="col-md-8"> <select class="form-control form-control-sm mb-3" name="Bank" id="Bank" >
     <option value="">Select</option>
    <?php
    $bank = "select name from bank";

    $runbank = mysqli_query($conn, $bank);
    while ($rowbank = mysqli_fetch_array($runbank)) { ?>
            <option value="<?php echo $rowbank['name']; ?>"><?php echo $rowbank['name']; ?></option>
                       <br/>
      <?php } ?>
   
</select>
     </div>
      
</div>

<div class="row div1">
    
    <div  class="col-md-4"><label>Site Address</label></div>
     <div  class="col-md-8"> <input class="form-control form-control-sm mb-3" type="text" name="Cloud_SiteAddress" id="Cloud_SiteAddress" /></div>
    
</div>


<div class="row div1">
    
    <div  class="col-md-4"><label>Location</label></div>
     <div  class="col-md-8"> <input class="form-control form-control-sm mb-3" type="text" name="Cloud_Location" id="Cloud_Location" /></div>
    
</div>


<div class="row div1">
    
    <div  class="col-md-4"><label>State</label></div>
     <div  class="col-md-4"> 

     <select class="form-control form-control-sm mb-3" name="Cloud_State" id="Cloud_State" onchange="states('Cloud_')" >
     <option value="">Select</option>
    <?php
    $qry = "select state_id,state from state";
    $result = mysqli_query($conn, $qry);
    while ($row = mysqli_fetch_array($result)) { ?>
            <option value="<?php echo $row['state_id']; ?>"><?php echo $row['state']; ?></option>
                       <br/>
      <?php } ?>
   
</select></div>
    
</div>



<div class="row div1">
    
    <div  class="col-md-4"><label>City</label></div>
     <div  class="col-md-8"> <select class="form-control form-control-sm mb-3" name="Cloud_City" id="Cloud_City" >
     <option value="">Select</option></select>
</div>

    
    
</div>


<div class="row div1">
    
    <div  class="col-md-4"><label>Zone</label></div>
     <div  class="col-md-8"> <select class="form-control form-control-sm mb-3"  name="Cloud_Zone" id="Cloud_Zone" >
     <option value="">Select</option>
     <option value="West">West</option>
     <option value="East">East</option>
     <option value="South">South</option>
     <option value="North">North</option></div>
     <div  class="col-md-2"></select></div>
</div>





<div class="row div1">
    
    <div  class="col-md-4"><label>IPAddress</label></div>
     <div  class="col-md-8"> <input class="form-control form-control-sm mb-3" type="text" name="Cloud_DVRIP" id="Cloud_DVRIP" /></div>
    
</div>


<div class="row div1">
    
    <div  class="col-md-4"><label>RourtID</label></div>
     <div  class="col-md-8"> <input class="form-control form-control-sm mb-3" type="text" name="Cloud_RourtID" id="Cloud_RourtID" /></div>
    
</div>





<div class="row div1" >
    
    <div  class="col-md-4"><lable>User Name</lable></div>
     <div  class="col-md-8"><input class="form-control form-control-sm mb-3" type="text" name="Cloud_UserName" id="Cloud_UserName" ></div>
     
</div>


<div class="row div1"  >
    
    <div  class="col-md-4"><lable>Password</lable></div>
     <div  class="col-md-8"><input class="form-control form-control-sm mb-3" type="Password" name="Cloud_Password" id="Cloud_Password" ></div>
     
</div>

   

<div class="row div1 ">
     
    <div  class="col-md-4"><label>Status</label></div>
     <div  class="col-md-4"> 
   <select class="form-control form-control-sm mb-3"  name="Cloud_Status" id="Cloud_Status" >
     <option value="">Select</option>
     <option value="Y">Live</option>
     <option value="P">Pending</option>
     <option value="T">Testing</option>
     <option value="NO">Dismantle</option>

     </select>
   
   </div>
      
</div>





<div class="row div1 ">
     
    <div  class="col-md-4"><label>Date</label></div>
     <div  class="col-md-4"> 
     <input class="form-control form-control-sm mb-3" type="date" name="statusDate" value="<?php echo date('Y-m-d'); ?>"/>
   
   </div>
      
</div>





<div class="row div1"  >
    
    <div  class="col-md-4"><lable>dvrname</lable></div>
     <div  class="col-md-4">
    <select class="form-control form-control-sm mb-3"  name="Cloud_dvrname" id="Cloud_dvrname" >
     <option value="">Select</option>
     <option value="Hikvision">Hikvision</option>
     <option value="CPPLUS">CPPLUS</option>
     </select>
   </div>
     
</div>


<div class="row div1">
     
    <div  class="col-md-4"><label>Customer</label></div>
     <div  class="col-md-8"> <select class="form-control form-control-sm mb-3" name="Cloud_Customer" id="Cloud_Customer" >
     <option value="">Select</option>
    <?php
    $cust = "select name from customer where status=1";

    $runcust = mysqli_query($conn, $cust);
    while ($rowcust = mysqli_fetch_array($runcust)) { ?>
            <option value="<?php echo $rowcust['name']; ?>"><?php echo $rowcust['name']; ?></option>
                       <br/>
      <?php } ?>
   
</select></div>
      
</div>






</div>


<div class="row div1">
     
    <div  class="col-md-4"><label>Remark</label></div>
     <div  class="col-md-8"><textarea class="form-control form-control-sm mb-3" rows="4" cols="25" id="AddSite_Remark" name="AddSite_Remark" required></textarea></div>
      
</div>



<div class="row div1 ">
     
    <div class="col-md-4"><label>Router Brand</label></div>
     <div class="col-md-8">
       <select class="form-control form-control-sm mb-3" name="router_brand" id="router_brand"  required>
          <option value="">Select </option>
          <option value="Gigatek">Gigatek </option>
          <option value="Credo">Credo</option>
          <option value="Techroute 3G">Techroute 3G </option>
          <option value="Techroute 4G">Techroute 4G </option>
          <option value="Techroute 4G">Maipu </option>
      </select></div>
      
</div>

<div class="row div1">
     
    <div class="col-md-4"><label>Router ID</label></div>
     <div class="col-md-8"> <input class="form-control form-control-sm mb-3" type="text" name="router_id" id="router_id" required></div>
      
</div>

<div class="row div1">
     
    <div class="col-md-4"><label>SIM Number</label></div>
     <div class="col-md-8"> <input class="form-control form-control-sm mb-3" type="text" name="sim_number" id="sim_number" required></div>
      
</div>


<div class="row div1 ">
     
    <div class="col-md-4"><label>SIM Owner</label></div>
     <div class="col-md-8">
       <select class="form-control form-control-sm mb-3" name="sim_owner" id="sim_owner"  required>
          <option value="">Select </option>
          <option value="CapitalSofts">CapitalSofts </option>
          <option value="IFIBER">IFIBER</option>
      </select></div>
      
</div>



<div class="row div1 ">
     
    <div class="col-md-4"><label>Tracker No.</label></div>
     <div class="col-md-4">
<input class="form-control form-control-sm mb-3" name="Cloud_trackerno" type="text" />
</div>
      
</div>


<div class="row div1 ">
     
    <div class="col-md-4"><label>BM Name</label></div>
     <div class="col-md-4">
<input class="form-control form-control-sm mb-3" name="Cloud_bmname" type="text" />
</div>
      
</div>


<div class="row div1 ">
     
    <div class="col-md-4"><label>Engineer Name</label></div>
     <div class="col-md-8">
     <input class="form-control form-control-sm mb-3" type="text" name="Cloud_engineerName" required />
</div>
      
</div>




<div class="row div1 ">
     
    <div class="col-md-4"><label>Live Snapshots</label></div>
     <div class="col-md-4">
<input class="form-control form-control-sm mb-3" name="Cloud_livesnapshots[]" type="file" multiple/>
</div>
      
</div>





            `;
                    $("#resultsection").html(a);
                } else if (project == 4) {
                    let a = `
<div id="Cloud">
  

<div class="row div1">
     
    <div  class="col-md-4"><label>Actual Installation Date</label></div>
     <div  class="col-md-8"> <input class="form-control form-control-sm mb-3" type="date" name="installationDate" id="installationDate" value="<?php echo date('Y-m-d'); ?>" /></div>
      
</div>

<div class="row div1">
     
    <div  class="col-md-4"><label>ATM ID</label></div>
     <div  class="col-md-8"> <input class="form-control form-control-sm mb-3" type="text" name="Cloud_ATMID" id="Cloud_ATMID" onkeyup="checkpanel()"/></div>
      
</div>


<div class="row div1">
     
    <div  class="col-md-4"><label>ATMID2</label></div>
     <div  class="col-md-8"> <input class="form-control form-control-sm mb-3" type="text" name="Cloud_ATMID2" id="Cloud_ATMID2" onkeyup="checkpanel()"/></div>
      
</div>

<div class="row div1">
     
    <div  class="col-md-4"><label>OLD ATMID</label></div>
     <div  class="col-md-8"> <input class="form-control form-control-sm mb-3" type="text" name="Cloud_OldATM" id="Cloud_ATMID2" onkeyup="checkpanel()"/></div>
      
</div>


<div class="row div1">
     
    <div  class="col-md-4"><label>Bank</label></div>
     <div  class="col-md-8"> <select class="form-control form-control-sm mb-3" name="Bank" id="Bank" >
     <option value="">Select</option>
    <?php
    $bank = "select name from bank";

    $runbank = mysqli_query($conn, $bank);
    while ($rowbank = mysqli_fetch_array($runbank)) { ?>
            <option value="<?php echo $rowbank['name']; ?>"><?php echo $rowbank['name']; ?></option>
                       <br/>
      <?php } ?>
   
</select>
     </div>
      
</div>

<div class="row div1">
    
    <div  class="col-md-4"><label>Site Address</label></div>
     <div  class="col-md-8"> <input class="form-control form-control-sm mb-3" type="text" name="Cloud_SiteAddress" id="Cloud_SiteAddress" /></div>
    
</div>


<div class="row div1">
    
    <div  class="col-md-4"><label>Location</label></div>
     <div  class="col-md-8"> <input class="form-control form-control-sm mb-3" type="text" name="Cloud_Location" id="Cloud_Location" /></div>
    
</div>


<div class="row div1">
    
    <div  class="col-md-4"><label>State</label></div>
     <div  class="col-md-4"> 

     <select class="form-control form-control-sm mb-3" name="Cloud_State" id="Cloud_State" onchange="states('Cloud_')" >
     <option value="">Select</option>
    <?php
    $qry = "select state_id,state from state";
    $result = mysqli_query($conn, $qry);
    while ($row = mysqli_fetch_array($result)) { ?>
            <option value="<?php echo $row['state_id']; ?>"><?php echo $row['state']; ?></option>
                       <br/>
      <?php } ?>
   
</select></div>
    
</div>



<div class="row div1">
    
    <div  class="col-md-4"><label>City</label></div>
     <div  class="col-md-8"> <select class="form-control form-control-sm mb-3" name="Cloud_City" id="Cloud_City" >
     <option value="">Select</option></select>
</div>

    
    
</div>


<div class="row div1">
    
    <div  class="col-md-4"><label>Zone</label></div>
     <div  class="col-md-8"> <select class="form-control form-control-sm mb-3"  name="Cloud_Zone" id="Cloud_Zone" >
     <option value="">Select</option>
     <option value="West">West</option>
     <option value="East">East</option>
     <option value="South">South</option>
     <option value="North">North</option></div>
     <div  class="col-md-2"></select></div>
</div>





<div class="row div1">
    
    <div  class="col-md-4"><label>IPAddress</label></div>
     <div  class="col-md-8"> <input class="form-control form-control-sm mb-3" type="text" name="Cloud_DVRIP" id="Cloud_DVRIP" /></div>
    
</div>


<div class="row div1">
    
    <div  class="col-md-4"><label>RourtID</label></div>
     <div  class="col-md-8"> <input class="form-control form-control-sm mb-3" type="text" name="Cloud_RourtID" id="Cloud_RourtID" /></div>
    
</div>





<div class="row div1" >
    
    <div  class="col-md-4"><lable>User Name</lable></div>
     <div  class="col-md-8"><input class="form-control form-control-sm mb-3" type="text" name="Cloud_UserName" id="Cloud_UserName" ></div>
     
</div>


<div class="row div1"  >
    
    <div  class="col-md-4"><lable>Password</lable></div>
     <div  class="col-md-8"><input class="form-control form-control-sm mb-3" type="Password" name="Cloud_Password" id="Cloud_Password" ></div>
     
</div>

   

<div class="row div1 ">
     
    <div  class="col-md-4"><label>Status</label></div>
     <div  class="col-md-4"> 
   <select class="form-control form-control-sm mb-3"  name="Cloud_Status" id="Cloud_Status" >
     <option value="">Select</option>
     <option value="Y">Live</option>
     <option value="P">Pending</option>
     <option value="T">Testing</option>
     <option value="NO">Dismantle</option>

     </select>
   
   </div>
      
</div>
<div class="row div1 ">
     
    <div  class="col-md-4"><label>Date</label></div>
     <div  class="col-md-4"> 
     <input class="form-control form-control-sm mb-3" type="date" name="statusDate" value="<?php echo date('Y-m-d'); ?>"/>
   
   </div>
      
</div>
<div class="row div1"  >
    
    <div  class="col-md-4"><lable>Camera Name</lable></div>
     <div  class="col-md-4">
    <select class="form-control form-control-sm mb-3"  name="Cloud_dvrname" id="Cloud_dvrname" >
     <option value="">Select</option>
     <option value="Hikvision">Hikvision</option>
     <option value="CPPLUS">CPPLUS</option>
     </select>
   </div>
     
</div>


<div class="row div1">
     
    <div  class="col-md-4"><label>Customer</label></div>
     <div  class="col-md-8"> <select class="form-control form-control-sm mb-3" name="Cloud_Customer" id="Cloud_Customer" >
     <option value="">Select</option>
    <?php
    $cust = "select name from customer where status=1";

    $runcust = mysqli_query($conn, $cust);
    while ($rowcust = mysqli_fetch_array($runcust)) { ?>
            <option value="<?php echo $rowcust['name']; ?>"><?php echo $rowcust['name']; ?></option>
                       <br/>
      <?php } ?>
   
</select></div>
      
</div>






</div>


<div class="row div1">
     
    <div  class="col-md-4"><label>Remark</label></div>
     <div  class="col-md-8"><textarea class="form-control form-control-sm mb-3" rows="4" cols="25" id="AddSite_Remark" name="AddSite_Remark" required></textarea></div>
      
</div>



<div class="row div1 ">
     
    <div class="col-md-4"><label>Router Brand</label></div>
     <div class="col-md-8">
       <select class="form-control form-control-sm mb-3" name="router_brand" id="router_brand"  required>
          <option value="">Select </option>
          <option value="Gigatek">Gigatek </option>
          <option value="Credo">Credo</option>
          <option value="Techroute 3G">Techroute 3G </option>
          <option value="Techroute 4G">Techroute 4G </option>
          <option value="Techroute 4G">Maipu </option>
      </select></div>
      
</div>

<div class="row div1">
     
    <div class="col-md-4"><label>Router ID</label></div>
     <div class="col-md-8"> <input class="form-control form-control-sm mb-3" type="text" name="router_id" id="router_id" required></div>
      
</div>

<div class="row div1">
     
    <div class="col-md-4"><label>SIM Number</label></div>
     <div class="col-md-8"> <input class="form-control form-control-sm mb-3" type="text" name="sim_number" id="sim_number" required></div>
      
</div>


<div class="row div1 ">
     
    <div class="col-md-4"><label>SIM Owner</label></div>
     <div class="col-md-8">
       <select class="form-control form-control-sm mb-3" name="sim_owner" id="sim_owner"  required>
          <option value="">Select </option>
          <option value="CapitalSofts">CapitalSofts </option>
          <option value="IFIBER">IFIBER</option>
      </select></div>
      
</div>



<div class="row div1 ">
     
    <div class="col-md-4"><label>Tracker No.</label></div>
     <div class="col-md-4">
<input class="form-control form-control-sm mb-3" name="Cloud_trackerno" type="text" />
</div>
      
</div>


<div class="row div1 ">
     
    <div class="col-md-4"><label>BM Name</label></div>
     <div class="col-md-4">
<input class="form-control form-control-sm mb-3" name="Cloud_bmname" type="text" />
</div>
      
</div>


<div class="row div1 ">
     
    <div class="col-md-4"><label>Engineer Name</label></div>
     <div class="col-md-8">
     <input class="form-control form-control-sm mb-3" type="text" name="Cloud_engineerName" required />
</div>
      
</div>




<div class="row div1 ">
     
    <div class="col-md-4"><label>Live Snapshots</label></div>
     <div class="col-md-4">
<input class="form-control form-control-sm mb-3" name="Cloud_livesnapshots[]" type="file" multiple/>
</div>
      
</div>





            `;
                    $("#resultsection").html(a);
                }
            });
        </script>



        <div class="row" style="margin-top:30px;">
            <div class="col">
                <!-- <button type="button" class="btn btn-primary px-5 rounded-0">Primary</button> -->
                <input class="btn btn-primary px-5 rounded-0" type="submit" name="sub" value="submit" />
            </div>

        </div>





    </form>

</div>



<script>

    // $(document).ready(function () {

        function states() {

            var project = document.getElementById("project").value;
            if (project == "1" || project == "10") {
                var tag = "AddSite_";
            } else if (project == "2") {
                var tag = "AddDVR_";
            } else if (project == "3") {
                var tag = "Cloud_";
            }

            var State = document.getElementById(tag + "State").value;
            $.ajax({
                type: 'POST',
                url: '<?php echo BASE_URL; ?>ajaxComponents/state_id.php',
                data: 'State=' + State,
                datatype: 'json',
                success: function (msg) {
                    // alert(msg);
                    var jsr = JSON.parse(msg);
                    //alert(jsr.length);
                    var newoption = ' <option value="">Select</option>';
                    $('#' + tag + 'City').empty();
                    for (var i = 0; i < jsr.length; i++) {
                        //var newoption= '<option id='+ jsr[i]["ids"]+' value='+ jsr[i]["ids"]+'>'+jsr[i]["modelno"]+'</option> ';
                        newoption += '<option id="' + jsr[i]["ids"] + '" value="' + jsr[i]["stateid"] + '">' + jsr[i]["stateid"] + '</option> ';
                    }
                    console.log(newoption);
                    $('#' + tag + 'City').append(newoption);

                }
            })

        }


        var boolPnl = "";
        function checkPanIP() {
            var project = document.getElementById("project").value;
            if (project == "1" || project == "10") {
                var tag = "AddSite_";
            } else if (project == "2") {
                var tag = "AddSite_";
            } else if (project == "3") {
                var tag = "AddSite_";
            }

            var PanelsIP = document.getElementById(tag + "PanelsIP").value;
            $.ajax({

                type: 'POST',
                url: '<?php echo BASE_URL; ?>ajaxComponents/checkPanels_IP.php',
                data: 'PanelsIP=' + PanelsIP,
                async: false,
                success: function (msg) {
                    //alert(msg);
                    if (msg >= 1) {
                        alert("Panels IP already exist");
                        boolPnl = "0";
                    } else {
                        boolPnl = "1";
                    }
                }
            })

            if (boolPnl == 1) {
                //  alert("anans--"+boolemail)
                return true;
            } else {
                return false;
            }

        }
        var boolemail = "";
        function checkip() {
            //alert("hello");
            var project = document.getElementById("project").value;
            if (project == "1" || project == "10") {
                var tag = "AddSite_";
            } else if (project == "2") {
                var tag = "AddSite_";
            } else if (project == "3") {
                var tag = "AddSite_";
            }

            var dv_ip = document.getElementById(tag + "DVRIP").value;
            $.ajax({

                type: 'POST',
                url: '<?php echo BASE_URL; ?>ajaxComponents/check_ip.php',
                data: 'dv_ip=' + dv_ip,
                async: false,
                success: function (msg) {
                    //alert(msg);
                    if (msg >= 1) {
                        alert("DVR IP already exist");
                        boolemail = "0";
                    } else {
                        boolemail = "1";
                    }
                }
            })

            if (boolemail == 1) {
                return true;
            } else {
                return false;
            }
        }
        var bool = "";
        function checkpanel() {
            var project = document.getElementById("project").value;
            if (project == "1" || project == "10") {
                var tag = "AddSite_";
            } else if (project == "2") {
                var tag = "AddSite_";
            } else if (project == "3") {
                var tag = "AddSite_";
            }

            var NewPanelID = document.getElementById(tag + "NewPanelID").value;
            $.ajax({
                type: 'POST',
                url: '<?php echo BASE_URL; ?>ajaxComponents/check_panel.php',
                data: 'NewPanelID=' + NewPanelID,
                async: false,
                success: function (msg) {
                    //alert(msg);
                    if (msg >= 1) {
                        alert("NewPanel ID already exist");
                        bool = "0";
                    } else {
                        bool = "1";
                    }
                }
            })

            if (bool == 1) {
                return true;
            } else {
                return false;
            }
        }
        var boolatm = "";
        function checkAtm() {
            var project = document.getElementById("project").value;
            if (project == "1") {
                var tag = "AddSite_";
            } else if (project == "2") {
                var tag = "AddSite_";
            } else if (project == "3") {
                var tag = "AddSite_";
            }

            var NewATMID = document.getElementById(tag + "ATMID").value;
            $.ajax({

                type: 'POST',
                url: '<?php echo BASE_URL; ?>ajaxComponents/check_Atm.php',
                data: 'NewATMID=' + NewATMID,
                async: false,
                success: function (msg) {
                    //alert(msg);
                    if (msg >= 1) {
                        alert("Atm Id already exist");
                        boolatm = "0";
                    } else {
                        boolatm = "1";
                    }
                }
            })

            if (boolatm == 1) {
                //  alert("anans--"+boolemail)
                return true;
            } else {
                return false;
            }
        }
        function validation() {
            var a = confirm("are you sure want to submit ");
            if (a == 1) {
                alert("Site  added successfully");
                forms.submit();
            } else {
                alert("your form is not submited");
            }
        }
        function val() {
            var project = document.getElementById("project").value;
            if (project == "1" || project == "10") {
                var tag = "AddSite_";
                var Customer = document.getElementById(tag + "Customer").value;
                var Bank = document.getElementById(tag + "Bank").value;
                var ATMID = document.getElementById(tag + "ATMID").value;
                var Panel_Make = document.getElementById(tag + "Panel_Make").value;
                var OldPanelID = document.getElementById(tag + "OldPanelID").value;
                var Zone = document.getElementById(tag + "Zone").value;
                var DVRName = document.getElementById(tag + "DVRName").value;
                var DVR_Model_num = document.getElementById(tag + "DVR_Model_num").value;
                var Router_Model_num = document.getElementById(tag + "Router_Model_num").value;
                var DVRIP = document.getElementById(tag + "DVRIP").value;
                var Password = document.getElementById(tag + "Password").value;
                var State = document.getElementById(tag + "State").value;
                var City = document.getElementById(tag + "City").value;
                var engname = document.getElementById(tag + "engname").value;

                var router_brand = document.getElementById(tag + "router_brand").value;
                var router_id = document.getElementById(tag + "router_id").value;
                var sim_number = document.getElementById(tag + "sim_number").value;
                var sim_owner = document.getElementById(tag + "sim_owner").value;

                if (Customer == "") {
                    alert("Please select customer");
                    return false;
                } else if (Bank == "") {
                    alert("Please select Bank");
                    return false;
                } else if (ATMID == "") {
                    alert("please fill up atm id");
                    return false;
                } else if (Panel_Make == "") {
                    alert("please select Panel Make");
                    return false;
                } else if (OldPanelID == "") {
                    alert("please fill up Old Panel ID");
                    return false;
                } else if (Zone == "") {
                    alert("please Select Zone");
                    return false;
                } else if (DVRName == "") {
                    alert("please Select DVR Name");
                    return false;
                } else if (DVR_Model_num == "") {
                    alert("please fill up DVR Model Number");
                    return false;
                } else if (Router_Model_num == "") {
                    alert("please fill up Router Model Number");
                    return false;
                } else if (DVRIP == "") {
                    alert("please fill up DVR IP");
                    return false;
                } else if (Password == "") {
                    alert("please fill up Password");
                    return false;
                } else if (State == "") {
                    alert("please Select State");
                    return false;
                } else if (City == "") {
                    alert("please Select City");
                    return false;
                } else if (engname == "") {
                    alert("please fill up Engineer name");
                    return false;
                } else {
                    return true;
                }
            }
            //////////////////////////////////////////////////////////////// For Add DVR  validation//////////////////////////////////
            else if (project == "2") {
                var tag = "AddSite_";
                var Customer = document.getElementById("Customer").value;
                var Bank = document.getElementById("Bank").value;
                var ATMID = document.getElementById("ATMID").value;
                var CTSLocalBranch = document.getElementById("CTSLocalBranch").value;
                var CTS_BM_Name = document.getElementById("CTS_BM_Name").value;
                var CTS_BM_Number = document.getElementById("CTS_BM_Number").value;
                var install_Status = document.getElementById("install_Status").value;
                var Zone = document.getElementById("Zone").value;
                var Password = document.getElementById("Password").value;
                var State = document.getElementById("State").value;
                var City = document.getElementById("City").value;

                if (Customer == "") {
                    alert("Please select customer");
                    return false;
                } else if (Bank == "") {
                    alert("Please select Bank");
                    return false;
                } else if (ATMID == "") {
                    alert("please fill up atm id");
                    return false;
                } else if (Zone == "") {
                    alert("please Select Zone");
                    return false;
                } else if (State == "") {
                    alert("please Select State");
                    return false;
                } else if (City == "") {
                    alert("please Select City");
                    return false;
                } else if (CTSLocalBranch == "") {
                    alert("please fill up CTS Local Branch ");
                    return false;
                } else if (CTS_BM_Name == "") {
                    alert("please fill up CTS BM Name ");
                    return false;
                } else if (CTS_BM_Number == "") {
                    alert("please fill up CTS BM Number ");
                    return false;
                } else if (install_Status == "") {
                    alert("please select Installation Status ");
                    return false;
                } else {
                    return true;
                }

            }

            /////////////////////////////////////////////////// For Cloud validation
            else if (project == "3") {
                var tag = "cloud_";
                return true;
            }

        }

        function finalval() {
            var project = document.getElementById("project").value;

            if (project == "1") {
                if (checkAtm() && checkpanel() && checkPanIP() && checkip() && val() && validation()) {
                    return true;
                } else {
                    return false;
                }
            } else if (project == "2") {
                if (checkAtm() && val() && validation()) {
                    return true;
                } else {
                    return false;
                }

            } else if (project == "3") {
                if (checkAtm() && val() && validation()) {
                    return true;
                } else {
                    return false;
                }
            }


        }
        function ChangeSitesForm() {
            var project = document.getElementById("project").value;
            if (project == "1" || project == "10") {
                $("#AddSite").show();
                $("#AddDVR").hide();
                $("#Cloud").hide();

                $("#hd_AddSite").show();
                $("#hd_Cloud").hide();
                $("#hd_DVR").hide();


            } else if (project == "2") {
                $("#AddSite").hide();
                $("#AddDVR").show();
                $("#Cloud").hide();

                $("#hd_AddSite").hide();
                $("#hd_Cloud").hide();
                $("#hd_DVR").show();

            } else if (project == "3") {
                $("#AddSite").hide();
                $("#AddDVR").hide();
                $("#Cloud").show();

                $("#hd_AddSite").hide();
                $("#hd_Cloud").show();
                $("#hd_DVR").hide();
            }
        }
        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode != 46 && charCode > 31 &&
                (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }

</script>
<?php include ('../footer.php'); ?>