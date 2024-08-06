<?php
session_start();
include('connect.php');

if (!$conn) {
    die("Database connection failed");
}


if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['submit'])) {
    $user_name = $_SESSION['user_name'];

    
    $userQuery = "SELECT user_id FROM users WHERE user_name = '$user_name'";
    $userResult = pg_query($conn, $userQuery);

    if ($userResult) {
        $userData = pg_fetch_assoc($userResult);
        $user_id = $userData['user_id'];

        
        $targetDirectory = "images/";
        $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        
        if ($_FILES["image"]["size"] > 1000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowedExtensions)) {
            echo "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                $completeImagePath = $targetFile;
                $existingImageQuery = "SELECT img_path FROM user_images WHERE user_name = '$user_name'";
                $existingImageResult = pg_query($conn, $existingImageQuery);

                if (pg_num_rows($existingImageResult) > 0) {
                    $updateQuery = "UPDATE user_images SET img_path = '$completeImagePath' WHERE user_name = '$user_name'";
                    $updateResult = pg_query($conn, $updateQuery);

                    if ($updateResult) {
                        echo "Profile image has been updated successfully.";
                    } else {
                        echo "Error updating profile image: " . pg_last_error($conn);
                    }
                } else {
                    $insertQuery = "INSERT INTO user_images (user_id, user_name, img_path) VALUES ('$user_id', '$user_name', '$completeImagePath')";
                    $insertResult = pg_query($conn, $insertQuery);

                    if ($insertResult) {
                        echo "Profile image has been updated successfully.";
                    } else {
                        echo "Error updating profile image: " . pg_last_error($conn);
                    }
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        echo "Error fetching user data: " . pg_last_error($conn);
    }
}

pg_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body
        {
            background-color: #121212;
        }
    </style>
</head>
<body>
    
</body>
</html>