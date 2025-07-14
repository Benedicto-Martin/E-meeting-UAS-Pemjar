<?php
require 'config/db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$result = $conn2->query("SELECT * FROM meetings");
$events = [];
while ($row = $result->fetch_assoc()) {
    $events[] = [
        'title' => $row['title'],
        'start' => $row['date_time'],
        'url' => 'meeting_detail.php?id=' . $row['id']
    ];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kalender Meeting</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js"></script>
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
            max-width: 1000px;
            margin: auto;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            margin-top: 10px;
        }

        #calendar {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .fc-toolbar-title {
            color: #0077b6;
        }

        .fc-event {
            background-color: #ffffff !important;
            border: 1px solid #0077b6 !important;
            color: #0077b6 !important;
        }

        .fc-daygrid-event-dot {
            border-color: #0077b6 !important;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: <?php echo json_encode($events); ?>,
                eventClick: function (info) {
                    info.jsEvent.preventDefault();
                    if (info.event.url) {
                        window.location.href = info.event.url;
                    }
                }
            });
            calendar.render();
        });
    </script>
</head>
<body>

    <!-- NAVBAR -->
    <div class="navbar">
        <div class="title">E-Meeting Kalender</div>
        <div class="nav-links">
            <a href="public/dashboard.php">Dashboard</a>
            <a href="meeting/list_meetings.php">Meeting</a>
            <a href="calender.php">Calendar</a>
            <a href="logout.php">Logout</a>   
        </div>
    </div>

    <!-- Konten Kalender -->
    <div class="content">
        <div id="calendar"></div>
    </div>

</body>
</html>
