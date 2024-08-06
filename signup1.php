<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
</html>
<?php
session_start();
include('connect.php');

try {
    // Get user inputs
    $username = isset( $_POST[ 'user_id' ] ) ? $_POST[ 'user_id' ] : '';
    $email = isset( $_POST[ 'email' ] ) ? $_POST[ 'email' ] : '';
    $password = isset( $_POST[ 'password' ] ) ? $_POST[ 'password' ] : '';
    $gender = isset( $_POST[ 'gender' ] ) ? $_POST[ 'gender' ] : '';
    $phone = isset( $_POST[ 'phone' ] ) ? $_POST[ 'phone' ] : '';

    // Check if the email is empty
    if ( empty( $email ) ) {
        echo '';
        exit;
    }

    // Check if the email already exists
    $checkEmailQuery = "SELECT COUNT(*) FROM users WHERE email = $1";
    $result = pg_query_params( $conn, $checkEmailQuery, array( $email ) );
    $rowCount = pg_fetch_result( $result, 0, 0 );

    if ( $rowCount > 0 ) {
        echo '<script>';
echo "Swal.fire({
    title: 'Error',
    text: 'Email address already exists.',
    icon: 'error'
}).then(function(){
    window.location.href = 'signup.html';
})";
echo '</script>';
        exit;
    }

    // Insert data into the database
    $sql = "INSERT INTO users (user_name, email, password, gender, phone) 
            VALUES ($1, $2, $3, $4, $5)";

    $result = pg_query_params( $conn, $sql, array( $username, $email, $password, $gender, $phone ) );

    if ( !$result ) {
        echo 'Error: Unable to execute the query.';
        exit;
    }

    header( 'Location: login.html' );
    exit();
} catch ( Exception $e ) {
    echo 'Error: ' . $e->getMessage();
}
finally {
    if ( $conn ) {
        pg_close( $conn );
    }
}
?>
