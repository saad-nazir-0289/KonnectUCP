<?php
include 'db.php';

$result = $conn->query("SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.user_id ORDER BY created_at DESC");

$posts = [];
while ($row = $result->fetch_assoc()) {
    $posts[] = $row;
}

echo json_encode($posts);
$conn->close();
?>
