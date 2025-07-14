<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
require '../config/db.php';
$result = $conn2->query("SELECT * FROM meetings ORDER BY date_time ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Meeting</title>
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

        /* NAMA */
        .Nama {
            text-align: left;
            margin-top: 10px;
            padding: 35px 210px 5px;
            font-size: 30px;
            font-weight: 600;
        }

        /* CONTENT */
        .content {
            padding: 40px;
            max-width: 1000px;
            margin: auto;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            margin-top: 10px;
        }

        .content h2 {
            color: #0077b6;
            margin-bottom: 20px;
        }

        .content p {
            font-size: 16px;
            line-height: 1.6;
            color: #333;
        }

        .add-btn {
            background-color: #0077b6;
            color: white;
            padding: 10px 18px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: background 0.3s ease;
        }

        .add-btn:hover {
            background-color: #005f91;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 24px;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        th, td {
            padding: 14px 16px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #0077b6;
            color: white;
        }

        td a {
            margin-right: 8px;
            text-decoration: none;
            font-weight: 500;
        }

        .edit-btn {
            color: #0077b6;
        }

        .delete-btn {
            color: #d90429;
        }

        .edit-btn:hover, .delete-btn:hover {
            text-decoration: underline;
        }

        .empty-message {
            margin-top: 20px;
            font-style: italic;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <div class="title">E-Meeting</div>
    <div class="nav-links">
        <a href="../public/dashboard.php">Dashboard</a>
        <a href="../meeting/list_meetings.php">Meeting</a>
        <a href="../calender.php">Calendar</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<!-- Content -->
<div class="content">
    <h2>Daftar Jadwal Meeting</h2>
    <a class="add-btn" href="add_meeting.php">+ Tambah Jadwal Meeting</a>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Waktu</th>
                <th>Guest</th>
                <th>Lokasi</th>
                <th>Aksi</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= htmlspecialchars($row['description']) ?></td>
                    <td><?= htmlspecialchars($row['date_time']) ?></td>
                    <td><?= htmlspecialchars($row['guest']) ?></td>
                    <td><?= htmlspecialchars($row['location']) ?></td>
                    <td>
                        <a class="edit-btn" href="edit_meeting.php?id=<?= $row['id'] ?>">Edit</a>
                        <a class="delete-btn" href="delete_meeting.php?id=<?= $row['id'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p class="empty-message">Belum ada jadwal meeting.</p>
    <?php endif; ?>
</div>

</body>
</html>
