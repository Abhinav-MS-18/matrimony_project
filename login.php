<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #111827, #1F2937);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
            
        }

        .login-container {
            background-color: rgba(0, 0, 0, 0.8);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
            text-align: center;
            animation: fadeInUp 1s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h2 {
            color: #fff;
            margin-bottom: 20px;
            font-size: 28px;
            text-shadow: 4px 4px 8px rgba(0, 174, 255, 0.7);
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #aaa;
        }

        input,
        select {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 2px solid #333;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 16px;
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
            transition: box-shadow 0.3s ease, background-color 0.3s ease;
        }

        input:focus,
        select:focus {
            box-shadow: 0 0 10px rgba(0, 174, 255, 0.7);
            background-color: rgba(0, 0, 0, 1);
        }

        button {
            margin-top:10px; ;
            padding: 15px 30px;
            background-color: #0d6efd;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            transition: font-size 0.3s ease;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        button:hover {
            background-color: #0a57cad1;
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
</head>

<body>
    <div class="login-container">
        <h2>Login</h2>
        <form action="login.php" method="post" autocomplete="off">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Enter your username">

            <label for="password">Password:</label>
            <input type="password" id="password" name="password">

            <button type="submit">Log In</button>
            <div style="color:whitesmoke;position:relative;top:10px;font-size:18px;">Don't have an Account?</div>
            <br>
            <div style="color:whitesmoke;position:relative;bottom:8px;font-size:18px;" type="button">Click here for <a href="signup.php">Sign up</a></div>
        </form>
    </div>
</body>

</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
</html>
<?php
include('connect.php');

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $passwordEntered = $_POST['password'];

    $getPasswordQuery = "SELECT password FROM users WHERE user_name = $1";
    $getPasswordResult = pg_query_params($conn, $getPasswordQuery, array($username));

    if (!$getPasswordResult) {
        echo 'Error: Query failed.\n';
        exit;
    }

    $hashedPassword = pg_fetch_result($getPasswordResult, 0);

    if (empty($hashedPassword)) {
        echo '<script>';
echo "Swal.fire({
    title: 'User not found!',
    text: 'Please check your username and try again.',
    icon: 'error'
}).then(function(){
    window.location.href = 'login.php';
})";
echo '</script>';

        exit;
    }

    
    if ($passwordEntered == $hashedPassword) {
        
        $credentialsAreValid = true;
        $_SESSION['user_name'] = $username; 
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = $_POST['username'];
            $passwordEntered = $_POST['password'];
        
            
            if (strlen($passwordEntered) < 8) {
                echo '<script>';
                echo "Swal.fire({
                    title: 'Password too short!',
                    text: 'Please enter a password with at least 8 characters.',
                    icon: 'error'
                }).then(function(){
                    window.location.href = 'login.php';
                })";
                echo '</script>';
        
                exit;
            }
        
        echo '<script>';
            echo "Swal.fire({
                title: 'Logged in Successfully !',
                text: 'Welcome back, $username!',
                icon: 'success'
            }).then(function(){
            window.location.href = 'homepage.php';
        })";
        echo '</script>';


        
        exit();

        
    } else {
        echo '<script>';

echo "Swal.fire({
    title: 'Incorrect Password!',
    text: 'Please double-check your password and try again.',
    icon: 'error'
}).then(function(){
    window.location.href = 'login.php';
})";
echo '</script>';

    }
} else {
    
    echo '<script>';
echo "Swal.fire({
    title: 'Incomplete Information',
    text: 'Please enter both username and password.',
    icon: 'error'
}).then(function(){
    window.location.href = 'login.php';
})";
echo '</script>';

}}
?>