<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "grubhub";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Recipe</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">

    <link rel="stylesheet" href="style1.css">
    <link rel="stylesheet" href="add_style.css">
</head>
<script>
    function runSpeechRecognition() {
        // get reference to the input field and the action span element
        var userInput = document.getElementById("instructions");
        var action = document.getElementById("action");

        // create a new SpeechRecognition object
        var recognition = new window.webkitSpeechRecognition();

        // set recognition properties
        recognition.continuous = true;
        recognition.interimResults = true;
        // recognition.lang = "en-US";
        recognition.lang = ["en-US", "fr-FR", "es-ES"];

        // start recognition
        recognition.start();

        // show the "listening" message
        action.innerHTML = "listening...";

        // handle recognition result
        recognition.onresult = function(event) {
            var transcript = "";
            for (var i = event.resultIndex; i < event.results.length; i++) {
                if (event.results[i].isFinal) {
                    transcript += event.results[i][0].transcript;
                }
            }

            // set the transcribed speech as the value of the input field
            userInput.value = transcript;

            // update the "listening" message to show the transcribed speech
            //action.innerHTML = "you said: " + transcript;
        };

        // handle recognition error
        recognition.onerror = function(event) {
            action.innerHTML = "error occurred in recognition: " + event.error;
        }
    }
</script>




