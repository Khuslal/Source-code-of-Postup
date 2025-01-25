<?php
session_start();
include "db_conn.php";

// Check if the user is logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit();
}
$username = $_SESSION['username'];

// Initialize variables
$post_id = '';
$post_title = '';
$category = '';
$post_text = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get post data
    $post_id = isset($_POST['post_id']) ? $_POST['post_id'] : null;
    $post_title = $_POST['post_title'];
    $category = $_POST['category'];
    $post_text = $_POST['post_text'];

    // Initialize variables for image and video
    $image_url = '';
    $video_url = '';
    $uploadOk = 1; // Flag to check if the file was uploaded successfully
    $target_dir = "uploads/"; // Directory to store uploaded files

    // Ensure the uploads directory exists
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true); // 0777 is the default mode for directories
    }

    // Handle image upload
    if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] == 0) {
        $imageFileType = strtolower(pathinfo(basename($_FILES['image_url']['name']), PATHINFO_EXTENSION));
        $target_file_image = $target_dir . uniqid() . '.' . $imageFileType;

        $check = getimagesize($_FILES["image_url"]["tmp_name"]);
        if ($check === false) {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed for images.";
            $uploadOk = 0;
        }

        if ($_FILES["image_url"]["size"] > 1024 * 1024 * 50) {
            echo "Sorry, your image file is too large.";
            $uploadOk = 0;
        }

        if ($uploadOk && move_uploaded_file($_FILES["image_url"]["tmp_name"], $target_file_image)) {
            $image_url = $target_file_image;
        } else {
            echo "Sorry, there was an error uploading your image file.";
        }
    }

    // Handle video upload
    if (isset($_FILES['video_url']) && $_FILES['video_url']['error'] == 0) {
        $videoFileType = strtolower(pathinfo(basename($_FILES['video_url']['name']), PATHINFO_EXTENSION));
        $target_file_video = $target_dir . uniqid() . '.' . $videoFileType;

        if (!in_array($videoFileType, ['mp4', 'mov', 'avi'])) {
            echo "Sorry, only MP4, MOV & AVI files are allowed for videos.";
            $uploadOk = 0;
        }

        // 1 kb = 1024 bytes, 1024*1024*100 = 100MB
        if ($_FILES["video_url"]["size"] > 1024 * 1024 * 100) {
            echo "Sorry, your video file is too large.";
            $uploadOk = 0;
        }

        if ($uploadOk && move_uploaded_file($_FILES["video_url"]["tmp_name"], $target_file_video)) {
            $video_url = $target_file_video;
        } else {
            echo "Sorry, there was an error uploading your video file.";
        }
    }

    if ($uploadOk) {
        // Insert new post data into the database
        $sql = "INSERT INTO post (post_id, username, fname, post_title, category, post_text, image_url, video_url) VALUES (?, ?, ?, ?, ?, ?, ?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('isssssss', $post_id, $username, $_SESSION['fname'], $post_title, $category, $post_text, $image_url, $video_url);
        if ($stmt->execute()) {
            header("Location: home.php");
            exit();
        } else {
            echo "Error connecting database: " . $stmt->error;
        }
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Post Form</title>
    <link rel="stylesheet" href="css/upload.css">
</head>

<body>
    <?php include 'header.php'; ?>
    <main>
        <div class="edit-container">
            <h2><?php echo 'Create Post'; ?></h2>
            <form action="" method="post" enctype="multipart/form-data">

                <label for="post_title">Post Title:</label>
                <input type="text" id="post_title" name="post_title" value="<?php echo htmlspecialchars($post_title); ?>" required>

                <label for="category">Category:</label>
                <input type="text" id="category" name="category" value="<?php echo htmlspecialchars($category); ?>" required>

                <label for="post_text">Post Text:</label>
                <textarea id="post_text" name="post_text" rows="10" required><?php echo htmlspecialchars($post_text); ?></textarea>

                <label for="image_upload">Upload Image:</label>
                <input type="file" id="image_upload" name="image_url" accept="image/jpeg, image/png, image/gif, image/webp">

                <label for="video_upload">Upload Video:</label>
                <input type="file" id="video_upload" name="video_url" accept="video/mp4, video/*">

                <button type="submit"><?php echo $post_id ? 'Update' : 'Submit'; ?></button>
            </form>
        </div>
    </main>
</body>

</html>