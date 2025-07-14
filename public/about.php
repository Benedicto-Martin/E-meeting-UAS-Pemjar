<?php
// Mulai session jika dibutuhkan
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tentang Aplikasi - E-Meeting</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f4f4f4;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
        }
        p {
            font-size: 16px;
            color: #555;
            line-height: 1.6;
        }
        a {
            text-decoration: none;
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tentang Aplikasi E-Meeting</h1>
        <p>
            Aplikasi E-Meeting adalah sebuah platform berbasis web yang dirancang untuk mempermudah proses rapat secara daring. 
            Pengguna dapat menjadwalkan meeting, mengelola peserta, serta melihat riwayat rapat yang telah selesai. 
            Aplikasi ini dibangun menggunakan PHP dan MySQL sebagai backend, serta struktur folder MVC untuk kemudahan pengembangan.
        </p>
        <p>
            <a href="index.php">Kembali ke Beranda</a>
        </p>
    </div>
</body>
</html>