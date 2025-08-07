<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "sql206.infinityfree.com";
$username   = "if0_39634793";
$password   = "testingbdserver";
$dbname     = "if0_39634793_pbdouting";

// DB connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Get input
$name     = $_POST['name'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($name) || empty($password)) {
    echo '<div style="text-align:center;">
            <p style="color:red; font-size:18px;">❌ Please fill in all fields.</p>
            <img src="MuaKissGIF.gif" alt="Error GIF" style="width:200px;">
          </div>';
    exit;
}

// ✅ Check if name is "admin" for admin login
if (strtolower($name) === "admin") {
    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $adminResult = $stmt->get_result();

    if ($adminResult->num_rows === 1) {
        $admin = $adminResult->fetch_assoc();
        if ($password === $admin['password']) {
            // Success: go to admin dashboard
            header("Location: admindashboard.php");
            exit;
        } else {
            // Wrong admin password
            echo '<div style="text-align:center;">
                    <p style="color:red; font-size:18px;">❌ Wrong password.</p>
                    <img src="MuaKissGIF.gif" alt="Error GIF" style="width:200px;">
                  </div>';
            exit;
        }
    } else {
        // Not an admin
        echo '<div style="text-align:center;">
                <p style="color:red; font-size:18px;">❌ You\'re not admin 🤣</p>
                <img src="MuaKissGIF.gif" alt="Error GIF" style="width:200px;">
              </div>';
        exit;
    }
}

// ✅ Otherwise: check student login
$stmt = $conn->prepare("SELECT * FROM students WHERE name = ?");
$stmt->bind_param("s", $name);
$stmt->execute();
$studentResult = $stmt->get_result();

if ($studentResult->num_rows === 1) {
    $student = $studentResult->fetch_assoc();

    if (password_verify($password, $student['password'])) {
        // Success
        $_SESSION['student_id'] = $student['id'];
        $_SESSION['student_name'] = $student['name'];
        header("Location: studentportal.html");
        exit;
    } else {
        // Wrong password
        echo '<div style="text-align:center;">
                <p style="color:red; font-size:18px;">❌ Invalid name or password.</p>
                <img src="MuaKissGIF.gif" alt="Error GIF" style="width:200px;">
              </div>';
        exit;
    }
} else {
    // Name not found
    echo '<div style="text-align:center;">
            <p style="color:red; font-size:18px;">❌ You\'re not registered broo 🤣.</p>
            <img src="MuaKissGIF.gif" alt="Error GIF" style="width:200px;">
          </div>';
    exit;
}
?>
