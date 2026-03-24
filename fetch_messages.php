<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit();
}

$user_id = $_SESSION['user_id'];
$contact_id = isset($_GET['contact_id']) ? $_GET['contact_id'] : 0;

if ($contact_id == 0) {
    echo json_encode(['error' => 'Invalid contact ID']);
    exit();
}

// Fetch messages
$sql = "SELECT message_id, sender_id, receiver_id, content, sent_at, 
               (sender_id = ?) AS is_sent 
        FROM messages 
        WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?)
        ORDER BY sent_at ASC";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("iiiii", $user_id, $user_id, $contact_id, $contact_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

echo json_encode($messages);
?>
