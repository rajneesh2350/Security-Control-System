<?php
// upload.php - Completely rewritten with proper parameter handling
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

// Clear output buffers
while (ob_get_level()) ob_end_clean();
header('Content-Type: application/json');

$servername = "localhost";
$username = "igipess_c41duigipess";
$password = "MyPassword26November1972";
$dbname = "igipess_r261172";

$response = ['success' => false, 'message' => ''];

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        throw new Exception('Database connection failed: ' . $conn->connect_error);
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    // Get form data
    $reportDate = isset($_POST['report_date']) ? $_POST['report_date'] : date('Y-m-d');
    $roomId = isset($_POST['room_id']) ? intval($_POST['room_id']) : 0;
    $roomNo = isset($_POST['room_no']) ? trim($_POST['room_no']) : '';
    $floor = isset($_POST['floor']) ? trim($_POST['floor']) : '';
    $mediaType = isset($_POST['media_type']) ? $_POST['media_type'] : 'photo';
    $latitude = isset($_POST['latitude']) && $_POST['latitude'] !== '' && $_POST['latitude'] !== 'null' ? floatval($_POST['latitude']) : 0;
    $longitude = isset($_POST['longitude']) && $_POST['longitude'] !== '' && $_POST['longitude'] !== 'null' ? floatval($_POST['longitude']) : 0;
    $geoAddress = isset($_POST['geo_address']) ? $_POST['geo_address'] : '';
    $equipmentStatus = isset($_POST['equipment_status']) ? $_POST['equipment_status'] : '';
    $notes = isset($_POST['notes']) ? $_POST['notes'] : '';

    // Debug log
    error_log("Upload data: room_id=$roomId, room_no=$roomNo, floor=$floor, date=$reportDate");

    if ($roomId <= 0) {
        throw new Exception('Please select a room');
    }

    // Check file upload
    if (!isset($_FILES['media_file']) || $_FILES['media_file']['error'] !== UPLOAD_ERR_OK) {
        $errorMsg = isset($_FILES['media_file']) ? 'Upload error code: ' . $_FILES['media_file']['error'] : 'No file uploaded';
        throw new Exception($errorMsg);
    }

    $fileTmp = $_FILES['media_file']['tmp_name'];
    $originalSize = $_FILES['media_file']['size'];
    $originalName = $_FILES['media_file']['name'];
    $fileExt = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

    // Create upload directory
    $uploadBaseDir = dirname(__FILE__) . '/uploads/';
    if (!is_dir($uploadBaseDir)) {
        mkdir($uploadBaseDir, 0777, true);
    }

    $dateSubDir = $uploadBaseDir . date('Y/m/d/');
    if (!is_dir($dateSubDir)) {
        mkdir($dateSubDir, 0777, true);
    }

    // Generate unique filename
    $timestamp = date('Ymd_His');
    $uniqueId = uniqid();
    $finalFileName = '';
    $compressedSize = $originalSize;
    $dbFileName = '';

    if ($mediaType === 'photo' && in_array($fileExt, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
        $finalFileName = $dateSubDir . $timestamp . '_' . $uniqueId . '.jpg';
        $compressedSize = compressImage($fileTmp, $finalFileName, 75);
        if ($compressedSize === false || $compressedSize === 0) {
            copy($fileTmp, $finalFileName);
            $compressedSize = filesize($finalFileName);
        }
        $dbFileName = 'uploads/' . date('Y/m/d/') . $timestamp . '_' . $uniqueId . '.jpg';
    } else {
        $finalFileName = $dateSubDir . $timestamp . '_' . $uniqueId . '.' . $fileExt;
        if (!move_uploaded_file($fileTmp, $finalFileName)) {
            throw new Exception('Failed to save file');
        }
        $compressedSize = filesize($finalFileName);
        $dbFileName = 'uploads/' . date('Y/m/d/') . $timestamp . '_' . $uniqueId . '.' . $fileExt;
    }

    // Check if file was saved
    if (!file_exists($finalFileName)) {
        throw new Exception('File not saved properly');
    }

    // Create table if not exists
    $conn->query("CREATE TABLE IF NOT EXISTS daily_room_reports (
        id INT AUTO_INCREMENT PRIMARY KEY,
        report_date DATE NOT NULL,
        room_id INT NOT NULL,
        room_no VARCHAR(50),
        floor VARCHAR(50),
        media_type VARCHAR(20) DEFAULT 'photo',
        file_name VARCHAR(255),
        original_size INT,
        compressed_size INT,
        latitude DECIMAL(10,8),
        longitude DECIMAL(11,8),
        geo_address TEXT,
        equipment_status TEXT,
        notes TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // Simple INSERT with direct values (avoiding bind_param issues)
    $reportDate = $conn->real_escape_string($reportDate);
    $roomNo = $conn->real_escape_string($roomNo);
    $floor = $conn->real_escape_string($floor);
    $mediaType = $conn->real_escape_string($mediaType);
    $dbFileName = $conn->real_escape_string($dbFileName);
    $geoAddress = $conn->real_escape_string($geoAddress);
    $equipmentStatus = $conn->real_escape_string($equipmentStatus);
    $notes = $conn->real_escape_string($notes);

    $sql = "INSERT INTO daily_room_reports
            (report_date, room_id, room_no, floor, media_type, file_name, original_size, compressed_size, latitude, longitude, geo_address, equipment_status, notes)
            VALUES
            ('$reportDate', $roomId, '$roomNo', '$floor', '$mediaType', '$dbFileName', $originalSize, $compressedSize, $latitude, $longitude, '$geoAddress', '$equipmentStatus', '$notes')";

    error_log("SQL Query: " . $sql);

    if ($conn->query($sql) === TRUE) {
        $response['success'] = true;
        $response['message'] = 'File uploaded successfully';
        $response['original_size'] = formatBytes($originalSize);
        $response['compressed_size'] = formatBytes($compressedSize);
        $response['compression_ratio'] = round(($compressedSize / max($originalSize, 1)) * 100, 1) . '%';
        $response['file_url'] = $dbFileName;
    } else {
        throw new Exception('Database insert failed: ' . $conn->error);
    }

} catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = $e->getMessage();
    error_log("Upload error: " . $e->getMessage());
}

