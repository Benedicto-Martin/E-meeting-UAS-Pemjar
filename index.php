<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Meeting</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

        * {
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #f6fafd;
            color: #1e1e2f;
            padding: 40px;
        }

        .container1 {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            max-width: 1200px;
            margin: auto;
            gap: 40px;
        }

        .left {
            flex: 1;
        }

        .right {
            flex: 1;
            display: flex;
            justify-content: center;
        }

        h1 {
            font-size: 42px;
            font-weight: 700;
            color: #1d1d40;
            margin-bottom: 20px;
        }

        .subjudul p {
            font-size: 18px;
            margin-bottom: 30px;
            color: #555;
        }

        .clock {
            font-size: 16px;
            margin-bottom: 30px;
            color: #888;
        }

        .btn a {
            display: inline-block;
            margin-right: 15px;
            background-color: #0077b6;
            color: white;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            transition: background 0.3s;
        }

        .btn a:hover {
            background-color: #005f91;
        }

        .btn a.secondary {
            background-color: #d1ecf6;
            color: #0077b6;
        }

        .illustration {
            width: 100%;
            max-width: 500px;
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        }

    </style>
</head>
<body>
    <div class="container1">
        <div class="left">
            <div class="Judul">
                <?php echo "<h1>Selamat Datang di Aplikasi E-Meeting</h1>"; ?>
            </div>

            <div class="subjudul">
                <?php echo "<p>Ini adalah platform untuk mengatur jadwal meeting dengan Google Calendar API.</p>"; ?>
            </div>

            <p class="clock">Waktu Lokal: <span id="clock"></span></p>

            <div class="btn">
                <a href="google/login_google.php">Login</a>
                <a href="public/register.php" class="secondary">Register</a>
            </div>
        </div>

        <div class="right">
            <img src="pngwing.com (13).png" alt="Illustration" class="illustration">
        </div>
    </div>

    <script>
        // Fungsi untuk memperbarui waktu lokal dari perangkat
        function updateClock() {
            const now = new Date();
            const options = {
                year: 'numeric',
                month: 'long',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };
            document.getElementById("clock").innerHTML = now.toLocaleString('id-ID', options);
        }

        setInterval(updateClock, 1000);
        updateClock();
    </script>
</body>
</html>
