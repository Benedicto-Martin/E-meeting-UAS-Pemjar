<?php
session_start();
require '../config/db.php';
require '../config/google-config.php';

// Pastikan user sudah login ke Google
if (!isset($_SESSION['access_token'])) {
    die("Error: Anda belum login ke Google.");
}

$client->setAccessToken($_SESSION['access_token']);
$calendarService = new Google_Service_Calendar($client);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title       = $_POST['title'];
    $description = $_POST['description'];
    $date_time   = $_POST['date_time'];
    $location    = $_POST['location'];
    $guest       = $_POST['guest']; // email tamu, pisahkan dengan koma

    // Simpan ke database terlebih dahulu
    $stmt = $conn2->prepare("INSERT INTO meetings (title, description, date_time, location, guest) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $title, $description, $date_time, $location, $guest);

    if ($stmt->execute()) {
        $meeting_id = $stmt->insert_id;

        // Siapkan waktu
        $start = new DateTime($date_time, new DateTimeZone('Asia/Jakarta'));
        $end = clone $start;
        $end->modify('+1 hour');

        $startTime = $start->format(DateTime::ATOM); // ISO 8601 format
        $endTime = $end->format(DateTime::ATOM);

        // Buat event Google Calendar
        $event = new Google_Service_Calendar_Event([
            'summary'     => $title,
            'description' => $description,
            'start'       => [
                'dateTime' => $startTime,
                'timeZone' => 'Asia/Jakarta',
            ],
            'end'         => [
                'dateTime' => $endTime,
                'timeZone' => 'Asia/Jakarta',
            ],
            'location'    => $location
        ]);

        // Tambahkan tamu undangan jika ada
        if (!empty($guest)) {
            $emails = array_map('trim', explode(',', $guest));
            $attendees = [];
            foreach ($emails as $email) {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $attendees[] = ['email' => $email];
                }
            }
            if (!empty($attendees)) {
                $event->setAttendees($attendees);
            }
        }

        // Kirim ke Google Calendar dengan pengiriman email ke tamu
        $createdEvent = $calendarService->events->insert(
            'primary',
            $event,
            ['sendUpdates' => 'all'] // ⬅️ inilah kunci agar undangan dikirim via email
        );

        // Simpan event_id ke database
        $event_id = $createdEvent->getId();
        $update = $conn2->prepare("UPDATE meetings SET event_id = ? WHERE id = ?");
        $update->bind_param("si", $event_id, $meeting_id);
        $update->execute();

    } else {
        echo "❌ Gagal menyimpan jadwal.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Meeting Ditambahkan</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: #f6fafd;
        }

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

        .container {
            max-width: 700px;
            margin: 50px auto;
            background: #fff;
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            text-align: center;
        }

        .container h2 {
            color: #0077b6;
            margin-bottom: 20px;
        }

        .message {
            font-size: 16px;
            color: #333;
            margin-bottom: 16px;
        }

        .calendar-link {
            display: inline-block;
            margin: 8px;
            background-color: #0077b6;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
        }

        .calendar-link:hover {
            background-color: #005f91;
        }
    </style>
</head>
<body>

<div class="navbar">
    <div class="title">E-Meeting</div>
    <div class="nav-links">
        <a href="../public/dashboard.php">Dashboard</a>
        <a href="../calender.php">Calendar</a>
        <a href="../logout.php">Logout</a>
    </div>
</div>

<div class="container">
    <h2>✅ Jadwal Meeting Ditambahkan</h2>
    <div class="message">
        Jadwal meeting "<strong><?= htmlspecialchars($title) ?></strong>" telah berhasil ditambahkan dan diundang melalui Google Calendar.
    </div>
    <a class="calendar-link" href="<?= $createdEvent->htmlLink ?>" target="_blank">📅 Lihat di Google Calendar</a>
    <a class="calendar-link" href="list_meetings.php">⬅️ Kembali ke Daftar Meeting</a>
</div>

</body>
</html>
