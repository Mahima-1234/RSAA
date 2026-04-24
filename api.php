<?php
session_start();
header('Content-Type: application/json');

// 1. Load Configuration
if (file_exists('config.php')) {
    require_once 'config.php';
}

// 2. File Paths
$dataFile = 'data.json';
$inquiriesFile = 'inquiries.json';

$action = $_GET['action'] ?? '';

// 3. Helper Functions
function sendResponse($success, $message, $data = null) {
    echo json_encode(['success' => $success, 'message' => $message, 'data' => $data]);
    exit;
}

// --- Public: Get Data ---
if ($action === 'get_data') {
    if (file_exists($dataFile)) {
        echo file_get_contents($dataFile);
    } else {
        sendResponse(false, 'Data file not found');
    }
    exit;
}

// --- Public: Submit Inquiry ---
if ($action === 'submit_inquiry') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (!$input) sendResponse(false, 'Invalid data');

    $inquiries = [];
    if (file_exists($inquiriesFile)) {
        $temp = json_decode(file_get_contents($inquiriesFile), true);
        if (is_array($temp)) $inquiries = $temp;
    }

    $input['id'] = uniqid();
    $input['timestamp'] = date('Y-m-d H:i:s');
    $input['resolved'] = false;
    
    array_unshift($inquiries, $input);

    if (file_put_contents($inquiriesFile, json_encode($inquiries, JSON_PRETTY_PRINT))) {
        sendResponse(true, 'Inquiry saved successfully');
    } else {
        sendResponse(false, 'Failed to save inquiry');
    }
}

// --- Admin: Login Logic (The Fix) ---
if ($action === 'login') {
    $input = json_decode(file_get_contents('php://input'), true);
    $password = $input['password'] ?? '';
    
    // 1. Get password from config.php, default to 'admin123' if missing
    $savedPassword = defined('ADMIN_PASSWORD') ? ADMIN_PASSWORD : 'admin123';
    
    $isValid = false;

    // 2. Check if it's a Secure Hash (starts with $2y$)
    if (strpos($savedPassword, '$2y$') === 0) {
        if (password_verify($password, $savedPassword)) {
            $isValid = true;
        }
    } else {
        // 3. Check if it's Plain Text (Simple mode)
        if ($password === $savedPassword) {
            $isValid = true;
        }
    }

    if ($isValid) { 
        $_SESSION['admin_logged_in'] = true;
        sendResponse(true, 'Login successful');
    } else {
        sendResponse(false, 'Invalid password');
    }
}

// --- Middleware: Check Auth ---
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    if ($action === 'check_auth') sendResponse(false, 'Not logged in');
    if ($action !== 'login') sendResponse(false, 'Unauthorized');
}

// --- Admin Actions ---

if ($action === 'check_auth') sendResponse(true, 'Logged in');

if ($action === 'logout') {
    session_destroy();
    sendResponse(true, 'Logged out');
}

if ($action === 'save_data') {
    $newData = file_get_contents('php://input');
    if (json_decode($newData) === null) sendResponse(false, 'Invalid JSON');
    if (file_put_contents($dataFile, $newData)) {
        sendResponse(true, 'Saved');
    } else {
        sendResponse(false, 'Save failed');
    }
}

if ($action === 'upload_image') {
    if (!isset($_FILES['image'])) sendResponse(false, 'No file');
    $uploadDir = 'uploads/';
    if (!file_exists($uploadDir)) mkdir($uploadDir, 0755, true);
    $fileName = time() . '_' . basename($_FILES['image']['name']);
    $targetPath = $uploadDir . $fileName;
    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
        $url = "$protocol://$_SERVER[HTTP_HOST]" . dirname($_SERVER['PHP_SELF']) . "/$targetPath";
        sendResponse(true, 'Upload successful', ['url' => $url]);
    } else {
        sendResponse(false, 'Upload failed');
    }
}

if ($action === 'get_inquiries') {
    if (file_exists($inquiriesFile)) { echo file_get_contents($inquiriesFile); } 
    else { echo json_encode([]); }
    exit;
}

if ($action === 'update_inquiry_status') {
    $input = json_decode(file_get_contents('php://input'), true);
    $id = $input['id'] ?? null;
    $resolved = $input['resolved'] ?? false;
    if (!$id) sendResponse(false, 'ID required');
    
    $inquiries = file_exists($inquiriesFile) ? json_decode(file_get_contents($inquiriesFile), true) : [];
    $updated = false;
    
    foreach ($inquiries as &$inq) {
        if (isset($inq['id']) && $inq['id'] === $id) {
            $inq['resolved'] = $resolved;
            $updated = true; break;
        }
    }
    
    if ($updated) {
        file_put_contents($inquiriesFile, json_encode($inquiries, JSON_PRETTY_PRINT));
        sendResponse(true, 'Status updated');
    } else {
        sendResponse(false, 'Inquiry not found');
    }
}

if ($action === 'delete_inquiry') {
    $input = json_decode(file_get_contents('php://input'), true);
    $id = $input['id'] ?? null;
    if (!$id) sendResponse(false, 'ID required');
    
    $inquiries = file_exists($inquiriesFile) ? json_decode(file_get_contents($inquiriesFile), true) : [];
    $initialCount = count($inquiries);
    $inquiries = array_values(array_filter($inquiries, function($inq) use ($id) {
        return isset($inq['id']) && $inq['id'] !== $id;
    }));

    if (count($inquiries) < $initialCount) {
        file_put_contents($inquiriesFile, json_encode($inquiries, JSON_PRETTY_PRINT));
        sendResponse(true, 'Inquiry deleted');
    } else {
        sendResponse(false, 'Inquiry not found');
    }
}

if ($action === 'download_inquiries') {
    $inquiries = file_exists($inquiriesFile) ? json_decode(file_get_contents($inquiriesFile), true) : [];
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=inquiries_export_" . date('Y-m-d') . ".xls");
    
    echo '<table border="1"><thead><tr style="background:#D4AF37;color:#fff;">
    <th>Date</th><th>Name</th><th>Phone</th><th>Service</th><th>Mode</th><th>Urgency</th><th>Resolved</th><th>Message</th>
    </tr></thead><tbody>';
    
    if (is_array($inquiries)) {
        foreach ($inquiries as $row) {
            $bg = ($row['resolved'] ?? false) ? '#e6fffa' : '#ffffff';
            echo "<tr style='background-color: {$bg};'>";
            echo "<td>" . ($row['timestamp'] ?? '') . "</td>";
            echo "<td>" . ($row['name'] ?? '') . "</td>";
            echo "<td>" . ($row['phone'] ?? '') . "</td>";
            echo "<td>" . ($row['service'] ?? '') . "</td>";
            echo "<td>" . ($row['mode'] ?? '') . "</td>";
            echo "<td>" . ($row['urgency'] ?? 'Normal') . "</td>";
            echo "<td>" . (($row['resolved'] ?? false) ? 'Yes' : 'No') . "</td>";
            echo "<td>" . ($row['message'] ?? '') . "</td>";
            echo "</tr>";
        }
    }
    echo '</tbody></table>';
    exit;
}
?>