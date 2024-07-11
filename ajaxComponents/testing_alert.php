<?php
session_start();
if(isset($_SESSION['login_user']) && isset($_SESSION['id']))
{
?>
<html>

    <head>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


	
	
       
        <script>
        function TestComplete(atm){
			var testRemark=document.getElementById('testRemark').value;
			var engiName=document.getElementById('engiName').value;
			var last_id=document.getElementById('last_id').value;
			
			if(testRemark==""){
				alert("Please Enter Remark");
			}else if(engiName==""){
				alert("Please Enter EngiName");
			}
			else{
				
			$("#HD_test").prop("disabled", true);
			var getATMID=document.getElementById('ATMID').value;
			
			
			
			var testid=document.getElementsByName('testid[]');
			
			var a=[];
			for(var i=0;i<testid.length;i++){
				 if(testid[i].checked){ a.push(testid[i].value);}
         	}
			
			
			if(getATMID!=""){
			$.ajax({
				type:"POST",
				url:"TestingComplete.php",
				data:"atm="+atm+'&a='+a+'&testRemark='+testRemark+'&last_id='+last_id+'&engiName='+engiName,
				success:function(msg){
					//alert(msg)
					if(msg=="1"){
						alert("Site live successfully" );
						window.open("viewsite.php","_SELF");
					}else{alert("Error")}
					
				}
			})
			}else{alert("ATM Id should not blank")}
			}
		}
		
		
		
		
		
            function a(strPage,perpg){
             
               var ATMID=document.getElementById("ATMID").value;
              
               var DVRIP=document.getElementById("DVRIP").value;
              
        
            $('#loadingmessage').show();  // show the loading message.
          
         
         
             
             $.ajax({
               
            type:'POST',    
   url:'testing_alert_process.php',
   data:'ATMID='+ATMID+'&DVRIP='+DVRIP,

   success: function(msg){
  // alert(msg);
    $('#loadingmessage').hide(); // hide the loading message
   document.getElementById("show").innerHTML=msg;
   
   
} })
            }
        </script>
        
        
	
        
</head>
      &nbsp;&nbsp;&nbsp;
        <!--<body onload="a('','')" style="background-color: #dce079">-->
		<body style="background-color: #dce079">
		       <?php include 'menu.php';?>
<form id="formf" name="formf" method="post" action="css_View_alert_export.php" >

            <div>
			<center><h1 style="margin-top:70px; color:#fff;"  ><b> View Current 30 Alert</b></h1></center>
			
      <table border="1" style="margin-top:40px; width:90%; " align="center" >          
     
     
      
               
<tr style="background-color:#8cb77e">


<input type="hidden" id="last_id" value="<?php echo $_GET['lastid'];?>">
<td> ATM ID :<input type="text" name="ATMID" id="ATMID" readonly value="<?php if($_GET['atmid']!=""){echo $_GET['atmid'];}?>"></td>
<td> DVRIP:<input type="text" name="DVRIP" id="DVRIP" ></td>

        <td><input type="button" name="submit" onclick="a('','')"value="search"></button></td>
		
</tr>
</table>
            </div>
            	<!--============== code for loader (Start)===================-->

			<div id='loadingmessage' style='display:none;' >
                <img src='img/loading.gif' style="position:center;left:50%;margin-left:550px; "/>
            </div>
          <!--============== code for loader (End) =====================-->
            
            
            <div id="show"></div>
          <textarea rows="2" id="testRemark" name="testRemark" placeholder="Please Enter Remark" style="display: block;margin-left: auto;margin-right: auto;" cols="30"></textarea>

		  <input type="text" id="engiName" name="engiName" placeholder="EngiName" style="display: block;margin-left: auto;margin-right: auto;" required>
		  
			<input type="button" id="HD_test" value="Testing Complete" onclick="TestComplete('<?php echo $_GET['atmid'];?>')" style="margin:auto;display:block;text-align:center">

           </form>   


</div>

</div>
			
			  
        </body>
    
</html>

<?php
}else
{ 
 header("location: index.php");
}
?>




