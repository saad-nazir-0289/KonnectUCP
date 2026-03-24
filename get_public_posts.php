<?php
require 'db_connect.php';

$sql = "SELECT users.username, posts.title, posts.content, posts.created_at 
        FROM posts 
        JOIN users ON posts.user_id = users.user_id 
        ORDER BY posts.created_at DESC";
$result = $mysqli->query($sql);

$posts = [];
while ($row = $result->fetch_assoc()) {
    $posts[] = $row;
}

echo json_encode($posts);
?>
