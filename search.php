<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    .button-container {
        
        margin-top: 10px;
    }

    .button-container button {
        background-color: #007bff; 
        color: #fff; 
        padding: 10px 20px; 
        border: none; 
        border-radius: 5px; 
        cursor: pointer; 
    }

    .button-container button:hover {
        background-color: #0056b3; 
        box-shadow: 0px 0px 5px #ef21a5, 
        0px 0px 30px #ef21a5, 
        0px 0px 90px #ef21a5;
    }
</style>
</head>
<body>

</body>
</html>
<?php
session_start();

include( 'connect.php' );
if ( !$conn ) {
    die( 'Connection failed.' );
}
    $age_p = isset( $_POST[ 'age' ] ) ? $_POST[ 'age' ] : '';
    $height_p = isset( $_POST[ 'height' ] ) ? $_POST[ 'height' ] : '';
    $weight_p = isset( $_POST[ 'weight' ] ) ? $_POST[ 'weight' ] : '';
    $religion_pref = isset( $_POST[ 'religion_pref' ] ) ? $_POST[ 'religion_pref' ] : '';
    $education_pref = isset( $_POST[ 'education_pref' ] ) ? $_POST[ 'education_pref' ] : '';
    $location = isset( $_POST[ 'location' ] ) ? $_POST[ 'location' ] : '';

    $age = isset( $_POST[ 'age' ] ) ? $_POST[ 'age' ] : '';
    $height = isset( $_POST[ 'height' ] ) ? $_POST[ 'height' ] : '';
    $weight = isset( $_POST[ 'weight' ] ) ? $_POST[ 'weight' ] : '';
    $religion_pref = isset( $_POST[ 'religion_pref' ] ) ? $_POST[ 'religion_pref' ] : '';
    $education_pref = isset( $_POST[ 'education_pref' ] ) ? $_POST[ 'education_pref' ] : '';
    $location = isset( $_POST[ 'location' ] ) ? $_POST[ 'location' ] : '';

if ( isset( $_SESSION[ 'user_name' ] ) ) {
    $user_name = $_SESSION[ 'user_name' ];
    $gender_query = "SELECT gender FROM users WHERE user_name = '$user_name'";
    $gender_result = pg_query($conn, $gender_query );

    $userid_query = "SELECT user_id FROM users WHERE user_name = '$user_name'";
    $userid_result = pg_query($conn, $userid_query);

    if ($gender_result && $row = pg_fetch_assoc($gender_result)) {
        $gender = $row[ 'gender' ];
    }
    if ($userid_result && $row = pg_fetch_assoc($userid_result)) {
        $userid = $row['user_id'];
    }
    $query_p = "INSERT INTO preferences (user_id, user_name, age, height, weight, religion_pref, education_pref, location) 
              VALUES ($1, $2, $3, $4, $5, $6, $7, $8)";
    $params = array($userid, $user_name, $age_p, $height_p, $weight_p, $religion_pref, $education_pref, $location);
    $result_p = pg_query_params($conn, $query_p, $params);

}
$query = "
    SELECT
        p.full_name AS name,
        p.phone AS phone,
        p.marital_status,
        p.location, p.religion, p.age, p.mother_tongue,
        u.height, u.weight, u.dob, u.blood_grp,
        users.user_id,
        (
            SELECT ii.img_path 
            FROM user_images ii 
            WHERE users.user_name = ii.user_name
            LIMIT 1
        ),
        p.education,
        (
            SELECT users.email
            FROM users
            WHERE p.user_id = users.user_id
        ) AS email
    FROM
        profile p
    JOIN
        update_profile u ON p.user_id = u.user_id
    JOIN
        users ON p.user_id = users.user_id

    WHERE
        p.gender <> '$gender' AND
        p.age BETWEEN $age - 5 AND $age + 5
        AND u.height BETWEEN $height - 15 AND $height + 15
        AND u.weight BETWEEN $weight - 10 AND $weight + 15
        AND ('$religion_pref' = 'any' OR lower(p.religion) = '$religion_pref')
        AND
        (
            ('$education_pref' = 'any' OR lower(p.education) = '$education_pref')
            OR ('$location' = 'any' OR lower(p.location) = '$location')
        )
        AND lower(p.marital_status) <> 'committed';
";

$result = pg_query( $conn, $query );

if ( !$result && !$result_p ) {
    echo 'Query failed: ' . pg_last_error( $conn );
} else {
    echo '<!DOCTYPE html>';
    echo "<html lang='en'>";
    echo '<head>';
    echo "<meta charset='UTF-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo '<title>Search Results</title>';
    echo '<style>';
    echo 'body { background-color: #121212; color: #fff; font-family: Arial, sans-serif; }';
    echo '.result-container { max-width: fit-content; margin: 0 auto; border-radius: 8px; box-shadow: 0 0 10px rgba(255, 255, 255, 0.1); background-color: #333; padding: 20px; margin-top: 2rem;}';
    echo '.result-item { margin-bottom: 20px; }';
    echo '.img-container { max-width: 100%; overflow: hidden; }';
    echo '.img-container img { max-width: 100%; height: auto; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); margin-bottom: 10px; }'; 
    echo '</style>';
    echo '</head>';
    echo '<body>';
    echo "<div class='display-section' style='display:flex;flex-wrap:wrap;justify-content:space-evenly;'>";
    
    while ($row = pg_fetch_assoc($result)) {
        echo "<div class='result-container' >";
            echo "<div class='result-item'>";
                echo "<div class='img-container'>";
                    echo "<img src='" . $row['img_path'] . "' alt='Profile Image' style='width:25em;height:25em;'>";
                echo "</div>";
                echo '<div style="padding-left:15px;">';
                    echo '<strong>Name:</strong> ' . $row['name'] . '<br>';
                    echo '<strong>Age:</strong> ' . $row['age'] . '<br>';
                    echo '<strong>Blood Group:</strong> ' . $row['blood_grp'] . '<br>';
                    echo '<strong>Height:</strong> ' . $row['height'] . '<br>';
                    echo '<strong>Weight:</strong> ' . $row['weight'] . '<br>';
                    echo '<strong>Email:</strong> ' . $row['email'] . '<br>';
                    echo '<strong>Phone:</strong> ' . $row['phone'] . '<br>';
                    echo '<strong>Education:</strong> ' . $row['education'] . '<br>';
                    echo '<strong>Religion:</strong> ' . $row['religion'] . '<br>';
                    echo '<strong>Location:</strong> ' . $row['location'] . '<br>';
                    echo '<strong>Mother Tongue:</strong> ' . $row['mother_tongue'] . '<br>';
                    echo '<strong>Marital Status:</strong> ' . $row['marital_status'];
                    echo '</div>';
                    echo '</div>';
                    echo "</div>";
                }
                echo "</div>";
                
echo '</body>';
echo '</html>';
}

pg_close( $conn );
?>


<!-- echo '<div class="button-container">';
    echo '<button onclick="sendMessage(hello, can we meet up !?..)">Request</button>';
echo '</div>'; -->