<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $servername = "sql206.infinityfree.com";
    $username   = "if0_39634793";
    $password   = "testingbdserver";
    $dbname     = "if0_39634793_pbdouting";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $inputUsername, $inputPassword);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $_SESSION['admin_username'] = $inputUsername;
        header("Location: adminportal.html");
        exit;
    } else {
        $error = "Invalid login";
    }
}
?>

<!DOCTYPE html>
<html lang="ms">
<head>
  <meta charset="UTF-8">
  <title>Admin Login</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #e9f5ff;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .login-box {
      background-color: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 6px 18px rgba(0,0,0,0.1);
      width: 300px;
    }
    h2 {
      text-align: center;
      color: #004466;
    }
    input[type="text"], input[type="password"] {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
    button {
      width: 100%;
      padding: 12px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 6px;
      font-weight: bold;
      cursor: pointer;
    }
    .error {
      color: red;
      text-align: center;
    }
  </style>
</head>
<body>

<div class="login-box">
  <h2>Admin Login</h2>
  <?php if (isset($error)): ?>
    <p class="error"><?= $error ?></p>
  <?php endif; ?>
  <form method="POST">
    <input type="text" name="username" placeholder="Admin Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
  </form>
</div>

</body>
</html>
