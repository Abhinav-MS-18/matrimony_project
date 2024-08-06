<?php
session_start();
?>
<!DOCTYPE html>
<html lang = 'en'>

<head>
<meta charset = 'UTF-8'>
<meta name = 'viewport' content = 'width=device-width, initial-scale=1.0'>
<title>Create Your Profile</title>
<script src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
<link rel = 'stylesheet' href = 'styles.css'>
<style>
body {
    background-color: #121212;
    color: #fff;
    font-family: Arial, sans-serif;
}

.profile-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 40px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba( 255, 255, 255, 0.1 );
    background-color: #333;
}

.wedding-images {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}

.wedding-images img {
    max-width: 100%;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba( 0, 0, 0, 0.2 );
    margin: 0 10px;
}

h2 {
    color: #ccc;
    margin-bottom: 20px;
    font-size: 28px;
}

form {
    width: 100%;
    display: grid;
    grid-template-columns: 1fr;
    gap: 20px;
}

label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
    color: #ccc;
}

input,
select {
    width: 100%;
    padding: 12px;
    border: 2px solid #555;
    border-radius: 8px;
    box-sizing: border-box;
    font-size: 16px;
    background-color: #444;
    color: #fff;
}

button {
    padding: 15px 30px;
    background-color: #4c4c4c;
    color: #fff;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 18px;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #5a5a5a;
}
</style>
</head>

<body>

<div class = 'profile-container'>
<div class = 'wedding-images'>
<!-- <img src = 'placeholder1.jpg' alt = 'Wedding Image 1'>
<img src = 'placeholder2.jpg' alt = 'Wedding Image 2'> -->
<!-- Replace with your image URLs or paths -->
</div>
<h2>Create Your Profile</h2>
<form id = 'profileForm' action = 'profile.php' method = 'post'>
<label for = 'full_name'>Full Name:</label>
<input type = 'text' id = 'full_name' name = 'full_name' required>

<label for = 'age'>Age:</label>
<input type = 'text' id = 'age' name = 'age' required>

<label for = 'gender'>Gender:</label>
<select id = 'gender' name = 'gender' required>
<option value = 'male'>Male</option>
<option value = 'female'>Female</option>
<option value = 'others'>Others</option>
</select>

<label for = 'religion'>Religion:</label>
<input type = 'text' id = 'religion' name = 'religion' required>

<label for = 'education'>Education:</label>
<input type = 'text' id = 'education' name = 'education' required>

<label for = 'marital_status'>Marital Status:</label>
<input type = 'text' id = 'marital_status' name = 'marital_status' required>

<label for = 'phone'>Phone:</label>
<input type = 'text' id = 'phone' name = 'phone' required>

<label for = 'mother_tongue'>Mother Tongue:</label>
<input type = 'text' id = 'mother_tongue' name = 'mother_tongue' required>

<label for = 'location'>Location:</label>
<input type = 'text' id = 'location' name = 'location' required>

<button type = 'submit'>Save Profile</button>
</form>
</div>
</body>

</html>
<?php
include('connect.php');
include('homeButton.html');
try {
    
    if (isset($_SESSION['user_name'])) {
        $user_name = $_SESSION['user_name'];
        $userid_query = "SELECT user_id FROM users WHERE user_name = '$user_name'";
        $userid_result = pg_query($conn, $userid_query);

        if ($userid_result && $row = pg_fetch_assoc($userid_result)) {
            $userid = $row['user_id'];

            $existing_profile_query = "SELECT COUNT(*) FROM profile WHERE user_id = $userid";
            $existing_profile_result = pg_query($conn, $existing_profile_query);

            if ($existing_profile_result) {
                $count = pg_fetch_row($existing_profile_result)[0];

                if ($count > 0) {
                    echo '<script>';
                    echo "Swal.fire({
                        title: 'Profile Exists',
                        text: 'You already have a profile. To update, please use the update profile page.',
                        icon: 'warning'
                    }).then(function(){
                        window.location.href = 'homepage.php'; // Replace with the page you want to redirect to
                    })";
                    echo '</script>';
                    exit(); 
                }
            }
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $full_name = isset($_POST['full_name']) ? $_POST['full_name'] : '';
            $age = isset($_POST['age']) ? $_POST['age'] : 0;
            $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
            $religion = isset($_POST['religion']) ? $_POST['religion'] : '';
            $education = isset($_POST['education']) ? $_POST['education'] : '';
            $marital_status = isset($_POST['marital_status']) ? $_POST['marital_status'] : '';
            $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
            $mother_tongue = isset($_POST['mother_tongue']) ? $_POST['mother_tongue'] : '';
            $location = isset($_POST['location']) ? $_POST['location'] : '';
            $sql = "INSERT INTO profile (user_id, full_name, age, gender, religion, education, marital_status, phone, mother_tongue, location)
                    VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10)";

            $result = pg_query_params($conn, $sql, array(
                $userid,
                $full_name,
                $age,
                $gender,
                $religion,
                $education,
                $marital_status,
                $phone,
                $mother_tongue,
                $location
            ));

            if (!$result) {
                echo 'Error: Query failed.\n';
                exit;
            }

            echo '<script>';
            echo "Swal.fire({
                title: 'Success!',
                text: 'Profile updated successfully.',
                icon: 'success'
            }).then(function(){
                window.location.href = 'homepage.php'; // Replace with the page you want to redirect to
            })";
            echo '</script>';
        }
    }
}
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
} finally {
    if ($conn) {
        pg_close($conn);
    }
}
?>
