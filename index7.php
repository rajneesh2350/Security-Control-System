<?php
/*// Add this at the VERY TOP of index.php (before ANY HTML)
ob_start();
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Authentication check
if (!isset($_SESSION['loggedin'])) {
    header("Location: https://igipess.du.ac.in/login.php");
    exit;
}

// Set user info from session if available
$userName = isset($_SESSION['username']) ? $_SESSION['username'] : 'Staff';
$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, user-scalable=yes">
    <meta name="theme-color" content="#667eea">
    <title>IGIPESS Room Check Pro - Smart Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            padding-bottom: 80px;
        }
        .navbar-brand { font-weight: bold; font-size: 1.3rem; }
        .card {
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            border: none;
            margin-bottom: 20px;
            overflow: hidden;
            background: white;
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-weight: bold;
            border: none;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }
        .card-header h4 { font-size: 1.2rem; margin: 0; }
        .btn-camera {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border: none;
            color: white;
            padding: 12px 25px;
            font-size: 1rem;
            border-radius: 50px;
            transition: transform 0.3s;
        }
        .btn-camera:disabled { opacity: 0.5; }
        .btn-upload {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 50px;
            font-weight: bold;
        }
        .progress { height: 25px; border-radius: 12px; }
        .progress-bar {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            border-radius: 12px;
            font-weight: bold;
            line-height: 25px;
            font-size: 0.8rem;
        }

        .rooms-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 10px;
            max-height: 280px;
            overflow-y: auto;
            padding: 5px;
        }
        .room-thumb {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 10px 6px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            border: 2px solid transparent;
        }
        .room-thumb:hover { background: #e9ecef; transform: scale(0.98); }
        .room-thumb.selected {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: #fff;
        }
        .room-thumb i { font-size: 1.5rem; margin-bottom: 6px; display: block; }
        .room-thumb .room-number { font-size: 0.8rem; font-weight: bold; }
        .room-thumb .room-desc { font-size: 0.65rem; opacity: 0.8; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .room-thumb .room-floor { font-size: 0.6rem; opacity: 0.7; margin-top: 2px; }

        .search-bar {
            background: white;
            border-radius: 25px;
            padding: 5px 15px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
        }
        .search-bar input { border: none; outline: none; width: 100%; padding: 8px 0; font-size: 0.9rem; }

        .filter-chip {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            background: #e9ecef;
            margin-right: 8px;
            margin-bottom: 8px;
            font-size: 0.75rem;
            cursor: pointer;
        }
        .filter-chip.active { background: #667eea; color: white; }

        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .stat-number { font-size: 2rem; font-weight: bold; }
        .stat-label { font-size: 0.8rem; opacity: 0.9; }

        .media-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            transition: transform 0.2s;
            margin-bottom: 20px;
            position: relative;
        }
        .media-card:hover { transform: translateY(-5px); }
        .media-thumb {
            position: relative;
            height: 180px;
            overflow: hidden;
            background: #1a1a2e;
            cursor: pointer;
        }
        .media-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .video-thumb-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .play-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0,0,0,0.7);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: none;
            z-index: 5;
        }
        .media-type-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(0,0,0,0.7);
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.7rem;
            z-index: 5;
        }
        .media-info { padding: 12px; }
        .room-badge {
            background: #667eea;
            color: white;
            padding: 3px 10px;
            border-radius: 15px;
            font-size: 0.7rem;
            display: inline-block;
        }
        .geo-text { font-size: 0.7rem; color: #6c757d; margin-top: 5px; }

        .action-buttons {
            position: absolute;
            bottom: 12px;
            right: 12px;
            display: flex;
            gap: 8px;
            z-index: 20;
            opacity: 1;
            visibility: visible;
        }
        .action-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.25);
            font-size: 1rem;
        }
        .action-btn:hover { transform: scale(1.1); }
        .share-btn { background: #25D366; color: white; }
        .share-btn:hover { background: #128C7E; }
        .delete-btn { background: #dc3545; color: white; }
        .delete-btn:hover { background: #c82333; }

        .group-header {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 12px 15px;
            border-radius: 15px;
            margin-top: 20px;
            margin-bottom: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .group-header:hover { opacity: 0.9; }
        .group-header i { transition: transform 0.3s; }
        .group-header.collapsed i { transform: rotate(-90deg); }
        .group-content { transition: all 0.3s; overflow: hidden; }
        .group-content.collapsed { display: none; }

        .date-filter {
            background: white;
            border-radius: 25px;
            padding: 5px;
            margin-bottom: 15px;
        }
        .date-filter .btn-group { width: 100%; flex-wrap: wrap; }
        .date-filter .btn {
            border-radius: 20px;
            padding: 8px 12px;
            font-size: 0.8rem;
            margin: 2px;
            transition: all 0.2s ease;
        }
        .calendar-btn { background: #28a745 !important; color: white !important; }
        .calendar-btn:hover { background: #218838 !important; }

        .modal-media { max-width: 90%; max-height: 80vh; margin: auto; }

        .nav-tabs .nav-link {
            border-radius: 25px;
            margin: 0 3px;
            color: white;
            background: rgba(255,255,255,0.2);
            padding: 8px 20px;
            transition: all 0.2s ease;
        }
        .nav-tabs .nav-link.active {
            background: white;
            color: #667eea !important;
            border: none;
        }

        .loader {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .selected-room-info {
            background: #e3f2fd;
            border-radius: 10px;
            padding: 8px 12px;
            margin: 10px 0;
            font-size: 0.85rem;
        }

        .compress-progress {
            font-size: 0.75rem;
            padding: 5px;
            background: #f0f0f0;
            border-radius: 8px;
            margin-top: 5px;
        }

        .video-recorder-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.95);
            z-index: 10000;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .video-preview-container {
            width: 100%;
            max-width: 400px;
            background: #000;
            border-radius: 20px;
            overflow: hidden;
            position: relative;
        }
        #liveVideoPreview {
            width: 100%;
            height: auto;
            background: #000;
            transform: scaleX(-1);
        }
        .recording-overlay {
            position: absolute;
            top: 20px;
            left: 0;
            right: 0;
            text-align: center;
        }
        .recording-timer-circle {
            background: rgba(255,0,0,0.8);
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: bold;
            margin: 0 auto;
            animation: pulse 1s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.1); opacity: 0.8; }
            100% { transform: scale(1); opacity: 1; }
        }
        .recording-controls { margin-top: 20px; display: flex; gap: 15px; }
        .btn-record-stop {
            background: #dc3545;
            border: none;
            padding: 15px 30px;
            border-radius: 50px;
            color: white;
            font-size: 1.2rem;
        }
        .btn-cancel-record {
            background: #6c757d;
            border: none;
            padding: 15px 30px;
            border-radius: 50px;
            color: white;
            font-size: 1.2rem;
        }

        .admin-card {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 15px;
            transition: all 0.2s ease;
        }
        .admin-card:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }
        .admin-thumb {
            width: 80px;
            height: 80px;
            border-radius: 10px;
            object-fit: cover;
            background: #1a1a2e;
        }
        .admin-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        .btn-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        @media (max-width: 768px) {
            .admin-thumb { width: 50px; height: 50px; }
            .admin-card .row > div { margin-bottom: 8px; }
            .rooms-grid { grid-template-columns: repeat(auto-fill, minmax(85px, 1fr)); }
        }

        @media (max-width: 480px) {
            .rooms-grid { grid-template-columns: repeat(auto-fill, minmax(75px, 1fr)); }
            .room-thumb i { font-size: 1.2rem; }
            .room-thumb .room-number { font-size: 0.7rem; }
            .room-thumb .room-desc { font-size: 0.55rem; }
            .stat-number { font-size: 1.5rem; }
            .media-thumb { height: 150px; }
            .date-filter .btn { padding: 5px 8px; font-size: 0.7rem; }
            .play-overlay { width: 35px; height: 35px; }
            .action-btn { width: 30px; height: 30px; font-size: 0.8rem; }
            .card-header { flex-direction: column; align-items: flex-start; }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-dark bg-transparent">
    <div class="container">
        <a class="navbar-brand" href="#">
            <i class="fas fa-building me-2"></i> IGIPESS Room Check Pro
        </a>
        <div class="d-flex align-items-center gap-3">
            <div class="user-badge bg-white bg-opacity-25 rounded-pill px-3 py-1 small">
                <i class="fas fa-user me-1"></i> <?php echo htmlspecialchars($userName); ?>
            </div>
            <div class="text-white small">
                <i class="fas fa-calendar-alt me-1"></i> <span id="currentDate"></span>
            </div>
        </div>
    </div>
</nav>

<div class="container mt-2">
    <ul class="nav nav-tabs mb-3" id="mainTab" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#capture">
                <i class="fas fa-camera me-1"></i> Capture
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#reports">
                <i class="fas fa-chart-line me-1"></i> Dashboard
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#admin">
                <i class="fas fa-user-shield me-1"></i> Admin
            </button>
        </li>
    </ul>

    <div class="tab-content">
        <!-- Capture Tab -->
        <div class="tab-pane fade show active" id="capture">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-camera-retro me-2"></i> Capture Media</h4>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <label class="form-label small fw-bold"><i class="fas fa-calendar-day me-1"></i> Date</label>
                        <input type="date" class="form-control form-control-sm" id="reportDate" value="<?php echo date('Y-m-d'); ?>">
                    </div>

                    <div class="search-bar mb-2">
                        <i class="fas fa-search me-2 text-muted"></i>
                        <input type="text" id="roomSearch" placeholder="Search by room number, floor or description..." onkeyup="filterRooms()">
                    </div>

                    <div id="floorChips" class="mb-2"></div>

                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <small class="text-muted"><i class="fas fa-door-open me-1"></i> Select Room</small>
                        <small id="roomCount" class="text-muted">0 rooms</small>
                    </div>
                    <div id="roomsList" class="rooms-grid mb-2">
                        <div class="text-center py-3"><div class="loader"></div></div>
                    </div>

                    <div id="selectedRoomInfo" class="selected-room-info" style="display:none;"></div>

                    <textarea class="form-control form-control-sm mb-2" id="notes" rows="2" placeholder="Additional notes..."></textarea>

                    <div class="text-center my-3">
                        <button class="btn btn-camera me-2" id="openCameraBtn" disabled>
                            <i class="fas fa-camera me-1"></i> Take Photo
                        </button>
                        <button class="btn btn-camera" id="openVideoBtn" disabled>
                            <i class="fas fa-video me-1"></i> Record Video (5 sec)
                        </button>
                    </div>

                    <input type="file" id="cameraInput" accept="image/*" capture="environment" style="display:none">

                    <div id="previewArea" style="display:none;" class="mt-2">
                        <div id="mediaPreview" style="position: relative;"></div>
                        <div id="compressionStatus" class="compress-progress"></div>
                        <div class="progress mb-2 mt-2">
                            <div id="uploadProgressBar" class="progress-bar" style="width: 0%">0%</div>
                        </div>
                        <button class="btn btn-upload w-100" id="uploadBtn">
                            <i class="fas fa-cloud-upload-alt me-1"></i> Upload
                        </button>
                    </div>

                    <div id="geoStatus" class="alert alert-info small mt-2" style="display:none; padding: 8px;">
                        <i class="fas fa-map-marker-alt me-1"></i> <span id="geoText">Getting location...</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dashboard Reports Tab -->
        <div class="tab-pane fade" id="reports">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-chart-pie me-2"></i> Dashboard Reports</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-6 col-md-3 mb-2">
                            <div class="stat-card">
                                <div class="stat-number" id="totalMedia">0</div>
                                <div class="stat-label">Total Media</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-2">
                            <div class="stat-card" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                                <div class="stat-number" id="totalPhotos">0</div>
                                <div class="stat-label">Photos</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-2">
                            <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                                <div class="stat-number" id="totalVideos">0</div>
                                <div class="stat-label">Videos</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-2">
                            <div class="stat-card" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                                <div class="stat-number" id="totalRoomsStat">0</div>
                                <div class="stat-label">Rooms Covered</div>
                            </div>
                        </div>
                    </div>

                    <div class="date-filter">
                        <div class="btn-group w-100" role="group">
                            <button class="btn btn-outline-primary filter-date" data-filter="day" onclick="loadDashboardReports('day')">Today</button>
                            <button class="btn btn-outline-primary filter-date" data-filter="week" onclick="loadDashboardReports('week')">This Week</button>
                            <button class="btn btn-outline-primary filter-date" data-filter="month" onclick="loadDashboardReports('month')">This Month</button>
                            <button class="btn btn-outline-primary filter-date" data-filter="year" onclick="loadDashboardReports('year')">This Year</button>
                            <button class="btn btn-outline-primary filter-date" data-filter="all" onclick="loadDashboardReports('all')">All Time</button>
                            <button class="btn btn-success calendar-btn" onclick="openCalendarPicker()">
                                <i class="fas fa-calendar-alt me-1"></i> Calendar
                            </button>
                        </div>
                    </div>

                    <div id="reportsContainer">
                        <div class="text-center py-5"><div class="loader"></div><p class="mt-2">Loading dashboard...</p></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin Tab -->
        <div class="tab-pane fade" id="admin">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-user-shield me-2"></i> Admin Management</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Admin Area</strong> - Manage all records. Delete operations are permanent.
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold"><i class="fas fa-calendar-day me-1"></i> Select Date</label>
                            <input type="date" id="adminDate" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button class="btn btn-primary w-100" onclick="loadAdminRecords()">
                                <i class="fas fa-search me-1"></i> Load Records
                            </button>
                        </div>
                        <div class="col-md-5 d-flex align-items-end justify-content-end gap-2">
                            <button class="btn btn-danger" onclick="deleteAllForDate()">
                                <i class="fas fa-trash-alt me-1"></i> Delete All for Date
                            </button>
                        </div>
                    </div>

                    <div id="adminContainer">
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-calendar-alt fa-3x mb-3 opacity-50"></i>
                            <p>Select a date and click "Load Records" to manage records</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mediaModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-dark">
            <div class="modal-body text-center p-0">
                <div id="modalMediaContent"></div>
            </div>
            <div class="modal-footer bg-dark border-0">
                <button class="btn btn-success" id="modalShareBtn" onclick="shareCurrentMedia()">
                    <i class="fab fa-whatsapp me-1"></i> Share on WhatsApp
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    let currentMediaType = 'photo';
    let currentMediaFile = null;
    let currentGeo = { lat: null, lng: null, address: '' };
    let selectedRoom = null;
    let allRooms = [];
    let filteredRooms = [];
    let currentFloor = '';
    let roomDetailsMap = {};
    let modal = new bootstrap.Modal(document.getElementById('mediaModal'));
    let currentModalMediaUrl = '';
    let currentModalMediaType = '';
    let mediaRecorder = null;
    let recordedChunks = [];
    let liveStream = null;
    let currentFilter = 'day';

    const MAX_FILE_SIZE = 2 * 1024 * 1024;
    const MAX_VIDEO_DURATION = 5;
    const BASE_PATH = '/rajneesh2350/';

    function getFullUrl(path) {
        if (!path) return '';
        if (path.startsWith('http')) return path;
        if (path.startsWith('/')) return window.location.origin + path;
        return window.location.origin + '/' + path;
    }

    function getActualMediaType(fileName, dbType) {
        if (!fileName) return dbType;
        const ext = fileName.toLowerCase().split('.').pop();
        if (ext === 'mp4' || ext === 'mov' || ext === 'avi' || ext === 'webm' || ext === 'mkv') return 'video';
        if (ext === 'jpg' || ext === 'jpeg' || ext === 'png' || ext === 'gif' || ext === 'webp') return 'photo';
        if (fileName.endsWith('.')) return 'video';
        return dbType;
    }

    function getCorrectFileUrl(fileName, mediaType) {
        if (!fileName) return '';
        let correctedFileName = fileName;
        if (correctedFileName.endsWith('.')) {
            correctedFileName = correctedFileName + (mediaType === 'photo' ? 'jpg' : 'mp4');
        }
        if (correctedFileName.startsWith('http')) return correctedFileName;
        if (correctedFileName.startsWith('/')) correctedFileName = correctedFileName.substring(1);
        return window.location.origin + BASE_PATH + correctedFileName;
    }

    document.getElementById('currentDate').innerText = new Date().toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });

    // ========== DELETE RECORD FUNCTION ==========
    async function deleteRecord(id, fileName, mediaType) {
        const result = await Swal.fire({
            title: 'Delete Record?',
            html: `<div class="text-center">
                    <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                    <p>This action <strong>cannot be undone!</strong></p>
                    <p class="text-muted small">The media file will be permanently deleted from the server.</p>
                   </div>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-trash me-1"></i> Yes, Delete',
            cancelButtonText: '<i class="fas fa-times me-1"></i> Cancel',
            reverseButtons: true
        });

        if (result.isConfirmed) {
            const loadingSwal = Swal.fire({
                title: 'Deleting...',
                html: '<div class="loader"></div><p class="mt-2">Please wait</p>',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => { Swal.showLoading(); }
            });

            try {
                const formData = new FormData();
                formData.append('id', id);
                formData.append('file_name', fileName);

                const response = await fetch('delete_record.php', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    loadingSwal.close();
                    Swal.fire({
                        title: 'Deleted!',
                        html: '<i class="fas fa-check-circle fa-2x text-success mb-2"></i><p>Record has been deleted successfully.</p>',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    loadDashboardReports(currentFilter);
                    if (document.getElementById('adminContainer').innerHTML !== '<div class="text-center py-5 text-muted">...') {
                        loadAdminRecords();
                    }
                } else {
                    loadingSwal.close();
                    Swal.fire({
                        title: 'Error!',
                        text: data.message || 'Failed to delete record',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            } catch(error) {
                loadingSwal.close();
                Swal.fire({
                    title: 'Error!',
                    text: 'Network error. Please try again.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        }
    }

    // ========== ADMIN FUNCTIONS ==========
    async function loadAdminRecords() {
        const date = document.getElementById('adminDate').value;
        if (!date) {
            Swal.fire('Error', 'Please select a date', 'warning');
            return;
        }

        document.getElementById('adminContainer').innerHTML = '<div class="text-center py-5"><div class="loader"></div><p class="mt-2">Loading records...</p></div>';

        try {
            const response = await fetch(`reports.php?action=get_by_date&date=${date}`);
            const reports = await response.json();

            if (!reports || reports.length === 0) {
                document.getElementById('adminContainer').innerHTML = `
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle me-2"></i> No records found for ${date}
                    </div>
                `;
                return;
            }

            let html = '';
            for (const report of reports) {
                const actualType = getActualMediaType(report.file_name, report.media_type);
                const fileUrl = getCorrectFileUrl(report.file_name, actualType);
                const room = roomDetailsMap[report.room_id] || {};

                html += `
                    <div class="admin-card">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                ${actualType === 'photo' ?
                                    `<img src="${fileUrl}" class="admin-thumb" style="width:80px; height:80px; object-fit:cover; border-radius:10px;" onerror="this.src='https://via.placeholder.com/80?text=No+Image'">` :
                                    `<video class="admin-thumb" style="width:80px; height:80px; object-fit:cover; border-radius:10px; background:#000;" preload="metadata">
                                        <source src="${fileUrl}" type="video/mp4">
                                     </video>`
                                }
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col-md-3">
                                        <small class="text-muted">Room</small>
                                        <div><strong>${escapeHtml(room.floor || report.floor)} - Room ${escapeHtml(report.room_no)}</strong><br><small class="text-muted">${escapeHtml(room.description || '')}</small></div>
                                    </div>
                                    <div class="col-md-3">
                                        <small class="text-muted">Type / Size</small>
                                        <div><span class="badge ${actualType === 'photo' ? 'bg-info' : 'bg-danger'}">${actualType}</span> <span class="badge bg-light text-dark">${report.compressed_size_formatted}</span></div>
                                    </div>
                                    <div class="col-md-3">
                                        <small class="text-muted">Date/Time</small>
                                        <div><small>${new Date(report.created_at).toLocaleString()}</small></div>
                                    </div>
                                    <div class="col-md-3">
                                        <small class="text-muted">Location</small>
                                        <div><small class="text-truncate" style="max-width:180px;">${escapeHtml(report.geo_address || 'N/A')}</small></div>
                                    </div>
                                </div>
                                ${report.notes ? `<div class="mt-2"><small class="text-muted">Notes:</small> <small>${escapeHtml(report.notes)}</small></div>` : ''}
                                <div class="mt-2">
                                    <small class="text-muted">File:</small>
                                    <small class="text-break">${escapeHtml(report.file_name)}</small>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="admin-actions">
                                    <button class="btn btn-sm btn-warning btn-icon" onclick="editRecordNotes(${report.id}, '${escapeHtml(report.notes || '')}')" title="Edit Notes">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger btn-icon" onclick="deleteRecord(${report.id}, '${report.file_name}', '${actualType}')" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <button class="btn btn-sm btn-success btn-icon" onclick="shareToWhatsApp('${report.file_name}', '${escapeHtml(report.room_no)}', '${escapeHtml(report.floor)}', '${new Date(report.created_at).toLocaleString()}', '${escapeHtml(report.geo_address || 'IGIPESS')}', '${actualType}')" title="Share">
                                        <i class="fab fa-whatsapp"></i>
                                    </button>
                                    <button class="btn btn-sm btn-info btn-icon" onclick="window.open('${fileUrl}', '_blank')" title="View Full">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }

            html += `<div class="mt-3 text-muted small text-center">Total records: ${reports.length}</div>`;
            document.getElementById('adminContainer').innerHTML = html;
        } catch(e) {
            document.getElementById('adminContainer').innerHTML = '<div class="alert alert-danger">Error loading records</div>';
            console.error(e);
        }
    }

    async function editRecordNotes(id, currentNotes) {
        const { value: notes } = await Swal.fire({
            title: 'Edit Notes',
            input: 'textarea',
            inputLabel: 'Update notes for this record',
            inputValue: currentNotes,
            inputPlaceholder: 'Enter new notes...',
            showCancelButton: true,
            confirmButtonText: '<i class="fas fa-save me-1"></i> Save Changes',
            cancelButtonText: 'Cancel',
            inputValidator: (value) => {
                if (value && value.length > 500) {
                    return 'Notes cannot exceed 500 characters';
                }
            }
        });

        if (notes !== undefined) {
            const loadingSwal = Swal.fire({
                title: 'Saving...',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });

            try {
                const response = await fetch('edit_record.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `id=${id}&notes=${encodeURIComponent(notes)}`
                });
                const data = await response.json();

                loadingSwal.close();

                if (data.success) {
                    Swal.fire({
                        title: 'Updated!',
                        text: 'Notes have been updated successfully.',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    loadAdminRecords();
                    loadDashboardReports(currentFilter);
                } else {
                    Swal.fire('Error', data.message || 'Update failed', 'error');
                }
            } catch(error) {
                loadingSwal.close();
                Swal.fire('Error', 'Network error. Please try again.', 'error');
            }
        }
    }

    async function deleteAllForDate() {
        const date = document.getElementById('adminDate').value;
        if (!date) {
            Swal.fire('Error', 'Please select a date', 'warning');
            return;
        }

        const checkResponse = await fetch(`reports.php?action=get_by_date&date=${date}`);
        const records = await checkResponse.json();

        if (!records || records.length === 0) {
            Swal.fire('No Records', `No records found for ${date}`, 'info');
            return;
        }

        const result = await Swal.fire({
            title: 'Delete All Records?',
            html: `<div class="text-center">
                    <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                    <p>You are about to delete <strong>${records.length} records</strong> for <strong>${date}</strong>.</p>
                    <p class="text-danger">This action cannot be undone!</p>
                   </div>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-trash-alt me-1"></i> Yes, Delete All',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        });

        if (result.isConfirmed) {
            const loadingSwal = Swal.fire({
                title: 'Deleting...',
                html: `<div class="loader"></div><p class="mt-2">Deleting ${records.length} records...</p>`,
                allowOutsideClick: false,
                showConfirmButton: false
            });

            try {
                const formData = new FormData();
                formData.append('date', date);

                const response = await fetch('delete_all_records.php', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                loadingSwal.close();

                if (data.success) {
                    Swal.fire({
                        title: 'Deleted!',
                        html: `<i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                               <p>${data.count} records have been deleted successfully.</p>`,
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    loadAdminRecords();
                    loadDashboardReports(currentFilter);
                } else {
                    Swal.fire('Error', data.message || 'Failed to delete records', 'error');
                }
            } catch(error) {
                loadingSwal.close();
                Swal.fire('Error', 'Network error. Please try again.', 'error');
            }
        }
    }

    // ========== DASHBOARD FUNCTIONS ==========
    function openCalendarPicker() {
        Swal.fire({
            title: 'Select Date',
            html: '<input type="date" id="calendarDate" class="form-control" value="' + new Date().toISOString().split('T')[0] + '">',
            showCancelButton: true,
            confirmButtonText: 'View Reports',
            preConfirm: () => {
                const date = document.getElementById('calendarDate').value;
                if (date) loadDashboardReportsByDate(date);
            }
        });
    }

    async function loadDashboardReportsByDate(date) {
        document.getElementById('reportsContainer').innerHTML = '<div class="text-center py-5"><div class="loader"></div><p class="mt-2">Loading reports for ' + date + '...</p></div>';
        try {
            const response = await fetch(`reports.php?action=get_by_date&date=${date}`);
            const reports = await response.json();
            if (!reports || reports.length === 0) {
                document.getElementById('reportsContainer').innerHTML = '<div class="text-center text-muted py-5"><i class="fas fa-calendar-day fa-3x mb-3"></i><p>No reports for ' + date + '</p></div>';
                return;
            }
            updateStats(reports);
            const groupedReports = [{ key: date, items: reports }];
            displayGroupedReports(groupedReports);
            document.querySelectorAll('.filter-date').forEach(btn => btn.classList.remove('active'));
        } catch(e) {
            document.getElementById('reportsContainer').innerHTML = '<div class="alert alert-danger">Error loading reports</div>';
        }
    }

    async function loadRooms() {
        document.getElementById('roomsList').innerHTML = '<div class="text-center py-3"><div class="loader"></div></div>';
        try {
            const response = await fetch('get_rooms.php?action=get_all_rooms');
            const data = await response.json();
            if (data.success && data.rooms) {
                allRooms = data.rooms;
                allRooms.forEach(room => { roomDetailsMap[room.id] = room; });
                filterRooms();
                loadFloorChips();
            } else {
                document.getElementById('roomsList').innerHTML = '<div class="text-danger small text-center">Error loading rooms</div>';
            }
        } catch(e) {
            document.getElementById('roomsList').innerHTML = '<div class="text-danger small text-center">Network error</div>';
            console.error(e);
        }
    }

    function loadFloorChips() {
        const floors = [...new Set(allRooms.map(r => r.floor))];
        let html = '<span class="filter-chip active" onclick="filterByFloor(\'\')">All</span>';
        floors.forEach(floor => {
            html += `<span class="filter-chip" onclick="filterByFloor('${floor}')">${floor}</span>`;
        });
        document.getElementById('floorChips').innerHTML = html;
    }

    function filterByFloor(floor) {
        currentFloor = floor;
        document.querySelectorAll('.filter-chip').forEach(c => c.classList.remove('active'));
        event.target.classList.add('active');
        filterRooms();
    }

    function filterRooms() {
        const searchTerm = document.getElementById('roomSearch').value.toLowerCase();
        filteredRooms = allRooms.filter(room => {
            let matchesSearch = !searchTerm ||
                room.room_no.toLowerCase().includes(searchTerm) ||
                (room.description && room.description.toLowerCase().includes(searchTerm)) ||
                room.floor.toLowerCase().includes(searchTerm);
            let matchesFloor = !currentFloor || room.floor === currentFloor;
            return matchesSearch && matchesFloor;
        });
        document.getElementById('roomCount').innerText = filteredRooms.length + ' rooms';
        displayRooms(filteredRooms);
    }

    function displayRooms(rooms) {
        if (rooms.length === 0) {
            document.getElementById('roomsList').innerHTML = '<div class="text-center text-muted small py-3">No rooms found</div>';
            return;
        }
        let html = '';
        rooms.forEach(room => {
            const isSelected = selectedRoom && selectedRoom.id === room.id;
            html += `
                <div class="room-thumb ${isSelected ? 'selected' : ''}" onclick="selectRoom(${room.id})">
                    <i class="fas ${room.icon || 'fa-door-open'}"></i>
                    <div class="room-number">${escapeHtml(room.room_no)}</div>
                    <div class="room-desc" title="${escapeHtml(room.description || '')}">${escapeHtml(room.description || '').substring(0, 25)}</div>
                    <div class="room-floor">${escapeHtml(room.floor)}</div>
                </div>
            `;
        });
        document.getElementById('roomsList').innerHTML = html;
    }

    function selectRoom(roomId) {
        const room = allRooms.find(r => r.id == roomId);
        if (room) {
            selectedRoom = room;
            displayRooms(filteredRooms);
            document.getElementById('selectedRoomInfo').style.display = 'block';
            document.getElementById('selectedRoomInfo').innerHTML = `<i class="fas fa-check-circle text-success me-2"></i> <strong>${escapeHtml(room.floor)} - Room ${escapeHtml(room.room_no)}</strong><br><small class="text-muted">${escapeHtml(room.description)}</small>`;
            document.getElementById('openCameraBtn').disabled = false;
            document.getElementById('openVideoBtn').disabled = false;

            Swal.fire({
                title: 'Room Selected!',
                html: `<strong>${escapeHtml(room.floor)} - Room ${escapeHtml(room.room_no)}</strong><br><small>${escapeHtml(room.description)}</small>`,
                icon: 'success',
                timer: 2000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        }
    }

    function getGeoLocation() {
        return new Promise((resolve) => {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition((position) => {
                    currentGeo.lat = position.coords.latitude;
                    currentGeo.lng = position.coords.longitude;
                    currentGeo.address = `${currentGeo.lat.toFixed(6)}, ${currentGeo.lng.toFixed(6)}`;
                    document.getElementById('geoStatus').style.display = 'block';
                    document.getElementById('geoText').innerHTML = `📍 ${currentGeo.lat.toFixed(4)}, ${currentGeo.lng.toFixed(4)}`;
                    resolve(currentGeo);
                }, () => {
                    document.getElementById('geoStatus').style.display = 'block';
                    document.getElementById('geoText').innerHTML = `📍 Location unavailable`;
                    resolve(currentGeo);
                });
            } else {
                resolve(currentGeo);
            }
        });
    }

    async function addGeoTagToImage(file, room, latitude, longitude, address) {
        return new Promise((resolve, reject) => {
            const compressionStatus = document.getElementById('compressionStatus');
            compressionStatus.innerHTML = '<span class="text-info"><i class="fas fa-spinner fa-spin"></i> Adding permanent geo-tag...</span>';

            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = (e) => {
                const img = new Image();
                img.src = e.target.result;
                img.onload = () => {
                    const canvas = document.createElement('canvas');
                    const ctx = canvas.getContext('2d');

                    let width = img.width;
                    let height = img.height;
                    const maxSize = 1200;
                    if (width > maxSize || height > maxSize) {
                        const ratio = Math.min(maxSize / width, maxSize / height);
                        width = Math.floor(width * ratio);
                        height = Math.floor(height * ratio);
                    }
                    canvas.width = width;
                    canvas.height = height;

                    ctx.drawImage(img, 0, 0, width, height);

                    const now = new Date();
                    const dateStr = now.toLocaleString('en-US', {
                        year: 'numeric', month: '2-digit', day: '2-digit',
                        hour: '2-digit', minute: '2-digit', second: '2-digit',
                        hour12: false
                    });

                    const watermarkLines = [
                        `🔒 IGIPESS VERIFIED | ${room.floor} - Room ${room.room_no}`,
                        `📍 ${latitude ? latitude.toFixed(6) : 'N/A'}, ${longitude ? longitude.toFixed(6) : 'N/A'}`,
                        `📅 ${dateStr}`
                    ];

                    ctx.font = 'bold 11px "Courier New", monospace';
                    const lineHeight = 16;
                    const padding = 8;
                    let maxWidth = 0;
                    watermarkLines.forEach(line => {
                        const metrics = ctx.measureText(line);
                        maxWidth = Math.max(maxWidth, metrics.width);
                    });
                    const boxWidth = Math.min(maxWidth + 20, width - 20);
                    const boxHeight = watermarkLines.length * lineHeight + padding * 2;

                    ctx.fillStyle = 'rgba(0, 0, 0, 0.7)';
                    ctx.fillRect(10, height - boxHeight - 10, boxWidth, boxHeight);

                    ctx.fillStyle = '#FFFFFF';
                    ctx.shadowColor = 'rgba(0,0,0,0.5)';
                    ctx.shadowBlur = 2;

                    watermarkLines.forEach((line, index) => {
                        ctx.fillText(line, 15, height - boxHeight - 10 + (index * lineHeight) + 15);
                    });

                    ctx.fillStyle = 'rgba(0, 0, 0, 0.6)';
                    ctx.fillRect(10, 10, 180, 22);
                    ctx.fillStyle = '#FFD700';
                    ctx.font = 'bold 10px "Segoe UI", Arial';
                    ctx.fillText('📸 IGIPESS Inspection', 15, 26);

                    ctx.shadowColor = 'transparent';

                    canvas.toBlob((blob) => {
                        const taggedFile = new File([blob], 'geo_tagged_' + Date.now() + '.jpg', { type: 'image/jpeg' });
                        compressionStatus.innerHTML = `<span class="text-success">✅ Geo-tag added! Size: ${formatBytes(blob.size)}</span>`;
                        resolve(taggedFile);
                    }, 'image/jpeg', 0.85);
                };
                img.onerror = reject;
            };
            reader.onerror = reject;
        });
    }

    async function startVideoRecording() {
        if (!selectedRoom) {
            Swal.fire('Error', 'Please select a room first', 'warning');
            return;
        }

        try {
            const stream = await navigator.mediaDevices.getUserMedia({
                video: { facingMode: { exact: "environment" } },
                audio: true
            });

            liveStream = stream;
            recordedChunks = [];

            const recorderModal = document.createElement('div');
            recorderModal.className = 'video-recorder-modal';
            recorderModal.innerHTML = `
                <div class="video-preview-container">
                    <video id="liveVideoPreview" autoplay playsinline muted></video>
                    <div class="recording-overlay">
                        <div class="recording-timer-circle" id="recordingTimerCircle">5</div>
                    </div>
                </div>
                <div class="recording-controls">
                    <button class="btn-record-stop" id="stopRecordingBtn">⏹️ Stop</button>
                    <button class="btn-cancel-record" id="cancelRecordingBtn">❌ Cancel</button>
                </div>
            `;
            document.body.appendChild(recorderModal);

            const videoPreview = document.getElementById('liveVideoPreview');
            videoPreview.srcObject = stream;

            mediaRecorder = new MediaRecorder(stream);
            mediaRecorder.ondataavailable = (event) => {
                if (event.data.size > 0) recordedChunks.push(event.data);
            };

            mediaRecorder.onstop = () => {
                const blob = new Blob(recordedChunks, { type: 'video/mp4' });
                const file = new File([blob], 'recording_' + Date.now() + '.mp4', { type: 'video/mp4' });
                handleVideoFile(file);
                if (liveStream) liveStream.getTracks().forEach(track => track.stop());
                recorderModal.remove();
            };

            mediaRecorder.start();

            let seconds = MAX_VIDEO_DURATION;
            const timerElement = document.getElementById('recordingTimerCircle');
            const countdown = setInterval(() => {
                seconds--;
                timerElement.innerHTML = seconds;
                if (seconds <= 0) {
                    clearInterval(countdown);
                    if (mediaRecorder && mediaRecorder.state === 'recording') mediaRecorder.stop();
                }
            }, 1000);

            setTimeout(() => {
                if (mediaRecorder && mediaRecorder.state === 'recording') mediaRecorder.stop();
            }, MAX_VIDEO_DURATION * 1000);

            document.getElementById('stopRecordingBtn').onclick = () => {
                if (mediaRecorder && mediaRecorder.state === 'recording') mediaRecorder.stop();
                clearInterval(countdown);
            };
            document.getElementById('cancelRecordingBtn').onclick = () => {
                if (mediaRecorder && mediaRecorder.state === 'recording') mediaRecorder.stop();
                if (liveStream) liveStream.getTracks().forEach(track => track.stop());
                recorderModal.remove();
                clearInterval(countdown);
            };
        } catch(err) {
            Swal.fire('Error', 'Could not access camera', 'error');
        }
    }

    function handleVideoFile(file) {
        currentMediaFile = file;
        const url = URL.createObjectURL(file);
        document.getElementById('mediaPreview').innerHTML = `<video controls class="media-preview"><source src="${url}"></video>`;
        document.getElementById('previewArea').style.display = 'block';
        document.getElementById('compressionStatus').innerHTML = `<span class="text-success">✅ Video ready: ${formatBytes(file.size)}</span>`;
        getGeoLocation();
    }

    function shareToWhatsApp(mediaUrl, roomNo, floor, date, location, mediaType) {
        const fullUrl = getCorrectFileUrl(mediaUrl, mediaType);
        const text = `🏢 *IGIPESS Room Inspection Report* 🏢\n\n` +
                    `📍 *Room:* ${floor} - ${roomNo}\n` +
                    `📅 *Date/Time:* ${date}\n` +
                    `🗺️ *Location:* ${location}\n` +
                    `🔗 *View Media:* ${fullUrl}\n\n` +
                    `✅ *Verified by IGIPESS Room Check Pro*`;

        const encodedText = encodeURIComponent(text);
        const whatsappUrl = `https://wa.me/?text=${encodedText}`;
        window.open(whatsappUrl, '_blank');
    }

    function shareCurrentMedia() {
        if (currentModalMediaUrl) {
            shareToWhatsApp(currentModalMediaUrl, 'View', 'Report', new Date().toLocaleString(), 'IGIPESS', currentModalMediaType);
        }
    }

    document.getElementById('openCameraBtn').onclick = () => {
        if (!selectedRoom) { Swal.fire('Error', 'Select a room first', 'warning'); return; }
        document.getElementById('cameraInput').click();
    };

    document.getElementById('openVideoBtn').onclick = () => {
        if (!selectedRoom) { Swal.fire('Error', 'Select a room first', 'warning'); return; }
        startVideoRecording();
    };

    document.getElementById('cameraInput').onchange = async (e) => {
        if (e.target.files && e.target.files[0]) {
            const originalFile = e.target.files[0];
            const url = URL.createObjectURL(originalFile);
            document.getElementById('mediaPreview').innerHTML = `<img src="${url}" class="media-preview">`;
            document.getElementById('previewArea').style.display = 'block';
            await getGeoLocation();
            try {
                const taggedFile = await addGeoTagToImage(originalFile, selectedRoom, currentGeo.lat, currentGeo.lng, currentGeo.address);
                currentMediaFile = taggedFile;
                const newUrl = URL.createObjectURL(taggedFile);
                document.getElementById('mediaPreview').innerHTML = `<img src="${newUrl}" class="media-preview">`;
            } catch(error) {
                currentMediaFile = originalFile;
            }
        }
    };

    document.getElementById('uploadBtn').onclick = async () => {
        if (!currentMediaFile) { Swal.fire('Error', 'No media', 'error'); return; }
        if (!selectedRoom) { Swal.fire('Error', 'Select a room', 'error'); return; }

        if (currentMediaFile.size > MAX_FILE_SIZE) {
            Swal.fire('Error', `File too large: ${formatBytes(currentMediaFile.size)}`, 'error');
            return;
        }

        Swal.fire({ title: 'Uploading...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });

        const formData = new FormData();
        formData.append('media_file', currentMediaFile);
        formData.append('room_id', selectedRoom.id);
        formData.append('room_no', selectedRoom.room_no);
        formData.append('floor', selectedRoom.floor);
        formData.append('report_date', document.getElementById('reportDate').value);
        formData.append('media_type', currentMediaType);
        formData.append('latitude', currentGeo.lat || '');
        formData.append('longitude', currentGeo.lng || '');
        formData.append('geo_address', currentGeo.address);
        formData.append('notes', document.getElementById('notes').value);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'upload.php', true);
        xhr.upload.onprogress = (e) => {
            if (e.lengthComputable) {
                const percent = (e.loaded / e.total) * 100;
                document.getElementById('uploadProgressBar').style.width = percent + '%';
                document.getElementById('uploadProgressBar').innerText = Math.round(percent) + '%';
            }
        };
        xhr.onload = () => {
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.response);
                    if (response.success) {
                        Swal.fire('Success!', 'Uploaded!', 'success');
                        document.getElementById('previewArea').style.display = 'none';
                        document.getElementById('uploadProgressBar').style.width = '0%';
                        currentMediaFile = null;
                        loadDashboardReports('day');
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                } catch(e) {
                    Swal.fire('Error', 'Server error', 'error');
                }
            } else {
                Swal.fire('Error', 'Upload failed', 'error');
            }
        };
        xhr.send(formData);
    };

    let allReportsData = [];

    async function loadDashboardReports(filter = 'day') {
        currentFilter = filter;
        document.getElementById('reportsContainer').innerHTML = '<div class="text-center py-5"><div class="loader"></div><p class="mt-2">Loading dashboard...</p></div>';
        try {
            const response = await fetch('reports.php?action=get_all_reports');
            allReportsData = await response.json();
            let filteredReports = filterReportsByDate(allReportsData, filter);
            updateStats(filteredReports);
            const groupedReports = groupReports(filteredReports, filter);
            displayGroupedReports(groupedReports);
            document.querySelectorAll('.filter-date').forEach(btn => {
                btn.classList.remove('active');
                if (btn.getAttribute('data-filter') === filter) btn.classList.add('active');
            });
        } catch(e) {
            document.getElementById('reportsContainer').innerHTML = '<div class="alert alert-danger">Error loading dashboard</div>';
        }
    }

    function filterReportsByDate(reports, filter) {
        const now = new Date();
        const today = new Date(now.getFullYear(), now.getMonth(), now.getDate());
        return reports.filter(report => {
            const reportDate = new Date(report.report_date);
            switch(filter) {
                case 'day': return reportDate.toDateString() === today.toDateString();
                case 'week': { const weekAgo = new Date(today); weekAgo.setDate(today.getDate() - 7); return reportDate >= weekAgo; }
                case 'month': return reportDate.getMonth() === now.getMonth() && reportDate.getFullYear() === now.getFullYear();
                case 'year': return reportDate.getFullYear() === now.getFullYear();
                default: return true;
            }
        });
    }

    function updateStats(reports) {
        document.getElementById('totalMedia').innerText = reports.length;
        document.getElementById('totalPhotos').innerText = reports.filter(r => getActualMediaType(r.file_name, r.media_type) === 'photo').length;
        document.getElementById('totalVideos').innerText = reports.filter(r => getActualMediaType(r.file_name, r.media_type) === 'video').length;
        document.getElementById('totalRoomsStat').innerText = new Set(reports.map(r => r.room_id)).size;
    }

    function groupReports(reports, filter) {
        const groups = {};
        reports.forEach(report => {
            const date = new Date(report.report_date);
            let groupKey;
            switch(filter) {
                case 'day': groupKey = `${date.getFullYear()}-${String(date.getMonth()+1).padStart(2,'0')}-${String(date.getDate()).padStart(2,'0')}`; break;
                case 'week': { const weekNum = Math.ceil(date.getDate() / 7); groupKey = `${date.getFullYear()}-W${weekNum}`; break; }
                case 'month': groupKey = `${date.getFullYear()}-${String(date.getMonth()+1).padStart(2,'0')}`; break;
                case 'year': groupKey = `${date.getFullYear()}`; break;
                default: groupKey = `${date.getFullYear()}-${String(date.getMonth()+1).padStart(2,'0')}`;
            }
            if (!groups[groupKey]) groups[groupKey] = [];
            groups[groupKey].push(report);
        });
        return Object.keys(groups).sort().reverse().map(key => ({ key, items: groups[key] }));
    }

    function displayGroupedReports(groupedReports) {
        if (groupedReports.length === 0) {
            document.getElementById('reportsContainer').innerHTML = '<div class="text-center text-muted py-5"><i class="fas fa-folder-open fa-3x mb-3"></i><p>No reports found</p></div>';
            return;
        }

        let html = '';
        groupedReports.forEach((group, index) => {
            const roomDetails = roomDetailsMap;
            html += `
                <div class="group-container">
                    <div class="group-header" onclick="toggleGroup(${index})">
                        <div class="d-flex justify-content-between align-items-center">
                            <div><i class="fas fa-calendar-alt me-2"></i><strong>${group.key}</strong><span class="badge bg-light text-dark ms-2">${group.items.length} items</span></div>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                    <div class="group-content" id="group-${index}">
                        <div class="row">
            `;

            group.items.forEach(item => {
                const room = roomDetails[item.room_id] || {};
                const mediaUrl = item.file_name;
                const actualType = getActualMediaType(mediaUrl, item.media_type);
                const isVideo = (actualType === 'video');
                const correctedUrl = getCorrectFileUrl(mediaUrl, actualType);

                if (!isVideo) {
                    html += `
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="media-card">
                                <div class="media-thumb" onclick="showMediaPreview('${mediaUrl}', '${actualType}')">
                                    <img src="${correctedUrl}" alt="Room ${item.room_no}" loading="lazy" onerror="this.src='https://via.placeholder.com/300x200?text=No+Image'">
                                    <span class="media-type-badge"><i class="fas fa-camera me-1"></i>Photo</span>
                                </div>
                                <div class="media-info">
                                    <span class="room-badge"><i class="fas fa-door-open me-1"></i> ${escapeHtml(room.floor || item.floor)} - Room ${escapeHtml(item.room_no)}</span>
                                    ${room.description ? `<div class="small text-muted mt-1">${escapeHtml(room.description.substring(0, 60))}</div>` : ''}
                                    <div class="geo-text"><i class="fas fa-map-marker-alt me-1"></i>${item.geo_address ? escapeHtml(item.geo_address.substring(0, 40)) : 'No location'}</div>
                                    <div class="geo-text"><i class="fas fa-clock me-1"></i>${new Date(item.created_at).toLocaleString()}</div>
                                    <div class="mt-2"><span class="badge bg-light"><i class="fas fa-compress-alt"></i> ${item.compressed_size_formatted}</span></div>
                                </div>
                                <div class="action-buttons">
                                    <button class="action-btn share-btn" onclick="event.stopPropagation(); shareToWhatsApp('${mediaUrl}', '${escapeHtml(item.room_no)}', '${escapeHtml(room.floor || item.floor)}', '${new Date(item.created_at).toLocaleString()}', '${escapeHtml(item.geo_address || 'IGIPESS')}', '${actualType}')" title="Share on WhatsApp">
                                        <i class="fab fa-whatsapp"></i>
                                    </button>
                                    <button class="action-btn delete-btn" onclick="event.stopPropagation(); deleteRecord(${item.id}, '${mediaUrl}', '${actualType}')" title="Delete Record">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                } else {
                    html += `
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="media-card">
                                <div class="media-thumb" onclick="showMediaPreview('${mediaUrl}', '${actualType}')" style="position:relative; cursor:pointer; background:#000;">
                                    <video class="video-thumb-img" preload="metadata" muted style="width:100%; height:100%; object-fit:cover;">
                                        <source src="${correctedUrl}" type="video/mp4">
                                    </video>
                                    <div class="play-overlay">
                                        <i class="fas fa-play"></i>
                                    </div>
                                    <span class="media-type-badge"><i class="fas fa-video me-1"></i>Video</span>
                                </div>
                                <div class="media-info">
                                    <span class="room-badge"><i class="fas fa-door-open me-1"></i> ${escapeHtml(room.floor || item.floor)} - Room ${escapeHtml(item.room_no)}</span>
                                    ${room.description ? `<div class="small text-muted mt-1">${escapeHtml(room.description.substring(0, 60))}</div>` : ''}
                                    <div class="geo-text"><i class="fas fa-map-marker-alt me-1"></i>${item.geo_address ? escapeHtml(item.geo_address.substring(0, 40)) : 'No location'}</div>
                                    <div class="geo-text"><i class="fas fa-clock me-1"></i>${new Date(item.created_at).toLocaleString()}</div>
                                    <div class="mt-2"><span class="badge bg-light"><i class="fas fa-compress-alt"></i> ${item.compressed_size_formatted}</span></div>
                                </div>
                                <div class="action-buttons">
                                    <button class="action-btn share-btn" onclick="event.stopPropagation(); shareToWhatsApp('${mediaUrl}', '${escapeHtml(item.room_no)}', '${escapeHtml(room.floor || item.floor)}', '${new Date(item.created_at).toLocaleString()}', '${escapeHtml(item.geo_address || 'IGIPESS')}', '${actualType}')" title="Share on WhatsApp">
                                        <i class="fab fa-whatsapp"></i>
                                    </button>
                                    <button class="action-btn delete-btn" onclick="event.stopPropagation(); deleteRecord(${item.id}, '${mediaUrl}', '${actualType}')" title="Delete Record">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                }
            });

            html += `</div></div></div>`;
        });

        document.getElementById('reportsContainer').innerHTML = html;
    }

    window.toggleGroup = function(index) {
        const content = document.getElementById(`group-${index}`);
        const header = content.previousElementSibling;
        content.classList.toggle('collapsed');
        header.classList.toggle('collapsed');
    };

    window.showMediaPreview = function(url, type) {
        currentModalMediaUrl = url;
        currentModalMediaType = type;
        const fullUrl = getCorrectFileUrl(url, type);
        const modalContent = document.getElementById('modalMediaContent');
        if (type === 'photo') {
            modalContent.innerHTML = `<img src="${fullUrl}" class="modal-media" style="max-width: 100%; max-height: 80vh;">`;
        } else {
            modalContent.innerHTML = `<video controls autoplay class="modal-media" style="max-width: 100%; max-height: 80vh;">
                                        <source src="${fullUrl}" type="video/mp4">
                                      </video>`;
        }
        modal.show();
    };

    window.shareToWhatsApp = shareToWhatsApp;
    window.shareCurrentMedia = shareCurrentMedia;
    window.openCalendarPicker = openCalendarPicker;
    window.deleteRecord = deleteRecord;
    window.loadAdminRecords = loadAdminRecords;
    window.editRecordNotes = editRecordNotes;
    window.deleteAllForDate = deleteAllForDate;

    function formatBytes(bytes) {
        if (!bytes) return '0 B';
        const sizes = ['B', 'KB', 'MB'];
        const i = Math.floor(Math.log(bytes) / Math.log(1024));
        return parseFloat((bytes / Math.pow(1024, i)).toFixed(1)) + ' ' + sizes[i];
    }

    function escapeHtml(str) {
        if (!str) return '';
        return String(str).replace(/[&<>]/g, (m) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;' }[m]));
    }

    window.filterRooms = filterRooms;
    window.filterByFloor = filterByFloor;
    window.selectRoom = selectRoom;
    window.loadDashboardReports = loadDashboardReports;
    window.toggleGroup = toggleGroup;
    window.showMediaPreview = showMediaPreview;

    loadRooms();
    loadDashboardReports('day');
    getGeoLocation();
</script>
</body>
</html>