<body>

    <!-- header section starts -->
    <section class="header">
        <?php
        include('header.php');
        ?>
    </section>

    <!--Header ends-->


    <section class="add-recipe">
        <div class="inside-add">
            <h3 class="title">Add your recipe</h3>
            <fieldset>
                <h4 class="sub-title">Now share your own recipes.</h2>
                    <div class="form">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <table>
                                <tr>
                                    <td> <label for="name">Recipe Name:</label></td>
                                    <td><input type="text" placeholder="Enter your recipe name" name="name" id="name"></td>
                                </tr>
                                <tr>
                                    <td><label for="instructions">Write Steps</label></td>
                                    <td><textarea placeholder="Add your recipe Steps" name="instructions" id="instructions"></textarea><button type="button" id="speak" onclick="runSpeechRecognition()"><i class="fa fa-microphone"></i></button> &nbsp; <span id="action"></span></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="ingredients">Ingredients</label><sub>Hold Ctrl(Windows)or Command(Mac) to select multiple ingredients</sub></td>
                                    <td><select name="ingredients[]" id="ingredients" multiple size="5" value="">
                                            <!-- <option value="Choose Ingredients" disabled selected>Choose Ingredients</option> -->
                                            <?php
                                            $query = $conn->query("SELECT * FROM `ingredients`");
                                            if ($query) {
                                                while ($fetch = $query->fetch_array()) {
                                                    echo "<option>" . $fetch['ing_name'] . "</option>";
                                                }
                                            }
                                            ?>
                                        </select></td>
                                </tr>
                                <tr>
                                    <td><label for="add_ingre">Add Ingredients</label><sub>If not present in the list</sub></td>
                                    <td><input type="text" name="add_ingre" placeholder="Add New ingredients" id="add_ingre"></td>
                                </tr>
                                <tr>
                                    <td><label for="cuisine">Cuisine Type</label></td>
                                    <td><select id="cuisine" name="cuisine" style="border: 1px solid;border-radius: 5px">
                                            <option value="" selected>Select Cuisine</option>
                                            <option value="Italian">Italian</option>
                                            <option value="Fast Food">Fast Food</option>
                                            <option value="Chinese">Chinese</option>
                                            <option value="North Indian">Indian</option>
                                            <option value="Dessert">Dessert</option>
                                            <option value="South Indian">South Indian</option>
                                            <option value="Japanese">Japanese</option>
                                            <option value="European">European</option>
                                            <option value="Thai">Thai</option>
                                            <option value="Korean">Korean</option>
                                            <option value="Continental">Continental</option>
                                            <option value="Mexican">Mexican</option>
                                            <option value="Others">Others</option>
                                        </select></td>
                                </tr>
                                <tr>
                                    <td><label for="recipe_img">Upload your Recipe Image</label></td>
                                    <td><input type="file" name="recipe_img" value="" id="fileUpload" /></td>
                                </tr>


                            </table>
                            <div class="button-container">

                                <input type="submit" class="submit" id="submit" name="submit" value="Submit Form">
                                <button type="reset" class="reset" id="reset" name="reset" value="Reset Form">Reset Form</button>
                            </div>

                        </form>
                    </div>
            </fieldset>
        </div>
    </section>

    <?php

    // Connect to the database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "grubhub";
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    if (isset($_REQUEST['submit']))
    {
        if (empty($_POST["name"]) || empty($_POST["cuisine"]) || empty($_POST["instructions"]) || null==$_FILES['recipe_img'] ) {
            echo  '<script>alert("Fill the details")</script>';
            die();

            // One or more required fields are empty
          }
        // Get the form data
        $name = $_POST['name'];
        $ingredients = "";

        if (!empty($_POST['ingredients']))
            $ingredients = $_POST['ingredients'];

        $newIngredient = $_POST['add_ingre'];
        $instructions = $_POST['instructions'];
        $cuisine=$_POST['cuisine'];
        
        // Add the new ingredient to the list
        // if (!empty($newIngredient)) {
        // $ingredients[] = $newIngredient;
        // }

        // Convert the ingredients array to a string
        if (!empty($ingredients))
            // $ingredients=null;
            $ingredientsString = implode(", ", $ingredients);
        // echo $ingredientsString;
        if (!empty($newIngredient)) {
            $newIngredient = ucwords(strtolower($newIngredient));
            // echo $newIngredient;
            $ingredientsString = $ingredientsString . ", " . $newIngredient;
        }
        // echo $ingredientsString."all ingred";}

        //only new ingredient array and adding to ingrdients table
        $new_ing = explode(",", $newIngredient);
        $app_id = '1218c4df';
        $app_key = '3008f99333511751a1a79c119b87f955';
        foreach ($new_ing as $ingredient) {

            // Build the API request URL
            $url = 'https://api.edamam.com/api/food-database/v2/parser?ingr=' . urlencode($ingredient) . '&app_id=' . $app_id . '&app_key=' . $app_key;

            // Send the API request and get the response
            $response = file_get_contents($url);

            // Parse the response JSON into a PHP array
            $result = json_decode($response, true);

            // Check if the API returned a valid result

            // Check if the API returned a valid result
            if (isset($result['hints'][0]['food']['label'])) {
                continue; // Add the validated ingredient to the array
            } else {
                // header('Location: home.php?error=invalid_ingredient'); // Redirect the user back to the home page with an error message
                // exit(); // Stop further execution
                unset($new_ing);
                break;
            }
        }
        if (empty($new_ing)) {
            echo '<script type ="text/JavaScript">';
            echo 'alert("Invalid ingredient name")';
            echo '</script>';
        } else 
        {
                    
            if ($_SERVER["REQUEST_METHOD"] == "POST") 
            {
                if (isset($_FILES['recipe_img']) && $_FILES["recipe_img"]["error"] == 0) {
                    $allowed = array("png" => "image/png", "jpeg" => "image/jpeg", "jpg" => "image/jpg");
                    $image = $_FILES["recipe_img"]["name"];
                    $tempname = $_FILES["recipe_img"]["tmp_name"];
                    $filetype = $_FILES["recipe_img"]["type"];
                    $filesize = $_FILES["recipe_img"]["size"];
                    //Verify file extension
                    $ext = pathinfo($image, PATHINFO_EXTENSION);
                    if (!array_key_exists($ext, $allowed)) {
                        echo '<script type ="text/JavaScript">';
                        echo 'alert("Invalid File extension. use .jpeg, .jpg, .png")';
                        echo '</script>';
                    } else {
                        //verify MAX size-50MB
                        $maxsize = 50 * 1024 * 1024;
                        if ($filesize > $maxsize) {
                            echo '<script type ="text/JavaScript">';
                            echo 'alert("File size is larger than the allowed limit of 50MB.")';
                            echo '</script>';
                        } else {
                            // Verify MYME type of the file
                            if (in_array($filetype, $allowed)) {
                                // Check whether file exists before uploading it
                                if (file_exists("uploads/" . $image)) {
                                    echo '<script type ="text/JavaScript">';
                                    echo 'alert("$image . " is already exists.You another name.")';
                                    echo '</script>';
                                } else { // Save the image file
                                    $target_dir = "uploads/" . $image;
                                    // // $target_file = $target_dir . basename($image["name"]);
                                    move_uploaded_file($tempname, $target_dir);
                                    echo '<script type ="text/JavaScript">';
                                    echo ' alert("Your file was uploaded successfully")';
                                    echo '</script>';
                                    foreach ($new_ing as $x) {
                                        $x = trim($x);
                        
                                        if (str_word_count($x) == 1) {
                                            $query = "Insert Ignore into ingredients(ing_name) values('$x') ";
                                            $conn->query($query);
                                        }
                                        // echo "Ingredinet added succesfully to ing table";
                                    }
                        
                        
                                    
                                    // Insert the recipe into the database
                                    $sql = "INSERT INTO recipe (name,ingredients, instruction,image,cuisine) VALUES ('$name', '$ingredientsString','$instructions','$image','$cuisine')";
                        
                                    if ($conn->query($sql) === TRUE) {
                                        echo '<script type ="text/JavaScript">';
                                        echo 'alert("Recipe added successfully")';
                                        echo '</script>';
                                    } else {
                                        echo '<script type ="text/JavaScript">';
                                        echo 'alert("Error")';
                                        echo '</script>';
                                        // echo 'alert("Error: " . $sql . "<br>" . $conn->error);
                                    }
                                }
                            } else {
                                echo '<script type ="text/JavaScript">';
                                echo 'alert("Failed to upload image!")';
                                echo '</script>';
                            }
                        }
                    }
                } else {
                    echo '<script type ="text/JavaScript">';
                    echo 'alert("File isnt set")';
                    echo '</script>';
                }
            }
            
        }
    }


    // Close the database connection
    $conn->close();
    ob_end_flush(); // Flush the output buffer and send the output to the browser
    ?>