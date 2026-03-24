<?php
session_start();
include 'db_connect.php'; // Include the DB connection

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit();
}

$user_id = $_SESSION['user_id']; // Get logged-in user's ID

// Query to get users that the logged-in user has messaged
$sql = "SELECT DISTINCT u.user_id, u.username FROM users u
        INNER JOIN messages m ON m.sender_id = u.user_id OR m.receiver_id = u.user_id
        WHERE (m.sender_id = ? OR m.receiver_id = ?) AND u.user_id != ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("iii", $user_id, $user_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

$contacts = [];
while ($row = $result->fetch_assoc()) {
    $contacts[] = $row;
}

echo json_encode($contacts);
?>
