<?php

// Check if the user is logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit();
}
$username = $_SESSION['username'];
$sql = "SELECT fname, email, phone, bio, username FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die('Error on connecting to database: ' . $conn->error);
}
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();

if (!$user_data) {
    die('Database error: ' . $conn->error);
}
$stmt->close();
