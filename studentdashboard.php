<?php
session_start();

if (!isset($_SESSION['student_id']) || !isset($_SESSION['student_name'])) {
    header("Location: studentlogin.html");
    exit;
}

$studentId = $_SESSION['student_id'];
$studentName = $_SESSION['student_name'];

$servername = "sql206.infinityfree.com";
$username   = "if0_39634793";
$password   = "testingbdserver";
$dbname     = "if0_39634793_pbdouting";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("DB connection failed");
}

// Get latest status
$sql = "SELECT status, location, timestamp FROM student_log WHERE student_id = ? ORDER BY timestamp DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $studentId);
$stmt->execute();
$result = $stmt->get_result();
$latest = $result->fetch_assoc();

// Get full logs
$sql_log = "SELECT status, location, timestamp FROM student_log WHERE student_id = ? ORDER BY timestamp DESC";
$stmt_log = $conn->prepare($sql_log);
$stmt_log->bind_param("i", $studentId);
$stmt_log->execute();
$log_result = $stmt_log->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Pelajar</title>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f5f5f5;
            padding: 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            max-width: 700px;
            width: 100%;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 { text-align: center; color: #006699; }
        .info p { margin: 6px 0; }
        .status-in { color: green; font-weight: bold; }
        .status-out { color: red; font-weight: bold; }
        button {
            padding: 10px 20px;
            margin: 10px 5px;
            border: none;
            border-radius: 6px;
            background-color: #007bff;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }
        table {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            font-size: 14px;
            text-align: left;
        }
        th { background: #f2f2f2; }
        .logout a {
            text-decoration: none;
            color: white;
            background: #d9534f;
            padding: 10px 16px;
            border-radius: 6px;
            font-weight: bold;
        }
        .privacy {
            font-size: 12px;
            color: gray;
            margin-top: -10px;
            margin-bottom: 20px;
        }
        a.map-link {
            color: #006699;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome, <?= htmlspecialchars($studentName) ?></h2>

        <div class="info">
            <p><strong>Status:</strong>
                <?php if ($latest && $latest['status'] === 'OUT'): ?>
                    <span class="status-out">OUT</span>
                <?php elseif ($latest && $latest['status'] === 'IN'): ?>
                    <span class="status-in">IN</span>
                <?php else: ?>
                    Not Set
                <?php endif; ?>
            </p>
            <p><strong>Last Location:</strong>
                <?php
                if (!empty($latest['location']) && strpos($latest['location'], ',') !== false):
                    list($lat, $lon) = explode(",", $latest['location']);
                    $lat = trim($lat);
                    $lon = trim($lon);
                ?>
                    <a class="map-link" href="https://www.google.com/maps?q=<?= $lat ?>,<?= $lon ?>" target="_blank">
                        <?= $lat ?>, <?= $lon ?>
                    </a>
                <?php else: ?>
                    -
                <?php endif; ?>
            </p>
            <p><strong>Last Updated:</strong> <?= $latest['timestamp'] ?? '-' ?></p>
        </div>

        <div class="privacy">
            ⚠️ Lokasi anda hanya digunakan untuk merekod status keluar/masuk dan tidak dikongsi kepada pihak luar.
        </div>

        <div class="actions">
            <button onclick="sendStatus('OUT')">Keluar (OUT)</button>
            <button onclick="sendStatus('IN')">Masuk (IN)</button>
        </div>

        <div class="logs">
            <h3>Log Keluar/Masuk:</h3>
            <?php if ($log_result->num_rows > 0): ?>
                <table>
                    <tr><th>Status</th><th>Location</th><th>Time</th></tr>
                    <?php while ($row = $log_result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['status']) ?></td>
                            <td>
                                <?php
                                if (!empty($row['location']) && strpos($row['location'], ',') !== false):
                                    list($lat, $lon) = explode(",", $row['location']);
                                    $lat = trim($lat);
                                    $lon = trim($lon);
                                ?>
                                    <a class="map-link" href="https://www.google.com/maps?q=<?= $lat ?>,<?= $lon ?>" target="_blank">
                                        <?= $lat ?>, <?= $lon ?>
                                    </a>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($row['timestamp']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            <?php else: ?>
                <p>No outing log yet.</p>
            <?php endif; ?>
        </div>

        <div class="logout">
      
            <a href="logout.php">Logout</a>
        </div>
          <a href="studentstatus.php"><button class="btn">Lihat Status Permohonan</button></a>

    </div>

    <script>
    function sendStatus(status) {
        if (!navigator.geolocation) {
            alert("Browser tidak menyokong geolocation.");
            return;
        }

        if (!confirm("Aplikasi akan merekod lokasi anda semasa log " + status + ". Teruskan?")) {
            return;
        }

        navigator.geolocation.getCurrentPosition(
            function(position) {
                sendToServer(status, position.coords.latitude, position.coords.longitude);
            },
            function(error) {
                if (confirm("Tidak dapat akses lokasi. Teruskan tanpa lokasi?")) {
                    sendToServer(status, null, null);
                } else {
                    alert("Proses dibatalkan.");
                }
            }
        );
    }

    function sendToServer(status, lat, lon) {
        fetch("update_status.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ status: status, lat: lat, lon: lon })
        })
        .then(response => response.text())
        .then(msg => {
            alert(msg);
            location.reload();
        });
    }
    </script>
</body>
</html>
