<?php include ('../header.php'); ?>



<script>
    
    function states() {
//alert("hello");

var State=document.getElementById("State").value;
//alert(productname);
$.ajax({
                    
                    type:'POST',
                    url:'../ajaxComponents/state_id.php',
                     data:'State='+State,
                     datatype:'json',
                    success:function(msg){
                        //alert(msg);
                       var jsr=JSON.parse(msg);
                       //alert(jsr.length);
                        var newoption=' <option value="">Select</option>' ;
                        $('#City').empty();
                        for(var i=0;i<jsr.length;i++)
                        {
                         
                       
                      //var newoption= '<option id='+ jsr[i]["ids"]+' value='+ jsr[i]["ids"]+'>'+jsr[i]["modelno"]+'</option> ';
		                   newoption+= '<option id='+ jsr[i]["ids"]+' value='+ jsr[i]["stateid"]+'>'+jsr[i]["stateid"]+'</option> ';
			
                        
                        }                       
                     $('#City').append(newoption);
 
                    }
                })
                
            }

  function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode != 46 && charCode > 31
              && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }

  function states1() {
var State=document.getElementById("State1").value;
$.ajax({
                    
                    type:'POST',
                    url:'../ajaxComponents/state_id.php',
                     data:'State='+State,
                     datatype:'json',
                    success:function(msg){
                        //alert(msg);
                       var jsr=JSON.parse(msg);
                       //alert(jsr.length);
                        var newoption=' <option value="">Select</option>' ;
                        $('#City1').empty();
                        for(var i=0;i<jsr.length;i++)
                        {
                         
                       
                      //var newoption= '<option id='+ jsr[i]["ids"]+' value='+ jsr[i]["ids"]+'>'+jsr[i]["modelno"]+'</option> ';
		                   newoption+= '<option id='+ jsr[i]["ids"]+' value='+ jsr[i]["stateid"]+'>'+jsr[i]["stateid"]+'</option> ';
			
                        
                        }                       
                     $('#City1').append(newoption);
 
                    }
                })
                
            }
     function validation(){
         var a=confirm("are you sure want to submit ");
         if(a==1){
            alert(" added successfully");
            forms.submit();
         }else{
             alert("your form is not submited");
         }
     }
      
     
      function val(){
      
	var name = document.getElementById("name").value;
	var lname = document.getElementById("lname").value;
	var Address = document.getElementById("Address").value;
	var mob1 = document.getElementById("mob1").value;
	var mob2 = document.getElementById("mob2").value;
	
	var Email = document.getElementById("Email").value;
	var emailFilter =  /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/ ;
	
	var pname = document.getElementById("pname").value;
	var plname = document.getElementById("plname").value;
	var pAddress = document.getElementById("pAddress").value;
	var pmob1 = document.getElementById("pmob1").value;
	var pmob2 = document.getElementById("pmob2").value;
	//alert("hii");
	if (name == "")
	{
		alert("Name can not be empty");
		return false;
	}
	else if (lname == "")
	{
		alert("Last Name can not be empty");
		return false;
	}
	
	else if ( Address == "")
	{
		alert(" Address can not to be empty");
		return false;
	}
	 else if ( Email == "")
	{
		alert(" please fill email id ");
		return false;
		
	}
	else if (!emailFilter.test(Email))
	{
		
		alert("invalid email ")
		return false;
	}
	 else if ( pname == "")
	{
		alert(" please fill up parent Name ");
		return false;
	}
	else if ( plname == "")
	{
		alert(" please fill up parent Last Name ");
		return false;
	}
	else if ( pAddress == "")
	{
		alert(" please fill up parent Address ");
		return false;
	}
	else if ( pmob1 == "")
	{
		alert(" please fill up parent mobile number ");
		return false;
	}
	else if ( pmob2 == "")
	{
		alert(" please fill up parent Alternate mobile number ");
		return false;
	}
	return true;
}

      
function finalval()
{
   
    if( val() && validation())
    {
       return true; 
       
    }
    else
    {
        
        return false; 
        
    }
    
   
}
  </script>
 
