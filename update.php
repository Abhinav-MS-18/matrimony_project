<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Your Profile</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
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
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
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
    <div class="profile-container">
        <h2>Update Profile</h2>
        <form id="profileForm" action="update.php" method="post">
            <label for="height">Height:</label>
            <input type="text" id="height" name="height" required>
        
            <label for="weight">Weight:</label>
            <input type="text" id="weight" name="weight" required>
        
            <label for="date_of_birth">Date of Birth:</label>
            <input type="date" id="date_of_birth" name="date_of_birth" required>
        
            <label for="blood_group">Blood Group:</label>
            <input type="text" id="blood_group" name="blood_group" required>
        
            <label for="diet">Diet:</label>
            <input type="text" id="diet" name="diet" required>
        
            <button type="submit">Save Profile</button>
        </form>
        
    </div>
</body>

</html>
<?php
include('connect.php');
include('homeButton.html');
if (!$conn) {
    die("Connection failed.");
}



if (isset($_SESSION['user_name'])) {
    $user_name = $_SESSION['user_name'];

        
        $checkProfileQuery = "SELECT COUNT(*) FROM profile WHERE user_id = (SELECT user_id FROM users WHERE user_name = '$user_name')";
        $checkProfileResult = pg_query($conn, $checkProfileQuery);

        if ($checkProfileResult && $row = pg_fetch_assoc($checkProfileResult)) {
            $profileCount = $row['count'];

            if ($profileCount == 0) {
                echo '<script>';
                echo 'Swal.fire({';
                    echo "    title: 'No Profile Found',";
                echo "    text: 'Please create a profile first before updating.',";
                echo "    icon: 'warning'";
                echo '}).then(function(){';
                    echo "    window.location.href = 'homepage.php';"; // Redirect to the create profile page
                echo '})';
                echo '</script>';
                exit();
            }
        }
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $height = $_POST['height'];
            $weight = $_POST['weight'];
            $dateOfBirth = $_POST['date_of_birth'];
            $bloodGroup = $_POST['blood_group'];
            $diet = $_POST['diet'];

        $userid_query = "SELECT user_id FROM users WHERE user_name = '$user_name'";
        $userid_result = pg_query($conn, $userid_query);

        if ($userid_result && $row = pg_fetch_assoc($userid_result)) {
            $userid = $row['user_id'];
        }
        $profid_query = "SELECT prof_id FROM profile WHERE user_id = '$userid'";
        $profid_result = pg_query($conn, $profid_query);

        if ($profid_result && $row = pg_fetch_assoc($profid_result)) {
            $profid = $row['prof_id'];
        }
        $checkUpdateProfileQuery = "SELECT COUNT(*) FROM update_profile WHERE user_id = '$userid'";
        $checkUpdateProfileResult = pg_query($conn, $checkUpdateProfileQuery);

        if ($checkUpdateProfileResult && $row = pg_fetch_assoc($checkUpdateProfileResult)) {
            $updateProfileCount = $row['count'];

            if ($updateProfileCount > 0) {
                $updateQuery = "UPDATE update_profile SET height = '$height', weight = '$weight', dob = '$dateOfBirth', blood_grp = '$bloodGroup', diet = '$diet' WHERE user_id = '$userid'";
                $updateResult = pg_query($conn, $updateQuery);

                if ($updateResult) {
                    echo '<script>';
                    echo "Swal.fire({
                        title: 'Success!',
                        text: 'Profile updated successfully.',
                        icon: 'success'
                    }).then(function(){
                        window.location.href = 'homepage.php'; 
                    })";
                    echo '</script>';
                } else {
                    echo "Error: " . pg_last_error($conn);
                }
            } else {
        $query = "INSERT INTO update_profile (user_id, prof_id, user_name, height, weight, dob, blood_grp, diet) 
                  VALUES ('$userid', '$profid', '$user_name', '$height', '$weight', '$dateOfBirth', '$bloodGroup', '$diet')";
        $result = pg_query($conn, $query);

        if ($result) {
            echo '<script>';
            echo "Swal.fire({
                title: 'Success!',
                text: 'Profile updated successfully.',
                icon: 'success'
            }).then(function(){
                window.location.href = 'homepage.php'; // Replace with the page you want to redirect to
            })";
            echo '</script>';
        } else {
            echo "Error: " . pg_last_error($conn);
        }
    }
    }
}
}
pg_close($conn);
?>