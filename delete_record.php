<?php
// delete_record.php
ob_start();
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

header('Content-Type: application/json');

// Authentication check
if (!isset($_SESSION['loggedin'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$servername = "localhost";
$username = "igipess_c41duigipess";
$password = "MyPassword26November1972";
$dbname = "igipess_r261172";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$fileName = isset($_POST['file_name']) ? $_POST['file_name'] : '';

if ($id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid record ID']);
    exit;
}

// First, get the file path to delete the actual file
$stmt = $conn->prepare("SELECT file_name FROM daily_room_reports WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();

// Delete the physical file if it exists
if ($row && $row['file_name']) {
    $filePath = $_SERVER['DOCUMENT_ROOT'] . '/rajneesh2350/' . $row['file_name'];
    if (file_exists($filePath)) {
        unlink($filePath);
    }
}

// Delete the database record
$stmt = $conn->prepare("DELETE FROM daily_room_reports WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Record deleted successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
}

$stmt->close();
$conn->close();
?>