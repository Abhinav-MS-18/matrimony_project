<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body
        {
            background-image: url(./images/matrim.jpg);
background-repeat: no-repeat;
background-size: cover;
        }
    </style>
</head>
<body>
    
</body>
</html>
<?php  
    $host = 'localhost';
    $port = '5432';
    $dbname = 'dbms_lab';
    $user = 'postgres';
    $password = 'Abhi2503@sql';
    
    $conn = pg_connect( "host=$host port=$port dbname=$dbname user=$user password=$password" );
    
    if ( !$conn ) {
        echo 'Error: Unable to connect to the database.\n';
        exit;
    }
?>