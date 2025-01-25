<?php
session_start();
include 'db_conn.php';


// Check if the user is logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit();
}
$username = $_SESSION['username'];

header('Content-Type: application/json'); // Ensure the content type is JSON

function fetchPosts($conn)
{
    $sql = "SELECT post_title, post_text, category, image_url, video_url, created_at FROM post ORDER BY created_at DESC";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

$posts = fetchPosts($conn);
echo json_encode($posts);
$conn->close();
