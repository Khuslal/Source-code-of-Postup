<?php
include 'db_config.php';

$sql = "SELECT title, content FROM posts";
$result = $conn->query($sql);

$posts = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }
}
$conn->close();

echo json_encode($posts);
?>
