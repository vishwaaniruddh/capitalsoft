<?php include('../config.php') ; 
require "../vendor/autoload.php";
use \Firebase\JWT\JWT;




$uname = $_REQUEST['username'];
$password = $_REQUEST['password'];



if($uname && $password){

    $sql = mysqli_query($con, "SELECT * FROM loginusers WHERE (uname = '$uname') AND pwd = '$password' AND user_status = 1");
    $result = mysqli_num_rows($sql);
    if($result>0){
        $sql_result = mysqli_fetch_assoc($sql);
        if($sql_result['user_status']==1){
                $_SESSION['auth']=1;
                $_SESSION['username']=$sql_result['name'];
                $_SESSION['designation']=$sql_result['designation'];
                $_SESSION['userid'] = $sql_result['id'];
                $_SESSION['level'] = $sql_result['level'];
                $_SESSION['uname'] = $sql_result['uname'];
                
                $_SESSION['branch'] = $sql_result['branch'];
                $_SESSION['zone'] = $sql_result['zone'];
                $_SESSION['cust_id'] = $sql_result['cust_id'];                
                $userid = $sql_result['id'];
                
                if($uname == 'admin@gmail.com'){
                    $_SESSION['access']=1 ;
                }
                
                
                
                
                
                $secret_key = "CapitalSoft";
        		$issuedat_claim = time(); // issued at
        		$notbefore_claim = $issuedat_claim + 10; //not before in seconds
        		$expire_claim = $issuedat_claim + 60; // expire time in seconds
        		
                $token = array(
                    "nbf" => $notbefore_claim,
                    "exp" => $expire_claim,
                    "data" => array(
                        "id" => $userid,
                        "fullname" => $fname,
                        "email" => $email,
                ));
                $jwt = JWT::encode($token, $secret_key,"HS256");
                $token_sql = "update loginusers set token='".$jwt."' , updated_at = '".$datetime."' where id='".$userid."'";
                    mysqli_query($con,$token_sql) ;                
                    
                
                $_SESSION['cftoken'] = $jwt ;
                $response['success'] = true;
                $response['redirect'] = 'index.php'; // Change this to your actual redirect URL

                

    header('Content-Type: application/json');
    echo json_encode($response);               
               
               }else{
                    $response['success'] = false;
                    $response['message'] = 'Invalid username or password';
                    $response['redirect'] = 'login.php'; // Change this to your actual redirect URL
                    header('Content-Type: application/json');
                    echo json_encode($response);
               } 
             }else{ 
                 $response['success'] = false;
                    $response['message'] = 'Invalid username or password';
                    $response['redirect'] = 'login.php'; // Change this to your actual redirect URL
                    header('Content-Type: application/json');
                    echo json_encode($response);
                 
             }
}
else{ 
    $response['success'] = false;
                    $response['message'] = 'Please provide both username and password';
                    $response['redirect'] = 'login.php'; // Change this to your actual redirect URL
                    header('Content-Type: application/json');
                    echo json_encode($response);
    }
