<?php
session_start();
require 'config/google-config.php';
if (!isset($_SESSION['access_token'])) {
    die('Harap login dengan Google!');
}

$client->setAccessToken($_SESSION['access_token']);
$calendarService = new Google_Service_Calendar($client);
$event = new Google_Service_Calendar_Event([
    'summary' => 'Rapat E-Meeting',
    'start' => ['dateTime' => '2025-05-20T10:00:00+07:00'],
    'end' => ['dateTime' => '2025-05-20T11:00:00+07:00'],
]);

$calendarId = 'primary';
$event = $calendarService->events->insert($calendarId,$event);

echo "Acara berhasil ditambahkan: " . $event->htmlLink;
?>
