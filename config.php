<?php session_start();
date_default_timezone_set('Asia/Kolkata');
error_reporting(0);

define('BASE_URL', 'http://192.168.0.27:8080/vertical/');


if ($_SERVER["HTTPS"] == "on") {
    // Get the current URL without the protocol
    $urlWithoutProtocol = preg_replace("/^https:/i", "http:", $_SERVER["REQUEST_URI"]);

    // Redirect to the same URL with HTTP instead of HTTPS
    header("Location: http://" . $_SERVER["HTTP_HOST"] . $urlWithoutProtocol);
    exit;
}


$base_url = "http://192.168.0.27:8080/vertical/";

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "esurv";

function connectToDatabase()
{
    global $host, $user, $pass, $dbname;

    $con = new mysqli($host, $user, $pass, $dbname);

    if ($con->connect_error) {
        die; // You might want to handle the connection error appropriately
    } else {
        return $con;
    }
}

function getConnectedDatabase()
{
    global $con;

    if (!$con || !$con->ping()) {
        $con = connectToDatabase();
    }

    return $con;
}

// Usage example:
$conn = $con = getConnectedDatabase();

$userid = $_SESSION['userid'];
$datetime = $created_at = date('Y-m-d H:i:s');
$date = date('Y-m-d');



function is_image($path)
{
    $a = getimagesize($path);
    $image_type = $a[2];

    if(in_array($image_type , array(IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG , IMAGETYPE_BMP)))
    {
        return true;
    }
    return false;
}





  function getsiminfo($atmid, $parameter)
  {
    global $conn;

    // echo "select $parameter from sites_siminfo where atmid='".$atmid."'";
    $sql = mysqli_query($conn, "select $parameter from sites_siminfo where atmid='" . $atmid . "'");
    $sql_result = mysqli_fetch_assoc($sql);
    return $sql_result[$parameter];
  }


  function get_livedatetime($atmid)
  {
    global $conn;
    $live_date = array();
    // echo "select live_date from sites_log where ATMID='".$atmid."'";
    $sql = mysqli_query($conn, "select live_date from sites where ATMID='" . $atmid . "'");
    if (mysqli_num_rows($sql) > 0) {
      while ($sql_result = mysqli_fetch_assoc($sql)) {
        $live_date[] = $sql_result['live_date'];
      }
    }
    return $live_date;
  }



  function get_sites_info($atmid, $parameter)
  {
    global $conn;
    $info = array();


    $sql = mysqli_query($conn, "select $parameter from sites_info where atmid='" . $atmid . "' order by id desc");
    if (mysqli_num_rows($sql) > 0) {
      while ($sql_result = mysqli_fetch_assoc($sql)) {
        $info[] = $sql_result[$parameter];
      }
    }
    return $info;
  }


  function convertDateTimeFormat($datetime, $outputFormat = "d/M/y H:i:s") {
    // Convert input datetime string to Unix timestamp
    $timestamp = strtotime($datetime);
    
    // Format the timestamp to the desired output format
    $newDate = date($outputFormat, $timestamp);
    
    return $newDate;
}