$conn->close();
echo json_encode($response);

function compressImage($source, $destination, $quality = 75) {
    if (!file_exists($source)) return false;

    $info = getimagesize($source);
    if (!$info) return false;

    switch ($info['mime']) {
        case 'image/jpeg':
            $image = imagecreatefromjpeg($source);
            break;
        case 'image/png':
            $image = imagecreatefrompng($source);
            if ($image) {
                imagepalettetotruecolor($image);
                imagealphablending($image, true);
                imagesavealpha($image, true);
            }
            break;
        case 'image/gif':
            $image = imagecreatefromgif($source);
            break;
        default:
            copy($source, $destination);
            return filesize($destination);
    }

    if (!$image) return false;

    // Resize if too large
    $maxWidth = 1200;
    $maxHeight = 1200;
    $width = imagesx($image);
    $height = imagesy($image);

    if ($width > $maxWidth || $height > $maxHeight) {
        $ratio = min($maxWidth / $width, $maxHeight / $height);
        $newWidth = max(1, intval($width * $ratio));
        $newHeight = max(1, intval($height * $ratio));

        $resizedImage = imagecreatetruecolor($newWidth, $newHeight);

        if ($info['mime'] == 'image/png') {
            imagealphablending($resizedImage, false);
            imagesavealpha($resizedImage, true);
            $transparent = imagecolorallocatealpha($resizedImage, 255, 255, 255, 127);
            imagefilledrectangle($resizedImage, 0, 0, $newWidth, $newHeight, $transparent);
        }

        imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        imagedestroy($image);
        $image = $resizedImage;
    }

    // Save compressed image
    if ($info['mime'] == 'image/jpeg') {
        imagejpeg($image, $destination, $quality);
    } elseif ($info['mime'] == 'image/png') {
        imagepng($image, $destination, 8);
    } elseif ($info['mime'] == 'image/gif') {
        imagegif($image, $destination);
    } else {
        copy($source, $destination);
    }

    imagedestroy($image);
    return file_exists($destination) ? filesize($destination) : false;
}

function formatBytes($bytes, $precision = 2) {
    if ($bytes === 0) return '0 B';
    $units = ['B', 'KB', 'MB', 'GB'];
    $i = floor(log($bytes) / log(1024));
    return round($bytes / pow(1024, $i), $precision) . ' ' . $units[$i];
}
?>