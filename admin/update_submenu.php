<?php
include('../config.php'); // Include your database connection script

// Check if the user is logged in
if (!isset($_SESSION['userid'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

// Retrieve POST data
$submenuName = isset($_POST['submenu_name']) ? $_POST['submenu_name'] : '';
$submenuId = isset($_POST['submenu_id']) ? intval($_POST['submenu_id']) : 0;

// Validate and sanitize input
$submenuName = htmlspecialchars($submenuName, ENT_QUOTES, 'UTF-8');

// Prepare and execute SQL query securely
$stmt = $con->prepare("UPDATE sub_menu SET sub_menu = ? WHERE id = ?");
$stmt->bind_param('si', $submenuName, $submenuId);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Submenu name updated successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update submenu name']);
}

// Close the statement and connection
$stmt->close();
?>
