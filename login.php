

<?php

include 'db.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT user_id, password_hash FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($user_id, $password_hash);

    if ($stmt->fetch() ) {
      session_start();
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $username;
        echo "Login Successful";
    } else {
        echo "Invalid credentials";
    }

    $stmt->close();
    $conn->close();
}
?>
