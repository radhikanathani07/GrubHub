<html>

<head>
    <title>Recently added</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">

    <link rel="stylesheet" href="style4.css">
    <link rel="stylesheet" href="style1.css">
</head>
<bodey>

    <section class="header">
    <?php
    include('header.php');
    ?>
    </section>
    </section>
    <section class="recipe">
        <div class="container" style="background-color:#76934a;">
            <center>
                <h1 style="font-family: 'Poppins',sans-serif;">Recently Added Recipes</h1>
            </center>

            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "grubhub";
            $conn = mysqli_connect($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $query = "Select max(r_id) as rid from `recipe` ";
            $query_run = mysqli_query($conn, $query);
            $count = 10;
            if (mysqli_num_rows($query_run) == 1) {
                $row = mysqli_fetch_array($query_run);
                $num = $row['rid'];

                while ($count > 0) {
                    $query = "Select * from `recipe` where r_id='$num'";
                    $query_run1 = mysqli_query($conn, $query);

                    if ($num == 0) {
                        break;
                    }
                    $num--;
                    if (mysqli_num_rows($query_run1) == 1) {
                        while ($row = mysqli_fetch_array($query_run1)) {

            ?>
                            <div class="<?php echo $num; ?>" style="background-color:#fff9;margin-top:15%;border: 2px solid black;padding:0 10% 10% 10%;">


                                <img src="./uploads/<?php echo $row['image']; ?>" height=100px width=100px>


                                <div class="details">
                                    <h2><?php echo $row['name']; ?></h2>
                                </div>

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
                                <div class="button_style" style="display:flex;justify-content:center;align-items:center;">
                                    <form action="instr.php" method="POST">
                                        <input type="hidden" name="instruction" value="<?php echo $row['instruction']; ?>">
                                        <center><button id="show-recipe" name="show-recipe">View Recipe</button></center>
                                    </form>
                                </div>
                            </div>

            <?php
                        }
                    }
                    $count--;
                }
            }
            ?>
        </div>
    </section>
    </body>

</html>