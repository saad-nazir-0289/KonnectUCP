<?php
$host = "localhost";
$user = "root";  // Change if needed
$password = "";  // Change if needed
$database = "dbproject";

$mysqli = new mysqli($host, $user, $password, $database);
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>
