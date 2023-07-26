<?php
session_start();

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'grubhub';

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    if (!empty($username) && !empty($email) && !empty($password) && !empty($cpassword)) {
        if (strlen($password) < 8) {
            echo '<script>alert("Password too short!!")</script>';
        } else {
            if ($password == $cpassword) {
                //save to database
                $query = "insert into users(username,email,password) values ('$username','$email','$password')";
                $result = mysqli_query($conn, $query);
                if ($result) {

                    header("Location:login.php");
                }
            } else {

                echo '<script>alert("The Confirm Password field does not match the Password entered!")</script>';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width-device-width, initial-scale-1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link rel="stylesheet" href="test.css">

    <title>Register Form</title>
</head>

<body>
    <div class="container">
        <form class="login-email" method="POST" action="">
            <p class="login-text">Register</p>
            <div class="input-group">
                <input type="text" placeholder="Username" name="username" required>
            </div>
            <div class="input-group">
                <input type="email" placeholder="Email" name="email" required>
            </div>
            <div class="input-group">
                <input type="password" placeholder="Password" name="password" required>
            </div>
            <div class="input-group">
                <input type="password" placeholder="Confirm Password" name="cpassword" required>
            </div>
            <div class="input-group">
                <button name="submit" class="btn">Register</button>
            </div>
            <p class="login-register-text">Have an account?&nbsp;<a href="index.php">Login Here</a></p>
        </form>
    </div>
</body>

</html>