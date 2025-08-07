<?php
// Database connection
$servername = "sql206.infinityfree.com";
$username   = "if0_39634793";
$password   = "testingbdserver";  // ✅ Correct from your screenshot
$dbname     = "if0_39634793_pbdouting";


$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form input
$name = $_POST['name'];
$course = $_POST['course'];
$semester = $_POST['semester'];
$plainPassword = $_POST['password'];

// Hash password
$hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

// Insert into DB
$sql = "INSERT INTO students (name, course, semester, password, device_token)
        VALUES (?, ?, ?, ?, NULL)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $name, $course, $semester, $hashedPassword);

if ($stmt->execute()) {
    echo "✅ Registration successful! You can now log in.";
} else {
    echo "❌ Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
