<?php
// reports.php - PURE JSON OUTPUT ONLY
error_reporting(E_ALL);
ini_set('display_errors', 0); // Don't display errors, log them instead
ini_set('log_errors', 1);

// Clear any output buffers
while (ob_get_level()) ob_end_clean();

// Set JSON header
header('Content-Type: application/json');

$servername = "localhost";
$username = "igipess_c41duigipess";
$password = "MyPassword26November1972";
$dbname = "igipess_r261172";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['error' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

$action = isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : 'get_all_reports');

if ($action === 'get_all_reports') {
    $result = $conn->query("SELECT * FROM daily_room_reports ORDER BY report_date DESC, created_at DESC");

    if (!$result) {
        echo json_encode(['error' => 'Query failed: ' . $conn->error]);
        exit;
    }

    $reports = [];
    while ($row = $result->fetch_assoc()) {
        $row['original_size_formatted'] = formatBytes($row['original_size']);
        $row['compressed_size_formatted'] = formatBytes($row['compressed_size']);
        $reports[] = $row;
    }
    echo json_encode($reports);

} elseif ($action === 'get_by_date') {
    $date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
    $date = $conn->real_escape_string($date);

    $result = $conn->query("SELECT * FROM daily_room_reports WHERE report_date = '$date' ORDER BY created_at DESC");

    if (!$result) {
        echo json_encode(['error' => 'Query failed: ' . $conn->error]);
        exit;
    }

    $reports = [];
    while ($row = $result->fetch_assoc()) {
        $row['original_size_formatted'] = formatBytes($row['original_size']);
        $row['compressed_size_formatted'] = formatBytes($row['compressed_size']);
        $reports[] = $row;
    }
    echo json_encode($reports);

} elseif ($action === 'get_checklist') {
    $date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
    $date = $conn->real_escape_string($date);

    $result = $conn->query("SELECT n.id, n.floor, n.room_no, n.description,
                                   COALESCE(dc.status, 'pending') as status
                            FROM igpess_network n
                            LEFT JOIN daily_room_checklist dc ON n.id = dc.room_id AND dc.report_date = '$date'
                            ORDER BY n.floor, CAST(n.room_no AS UNSIGNED)");

    if (!$result) {
        echo json_encode(['error' => 'Query failed: ' . $conn->error]);
        exit;
    }

    $checklist = [];
    while ($row = $result->fetch_assoc()) {
        $checklist[] = $row;
    }
    echo json_encode($checklist);

} elseif ($action === 'update_checklist') {
    $date = isset($_POST['date']) ? $_POST['date'] : date('Y-m-d');
    $roomId = isset($_POST['room_id']) ? intval($_POST['room_id']) : 0;
    $status = isset($_POST['status']) ? $_POST['status'] : 'pending';
    $notes = isset($_POST['notes']) ? $_POST['notes'] : '';

    $roomResult = $conn->query("SELECT room_no, floor FROM igpess_network WHERE id = $roomId");

    if (!$roomResult || $roomResult->num_rows == 0) {
        echo json_encode(['success' => false, 'message' => 'Room not found']);
        exit;
    }

    $room = $roomResult->fetch_assoc();
    $date = $conn->real_escape_string($date);
    $roomNo = $conn->real_escape_string($room['room_no']);
    $floor = $conn->real_escape_string($room['floor']);
    $status = $conn->real_escape_string($status);
    $notes = $conn->real_escape_string($notes);

    $sql = "INSERT INTO daily_room_checklist (report_date, room_id, room_no, floor, status, notes, completed_at)
            VALUES ('$date', $roomId, '$roomNo', '$floor', '$status', '$notes', NOW())
            ON DUPLICATE KEY UPDATE
            status = '$status',
            notes = '$notes',
            completed_at = IF('$status' = 'completed', NOW(), NULL)";

    if ($conn->query($sql)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }
} else {
    echo json_encode(['error' => 'Invalid action: ' . $action]);
}

$conn->close();

function formatBytes($bytes, $precision = 2) {
    if ($bytes === 0 || $bytes === null) return '0 B';
    $units = ['B', 'KB', 'MB', 'GB'];
    $i = floor(log($bytes) / log(1024));
    return round($bytes / pow(1024, $i), $precision) . ' ' . $units[$i];
}
?>