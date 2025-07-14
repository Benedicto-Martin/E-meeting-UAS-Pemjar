<?php
require '../config/google-config2.php';
if (!isset($_GET['code'])) {
    die('Error: No authentication code provided.');
}
$token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
$client->setAccessToken($token);

// Simpan token ke dalam sesi atau database
$_SESSION['google_token'] = $token;

header('Location: ../public/dashboard.php'); // Redirect ke dashboard aplikasi
exit();
?>