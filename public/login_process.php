<?php
session_start();
require '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn1->prepare("SELECT id, name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        // Email tidak ditemukan
        echo "Email tidak terdaftar. Silakan <a href='register.php'>daftar</a> terlebih dahulu.";
    } else {
        // Email ditemukan, cek password
        $stmt->bind_result($id, $name, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            // Password cocok, login berhasil
            $_SESSION['user_id'] = $id;
            $_SESSION['user_name'] = $name;
            header("Location: dashboard.php"); // Redirect ke dashboard
            exit();
        } else {
            // Password salah
            echo "Password salah. Silakan coba lagi.";
        }
    }

    $stmt->close();
    $conn1->close();
}
?>
