<?php
session_start();

// include("user.php");

if (isset($_POST['submit'])) {
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $dbname = 'grubhub';

    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    // $conn = mysqli_connect("localhost", "root", "", "user");
    if (isset($_POST['userid'])) {
        if (isset($_POST['password'])) {
            $userid = $_POST['userid'];
            $password = $_POST['password'];
            $flag = 0;
            $sql = "Select password from users where username = '$userid'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    if ($row['password'] == $password) {
                        // $sessionid=$row['sessionid'];
                        echo "<script type='text/javascript'>alert('Successfully Login.')</script>";

                        $flag = 1;
                        $_SESSION['user_id'] = $userid;
                        if ($_SESSION['user_id'] == $userid) {
                            header("Location:home.php");
                        }
                    } else {
                        echo "<script type='text/javascript'>alert('Incorrect Password.')</script>";
                    }
                }
            } else {
                echo "<script type='text/javascript'>alert('Username is incorrect.')</script>";
            }
        } else {
            echo "<script type='text/javascript'>alert('Please enter the password.')</script>";
        }
    } else {
        echo "<script type='text/javascript'>alert('Please enter a username')</script>";
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

    <title>Login/Sign-up Page</title>
</head>

<body>
    <div class="container">
        <form class="login-email" method="POST" action="">
            <p class="login-text">Login</p>
            <div class="input-group">
                <input type="text" placeholder="username" name='userid' required>
            </div>
            <div class="input-group">
                <input type="password" placeholder="Password" name='password' required>
            </div>
            <div class="input-group">
                <button>Login</button>
            </div>
            <p class="login-register-text">Don't have an account?&nbsp;<a href="register.php">Register Here</a></p>
        </form>
    </div>
</body>

</html>