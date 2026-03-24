<?php
session_start();
include 'db_connect.php';

if (!isset($_GET['user_id'])) {
    echo json_encode(['error' => 'No user ID provided']);
    exit();
}

$user_id = intval($_GET['user_id']);
$stmt = $mysqli->prepare("SELECT user_id, username FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user) {
    echo json_encode($user);
} else {
    echo json_encode(['error' => 'User not found']);
}
?>
