<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">

    <link rel="stylesheet" href="style4.css">
    <link rel="stylesheet" href="style1.css">



</head>

<body>
    <!-- header section starts -->
    <section class="header">
        <?php
        include('header.php');
        ?>
    </section>

    <!--Header ends-->
    <?php
    // if (isset($_SESSION['user_id'])) {
    //echo "Session ID is set: " . session_id();



    // Connect to the database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "grubhub";
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $name = '';
    $query_run = '';

    if (isset($_POST['show-recipe'])) {
        $instr = $_POST['instruction'];
        $query = "Select * from `recipe` where instruction='$instr'";
        $query_run = mysqli_query($conn, $query);
        if (mysqli_num_rows($query_run) > 0) {
            while ($row = mysqli_fetch_array($query_run)) {

    ?>

                <section class="display">
                    <img src="./uploads/<?php echo $row['image']; ?>" height=100px width=100px>
                    <div class="name"><?php echo $row['name']; ?></div>
                    <div class="ingredient-con">
                        <h4>Required Ingredients are:</h2>
                            <ul>
                                <?php
                                $ing = $row['ingredients'];
                                $ingredients = preg_split("/\,/", $ing);
                                $arrlength = count($ingredients);
                                for ($x = 0; $x < $arrlength; $x++) { ?>
                                    <li><?php echo $ingredients[$x]; ?></li>
                                <?php
                                } ?>
                            </ul>
                    </div>
                    <div class="instruct"><?php echo $row['instruction']; ?></div>
                    <form method="POST" action="instrgtts.php">
                        <input type="hidden" name="txt" value="<?php echo $row['instruction']; ?>"><br><br><br>
                        <label for="lang" style="color:green">Select Language:</label>
                        <select name="lang" id="lang" style="color:green">
                            <option value="en">English</option>
                            <option value="es">Spanish</option>
                            <option value="fr">French</option>
                            <!-- Add more language options as needed -->
                        </select><br>
                        <button type="submit" name="submit" value="submit" id="audio">Recipe Audiobook</button>
                    </form>
                    <!-- <div id="audio"></div> -->
                </section>



    <?php
            }
        }
    }

    ?>

    <!-- footer section starts -->
    <!-- 

    // } else {
    //     echo "<script>alert('You need to login to view this recipe.\nRedirecting to Login page.')</script>";
    //     header("Location:login.php");
    // }
    ?> -->

</body>