<?php include ('../header.php'); ?>
<div class="page-content">
    <?php

    $name = $_POST['name'];
    $lname = $_POST['lname'];
    $father = $_POST['father'];
    $Mother = $_POST['Mother'];
    $Address = $_POST['Address'];
    $State = $_POST['State'];
    $City = $_POST['City'];
    $pincode = $_POST['pincode'];
    $mob1 = $_POST['mob1'];
    $mob2 = $_POST['mob2'];
    $Email = $_POST['Email'];
    $dob = $_POST['dob'];
    $marrage = $_POST['marriage'];
    $Department = $_POST['Department'];
    $Employeeid = $_POST['Employeeid'];
    $Work = $_POST['Work'];
    $Joining = $_POST['Joining'];

    $pname = $_POST['pname'];
    $plname = $_POST['plname'];
    $pAddress = $_POST['pAddress'];
    $State1 = $_POST['State1'];
    $City1 = $_POST['City1'];
    $pincode2 = $_POST['pincode2'];
    $pmob1 = $_POST['pmob1'];
    $Relationship = $_POST['Relationship'];
    $pmob2 = $_POST['pmob2'];

    date_default_timezone_set('Asia/Kolkata');
    $curentdt = date("Y-m-d H:i:s");

    $target_dir = "UploadAttachment/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

    if (isset($_POST["submit"])) {
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);

    }







    $sql = "insert into employee(name,lname,father,Mother,Address,State,City,pincode,mob1,mob2,Email,dob,marriage,Department,Employeeid,Work,Joining,parent_name,parent_lastname,parent_Address,patent_State,parent_City,parent_pincode,parent_mob1,parent_mob2,Relationship,addby,entry_date,attachment,img)
values('" . $name . "','" . $lname . "','" . $father . "','" . $Mother . "','" . $Address . "','" . $State . "','" . $City . "','" . $pincode . "','" . $mob1 . "','" . $mob2 . "','" . $Email . "','" . $dob . "','" . $marrage . "','" . $Department . "','" . $Employeeid . "','" . $Work . "','" . $Joining . "','" . $pname . "','" . $plname . "','" . $pAddress . "','" . $State1 . "','" . $City1 . "','" . $pincode2 . "','" . $pmob1 . "','" . $pmob2 . "','" . $Relationship . "','" . $_SESSION['id'] . "','" . $curentdt . "','" . $target_file . "','')";
    // echo $sql;
    $result = mysqli_query($conn, $sql);

    if ($result) {

        $empid = $conn->insert_id;

        ?>
        <script>
            alert("register successfully");
            // window.open("./adduser.php", "_self");
            function update() {
                var fn = document.getElementById("fn").value;
                var name = document.getElementById("name").value;
                var password = document.getElementById("password").value;
                $.ajax({
                    type: 'POST',
                    url: '',
                    data: 'fn=' + fn + '&name=' + name + '&password=' + password,
                    success: function (msg) {
                        alert(msg);
                            }
                })
            }
        </script>


<form name="myForm" action="./addusers_process.php" method="POST" class="form1">

           <input type="hidden" name="empid" value="<?php echo $empid; ?>">
            <div><input type="hidden" name="drop" id="drop" /></div>
            <div class="row hed">
                    <div class="col-md-12">
                    <h6 class="mb-0 text-uppercase">Update Password and Permission</h6>
                    <hr />
                </div>
            </div>

            <div class="row div1">
                <div class="col-md-4">
                    <leble>Name</leble>
                </div>
                <div class="col-md-8"><input type="text" class="form-control form-control-sm mb-3" value="<?php echo $_REQUEST['name'] . ' ' . $_REQUEST['lname'] ;?>" name="fn" id="fn" /></div>
                
            </div>
            <div class="row div1 ">
                <div class="col-md-4">
                    <leble>Email Id</leble>
                </div>
                <div class="col-md-8"><input type="text" class="form-control form-control-sm mb-3" value="<?php echo $_REQUEST['Email'];?>" name="name" id="name" /></div>                
            </div>

            <div class="row div1">
                <div class="col-md-4">
                    <leble>password</leble>
                </div>
                <div class="col-md-8"><input type="text" class="form-control form-control-sm mb-3" name="password" id="password" required /></div>
                
            </div>
            <div class="row div1">
                <div class="col-md-4">
                    <leble>designation</leble>
                </div>
                <div class="col-md-8">
                    <select name="degi" class="form-control form-control-sm mb-3" id="degi">
                        <option value="2">Monitoring</option>
                        <option value="0">Help desk</option>
                    </select>
                </div>
            </div>
            <div class="row div1">
                <div class="col-md-4">
                    <leble>Permission</leble>
                </div>
                <div class="col-md-8">
                            <select size="5"  class="form-control form-control-sm mb-3" name="lstStates" multiple="multiple" id="lstStates" onchange="per()">
                        <optgroup label="Site">
                        <optgroup label=" ">
                            <option value="1">Add Site</option>
                            <option value="2">View Site</option>
                            <option value="51">Edit Site</option>
                                    </optgroup>
                        </optgroup>
                                            <optgroup label="Users">
                        </optgroup>
                        <optgroup label="">
                            <option value="3">Add User</option>
                            <option value="22">View User</option>
                        </optgroup>

                        <optgroup label="Alert">
                        </optgroup>
                        <optgroup label="">
                            <option value="5">View Alert</option>
                            <option value="6">Last Communication</option>
                            <option value="7">Count call close by</option>
                            <option value="8">HZ /HL View</option>
                            <option value="9">Description Count</option>
                            <option value="10">call alert report</option>
                            <option value="12">View Alert Report</option>
                            <option value="11">Mains & UPS Fail</option>
                            <option value="13">view Graph</option>
                            <option value="14">QRT Excel upload</option>
                            <option value="15">Mail Count</option>
                            <option value="16">site visit</option>
                            <option value="17">view site test details</option>
                                    </optgroup>
                                                    </select>

    </div>
                
            </div>





            <div class="row" style="margin-top:30px;">
                <div class="col-md-3">
                    
                <input type="submit" class="btn btn-primary btn-sm px-5 rounded-0" name="sub" value="submit" />
                </div>

            </div>

        </form>






        <script src="https://rawgit.com/nobleclem/jQuery-MultiSelect/master/jquery.multiselect.js"></script>

        <script>

function per() {
        var obj = myForm.lstStates,
                    options = obj.options,
                    selected = [], i, str;
                        for (i = 0; i < options.length; i++) {
                    options[i].selected && selected.push(obj[i].value);
                }
                    str = selected.join();
                    // what should I write here??
                // alert("Options selected are " + str);
                    document.getElementById("drop").value = str;
            }

            $(function () {
                $('#lstStates').multiselect({
                    buttonText: function (options) {
                        if (options.length === 0) {
                            return 'No option selected ...';
                        }
                        var labels = [];
                        options.each(function () {
                            if ($(this).attr('value') !== undefined) {
                                labels.push($(this).attr('value'));
                            }
                        });
                        return labels.join(', ');
                    }
                });
            });
        </script>








<?php } ?>


</div>
<?php include ('../footer.php'); ?>