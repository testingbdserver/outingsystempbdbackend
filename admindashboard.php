<?php
// admindashboard.php
session_start();

$servername = "sql206.infinityfree.com";
$username   = "if0_39634793";
$password   = "testingbdserver";
$dbname     = "if0_39634793_pbdouting";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT s.*, l.status, l.location, l.timestamp
        FROM students s
        LEFT JOIN student_log l ON s.id = l.student_id
        ORDER BY s.name, l.timestamp DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f5f5f5;
      margin: 0;
      padding: 20px;
    }
    .container {
      max-width: 1100px;
      margin: auto;
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }
    h1 {
      color: #333;
    }
    .home-button {
      background-color: #007bff;
      color: white;
      padding: 10px 16px;
      border: none;
      border-radius: 6px;
      text-decoration: none;
      font-weight: bold;
    }
    input[type="text"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
    th {
      background-color: #f0f0f0;
    }
    tr:hover {
      background-color: #f9f9f9;
    }
    .status-out {
      color: red;
      font-weight: bold;
    }
    .status-in {
      color: green;
      font-weight: bold;
    }
    a {
      color: blue;
      text-decoration: underline;
    }
    @media print {
      .top-bar, #searchInput {
        display: none;
      }
    }
  </style>
  <script>
  function searchTable() {
    const input = document.getElementById("searchInput").value.toLowerCase();
    const rows = document.querySelectorAll("tbody tr");

    rows.forEach(row => {
      const rowText = row.innerText.toLowerCase();
      row.style.display = rowText.includes(input) ? "" : "none";
    });
  }
  </script>
</head>
<body>
<div class="container">
  <div class="top-bar">
    <h1>Admin Dashboard</h1>
    <a href="index.html" class="home-button">Home</a>
  </div>

  <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search the content">

  <table>
    <thead>
      <tr>
        <th>Bil</th>
        <th>Nama</th>
        <th>Kursus</th>
        <th>Semester</th>
        <th>Status</th>
        <th>Lokasi</th>
        <th>Kemaskini Terakhir</th>
        <th>Tarikh Daftar</th>
      </tr>
    </thead>
    <tbody>
    <?php 
    $bil = 1;
    while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $bil++ ?></td>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= htmlspecialchars($row['course']) ?></td>
        <td><?= htmlspecialchars($row['semester']) ?></td>
        <td>
          <?php
            if ($row['status'] === 'OUT') {
              echo '<span class="status-out">OUT</span>';
            } elseif ($row['status'] === 'IN') {
              echo '<span class="status-in">IN</span>';
            } else {
              echo '—';
            }
          ?>
        </td>
        <td>
          <?php 
            if (!empty($row['location'])) {
              $loc = htmlspecialchars($row['location']);
              echo "<a href=\"https://www.google.com/maps?q=$loc\" target=\"_blank\">$loc</a>";
            } else {
              echo '-';
            }
          ?>
        </td>
        <td><?= htmlspecialchars($row['timestamp'] ?? '-') ?></td>
        <td><?= htmlspecialchars($row['created_at']) ?></td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>
