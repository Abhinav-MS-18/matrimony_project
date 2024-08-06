<?php
include('connect.php');


if (!isset($_SESSION['user_name'])) {
    header('Location: login.php');
    exit();
}

$query = "SELECT img_path FROM user_images ui JOIN users u ON u.user_name = ui.user_name WHERE u.user_name = $1";

$stmt = pg_prepare($conn, 'get_image_by_username', $query);

$result = pg_execute($conn, 'get_image_by_username', array($_SESSION['user_name']));

if ($result) {
    if (pg_num_rows($result) > 0) {
        $imagePath = pg_fetch_result($result, 0, 'img_path');

        $imageSrc = "./" . $imagePath;
    } else {
        $imageSrc = "./images/default.jpg";
    }
} else {
    $imageSrc = "./images/default.jpg";
}

pg_close($conn);
?>


<!DOCTYPE html>
<html lang = 'en'>

<head>
<meta charset = 'UTF-8'>
<meta name = 'viewport' content = 'width=device-width, initial-scale=1.0'>
<title>Document</title>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
@import url( 'https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500&display=swap' );
*
 {
    margin: 0;
    padding: 0;
    list-style-type: none;
    box-sizing: border-box;
    font-family: sans-serif;
}
:root {
    --primary: #eeeeee;
    --secondary: #227c70;
    --green: #82cd47;
    --secondary-light: rgb( 34, 124, 112, 0.2 );
    --secondary-light-2: rgb( 127, 183, 126, 0.1 );
    --white: #fff;
    --black: #393e46;
    --shadow: 0px 2px 8px 0px var( --secondary-light );
}

body {
    height: 100vh;
    width: 100%;
    background-color: var( --primary );
    display: flex;
}

.profile-dropdown {
    position: absolute;
    top: 20px;
    right: 3rem;
}

.profile-img {
    width: 6rem;
    position: relative;
    height: 6rem;
    border-radius: 50%;
    background: url( <?php echo $imageSrc; ?>);
    background-size: cover;
}

.profile-dropdown-list {
    position: relative;
    top: 105px;
    width: 200px;
    right: 3.5em;
    background-color: var( --white );
    border-radius: 10px;
    box-shadow: var( --shadow );
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.5s;
}

.profile-dropdown-list.active {
    max-height: 500px;
}

.profile-dropdown-btn {
    display: flex;
    position: absolute;
    align-items: center;
    right: 10px;
    justify-content: space-between;
    padding-right: 25px;
    font-size: 0.9rem;
    font-weight: 500;
    border: 2.5px solid var( --secondary );
    border-radius: 50px;
    cursor: pointer;
    width: 250px;
    transition: box-shadow 0.2s, background-color 0.2s;
}

.profile-dropdown-btn:hover {
    background-color: var( --secondary-light-2 );
    box-shadow: var( --shadow );
}

.profile-img i {
    position: absolute;
    right: 0.2rem;
    bottom: 0.3rem;
    font-size: 15px;
    color: var( --green );
}

.profile-dropdown-btn span {
    margin: 0 0.5rem;
    margin-right: 0;
}

.profile-dropdown-list-item {
    padding: 0.5rem 0 0.5rem 1rem;
    transition: background-color 0.2s padding-left 0.2s;
}

.profile-dropdown-list-item a {
    display: flex;
    align-items: center;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
    color: var( --black );
}

.profile-dropdown-list-item a i {
    margin-right: 0.8rem;
    font-size: 1.1rem;
    width: 2.3rem;
    height: 2.3rem;
    background-color: var( --secondary );
    color: var( --white );
    line-height: 2.3rem;
    text-align: center;
    border-radius: 50%;
}

.profile-dropdown-list-item:hover {
    padding-left: 1.5rem;
    background-color: var( --secondary-light );
}

.profile-dropdown-list hr {
    border: 0.5px solid var( --green );
}
</style>
<link rel = 'stylesheet' href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css'>
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
</head>

<body>
<div class = 'profile-dropdown'>
<div class = 'profile-dropdown-btn' onclick = 'toggle()'>
<div class = 'profile-img'>
<i class = 'fa-solid fa-circle'></i>
</div>
<span>
<?php
if ( isset( $_SESSION[ 'user_name' ] ) )
 {
    echo "<i class='fa-solid fa-caret-down'>".$_SESSION[ 'user_name' ].'</i>';

}
?>
</span>
</div>
<ul class = 'profile-dropdown-list'>
<li class = 'profile-dropdown-list-item'>
<a href = 'upload_image.html'>
<i class="fa-solid fa-image"></i>Upload Image
</a>
</li>
<li class = 'profile-dropdown-list-item'>
<a href = 'detailsP.php'>
<i class = 'fa-regular fa-user'></i>View Profile
</a>
</li>
<li class = 'profile-dropdown-list-item'>
<a href = 'update.php'>
<i class="fa-solid fa-arrows-rotate"></i>Update Profile
</a>
</li>
<li class = 'profile-dropdown-list-item'>
<a href = 'family.php'>
<i class='fas fa-users'></i>Update Family-Details
</a>
</li>
<hr>
<li class = 'profile-dropdown-list-item'>
<a href = 'logout.php'>
<i class="fa-solid fa-right-from-bracket"></i>Logout
</a>
</li>
</ul>
</div>
<script>
    let profile = document.querySelector(".profile-dropdown-list");
let btn = document.querySelector(".profile-dropdown-btn");

const toggle = ()=>profile.classList.toggle('active');
window.addEventListener('click',function(e)
{
    if(!btn.contains(e.target))
    profileDropdownList.classList.remove('active');
});

</script>
</body>

</html>
