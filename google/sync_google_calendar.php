<?php
session_start(); // Tambahkan ini!

require '../config/google-config2.php';
require '../config/db.php';


if (!isset($_SESSION['access_token'])) {
    die("Error: Silakan login ke Google terlebih dahulu.");
}

$client->setAccessToken($_SESSION['access_token']);
$calendarService = new Google_Service_Calendar($client);

// Ambil data meeting dari database
$meeting_id = $_GET['id'];
$result = $conn2->query("SELECT * FROM meetings WHERE id = $meeting_id");

if ($result && $result->num_rows > 0) {
    $meeting = $result->fetch_assoc();

    $event = new Google_Service_Calendar_Event([
        'summary'     => $meeting['title'],
        'description' => $meeting['description'],
        'start' => [
            'dateTime' => date('c', strtotime($meeting['date_time'])),
            'timeZone' => 'Asia/Jakarta',
        ],
        'end' => [
            'dateTime' => date('c', strtotime($meeting['date_time'] . ' +1 hour')),
            'timeZone' => 'Asia/Jakarta',
        ],
        'location' => $meeting['location']
    ]);


    $calendarId = 'primary';
    $event = $calendarService->events->insert($calendarId, $event);

    echo "Jadwal meeting berhasil dikirim ke Google Calendar: <a href='{$event->htmlLink}' target='_blank'>Lihat di Google Calendar</a>";
} else {
    echo "Data meeting tidak ditemukan.";
}
?>
