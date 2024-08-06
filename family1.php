<?php
// Assuming you have a PostgreSQL database set up
session_start();
include('connect.php'); // Ensure the database connection is properly established

try { 
    // Retrieve the new fields
    $father_occupation = isset($_POST['father_occupation']) ? $_POST['father_occupation'] : '';
    $mother_occupation = isset($_POST['mother_occupation']) ? $_POST['mother_occupation'] : '';
    $num_brothers = isset($_POST['num_brothers']) ? $_POST['num_brothers'] : '';
    $num_sisters = isset($_POST['num_sisters']) ? $_POST['num_sisters'] : '';

    // Insert data into the database without the old fields
    $sql = "INSERT INTO family_details (father_occ, mother_occ, no_bro, no_sis)
            VALUES ($1, $2, $3, $4)";

    $result = pg_query_params($conn, $sql, array(
        $father_occupation,
        $mother_occupation,
        $num_brothers,
        $num_sisters
    ));

    if (!$result) {
        echo 'Error: Query failed.\n';
        exit;
    }

    echo 'Profile saved successfully';
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
} finally {
    // Close the database connection
    if ($conn) {
        pg_close($conn);
    }
}
?>