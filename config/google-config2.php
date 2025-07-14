<?php
require __DIR__ . '/../vendor/autoload.php';
$client = new Google_Client();
$client->setAuthConfig(__DIR__ . '/credentials.json');
$client->setScopes(Google_Service_Calendar::CALENDAR);
$client->setRedirectUri('http://localhost/e_meeting/google-callback.php');
$client->setAccessType('offline');
?>