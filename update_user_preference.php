<?php include ('./config.php'); // Include your database connection script

// Check if the user is logged in
if (!isset($_SESSION['userid'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

// Retrieve POST data
$userId = $_POST['userId'];
$preference = $_POST['preference'];
$mode = $_REQUEST['mode'];
if ($mode == 'theme') {
    $preference_type = 'theme_preference';
} else if ($mode == 'header') {
    $preference_type = 'header_preference';
} else if ($mode == 'sidebar') {
    $preference_type = 'sidebar_preference';
}



$userId = intval($userId);
$preference = htmlspecialchars($preference, ENT_QUOTES, 'UTF-8');

$sql = mysqli_query($con, "select * from user_preference where userid='" . $userId . "' and status=1");
if ($sql_result = mysqli_fetch_assoc($sql)) {

    // Update
    echo $query = "UPDATE user_preference SET $preference_type = '" . $preference . "' WHERE userid = '" . $userId . "'";


} else {
    // insert
    $query = "INSERT INTO user_preference(userid, $preference_type , status)
    VALUES('" . $userId . "','" . $preference . "',1);
    ";

}

echo $query ; 

if (mysqli_query($con, $query)) {
    echo json_encode(['status' => 'success', 'message' => 'Preference updated successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update preference']);
}
?>