<?php
session_start();
include 'db_conn.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the username and password from the POST request
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Prepare and execute the query to retrieve the hashed password
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if the query returned any results (i.e., if the user exists)
        if ($result->num_rows > 0) {
            // Fetch the user data from the result set
            $row = $result->fetch_assoc();
            // Verify the password entered by the user against the hashed password in the database
            if (password_verify($password, $row['password'])) {
                // If the password is correct, set session variables
                $_SESSION['username'] = $username;
                $_SESSION['loggedin'] = true;

                // Redirect the user to the home page
                header("Location: home.php");
                exit();
            } else {
                // If the password is incorrect, display an error message
                $error = "Invalid password";
            }
        } else {
            // If no user is found with the given username, display an error message
            $error = "No user found";
        }
        $stmt->close();
    } else {
        $error = "Username and password field cannot be empty";
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" href="css/signup.css">
</head>

<body>
    <main>
        <div class="container">
            <form action="" method="post">
                <h1>Post Up</h1>
                <h5>Please Login To Continue</h5>
                <?php if (isset($error)): ?>
                    <p style="color:red;"><?php echo $error; ?></p>
                <?php endif; ?>
                <label for="username"> Username: </label>
                <input type="text" id="username" name="username" placeholder="username" required>
                <br>
                <label for="password"> Password: </label>
                <input type="password" id="password" name="password" placeholder="password" required>
                <br>
                <button type="submit">Login</button>
                <a id="signuplink" href="signup.php">New users? Click here to signup</a>
            </form>
        </div>
    </main>
</body>

</html>