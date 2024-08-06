<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
</html>
<?php
session_start();
include('connect.php');

// Example: Assuming $userData is an array with user details fetched from the database
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $passwordEntered = $_POST['password'];

    // Retrieve the hashed password from the database using the username
    $getPasswordQuery = "SELECT password FROM users WHERE user_name = $1";
    $getPasswordResult = pg_query_params($conn, $getPasswordQuery, array($username));

    if (!$getPasswordResult) {
        echo 'Error: Query failed.\n';
        exit;
    }

    $hashedPassword = pg_fetch_result($getPasswordResult, 0);

    // Check if the username exists
    if (empty($hashedPassword)) {
        echo '<script>';
echo "Swal.fire({
    title: 'User not found!',
    text: 'Please check your username and try again.',
    icon: 'error'
}).then(function(){
    window.location.href = 'login.html';
})";
echo '</script>';

        exit;
    }

    // Verify the entered password against the hashed password
    if ($passwordEntered == $hashedPassword) {
        // Set $credentialsAreValid to true if the username and password are correct
        $credentialsAreValid = true;
        $_SESSION['user_name'] = $username; // Set user details in the session
        // Other user details can also be stored in the session

        // SweetAlert for successful login
        echo '<script>';
            echo "Swal.fire({
                title: 'Logged in Successfully !',
                text: 'Welcome back, $username!',
                icon: 'success'
            }).then(function(){
            window.location.href = 'homepage.php';
        })";
        echo '</script>';


        // Optionally, you can remove the exit() if you want the script to continue running.
        exit();

        // Perform additional actions, such as setting session variables
    } else {
        echo '<script>';
echo "Swal.fire({
    title: 'Incorrect Password!',
    text: 'Please double-check your password and try again.',
    icon: 'error'
}).then(function(){
    window.location.href = 'login.html';
})";
echo '</script>';

    }
} else {
    // If username or password is not set in the POST request
    echo '<script>';
echo "Swal.fire({
    title: 'Incomplete Information',
    text: 'Please enter both username and password.',
    icon: 'error'
}).then(function(){
    window.location.href = 'login.html';
})";
echo '</script>';

}
?>