<?php
// delete_all_records.php
ob_start();
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

header('Content-Type: application/json');

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

$date = isset($_POST['date']) ? $_POST['date'] : '';

if (empty($date)) {
    echo json_encode(['success' => false, 'message' => 'Invalid date']);
    exit;
}

// Get all file paths
$stmt = $conn->prepare("SELECT file_name FROM daily_room_reports WHERE report_date = ?");
$stmt->bind_param("s", $date);
$stmt->execute();
$result = $stmt->get_result();

$files = [];
while ($row = $result->fetch_assoc()) {
    if ($row['file_name']) {
        $files[] = $row['file_name'];
    }
}
$stmt->close();

// Delete physical files
foreach ($files as $file) {
    $filePath = $_SERVER['DOCUMENT_ROOT'] . '/rajneesh2350/' . $file;
    if (file_exists($filePath)) {
        unlink($filePath);
    }
}

// Delete database records
$stmt = $conn->prepare("DELETE FROM daily_room_reports WHERE report_date = ?");
$stmt->bind_param("s", $date);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'All records deleted', 'count' => count($files)]);
} else {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
}

$stmt->close();
$conn->close();
?>