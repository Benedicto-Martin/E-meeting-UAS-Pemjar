<?php
session_start();
require 'config/db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID meeting tidak valid.");
}

$meetingId = (int) $_GET['id'];
$stmt = $conn2->prepare("SELECT * FROM meetings WHERE id = ?");
$stmt->bind_param("i", $meetingId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Data meeting tidak ditemukan.");
}

$meeting = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Meeting</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: #f6fafd;
        }

        /* NAVBAR */
        .navbar {
            background-color: #0077b6;
            padding: 16px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #fff;
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

        /* CONTENT */
        .content {
            padding: 40px;
            max-width: 800px;
            margin: auto;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            margin-top: 20px;
        }

        .content h2 {
            color: #0077b6;
            margin-bottom: 24px;
        }

        .label {
            font-weight: 600;
            color: #333;
            margin-top: 12px;
        }

        .value {
            margin-bottom: 16px;
            color: #555;
        }

        .value a {
            text-decoration: none;
            color: #0077b6;
            font-weight: 500;
            margin-right: 10px;
        }

        .value a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <div class="title">E-Meeting</div>
    <div class="nav-links">
        <a href="public/dashboard.php">Dashboard</a>
        <a href="meeting/list_meetings.php">Meeting</a>
        <a href="calender.php">Calendar</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<!-- Content -->
<div class="content">
    <h2>Detail Meeting</h2>

    <div class="label">Judul:</div>
    <div class="value"><?= htmlspecialchars($meeting['title']) ?></div>

    <div class="label">Deskripsi:</div>
    <div class="value"><?= nl2br(htmlspecialchars($meeting['description'])) ?></div>

    <div class="label">Tanggal & Waktu:</div>
    <div class="value"><?= date('d M Y, H:i', strtotime($meeting['date_time'])) ?></div>

    <div class="label">Lokasi:</div>
    <div class="value"><?= htmlspecialchars($meeting['location']) ?></div>

    <div class="label">Tamu Undangan:</div>
    <div class="value"><?= htmlspecialchars($meeting['guest']) ?: '-' ?></div>

    <div class="label">Tindakan:</div>
    <div class="value">
        <a href="meeting/edit_meeting.php?id=<?= $meeting['id'] ?>">✏️ Edit</a>
        <a href="meeting/delete_meeting.php?id=<?= $meeting['id'] ?>" onclick="return confirm('Yakin ingin menghapus meeting ini?')">🗑️ Hapus</a>
        <a href="javascript:history.back()">⬅️ Kembali</a>
    </div>
</div>

</body>
</html>
