<?php
session_start();
require_once "db_connect.php";

$sql = "SELECT tasks.task_id, tasks.title, tasks.description, users.username 
        FROM tasks 
        JOIN users ON tasks.user_id = users.user_id 
        ORDER BY tasks.created_at DESC";

$result = $mysqli->query($sql);
$tasks = [];

while ($row = $result->fetch_assoc()) {
    $tasks[] = $row;
}

echo json_encode($tasks);
?>
