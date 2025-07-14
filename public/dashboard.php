<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard E-Meeting</title>
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
            max-width: 800px;
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

<div class="Nama">
    <span>Halo, <?= htmlspecialchars($_SESSION['user_name']); ?> 👋</span>
</div>

<!-- Content -->
<div class="content">
    <h2>Tentang Aplikasi</h2>
    <p>
        Selamat datang di <strong>E-Meeting</strong>! Platform ini dirancang untuk memudahkan Anda dalam
        mengatur jadwal rapat secara efisien menggunakan integrasi Google Calendar API.
    </p>
    <p>
        Fitur-fitur utama termasuk:
        <ul>
            <li>Membuat dan mengelola jadwal rapat.</li>
            <li>Integrasi langsung dengan akun Google Anda.</li>
            <li>Tampilan kalender yang interaktif dan mudah digunakan.</li>
        </ul>
    </p>
    <p>Gunakan menu navigasi di atas untuk mulai menjadwalkan pertemuan atau melihat kalender Anda.</p>
</div>

</body>
</html>
