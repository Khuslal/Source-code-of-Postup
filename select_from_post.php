<?php

// Check if the user is logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit();
}
$username = $_SESSION['username'];

// Fetch posts from the database
$sql_posts = "SELECT fname, username, post_title, category, post_text, image_url, video_url, created_at FROM post ORDER BY post_id DESC";
$stmt_posts = $conn->prepare($sql_posts);
if (!$stmt_posts) {
    die('Database Error : ' . $conn->error);
}
$stmt_posts->execute();
$posts_result = $stmt_posts->get_result();
$posts = $posts_result->fetch_all(MYSQLI_ASSOC);
$stmt_posts->close();
