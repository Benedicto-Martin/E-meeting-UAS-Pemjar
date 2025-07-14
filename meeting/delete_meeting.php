<?php
session_start();
require '../config/db.php';
require '../config/google-config.php';

// Validasi ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("❌ ID meeting tidak valid.");
}

$meetingId = (int) $_GET['id'];

// Cek apakah user sudah login Google
if (!isset($_SESSION['access_token'])) {
    die("❌ Akses ditolak. Silakan login ke Google terlebih dahulu.");
}

$client = new Google_Client();
$client->setAccessToken($_SESSION['access_token']);
$calendarService = new Google_Service_Calendar($client);

// Ambil event_id dari database
$stmt = $conn2->prepare("SELECT event_id FROM meetings WHERE id = ?");
$stmt->bind_param("i", $meetingId);
$stmt->execute();
$result = $stmt->get_result();
$meeting = $result->fetch_assoc();

if (!$meeting) {
    die("❌ Data meeting tidak ditemukan di database.");
}

$eventId = $meeting['event_id'];

// Hapus dari Google Calendar jika eventId ada
if (!empty($eventId)) {
    try {
        $calendarService->events->delete('primary', $eventId);
    } catch (Google_Service_Exception $e) {
        $error = json_decode($e->getMessage(), true);
        if (
            $error['error']['code'] === 410 &&
            $error['error']['errors'][0]['reason'] === 'deleted'
        ) {
            echo "⚠️ Event sudah dihapus sebelumnya dari Google Calendar.<br>";
        } else {
            echo "❌ Gagal menghapus dari Google Calendar: " . $e->getMessage() . "<br>";
        }
    }
} else {
    echo "ℹ️ Event belum pernah disinkronkan ke Google Calendar.<br>";
}

// Hapus dari database lokal
$stmt = $conn2->prepare("DELETE FROM meetings WHERE id = ?");
$stmt->bind_param("i", $meetingId);
$stmt->execute();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Meeting Dihapus</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f6fafd;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #0077b6;
            padding: 16px 32px;
            color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar .title {
            font-size: 20px;
            font-weight: 600;
        }
        .navbar .nav-links a {
            color: #fff;
            text-decoration: none;
            margin-left: 20px;
            font-weight: 500;
        }
        .navbar .nav-links a:hover {
            text-decoration: underline;
        }
        .container {
            max-width: 700px;
            margin: 50px auto;
            background: #fff;
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            text-align: center;
        }
        .container h2 {
            color: #0077b6;
            margin-bottom: 20px;
        }
        .message {
            font-size: 16px;
            margin: 10px 0;
            color: #333;
        }
        .back-link {
            margin-top: 30px;
            display: inline-block;
            background-color: #0077b6;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
        }
        .back-link:hover {
            background-color: #005f91;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <div class="title">E-Meeting</div>
    <div class="nav-links">
        <a href="../public/dashboard.php">Dashboard</a>
        <a href="../calender.php">Calendar</a>
        <a href="../logout.php">Logout</a>
    </div>
</div>

<!-- Main Content -->
<div class="container">
    <h2>✅ Jadwal Meeting Dihapus</h2>
    <div class="message">✅ Jadwal meeting berhasil dihapus dari aplikasi.</div>
    <a class="back-link" href="list_meetings.php">⬅️ Kembali ke Daftar Meeting</a>
</div>

</body>
</html>
