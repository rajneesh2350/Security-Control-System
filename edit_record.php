<?php
ob_start();
session_start();
if (!isset($_SESSION['loggedin'])) {
    die(json_encode(['success' => false, 'message' => 'Unauthorized']));
}

include 'config.php';
header('Content-Type: application/json');

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$notes = isset($_POST['notes']) ? $_POST['notes'] : '';

if ($id > 0) {
    $stmt = $conn->prepare("UPDATE daily_room_reports SET notes = ? WHERE id = ?");
    $stmt->bind_param("si", $notes, $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid ID']);
}
$conn->close();
?>