<?php
require '../config/db.php';
$id = $_GET['id'];
$result = $conn2->query("SELECT * FROM meetings WHERE id = $id");
$meeting = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Jadwal Meeting</title>
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
            margin-bottom: 20px;
        }

        form label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
            color: #333;
        }

        form input[type="text"],
        form input[type="datetime-local"],
        form textarea {
            width: 100%;
            padding: 10px 14px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-family: 'Inter', sans-serif;
            font-size: 15px;
        }

        form textarea {
            resize: vertical;
            min-height: 80px;
        }

        .form-buttons {
            display: flex;
            gap: 12px;
        }

        button {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
        }

        button[type="submit"] {
            background-color: #0077b6;
            color: white;
        }

        button[type="submit"]:hover {
            background-color: #005f91;
        }

        button.cancel-btn {
            background-color: #e0e0e0;
            color: #333;
        }

        button.cancel-btn:hover {
            background-color: #ccc;
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

<!-- Content -->
<div class="content">
    <h2>Edit Jadwal Meeting</h2>
    <form action="update_meeting.php" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($meeting['id']); ?>">

        <label>Judul Meeting:</label>
        <input type="text" name="title" value="<?= htmlspecialchars($meeting['title']); ?>" required>

        <label>Deskripsi:</label>
        <textarea name="description"><?= htmlspecialchars($meeting['description']); ?></textarea>

        <label>Tanggal & Waktu:</label>
        <input type="datetime-local" name="date_time" value="<?= date('Y-m-d\TH:i', strtotime($meeting['date_time'])); ?>" required>

        <label>Lokasi:</label>
        <input type="text" name="location" value="<?= htmlspecialchars($meeting['location']); ?>">

        <label>Guest (email, pisahkan dengan koma):</label>
        <input type="text" name="guest" placeholder="user1@example.com, user2@example.com" value="<?= htmlspecialchars($meeting['guest']); ?>">

        <div class="form-buttons">
            <button type="submit">Simpan Perubahan</button>
            <button type="button" class="cancel-btn" onclick="window.history.back()">Batal</button>
        </div>
    </form>
</div>

</body>
</html>
