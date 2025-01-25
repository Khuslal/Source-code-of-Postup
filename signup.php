<?php
include 'db_conn.php';

function validate_username($username)
{
    return strlen($username) >= 5;
}

function validate_password($password)
{
    // Checks for at least one uppercase, number, character, and a minimum length of 8 characters
    return strlen($password) >= 8 &&
        preg_match('/[A-Z]/', $password) &&
        preg_match('/[0-9]/', $password) &&
        preg_match('/[\W_]/', $password);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!validate_username($username)) {
        $error = "Username must contain at least 5 characters.";
    } elseif (!validate_password($password)) {
        $error = "Password must contain at least one capital letter, one special character, one number, and be at least 8 characters long.";
    } else {
        // Hash the password before storing it in the database
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Check if username already exists
        $check_user = $conn->prepare('SELECT * FROM users WHERE username = ?');
        $check_user->bind_param("s", $username);
        $check_user->execute();
        $check_user->store_result();

        if ($check_user->num_rows > 0) {
            $error = "Username already exists.";
        } else {
            // Insert new user if username does not exist
            $new_user = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $new_user->bind_param("ss", $username, $hashed_password);

            if ($new_user->execute()) {
                // Set session variables upon successful signup
                session_start();
                $_SESSION['username'] = $username;
                $_SESSION['loggedin'] = true;

                // Redirect to setProfile.php page
                header("Location: setProfile.php");
                exit();
            } else {
                $error = "Error: " . $new_user->error;
            }
            $new_user->close();
        }
        $check_user->close();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Signup</title>
    <link rel="stylesheet" href="css/signup.css">
</head>

<body>
    <main>
        <div class="container">
            <form action="" method="post">
                <h1>Post Up</h1>
                <h5>Please Signup To Continue</h5>
                <?php if (isset($error)) : ?>
                    <p style="color:red;"><?php echo $error; ?></p>
                <?php endif; ?>

                <label for="username">Username:</label>
                <input type="text" id="username" name="username" placeholder="username" required>
                <br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="password" required>
                <br>
                <button type="submit">Signup</button>
                <a href="index.php" id="signuplink">Click here to login</a>
            </form>
        </div>
    </main>
</body>

</html>