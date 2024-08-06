<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matrimony Registration</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #111827, #1F2937);
            ;
            /* Dark background color */
            /* color: #fff; */
            /* Light text color */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
        }

        .registration-container {
            background-color: rgba(0, 0, 0, 0.8);
            /* Semi-transparent dark background */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
            /* Light shadow */
            text-align: center;
            animation: fadeInUp 1s ease;
        }

        h2 {
            color: #fff;
            /* Light text color */
            margin-bottom: 20px;
            font-size: 28px;
            text-shadow: 4px 4px 8px rgba(0, 174, 255, 0.7);
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #aaa;
            /* Light gray text color */
        }

        input,
        select {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 2px solid #333;
            /* Dark gray border */
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 16px;
            background-color: rgba(255, 255, 255, 0.1);
            /* Semi-transparent white background */
            transition: box-shadow 0.3s ease, background-color 0.3s ease;
            color: #fff;
            /* Light text color */
        }

        input:focus,
        select:focus {
            box-shadow: 0 0 10px rgba(255, 111, 97, 0.7);
            background-color: rgba(0, 0, 0, 1);
            /* Lighter semi-transparent white background on focus */
        }

        button {
            margin-top: 10px;
            padding: 15px 30px;
            background-color: #0d6efd;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.3s ease;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        button:hover {
            background-color: #0a57cad1;
        }

        img {
            max-width: 100%;
            height: auto;
            margin-top: 30px;
            animation: fadeIn 1s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .hidden {
            display: none;
        }
        a
        {
            text-decoration: none;
            color: #0d6efd;
            font-size: 20px;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        a:hover
        {
            font-size: 22px;
        }
    </style>
    <script>
        function showNextSection(currentSectionId, nextSectionId) {
            var currentSection = document.getElementById(currentSectionId);
            var nextSection = document.getElementById(nextSectionId);

            if (validateSection(currentSectionId)) {
                currentSection.classList.add('hidden');
                nextSection.classList.remove('hidden');
            }
        }

        function validateSection(sectionId) {
            var user_id = document.getElementById('user_id').value;
            var email = document.getElementById('email').value;
            if (sectionId === 'section1') {
                // Simple validation for username and email
                if (user_id === '' || email === '') {
                    Swal.fire({
            title: 'Username and email are required',
            text: '',
            icon: 'warning'
        });
                    return false;
                }
            } 
            else if (sectionId === 'section2') {
                // Add password validation
                var password = document.getElementById('password').value;
                var confirmPassword = document.getElementById('confirmPassword').value;
                var passwordRegex = /^(?=.*[A-Za-z])(?=.*\d).{8,}$/;
                if (password === '' || confirmPassword === '') {
                    Swal.fire({
            title: 'Password and Confirm Password are required',
            text: '',
            icon: 'warning'
        });
                    return false;
                }

            if (!passwordRegex.test(password)) {
                Swal.fire({
                    title: 'Error',
                    text: 'Password should be at least 8 characters long and contain at least one letter and one number.',
                    icon: 'warning'
                });
                return false;
            }

                if (password !== confirmPassword) {
                    Swal.fire({
            title: 'Passwords do not match !',
            text: '',
            icon: 'error'
        });
                    return false;
                }
            }
             else if (sectionId === 'section3') {
                // Add gender and phone validation
                var gender = document.getElementById('gender').value;
                var phone = document.getElementById('phone').value;

                if (gender === '' || phone === '') {
                    Swal.fire({
            title: 'Gender and phone number are required',
            text: '',
            icon: 'error'
        });
                    return false;
                }
            }

            return true;
        }
    </script>
</head>

<body>
    <div class="registration-container" id="section1">
        <h2>Registration</h2>
        <form id="registrationForm" action="signup.php" method="post">
            <label for="user_id">Username:</label>
            <input type="text" id="user_id" name="user_id" required maxlength="15" placeholder="Enter your name">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required placeholder="Enter your email">

            <button type="button" onclick="showNextSection('section1', 'section2')">Next</button>
            <div style="color:whitesmoke;position:relative;top:10px;font-size:18px;">Already have an Account?</div>
            <br>
            <div style="color:whitesmoke;position:relative;bottom:8px;font-size:18px;" type="button">
                Click here to <a href="login.php">Login</a>
            </div>
        
        
    </div>

    <div class="registration-container hidden" id="section2">
        <h2>Registration</h2>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password">

        <label for="confirmPassword">Confirm Password:</label>
        <input type="password" id="confirmPassword" name="confirmPassword">

        <button type="button" onclick="showNextSection('section2', 'section3')">Next</button>
    </div>

    <div class="registration-container hidden" id="section3">
        <h2>Registration</h2>
        <label for="gender">Gender:</label>
        <select id="gender" name="gender">
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="others">Others</option>
        </select>

        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" placeholder="e.g., 1234567890" maxlength="10">

        <button type="submit">Sign Up</button>
        </form>
    </div>
    <!-- <img src="path/to/your/image.jpg" alt="Matrimony Image"> -->

</body>

</html>

<?php
include('connect.php');

try {
    // Get user inputs
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = isset($_POST['user_id']) ? $_POST['user_id'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';

    // Check if the email or password is empty
    /* if (empty($email) || empty($password)) {
        echo '';
        exit;
    } */

    // Check if the email already exists
    $checkEmailQuery = "SELECT COUNT(*) FROM users WHERE email = $1";
    $result = pg_query_params($conn, $checkEmailQuery, array($email));
    $rowCount = pg_fetch_result($result, 0, 0);

    if ($rowCount > 0) {
        echo '<script>';
        echo "Swal.fire({
            title: 'Error',
            text: 'Email address already exists.',
            icon: 'error'
        })";
        echo '</script>';
        exit;
    }

    // Validate password
    /* if (strlen($password) < 8 || !preg_match("/[A-Za-z]/", $password) || !preg_match("/\d/", $password)) {
        echo '<script>';
        echo "Swal.fire({
            title: 'Error',
            text: 'Password should be at least 8 characters long and contain at least one letter and one number.',
            icon: 'error'
        }).then(function(){
            window.location.href = 'signup.php';
        })";
        echo '</script>';
        exit;
    } */

    // Insert data into the database
    $sql = "INSERT INTO users (user_name, email, password, gender, phone) 
            VALUES ($1, $2, $3, $4, $5)";

    $result = pg_query_params($conn, $sql, array($username, $email, $password, $gender, $phone));

    if (!$result) {
        echo 'Error: Unable to execute the query.';
        exit;
    }
    if ($result) {
        echo '<script>';
        echo "Swal.fire({
            title: 'Success',
            text: 'Registration successful!',
            icon: 'success'
        }).then(function(){
            window.location.href = 'login.php';
        })";
        echo '</script>';
        exit;
    }
    /* header('Location: login.html'); */
    exit();
}
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
} finally {
    if ($conn) {
        pg_close($conn);
    }
}

?>
