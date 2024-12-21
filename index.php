<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Postup</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <h1>Postup</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="profile.html">Profile</a>
            <a href="post.html">Post</a>
            <a href="feedback.html">Feedback</a>
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']): ?>
                <button>Logout</button>
            <?php else: ?>
                <a href="login.html">Login</a>
                <a href="signup.html">Signup</a>
            <?php endif; ?>
        </nav>
    </header>
    <main>
        <div id="posts"></div>
    </main>
    <script>
        // Hide login/signup form if logged in
        <?php if (isset($_SESSION['loggedin']) && $_SESSION['signedin']): ?>
            document.querySelector('.container').style.display = 'none';
        <?php endif; ?>
    </script>
    <script src="scripts.js"></script>
</body>

</html>