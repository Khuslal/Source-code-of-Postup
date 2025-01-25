<?php
session_start();
include 'db_conn.php';

// Check if the user is logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit();
}
$username = $_SESSION['username'];

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Handle form submission from setprofile.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST['fname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $bio = $_POST['bio'];
    // $username = $_SESSION['username'];

    // Update user information in the database
    $sql_users = "UPDATE users SET fname = ?, email = ?, phone = ?, bio = ? WHERE username = ?";
    $stmt = $conn->prepare($sql_users);
    if (!$stmt) {
        die('Error preparing statement: ' . $conn->error);
    }
    $stmt->bind_param('sssss', $fname, $email, $phone, $bio, $username);
    if ($stmt->execute()) {
        $message = "Profile updated successfully!";
    } else {
        $error = "Error updating profile: " . $stmt->error;
    }
    $stmt->close();

    // Update fname in the post table
    $sql_posts = "UPDATE post SET fname = ? WHERE username = ?";
    $stmt_posts = $conn->prepare($sql_posts);
    if (!$stmt_posts) {
        die('Error preparing statement: ' . $conn->error);
    }
    $stmt_posts->bind_param('ss', $fname, $username);
    $stmt_posts->execute();
    if (!$stmt_posts->execute()) {
        $error = " Error updating posts: " . $stmt_posts->error;
    }
    $stmt_posts->close();
}

// Profile bio-data code starts here
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
    die('Database error: ' . $stmt->error);
}
// Set the fname in session 
$_SESSION['fname'] = $user_data['fname'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="css/profile.css">
</head>

<body>
    <?php include 'header.php'; ?>
    <main>
        <?php if (isset($message)) : ?>
            <p style="color:green;" id=update_Profile><?php echo $message; ?></p>
        <?php endif; ?>
        <?php if (isset($error)) : ?>
            <p style="color:red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <h2>My Profile</h2>
        <!-- Display Bio-Data -->
        <div class="profile-container">
            <h4>Name: <?php echo htmlspecialchars($user_data['fname'] ?? ''); ?></h4>
            <p>Email: <?php echo htmlspecialchars($user_data['email'] ?? ''); ?></p>
            <p>Phone: <?php echo htmlspecialchars($user_data['phone'] ?? ''); ?></p>
            <p>About me: <?php echo htmlspecialchars($user_data['bio'] ?? ''); ?></p>
            <p>Username: <?php echo htmlspecialchars($user_data['username'] ?? ''); ?></p>
            <a href="setProfile.php">Edit Profile</a>
        </div>

        <?php
        // Fetch posts from the database
        $sql_posts = "SELECT post_id, username, fname, post_title, category,
         post_text, image_url, video_url, created_at FROM post WHERE username = ?
          ORDER BY post_id DESC";
        $stmt_posts = $conn->prepare($sql_posts);
        if (!$stmt_posts) {
            die('Database error: ' . $conn->error);
        }
        $stmt_posts->bind_param('s', $username);
        $stmt_posts->execute();
        $posts_result = $stmt_posts->get_result();
        $posts = $posts_result->fetch_all(MYSQLI_ASSOC);
        $stmt_posts->close();
        $conn->close();
        ?>

        <!-- Display user's posts -->
        <div class="posts-container">
            <?php if (count($posts) > 0): ?>
                <?php foreach ($posts as $post): ?>
                    <div class="post">
                        <h2><?php echo htmlspecialchars($post['fname'] ?? ''); ?></h2>
                        <a href="edit_post.php?post_id=<?php echo htmlspecialchars($post['post_id'] ?? ''); ?>">Edit</a>
                        <a href="delete_post.php?post_id=<?php echo htmlspecialchars($post['post_id']); ?>" onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
                        <p>Uploaded at: <?php echo htmlspecialchars($post['created_at'] ?? ''); ?></p><br>
                        <h2><?php echo htmlspecialchars($post['post_title'] ?? ''); ?></h2><br>
                        <p><?php echo htmlspecialchars($post['category'] ?? ''); ?></p><br>
                        <p><?php echo nl2br(htmlspecialchars($post['post_text'] ?? '')); ?></p><br>
                        <?php if (!empty($post['image_url'])): ?>
                            <img src="<?php echo htmlspecialchars($post['image_url']); ?>" alt="Image">
                        <?php endif; ?>
                        <br>
                        <?php if (!empty($post['video_url'])): ?>
                            <video controls>
                                <source src="<?php echo htmlspecialchars($post['video_url']); ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No posts found.</p>
            <?php endif; ?>
        </div>
    </main>
</body>

</html>