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


    <section class="header">
        <?php
        include('header.php');
        ?>
    </section>
    </section>



    <?php
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $dbname = 'grubhub';

    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['submit'])) {

            $ingredients = array();
            $sql = "SELECT name FROM ingre";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    //print($row['name']);
                    $ingredients[] = $row['name'];
                }
            }
            //print_r($ingredients);
            if (count($ingredients) == 0) {
                //echo "hi00";
                header('Location:choose_ingre.php');
            } else {

                $recipes = array();
                $sql = "SELECT name, ingredients FROM recipe";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        //print($row['name']);
                        $recipes[] = array(
                            'name' => $row['name'],
                            'ingredients' => explode(',', $row['ingredients'])
                        );
                    }
                }




                // Get the selected ingredients and remove any duplicates
                $selectedIngredients = array_unique($ingredients);
                // print_r($recipes);

                // Remove any unchecked ingredients from the array
                foreach ($recipes as $key => $recipe) {
                    $recipes[$key]['score'] = 0;
                    foreach ($selectedIngredients as $ingredient) {
                        // trim the ingredient and convert to lowercase
                        $ingredient = strtolower(trim($ingredient));

                        // loop through recipe ingredients, trim and compare with selected ingredient
                        foreach ($recipe['ingredients'] as $recipeIngredient) {
                            $recipeIngredient = strtolower(trim($recipeIngredient));
                            if ($ingredient === $recipeIngredient) {
                                $recipes[$key]['score']++;
                                break;
                            }
                        }
                    }
                }


                // Sort the recipes by score (number of common ingredients)
                usort($recipes, function ($a, $b) {
                    return $b['score'] - $a['score'];
                });

                // Output the results
    ?>
                <section class="recipe">
                    <div class="container"><?php
                                            if ($selectedIngredients) {
                                                echo '<h2>Results:</h2>';
                                                foreach ($recipes as $recipe) {
                                                    if ($recipe['score'] > 0) {
                                                        // echo '<h3>' . $recipe['name'] . '</h3>';
                                                        // echo '<p>Ingredients: ' . implode(', ', $recipe['ingredients']) . '</p>';
                                                        $name = $recipe['name'];
                                                        $query = "Select * from `recipe` where name like '$name'";
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
                                            <form action="instr.php" method="POST">
                                                <input type="hidden" name="instruction" value="<?php echo $row['instruction']; ?>">
                                                <button id="show-recipe" name="show-recipe">View Recipe</button>
                                            </form>

                        <?php
                                                            }
                                                        }
                                                        echo '<p>Score: ' . $recipe['score'] . '</p>';
                                                    }
                                                }
                                            } else {
                                                echo '<p>Please select at least one ingredient.</p>';
                                            }
                                            $sql = "DELETE FROM ingre";
                                            if ($conn->query($sql)) {
                                                //echo "All rows deleted successfully";
                                            } else {
                                                echo "Error deleting rows: " . $mysqli->error;
                                            }

                        ?>
                    </div>
                </section>
    <?php




                // close the database connection
                //$mysqli->close();

                // and display the results here.
            }
        }
    } ?>
</body>