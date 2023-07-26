<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"/>



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">

    <link rel="stylesheet" href="style4.css">
    <link rel="stylesheet" href="style1.css">
    <script>
        function runSpeechRecognition() {
            // get reference to the input field and the action span element
            var userInput = document.getElementById("user-inp");
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
    

</head>
<body>
<!-- header section starts -->

<section class="header">
<?php
    include('header.php');
    ?>
    </section>

<!--Header ends-->
 
    <section class="recipe">
        <div class="container">
            <div class="search-container">
                <form action="" method="POST">
                    <input type="text" placeholder="Type the dish name" id="user-inp" name="user-inp" />
                    <button type="button" id="speak" onclick="runSpeechRecognition()"><i class="fa fa-microphone"></i></button> &nbsp; <span id="action"></span></p>
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
        $name='';
        $query_run='';
        if(isset($_POST['submit']))
        {
            // Get the form data
            $name = $_POST['user-inp'];
            $query= "Select * from `recipe` where name like '%$name%'";
            $query_run=mysqli_query($conn,$query);
        
        
        if(mysqli_num_rows($query_run)>0){

                while($row=mysqli_fetch_array($query_run)){

        ?>
        
            <img src="./uploads/<?php echo $row['image'];?>" height=100px width=100px>
        
                
                <div class="details">
                    <h2><?php echo $row['name'];?></h2>
                </div>

                <div class="ingredient-con">
                    <h4>Required Ingredients are:</h2>
                    <ul>
                    <?php
                        $ing=$row['ingredients'];
                        $ingredients=preg_split ("/\,/", $ing);
                        $arrlength=count($ingredients);
                        for($x = 0; $x < $arrlength; $x++) {?>
                            <li><?php echo $ingredients[$x];?></li>    
                        <?php ;}?>
                    </ul>
                </div>
                <div class="recipe-details">
                    <button id="hide-recipe">X</button>
                    <pre id="instruction"><?php echo $row['instruction'];?></pre>
                </div>
                <form action="instr.php" method="POST">
                    <input type="hidden" name="instruction" value="<?php echo $row['instruction'];?>">
                    <button id="show-recipe" name="show-recipe">View Recipe</button>
                </form>
  
        <?php
                }
            }
        else{
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
    .footer{
    background-color:var(--main-color);
    position:relative;
    top:5em;
}
</style>
