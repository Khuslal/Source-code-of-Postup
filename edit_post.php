<?php
session_start();
include 'db_conn.php';


// Check if the user is logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit();
}
$username = $_SESSION['username'];

// Fetch the post ID from the URL
$post_id = isset($_GET['post_id']) ? (int)$_GET['post_id'] : 0;

if ($post_id > 0) {
    $sql = "SELECT * FROM post WHERE post_id = ? AND username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('is', $post_id, $username); // 'i' for integer and 's' for string
    $stmt->execute();
    $result = $stmt->get_result();
    $post = $result->fetch_assoc();
    $stmt->close();

    if (!$post) {
        echo "Post not found.";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_title = $_POST['post_title'];
    $category = $_POST['category'];
    $post_text = $_POST['post_text'];
    $image_url = $post['image_url']; // Default to current image if no new image is uploaded
    $video_url = $post['video_url']; // Default to current video if no new video is uploaded
    $uploadOk = 1;
    $target_dir = "uploads/";

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true); // 0777 is default mode for directories
    }

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

        if ($_FILES["image_url"]["size"] > 10000000) {
            echo "Sorry, your image file is too large.";
            $uploadOk = 0;
        }

        if ($uploadOk && move_uploaded_file($_FILES["image_url"]["tmp_name"], $target_file_image)) {
            $image_url = $target_file_image;
        } else {
            echo "Sorry, there was an error uploading your image file.";
        }
    }

    if (isset($_FILES['video_url']) && $_FILES['video_url']['error'] == 0) {
        $videoFileType = strtolower(pathinfo(basename($_FILES['video_url']['name']), PATHINFO_EXTENSION));
        $target_file_video = $target_dir . uniqid() . '.' . $videoFileType;

        if (!in_array($videoFileType, ['mp4', 'mov', 'avi'])) {
            echo "Sorry, only MP4, MOV & AVI files are allowed for videos.";
            $uploadOk = 0;
        }

        if ($_FILES["video_url"]["size"] > 50000000) {
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
        $sql = "UPDATE post SET post_title = ?, category = ?, post_text = ?, image_url = ?, video_url = ? WHERE post_id = ? AND username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssssis', $post_title, $category, $post_text, $image_url, $video_url, $post_id, $username);

        if ($stmt->execute()) {
            header("Location: profile.php");
            exit();
        } else {
            echo "Error updating record: " . $stmt->error;
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <link rel="stylesheet" href="css/upload.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <div class="edit-container">
            <h2>Edit Post</h2>
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($post['post_id']); ?>">

                <label for="post_title">Post Title:</label>
                <input type="text" id="post_title" name="post_title" value="<?php echo htmlspecialchars($post['post_title']); ?>" required>

                <label for="category">Category:</label>
                <input type="text" id="category" name="category" value="<?php echo htmlspecialchars($post['category']); ?>" required>

                <label for="post_text">Post Text:</label>
                <textarea id="post_text" name="post_text" rows="10" required><?php echo htmlspecialchars($post['post_text']); ?></textarea>

                <label for="image_upload">Upload Image:</label>
                <input type="file" id="image_upload" name="image_url" accept="image/jpeg, image/png, image/gif, image/webp">

                <label for="video_upload">Upload Video:</label>
                <input type="file" id="video_upload" name="video_url" accept="video/mp4, video/*">

                <button type="submit">Update</button>
            </form>
        </div>
    </main>
</body>
</html>
