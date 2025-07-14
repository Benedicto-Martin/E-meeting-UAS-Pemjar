<?php
session_start();

require '../config/google-config.php';
require '../config/db.php';

if (!isset($_SESSION['access_token'])) {
    die("Error: Anda belum login ke Google.");
}

$client->setAccessToken($_SESSION['access_token']);
$calendarService = new Google_Service_Calendar($client);

// Ambil data dari form
$id          = $_POST['id'];
$title       = $_POST['title'];
$description = $_POST['description'];
$date_time   = $_POST['date_time'];
$guest       = $_POST['guest']; // email tamu, pisahkan koma

// Validasi input
if (empty($id) || empty($title) || empty($date_time)) {
    die("Error: Data tidak lengkap.");
}

// Update database lokal
$stmt = $conn2->prepare("UPDATE meetings SET title = ?, description = ?, date_time = ?, guest = ? WHERE id = ?");
$stmt->bind_param("ssssi", $title, $description, $date_time, $guest, $id);
$stmt->execute();

// Ambil event_id
$result = $conn2->query("SELECT event_id FROM meetings WHERE id = $id");
$meeting = $result->fetch_assoc();
$eventId = $meeting['event_id'];

if (empty($eventId)) {
    die("Error: Meeting ini belum pernah disinkronkan ke Google Calendar.");
}

// Siapkan waktu mulai & akhir
$start = new DateTime($date_time, new DateTimeZone('Asia/Jakarta'));
$end = clone $start;
$end->modify('+1 hour');

$startTime = $start->format(DateTime::ATOM);
$endTime = $end->format(DateTime::ATOM);

// Ambil event dari Google Calendar
$event = $calendarService->events->get('primary', $eventId);

// Set data baru
$event->setSummary($title);
$event->setDescription($description);
$event->setStart(new Google_Service_Calendar_EventDateTime([
    'dateTime' => $startTime,
    'timeZone' => 'Asia/Jakarta'
]));
$event->setEnd(new Google_Service_Calendar_EventDateTime([
    'dateTime' => $endTime,
    'timeZone' => 'Asia/Jakarta'
]));

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

// Kirim update ke Google Calendar + kirim email undangan ke guest
$updatedEvent = $calendarService->events->update(
    'primary',
    $eventId,
    $event,
    ['sendUpdates' => 'all'] // ⬅️ inilah bagian penting
);

// Sukses
echo "✅ Event berhasil diperbarui: <a href='" . $updatedEvent->htmlLink . "' target='_blank'>Lihat di Google Calendar</a>";
?>
