<?php
session_start();
if (!isset($_SESSION['student_id']) || !isset($_SESSION['student_name'])) {
    header("Location: studentlogin.html");
    exit;
}

$servername = "sql206.infinityfree.com";
$username = "if0_39634793";
$password = "testingbdserver";
$dbname = "if0_39634793_pbdouting";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$studentId = $_SESSION['student_id'];
$studentName = $_SESSION['student_name'];

$sql = "SELECT * FROM applications WHERE student_id = ? ORDER BY id DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $studentId);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="ms">
<head>
  <meta charset="UTF-8">
  <title>Status Permohonan - Pelajar</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f4f8fc;
      padding: 30px;
    }
    h2 {
      color: #004466;
    }
    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }
    .btn {
      background-color: #007bff;
      color: white;
      border: none;
      padding: 10px 16px;
      border-radius: 6px;
      font-weight: bold;
      cursor: pointer;
      margin-left: 8px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      background-color: #fff;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    th, td {
      padding: 12px;
      border-bottom: 1px solid #ddd;
      text-align: center;
    }
    th {
      background-color: #006699;
      color: white;
    }
    @media print {
      .btn, .top-bar a {
        display: none !important;
      }
    }
  </style>
</head>
<body>

  <div class="top-bar">
    <h2>Status Permohonan Anda</h2>
    <div>
      <button class="btn" onclick="window.print()">Print PDF</button>
      <a href="logout.php"><button class="btn">Logout</button></a>
    </div>
  </div>

  <table>
    <tr>
      <th>Bil</th>
      <th>Nama</th>
      <th>Destinasi</th>
      <th>Sebab</th>
      <th>Tarikh</th>
      <th>Status</th>
      <th>Disemak Oleh</th>
    </tr>
    <?php $num = 1; while ($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= $num++ ?></td>
      <td><?= htmlspecialchars($row['student_name']) ?></td>
      <td><?= htmlspecialchars($row['destination']) ?></td>
      <td><?= htmlspecialchars($row['reason']) ?></td>
      <td><?= htmlspecialchars($row['date']) ?></td>
      <td><?= htmlspecialchars($row['status']) ?></td>
      <td><?= htmlspecialchars($row['approved_by'] ?? '-') ?></td>
    </tr>
    <?php endwhile; ?>
  </table>

</body>
</html>
