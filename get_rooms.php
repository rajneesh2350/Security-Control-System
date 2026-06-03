<?php
// get_rooms.php - Working version
error_reporting(0);
ini_set('display_errors', 0);

// Clear any output buffers
while (ob_get_level()) ob_end_clean();

header('Content-Type: application/json');

$servername = "localhost";
$username = "igipess_c41duigipess";
$password = "MyPassword26November1972";
$dbname = "igipess_r261172";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit;
}

$action = isset($_GET['action']) ? $_GET['action'] : 'get_all_rooms';

if ($action === 'get_all_rooms') {
    $floor = isset($_GET['floor']) && $_GET['floor'] !== '' ? $_GET['floor'] : '';

    $sql = "SELECT id, floor, room_no, description, icon, room_image,
                   networking, interactive_board, wifi_router, cctv, ups, audio_video,
                   remarks, latitude, longitude
            FROM igpess_network";

    if (!empty($floor)) {
        $sql .= " WHERE floor = '" . $conn->real_escape_string($floor) . "'";
    }

    $sql .= " ORDER BY floor, CAST(room_no AS UNSIGNED), room_no";

    $result = $conn->query($sql);

    if (!$result) {
        echo json_encode(['success' => false, 'error' => 'Query failed']);
        $conn->close();
        exit;
    }

    $rooms = [];
    while ($row = $result->fetch_assoc()) {
        $rooms[] = $row;
    }

    echo json_encode(['success' => true, 'rooms' => $rooms, 'count' => count($rooms)]);

} elseif ($action === 'get_floors') {
    $sql = "SELECT DISTINCT floor FROM igpess_network WHERE floor IS NOT NULL AND floor != '' ORDER BY floor";
    $result = $conn->query($sql);

    $floors = [];
    while ($row = $result->fetch_assoc()) {
        $floors[] = $row['floor'];
    }

    echo json_encode(['success' => true, 'floors' => $floors]);
}

$conn->close();
?>