<div class="page-content">



    <form id="forms" action="./adduser_process.php" method="POST" class="form1" enctype="multipart/form-data"
        onsubmit="return finalval()">

        <div class="row hed">

            <div class="col-md-10">

            <h6 class="mb-0 text-uppercase">Personal Information</h6>
            <hr />    
            
            </div>

        </div>

        <div class="row div1">
            
            <div class="col-md-4">
                <label>Name</label>
            </div>
            <div class="col-md-8"><input class="form-control form-control-sm mb-3" type="text" name="name" id="name" /></div>
            
        </div>

        <div class="row div1 ">
            
            <div class="col-md-4">
                <label>Last Name</label>
            </div>
            <div class="col-md-8"><input class="form-control form-control-sm mb-3" type="text" name="lname" id="lname" /></div>
            
        </div>

        <div class="row div1 ">
            
            <div class="col-md-4">
                <label>Father name</label>
            </div>
            <div class="col-md-8"><input class="form-control form-control-sm mb-3" type="text" name="father" id="father" /></div>
            
        </div>
        <div class="row div1 ">
            
            <div class="col-md-4">
                <label>Mother Name</label>
            </div>
            <div class="col-md-8"><input class="form-control form-control-sm mb-3" type="text" name="Mother" id="Mother" /></div>
            
        </div>

        <div class="row div1">
            
            <div class="col-md-4">
                <label>Address</label>
            </div>
            <div class="col-md-8"><textarea class="form-control form-control-sm mb-3" rows="3" cols="20" id="Address" name="Address"></textarea></div>
            
        </div>

        <div class="row div1">
            
            <div class="col-md-4">
                <label>State</label>
            </div>
            <div class="col-md-8"><select class="form-control form-control-sm mb-3" name="State" id="State" onchange="states()"  />
                <option value="">Select</option>
                <?php
                $qry = "select state_id,state from state";

                $result = mysqli_query($conn, $qry);
                while ($row = mysqli_fetch_array($result)) { ?>
                    <option value="<?php echo $row['state_id']; ?>" /><?php echo $row['state']; ?></option>
                    <br />
                <?php } ?>

                </select>
            </div>
            
        </div>

        <div class="row div1">
            
            <div class="col-md-4">
                <label>City</label>
            </div>
            <div class="col-md-8"><select class="form-control form-control-sm mb-3" name="City" id="City"  />
                <option value="">Select</option>

                </select>
            </div>

            

        </div>

        <div class="row div1 ">
            
            <div class="col-md-4">
                <label>Pin Code</label>
            </div>
            <div class="col-md-8"><input class="form-control form-control-sm mb-3" type="text" name="pincode" id="pincode" maxlength="7"
                    onkeypress="return isNumberKey(event)" /></div>
            
        </div>

        <div class="row div1 ">
            
            <div class="col-md-4">
                <label>Mobile No</label>
            </div>
            <div class="col-md-8"><input class="form-control form-control-sm mb-3" type="text" name="mob1" id="mob1" maxlength="10"
                    onkeypress="return isNumberKey(event)" /></div>
            
        </div>

        <div class="row div1 ">
            
            <div class="col-md-4">
                <label>Alternate No</label>
            </div>
            <div class="col-md-8"><input class="form-control form-control-sm mb-3" type="text" name="mob2" id="mob2" maxlength="10"
                    onkeypress="return isNumberKey(event)" /></div>
            
        </div>

        <div class="row div1 ">
            
            <div class="col-md-4">
                <label>Email Id</label>
            </div>
            <div class="col-md-8"><input class="form-control form-control-sm mb-3" type="text" name="Email" id="Email" /></div>
            
        </div>

        <div class="row div1 ">
            
            <div class="col-md-4">
                <label>DOB</label>
            </div>
            <div class="col-md-8"><input class="form-control form-control-sm mb-3" type="date" name="dob" id="dob" /></div>
            
        </div>

        <div class="row div1 ">
            
            <div class="col-md-4">
                <label>Marital Status</label>
            </div>
            <div class="col-md-8"><select class="form-control form-control-sm mb-3" name="marriage" id="marriage"  />
                <option value="Unmarried">Unmarried</option>
                <option value="Married">Married</option></select>
            </div>
            
        </div>

        <div class="row div1 ">
            
            <div class="col-md-4">
                <label>Department</label>
            </div>
            <div class="col-md-8"><select class="form-control form-control-sm mb-3" name="Department" id="Department"  />
                <option value="E-Surveillance">E-Surveillance</option>
                <option value="Other">Other</option></select>
            </div>
            
        </div>

        <div class="row div1">
            
            <div class="col-md-4">
                <label>Employee Id</label>
            </div>
            <div class="col-md-8"><input class="form-control form-control-sm mb-3" type="text" name="Employeeid" id="Employeeid" /></div>
            
        </div>

        <div class="row div1">
            
            <div class="col-md-4">
                <label>Work Location</label>
            </div>
            <div class="col-md-8"><input class="form-control form-control-sm mb-3" type="text" name="Work" id="Work" /></div>
            
        </div>

        <div class="row div1">
            
            <div class="col-md-4">
                <label>Joining Date</label>
            </div>
            <div class="col-md-8"><input class="form-control form-control-sm mb-3" type="date" name="Joining" id="Joining" /></div>
            
        </div>


        <div class="row div1">
            
            <div class="col-md-4">
                <label>Attachment</label>
            </div>
            <div class="col-md-8"><input class="form-control form-control-sm mb-3" type="file" name="fileToUpload" id="fileToUpload" /></div>
            
        </div>

