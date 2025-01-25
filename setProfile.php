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

// Function to validate email format
function validate_email($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('/@gmail\.com$/', $email);
}

// Function to validate fname (only alphabetic characters and spaces)
function validate_fname($fname)
{
    return preg_match('/^[a-zA-Z\s]+$/', $fname);
}

// Connection prepared! To get the previous value of profile while editing.
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
    die('Database error: ' . $conn->error);
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Set Profile</title>
    <link rel="stylesheet" href="css/setProfile.css">
</head>

<body>
    <main>
        <header>
            <h1>Postup</h1>
            <nav>
                <a href="logout.php">Logout</a>
            </nav>
        </header>
        <div class="edit-container">
            <h2>Edit Profile</h2>
            <form id="editProfileForm" action="profile.php" method="post" onsubmit="return validateForm()">
                <label for="nameInput">Name:</label>
                <input type="text" id="nameInput" name="fname" required value="<?php echo htmlspecialchars($user_data['fname']); ?>">

                <label for="emailInput">Email:</label>
                <input type="email" id="emailInput" name="email" required value="<?php echo htmlspecialchars($user_data['email']); ?>">

                <label for="phoneInput">Phone:</label>
                <input type="tel" id="phoneInput" name="phone" required value="<?php echo htmlspecialchars($user_data['phone']); ?>">

                <label for="bio">About me:</label>
                <textarea id="bioInput" name="bio"><?php echo htmlspecialchars($user_data['bio']); ?></textarea>

                <button type="submit">Save Changes</button>
            </form>
        </div>
    </main>

    <script>
        function validateForm() {
            var fname = document.getElementById('nameInput').value;
            var email = document.getElementById('emailInput').value;
            var fnameRegex = /^[a-zA-Z\s]+$/; // \s is for space.
            var emailRegex = /^[^\s@]+@gmail\.com$/; // ^[^\s@]+@gmail\.com$ means no spaces, @gmail, and no spaces

            if (!fnameRegex.test(fname)) {
                alert('Name must contain only letters and spaces.');
                return false;
            }

            if (!emailRegex.test(email)) {
                alert('Please enter a valid Gmail address.');
                return false;
            }

            return true;
        }
    </script>
</body>

</html>