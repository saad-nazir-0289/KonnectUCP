<?php
session_start();
include 'db_connect.php'; // Make sure this file is correctly included

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Error: User not logged in.");
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Check if both title and content are provided
if (!isset($_POST['title']) || !isset($_POST['content'])) {
    die("Error: Missing post data.");
}

$title = $_POST['title'];
$content = $_POST['content'];

// Prepare SQL query
$sql = "INSERT INTO posts (user_id, title, content) VALUES (?, ?, ?)";
$stmt = $mysqli->prepare($sql);

if (!$stmt) {
    die("Prepare failed: " . $mysqli->error);
}

// Bind parameters (user_id, title, content)
$stmt->bind_param("iss", $user_id, $title, $content);

// Execute query
if ($stmt->execute()) {
    echo "Post added successfully!";
} else {
    echo "Error: " . $stmt->error;
}

// Close statement and connection
$stmt->close();
$mysqli->close();
?>
