<?php
$host = "localhost";
$username = "root"; // Change if using a different user
$password = ""; // Change if you set a password
$dbname = "dbproject";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
