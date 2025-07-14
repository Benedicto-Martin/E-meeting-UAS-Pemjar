<?php
session_start();
require 'config/google-config.php';

if (!isset($_GET['code'])) {
    die('Kode tidak ditemukan');
}

// PERBAIKAN DI SINI (hilangkan tanda `-` dan pindahkan ke baris atas)
$token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

if (isset($token['error'])) {
    die('Gagal mengambil token akses: ' . htmlspecialchars($token['error']));
}

// Simpan token di session
$_SESSION['access_token'] = $token;

// Redirect ke dashboard
header("Location: public/dashboard.php");
exit();
?>
