<?php
session_start();
include 'db_conn.php';

// Check if the user is logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit();
}
$username = $_SESSION['username'];

error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'select_from_post.php';

?>
<?php include 'select_users_data.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <title>homepage</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <?php include 'header.php'; ?>
    <main>
        <h2>Home</h2>
        <div id="posts">
            <?php foreach ($posts as $post): ?>
                <div class="post">
                    <h2><?php echo htmlspecialchars($post['fname'] ?? ''); ?></h2>
                    <p>Uploaded at: <?php echo htmlspecialchars($post['created_at']); ?></p>
                    <h2><?php echo htmlspecialchars($post['post_title']); ?></h2>
                    <p><?php echo htmlspecialchars($post['category']); ?></p>
                    <p><?php echo nl2br(htmlspecialchars($post['post_text'])); ?></p>
                    <?php if ($post['image_url']): ?>
                        <img src="<?php echo htmlspecialchars($post['image_url']); ?>" alt="Image">
                    <?php endif; ?>
                    <?php if ($post['video_url']): ?>
                        <video controls>
                            <source src="<?php echo htmlspecialchars($post['video_url']); ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
    <?php
    // Close the database connection
    $conn->close();
    ?>
</body>

</html>