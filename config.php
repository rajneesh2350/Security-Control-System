<?php
// config.php - Updated Database Configuration
error_reporting(1);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "your-domain-username";
$password = "your-domain-password";
$dbname = "your-database-name";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Encryption key (keep this secure!)
define('ENCRYPTION_KEY', 'your-256-bit-secret-key-here-change-this');
define('ENCRYPTION_IV', '1234567890123456'); // 16 chars for AES-256-CBC

// Upload path
define('UPLOAD_PATH', 'https://igipess.du.ac.in/rajneesh2350/uploads/');
define('UPLOAD_DIR', $_SERVER['DOCUMENT_ROOT'] . '/rajneesh2350/uploads/');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create upload directory if not exists
if (!is_dir(UPLOAD_DIR)) {
    mkdir(UPLOAD_DIR, 0777, true);
}

// Create reports table if not exists
$createReportsTable = "CREATE TABLE IF NOT EXISTS daily_room_reports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    report_date DATE NOT NULL,
    room_id INT NOT NULL,
    room_no VARCHAR(50),
    floor VARCHAR(50),
    media_type ENUM('photo', 'video') DEFAULT 'photo',
    file_name VARCHAR(255),
    original_size INT,
    compressed_size INT,
    latitude DECIMAL(10,8),
    longitude DECIMAL(11,8),
    geo_address TEXT,
    equipment_status TEXT,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_date (report_date),
    INDEX idx_room (room_id),
    FOREIGN KEY (room_id) REFERENCES igpess_network(id) ON DELETE CASCADE
)";

$conn->query($createReportsTable);

// Create daily checklist table
$createChecklistTable = "CREATE TABLE IF NOT EXISTS daily_room_checklist (
    id INT AUTO_INCREMENT PRIMARY KEY,
    report_date DATE NOT NULL,
    room_id INT NOT NULL,
    room_no VARCHAR(50),
    floor VARCHAR(50),
    status ENUM('pending', 'completed', 'issue') DEFAULT 'pending',
    networking_status ENUM('working', 'issue', 'not_applicable') DEFAULT 'pending',
    interactive_board_status ENUM('working', 'issue', 'not_applicable') DEFAULT 'pending',
    wifi_status ENUM('working', 'issue', 'not_applicable') DEFAULT 'pending',
    cctv_status ENUM('working', 'issue', 'not_applicable') DEFAULT 'pending',
    ups_status ENUM('working', 'issue', 'not_applicable') DEFAULT 'pending',
    audio_video_status ENUM('working', 'issue', 'not_applicable') DEFAULT 'pending',
    notes TEXT,
    completed_at TIMESTAMP NULL,
    UNIQUE KEY unique_daily_room (report_date, room_id),
    FOREIGN KEY (room_id) REFERENCES igpess_network(id) ON DELETE CASCADE
)";

$conn->query($createChecklistTable);
?>
