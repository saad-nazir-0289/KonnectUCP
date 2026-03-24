<?php
session_start();
require_once "db_connect.php"; // Ensure database connection

if (!isset($_SESSION['user_id'])) {
    echo "User not logged in";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $user_id = $_SESSION['user_id'];

    if (empty($title) || empty($description)) {
        echo "Title and description cannot be empty.";
        exit;
    }

    $stmt = $mysqli->prepare("INSERT INTO tasks (user_id, title, description) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $title, $description);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "Error: " . $mysqli->error;
    }

    $stmt->close();
}
?>
