<?php
session_start();
include 'db_connect.php'; // Include your database connection file

if (!isset($_SESSION['user_id'])) {
    echo "Please log in to send messages.";
    exit();
}

$sender_id = $_SESSION['user_id'];  // Logged-in user ID
$receiver_id = isset($_POST['receiver_id']) ? $_POST['receiver_id'] : null;
$content = isset($_POST['content']) ? $_POST['content'] : null;

if (!$receiver_id || !$content) {
    echo "Missing receiver or content.";
    exit();
}

// Insert message into the database
$sql = "INSERT INTO messages (sender_id, receiver_id, content) VALUES (?, ?, ?)";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("iis", $sender_id, $receiver_id, $content);

if ($stmt->execute()) {
    echo "success";  // Respond success if the message is sent
} else {
    echo "Error: " . $stmt->error;
}
?>
