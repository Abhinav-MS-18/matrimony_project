<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NK</title>
    <link rel="Shortcut Icon" type="images" href="./imgs/favicon4.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php include('sidebar.html');?>

    <!-- <div id="navContainer">
        <button id="menuToggle">&#9776; Menu</button>

        <nav>
            <a href="login.html" id="loginLink">Login</a>
            <a href="signup.html" id="registerLink">Register</a>
            <div id="link">
                <a href="profile.html">Create Profile</a>
                <a href="update.html">Update Profile</a>
                <a href="search.html">Search with Preferences</a>
            </div>
        </nav>
    </div> -->
    <main>
        <?php
            if(isset($_SESSION['user_name']))
            {
                echo "<h1>Welcome " . $_SESSION['user_name'] . " !!</h1>";
                include('profilemenu.php');
            }
            else
            {
                echo "<h1>Welcome to Your Homepage</h1>
                      <p>This is a simple homepage with a left-side navigation bar.</p>";
            }
        ?>
    </main>

    <script>
        const toggleButton = document.getElementById('menuToggle');
        const navBar = document.querySelector('nav');
        const loginLink = document.getElementById('loginLink');
        const registerLink = document.getElementById('registerLink');
        const links = document.getElementById('link');
        const isLoggedIn = <?php echo json_encode(isset($_SESSION['user_name'])); ?>
        
        if (isLoggedIn) {
            loginLink.innerHTML = '<i class="fa fa-sign-out" style="font-size:20px;"></i> Logout';
            loginLink.href = 'logout.php'; 
            registerLink.style.display = 'none'; 
            links.style.display = 'block';
        } else {
            loginLink.innerHTML = 'Login';
            loginLink.href = 'login.php'; 
            registerLink.style.display = 'block';
            links.style.display = 'none';
        }

        toggleButton.addEventListener('click', () => {
            navBar.classList.toggle('show');
        });
    </script>
</body>
</html>