<p></p>
<p></p>
<p></p>
        <div class="row hed">
            <div class="col-md-10">
            <h6 class="mb-0 text-uppercase">Emergency Contact Information</h6>
            <hr />    

            </div>
        </div>

        <div class="row div1">
            
            <div class="col-md-4">
                <label> Parent name</label>
            </div>
            <div class="col-md-8"><input class="form-control form-control-sm mb-3" type="text" name="pname" id="pname" /></div>
            
        </div>

        <div class="row div1 ">
            
            <div class="col-md-4">
                <label>Parent Last Name</label>
            </div>
            <div class="col-md-8"><input class="form-control form-control-sm mb-3" type="text" name="plname" id="plname" /></div>
            
        </div>



        <div class="row div1">
            
            <div class="col-md-4">
                <label>Address</label>
            </div>
            <div class="col-md-8"><textarea class="form-control form-control-sm mb-3" rows="3" cols="20" id="pAddress" name="pAddress"></textarea></div>
            
        </div>

        <div class="row div1">
            
            <div class="col-md-4">
                <label>State</label>
            </div>
            <div class="col-md-8"><select class="form-control form-control-sm mb-3" name="State1" id="State1" onchange="states1()"  />
                <option value="">Select</option>
                <?php
                $qry1 = "select state_id,state from state";

                $result1 = mysqli_query($conn, $qry1);
                while ($row1 = mysqli_fetch_array($result1)) { ?>
                    <option value="<?php echo $row1['state_id']; ?>" /><?php echo $row1['state']; ?></option>
                    <br />
                <?php } ?>

                </select>
            </div>
            
        </div>

        <div class="row div1">
            
            <div class="col-md-4">
                <label>City</label>
            </div>
            <div class="col-md-8"><select class="form-control form-control-sm mb-3" name="City1" id="City1"  />
                <option value="">Select</option>

                </select>
            </div>

            

        </div>

        <div class="row div1 ">
            
            <div class="col-md-4">
                <label>Pin Code</label>
            </div>
            <div class="col-md-8"><input class="form-control form-control-sm mb-3" type="text" name="pincode2" id="pincode2" maxlength="7"
                    onkeypress="return isNumberKey(event)" /></div>
            
        </div>

        <div class="row div1 ">
            
            <div class="col-md-4">
                <label>Mobile No</label>
            </div>
            <div class="col-md-8"><input class="form-control form-control-sm mb-3" type="text" name="pmob1" id="pmob1" maxlength="10"
                    onkeypress="return isNumberKey(event)" /></div>
            
        </div>

        <div class="row div1 ">
            
            <div class="col-md-4">
                <label>Alternate No</label>
            </div>
            <div class="col-md-8"><input class="form-control form-control-sm mb-3" type="text" name="pmob2" id="pmob2" maxlength="10"
                    onkeypress="return isNumberKey(event)" /></div>
            
        </div>

        <div class="row div1 ">
            
            <div class="col-md-4">
                <label>Relationship</label>
            </div>
            <div class="col-md-8"><input class="form-control form-control-sm mb-3" type="text" name="Relationship" id="Relationship" /></div>
            
        </div>

        <div class="row" style="margin-top:30px;">
            <div class="col-md-3"></div>
            <div class="col-md-3">
                <input class="btn btn-primary btn-sm px-5 rounded-0" type="submit" name="submit" id="submit" value="Proceed to Permission" />
            </div>

            <div class="col-md-3"></div>
        </div>


    </form>

</div>
<?php include ('../footer.php'); ?>