<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Family Profile</title>
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
    <form id="familyForm" action="family.php" method="post">

        <label for="father_occupation">Father's Occupation:</label>
        <input type="text" id="father_occupation" name="father_occupation" required>
    
        <label for="mother_occupation">Mother's Occupation:</label>
        <input type="text" id="mother_occupation" name="mother_occupation" required>
    
        <label for="num_brothers">Number of Brothers:</label>
        <input type="number" id="num_brothers" name="num_brothers" required>
    
        <label for="num_sisters">Number of Sisters:</label>
        <input type="number" id="num_sisters" name="num_sisters" required>
    
        <button type="submit">Save The Details</button>
    </form>
    
    </div>
</body>

</html>
<?php
include('connect.php'); 
include('homeButton.html');
try {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user_name = $_SESSION['user_name'];
        $userid_query = "SELECT user_id FROM users WHERE user_name = '$user_name'";
        $userid_result = pg_query($conn, $userid_query);

        if ($userid_result && $row = pg_fetch_assoc($userid_result)) {
            $userid = $row['user_id'];

            $father_occupation = isset($_POST['father_occupation']) ? $_POST['father_occupation'] : '';
            $mother_occupation = isset($_POST['mother_occupation']) ? $_POST['mother_occupation'] : '';
            $num_brothers = isset($_POST['num_brothers']) ? $_POST['num_brothers'] : 0;
            $num_sisters = isset($_POST['num_sisters']) ? $_POST['num_sisters'] : 0;

            $existingDetailsQuery = "SELECT COUNT(*) FROM family_details WHERE user_id = $1";
            $existingDetailsResult = pg_query_params($conn, $existingDetailsQuery, array($userid));

            if ($existingDetailsResult && $rowCount = pg_fetch_result($existingDetailsResult, 0, 0) > 0) {
                $updateQuery = "UPDATE family_details SET father_occ = $1, mother_occ = $2, no_bro = $3, no_sis = $4 WHERE user_id = $5";
                $updateResult = pg_query_params($conn, $updateQuery, array(
                    $father_occupation,
                    $mother_occupation,
                    $num_brothers,
                    $num_sisters,
                    $userid
                ));
            } else {
                $insertQuery = "INSERT INTO family_details (user_id, father_occ, mother_occ, no_bro, no_sis)
                                VALUES ($1, $2, $3, $4, $5)";
                $insertResult = pg_query_params($conn, $insertQuery, array(
                    $userid,
                    $father_occupation,
                    $mother_occupation,
                    $num_brothers,
                    $num_sisters
                ));
            }
            echo '<script>';
            echo "Swal.fire({
                title: 'Profile saved successfully!',
                text: '',
                icon: 'success'
            }).then(function(){
                window.location.href = 'homepage.php';
            })";
            echo '</script>';
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
