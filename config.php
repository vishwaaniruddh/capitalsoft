<?php session_start();
date_default_timezone_set('Asia/Kolkata');
error_reporting(0);

// define('BASE_URL', 'http://192.168.0.27:8080/vertical/');
define('BASE_URL', 'http://localhost/capitalsoft/');


if ($_SERVER["HTTPS"] == "on") {
  // Get the current URL without the protocol
  $urlWithoutProtocol = preg_replace("/^https:/i", "http:", $_SERVER["REQUEST_URI"]);

  // Redirect to the same URL with HTTP instead of HTTPS
  header("Location: http://" . $_SERVER["HTTP_HOST"] . $urlWithoutProtocol);
  exit;
}


$base_url = "http://192.168.0.27:8080/vertical/";
$base_url = "http://localhost/capitalsoft/";

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

  if (in_array($image_type, array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_BMP))) {
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


function convertDateTimeFormat($datetime, $outputFormat = "d/M/y H:i:s")
{
  // Convert input datetime string to Unix timestamp
  $timestamp = strtotime($datetime);

  // Format the timestamp to the desired output format
  $newDate = date($outputFormat, $timestamp);

  return $newDate;
}
function convertDateFormat($datetime, $outputFormat = "d-m-Y")
{
  // Convert input datetime string to Unix timestamp
  $timestamp = strtotime($datetime);

  // Format the timestamp to the desired output format
  $newDate = date($outputFormat, $timestamp);

  return $newDate;
}
function getPanelZoneStatus($panelip, $zone)
{
  global $con;
  $zone = ltrim($zone, '0');
  $zoneColumn = "zon$zone";

  // Check if the column exists in the panel_health table
  $columnExists = false;
  $result = mysqli_query($con, "SHOW COLUMNS FROM panel_health LIKE '$zoneColumn'");
  if (mysqli_num_rows($result) > 0) {
    $columnExists = true;
  }

  // If the column exists, proceed with the query
  if ($columnExists) {
    $sql = mysqli_query($con, "SELECT $zoneColumn FROM panel_health WHERE ip='$panelip'");
    if ($sql_result = mysqli_fetch_assoc($sql)) {
      return $sql_result[$zoneColumn];
    } else {
      return '';
    }
  } else {
    // Handle the case where the column does not exist
    return '';
  }
}

function getPanelZone($panelMake, $sensorType)
{
  global $con;
  $query = "SELECT ZONE FROM $panelMake WHERE SensorName like '%" . $sensorType . "%'";
  $result = mysqli_query($con, $query);

  if ($result && mysqli_num_rows($result) > 0) {
    $panelrow = mysqli_fetch_assoc($result);

    return $panelrow['ZONE'];
  } else {
    return 0;
  }

}

// Fetch User UI Preference
function getUserPreferences()
{
    global $con, $userid;

    // Prepare and execute the SQL query securely
    $stmt = $con->prepare("SELECT theme_preference, header_preference, sidebar_preference FROM user_preference WHERE userid = ?");
    $stmt->bind_param('i', $userid);
    $stmt->execute();
    $stmt->bind_result($theme_preference, $header_preference, $sidebar_preference);
    
    if ($stmt->fetch()) {
        // Determine the theme class based on the theme preference
        $theme_classes = [
            'darkmode' => 'dark-theme',
            'lightmode' => 'light-theme',
            'semidark' => 'semi-dark',
            'minimaltheme' => 'minimal-theme'
        ];
        
        $theme_class = isset($theme_classes[$theme_preference]) ? $theme_classes[$theme_preference] : 'default-theme';
        $theme = ['thememode' => $theme_preference, 'theme_class' => $theme_class];
        
        // Extract the last character of the header and sidebar preferences
        $header_number = substr($header_preference, -1);
        $sidebar_number = substr($sidebar_preference, -1);

        // Prepare the result data
        $header = ['headermode' => $header_preference, 'header_number' => $header_number];
        $sidebar = ['sidebarmode' => $sidebar_preference, 'sidebar_number' => $sidebar_number];
        $data = ['data' => ['theme' => $theme, 'header' => $header, 'sidebar' => $sidebar]];

        // Close the statement
        $stmt->close();

        return $data;
    }

    // Close the statement in case of no data
    $stmt->close();

    return null;
}

// Fetch user preferences
$getUserPreference = getUserPreferences();

if ($getUserPreference) {
    // Extract values
    $theme_mode = $getUserPreference['data']['theme']['thememode'];
    $theme_class = $getUserPreference['data']['theme']['theme_class'];
    $header_mode = $getUserPreference['data']['header']['headermode'];
    $header_number = $getUserPreference['data']['header']['header_number'];
    $sidebar_mode = $getUserPreference['data']['sidebar']['sidebarmode'];
    $sidebar_number = $getUserPreference['data']['sidebar']['sidebar_number'];
} else {
    // Set default values if no preferences found
    $theme_mode = 'lightmode'; // default value
    $theme_class = 'light-theme'; // default class
    $header_mode = '';
    $header_number = '';
    $sidebar_mode = '';
    $sidebar_number = '';
}
