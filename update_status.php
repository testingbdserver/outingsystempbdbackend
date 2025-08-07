<?php
session_start();

$studentId = $_SESSION['student_id'] ?? null;
if (!$studentId) {
    http_response_code(403);
    exit("❌ Not logged in.");
}

$servername = "sql206.infinityfree.com";
$username   = "if0_39634793";
$password   = "testingbdserver";
$dbname     = "if0_39634793_pbdouting";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    http_response_code(500);
    exit("❌ Database connection error.");
}

// Get POST data
$data = json_decode(file_get_contents("php://input"), true);
$status = strtoupper(trim($data['status'] ?? ''));
$lat = $data['lat'] ?? null;
$lon = $data['lon'] ?? null;

// Validate status
if (!in_array($status, ['IN', 'OUT'])) {
    http_response_code(400);
    exit("❌ Invalid status.");
}

// Handle location (can be null)
$location = ($lat !== null && $lon !== null) ? "$lat, $lon" : "Unknown";

// Insert into DB
$stmt = $conn->prepare("INSERT INTO student_log (student_id, status, location) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $studentId, $status, $location);

if ($stmt->execute()) {
    echo "✅ Status updated to $status!";
} else {
    http_response_code(500);
    echo "❌ Failed to update status.";
}
?>
