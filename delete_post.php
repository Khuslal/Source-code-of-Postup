<?php
session_start();
include 'db_conn.php'; // Database connection


// Check if the user is logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit();
}
$username = $_SESSION['username'];

// Enable error reporting for debugging
error_reporting(E_ALL); // for single error type use E_ERROR
// E_All constant enables all error reporting
ini_set('display_errors', 1);

/* Get the post ID from the URL
    Typecast to integer, if not set then 0 */
$post_id = isset($_GET['post_id']) ? (int)$_GET['post_id'] : 0;

// Check if the post ID is valid
if ($post_id > 0) {
    // Prepare the delete query
    $sql = "DELETE FROM post WHERE post_id = ? AND username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('is', $post_id, $username); // 'i' for integer and 's' for string
    if ($stmt->execute()) {
        header("Location: profile.php");
        exit();
    } else {
        echo "Error deleting post: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Invalid Post ID.";
}

$conn->close();
