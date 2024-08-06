<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Profile Details</title>
    <style>
        body {
            background-color: #121212;
            color: #fff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        nav {
            background-color: #333;
            overflow: hidden;
            height: 40px; 
        }

        nav a {
            float: left;
            display: block;
            color: #fff;
            text-align: center;
            padding: 10px 16px; 
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        nav a:hover {
            background-color: #555;
        }

        .profile-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 45px;
            position: relative;
            top: 70px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
            background-color: #333;
        }

        h2 {
            color: #ccc;
            margin-bottom: 20px;
            font-size: 28px;
        }

        .profile-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .label {
            font-weight: bold;
            color: #ccc;
        }

        .value {
            color: #fff;
        }
        .profile-navbar {
            background-color: #333;
            overflow: hidden;
            height: 45px;
            position: relative;
            display: flex;
            align-items: center;
            top: 25px;
            left: 16.5em;
            width: 65%;
            margin-bottom: 20px; 
        }

        .profile-navbar a {
            float: left;
            display: block;
            color: #fff;
            width: 30%;
            text-align: center;
            padding: 10px 16px;
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .profile-navbar a:hover:not(.active) {
            background-color: #555;
        }
        a.active
        {
            background-color: #0d6efd;
            cursor: pointer;
        }
    </style>
</head>

<body>
        <div class="profile-navbar">
            <a href="detailsP.php" class="active">Profile</a>
            <a href="detailsF.php" class="inactive">Family Details</a>
            <a href="detailsA.php" class="inactive">Additional Details</a>
        </div>
    <div class="profile-container">
        <h2>User Profile</h2>
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
                    $profile_query = "SELECT * FROM profile WHERE user_id = $1";
                    $profile_result = pg_query_params($conn, $profile_query, array($userid));
                    $profile = pg_fetch_assoc($profile_result);
                        echo '<div class="profile-details">';
                        echo '<div class="label">Full Name:</div><div class="value">' . (isset($profile['full_name']) ? $profile['full_name'] : '') . '</div>';
                        echo '<div class="label">Age:</div><div class="value">' . (isset($profile['age']) ? $profile['age'] : '') . '</div>';
                        echo '<div class="label">Gender:</div><div class="value">' . (isset($profile['gender']) ? $profile['gender'] : '') . '</div>';
                        echo '<div class="label">Religion:</div><div class="value">' . (isset($profile['religion']) ? $profile['religion'] : '') . '</div>';
                        echo '<div class="label">Education:</div><div class="value">' . (isset($profile['education']) ? $profile['education'] : '') . '</div>';
                        echo '<div class="label">Marital Status:</div><div class="value">' . (isset($profile['marital_status']) ? $profile['marital_status'] : '') . '</div>';
                        echo '<div class="label">Phone:</div><div class="value">' . (isset($profile['phone']) ? $profile['phone'] : '') . '</div>';
                        echo '<div class="label">Mother Tongue:</div><div class="value">' . (isset($profile['mother_tongue']) ? $profile['mother_tongue'] : '') . '</div>';
                        echo '<div class="label">Location:</div><div class="value">' . (isset($profile['location']) ? $profile['location'] : '') . '</div>';
                        echo '</div>';
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
    </div>
</body>

</html>
