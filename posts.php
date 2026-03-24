<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo "Unauthorized";
    exit;
}

$user_id = $_SESSION['user_id'];
$title = $_POST['title'];
$content = $_POST['content'];

$stmt = $conn->prepare("INSERT INTO posts (user_id, title, content) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $user_id, $title, $content);

if ($stmt->execute()) {
    echo "Post Created";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
