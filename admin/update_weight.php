<?php
include('../config.php');
if (!isset($_SESSION['userid'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

$submenuId = isset($_POST['submenu_id']) ? intval($_POST['submenu_id']) : 0;
$newWeight = isset($_POST['weight']) ? intval($_POST['weight']) : 0;

if ($submenuId <= 0 || $newWeight < 0) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
    exit;
}

$stmt = $con->prepare("UPDATE sub_menu SET weight = ? WHERE id = ?");
$stmt->bind_param('ii', $newWeight, $submenuId);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Weight updated successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update weight']);
}

$stmt->close();
?>
