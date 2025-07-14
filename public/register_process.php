<?php
require '../config/db.php'; // Koneksi ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password

    // Cek apakah email sudah terdaftar
    $check = $conn1->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "Email sudah terdaftar. Silakan gunakan email lain atau <a href='login.php'>login</a>.";
    } else {
        // Jika email belum terdaftar, lanjutkan registrasi
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $password);

        if ($stmt->execute()) {
            echo "Registrasi berhasil! Silakan <a href='login.php'>login</a>";
        } else {
            echo "Gagal mendaftar!";
        }
    }

    // Tutup statement
    $check->close();
    if (isset($stmt)) $stmt->close();
    $conn->close();
}
?>
