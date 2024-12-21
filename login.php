<?php
// Start the session
session_start();
// Include the database configuration file
include 'db_config.php';

// Retrieve the username and password from the POST request
$username = $_POST['username'];
$password = $_POST['password'];

// Query the database for the user with the given username
$sql = "SELECT * FROM users WHERE username = '$username'";
$result = $conn->query($sql);

// Check if the query returned any results (i.e., if the user exists)
if ($result->num_rows > 0) {
    // Fetch the user data from the result set

    /* The fetch_assoc() "ASSOCIATIVE" method is a function in PHP that fetches a result row as an associative array. 
     It returns the data from a database query in the form of an array where the keys are 
     the column names of the table. It allows you to access the data in 
     a more readable and meaningful way using the column names. */
    $row = $result->fetch_assoc();
    // Verify the password entered by the user against the hashed password in the database
    if (password_verify($password, $row['password'])) {
        // If the password is correct, set a session variable for the username
        $_SESSION['username'] = $username;
        // Redirect the user to the home page (index.php)
        header("Location: index.html");
        // Ensure the script stops executing after the redirect
        exit();
    } else {
        // If the password is incorrect, display an error message
        echo "Invalid password";
    }
} else {
    // If no user is found with the given username, display an error message
    echo "No user found";
}

// Close the database connection
$conn->close();
