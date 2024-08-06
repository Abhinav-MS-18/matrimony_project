<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Additional Details</title>
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
            top: 25px;
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
            margin-bottom: 5px;
        }

        .value {
            color: #fff;
            margin-bottom: 15px;
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
    
    <div class="home-button">
        <a href="homepage.php">
            <i class="fa-solid fa-house"></i>
        </a>
    </div>
    <div class="profile-navbar">
        <a href="detailsP.php" class="inactive">Profile</a>
        <a href="detailsF.php" class="inactive">Family Details</a>
        <a href="detailsA.php" class="active">Additional Details</a>
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
                        $profile_query = "SELECT * FROM update_profile WHERE user_id = $1";
                        $profile_result = pg_query_params($conn, $profile_query, array($userid));
                        $profile = pg_fetch_assoc($profile_result);
                            echo '<div class="profile-details">';
                            echo '<div class="label">Height:</div><div class="value">' . (isset($profile['height']) ? $profile['height'] : '') . '</div>';
                            echo '<div class="label">Weight:</div><div class="value">' . (isset($profile['weight']) ? $profile['weight'] : '') . '</div>';
                            echo '<div class="label">Date of Birth:</div><div class="value">' . (isset($profile['dob']) ? $profile['dob'] : '') . '</div>';
                            echo '<div class="label">Blood Group:</div><div class="value">' . (isset($profile['blood_grp']) ? $profile['blood_grp'] : '') . '</div>';
                            echo '<div class="label">Diet:</div><div class="value">' . (isset($profile['diet']) ? $profile['diet'] : '') . '</div>';
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