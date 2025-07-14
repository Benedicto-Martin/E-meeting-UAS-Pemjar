<?php
$host1     = 'localhost';     // biasanya 'localhost'
$username1 = 'root';          // username MySQL (default XAMPP: root)
$password1 = '';              // password MySQL (default XAMPP: kosong)
$database1 = 'e_meeting';     // nama database kamu

$conn1 = new mysqli($host1, $username1, $password1, $database1);

// Cek koneksi
if ($conn1->connect_error) {
    die("Koneksi database gagal: " . $conn1->connect_error);
}


$host2     = 'localhost';     // biasanya 'localhost'
$username2 = 'root';          // username MySQL (default XAMPP: root)
$password2 = '';              // password MySQL (default XAMPP: kosong)
$database2 = 'emeeting_db';     // nama database kamu

$conn2 = new mysqli($host2, $username2, $password2, $database2);

// Cek koneksi
if ($conn2->connect_error) {
    die("Koneksi database gagal: " . $conn2->connect_error);
}
?>
