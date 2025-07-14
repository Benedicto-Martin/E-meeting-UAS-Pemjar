<?php
require '../config/google-config.php';
$auth_url = $client->createAuthUrl();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Google</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');

        body {
            background-color: #f6fafd;
            font-family: 'Inter', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-box {
            background-color: #fff;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            text-align: center;
            width: 100%;
            max-width: 380px;
        }

        .login-box img.logo {
            width: 50px;
            margin-bottom: 20px;
        }

        .login-box h2 {
            margin-bottom: 30px;
            color: #1e1e2f;
            font-size: 22px;
        }

        .google-login-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #0077b6;
            color: #fff;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 600;
            transition: background 0.3s ease;
        }

        .google-login-btn:hover {
            background-color: #005f91;
        }

        .google-login-btn img {
            width: 20px;
            height: 20px;
            margin-right: 10px;
        }
    </style>
</head>
<body>

<div class="login-box">
    <img src="../google.png" alt="Google Logo" class="logo">
    <h2>Masuk ke E-Meeting</h2>
    <a href="<?= $auth_url ?>" class="google-login-btn">
        <img src="../google.png" alt="logo">
        Login dengan Google
    </a>
</div>

</body>
</html>
