<?php
session_start();
require 'config/google-config.php';
if (!isset($_SESSION['access_token'])) {
    die('Harap login dengan Google!');
}

$client->setAccessToken($_SESSION['access_token']);
$calendarService = new Google_Service_Calendar($client);

$calendarId = 'primary';
$events = $calendarService->events->listEvents($calendarId);

foreach ($events->getItems() as $event) {
    echo "<p>" . $event->getSummary() . " - " . $event->getStart()->getDateTime() . "</p>";
}
?>