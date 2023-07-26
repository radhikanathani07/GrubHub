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
    $sql = "SELECT DISTINCT cuisine FROM recipe";
    $result = $conn->query($sql);
    $options = "";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $options .= "<option value='" . $row["cuisine"] . "'>" . $row["cuisine"] . "</option>";
        }
    }
    $conn->close();

    ?>
    <section class="recipe">
        <div class="container">
            <div class="search-container">
                <form action="" method="POST">
                    <!-- <div class="cuisine_list"> -->
                    <label for="cuisine">Select a Cuisine</label>
                    <select id="cuisine" name="cuisine">
                        <?php echo $options; ?>
                    </select>
                    <button type="submit" name="submit" id="submit">Search</button>

                </form>
            </div>
            <?php
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
            if (isset($_POST['submit'])) {
                // Get the form data
                $name = $_POST['cuisine'];
                $query = "Select * from `recipe` where cuisine like '%$name%'";
                $query_run = mysqli_query($conn, $query);


                if (mysqli_num_rows($query_run) > 0) {

                    while ($row = mysqli_fetch_array($query_run)) {

            ?>

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
                        <div class="recipe-details">
                            <button id="hide-recipe">X</button>
                            <pre id="instruction"><?php echo $row['instruction']; ?></pre>
                        </div>
                        <form action="instr.php" method="POST">
                            <input type="hidden" name="instruction" value="<?php echo $row['instruction']; ?>">
                            <button id="show-recipe" name="show-recipe">View Recipe</button>
                        </form>

            <?php
                    }
                } else {
                    echo "No data available";
                }
            }
            ?>

            <div id="result"></div>
        </div>
    </section>


    <!-- footer section starts -->

    <section class="footer">
        <?php
        include('footer.php');
        ?>
    </section>

</body>

<style>
    label {
        display: relative;
        font-weight: bold;
        margin-bottom: 5px;
    }

    select {
        display: relative;
        font-size: 16px;
        font-family: Arial, sans-serif;
        color: #333;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-shadow: none;
        background-color: #fff;
        width: 200px;
        margin: 0 auto 20px;
        /* text-align:center; */
    }

    option {
        font-size: 16px;
        font-family: Arial, sans-serif;
        color: #333;
        padding: 10px;
        background-color: #fff;
        /* display:block; */
    }

    option:hover {
        background-color: var(--main-color);
    }

    option:checked {
        background-color: var(--main-color);
        color: var(--font-color);
    }
</style>