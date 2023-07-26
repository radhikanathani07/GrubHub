<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <title>Available Ingredients</title>
    <link rel="stylesheet" href="style1.css">

    <style>
        <?php include "Home.php" ?>* {
            margin: auto;
            padding: auto;
        }

        body {
            background-color: white;
        }

        .center {
            margin-left: auto;
            margin-right: auto;
        }


        td {
            border: 2px solid black;
            padding: 0.5rem;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            color: black;
        }

        th {
            border: 2px solid black;
            padding: 0.5rem;
            text-align: center;
            font-size: 25px;
            color: black;
        }

        table {
            margin: 0px;
            padding: 0px;
            width: 75%;
            border-collapse: collapse;
        }

        tbody tr:nth-child(odd) {
            background: #fff9;
        }

        tbody tr:nth-child(even) {
            background: #fff9;
        }

        caption {
            font-size: 0.8rem;
        }

        input[type="checkbox"] {
            -webkit-appearance: none;
            height: 50px;
            width: 50px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid black;
            background-color: black;
        }

        input[type="checkbox"]:after {
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            content: "\f00c";
            font-size: 50px;
            color: black;
            display: none;
        }

        input[type="checkbox"]:hover {
            background-color: #735f75;
        }

        input[type="checkbox"]:checked {
            background-color: #5bcd3e;
        }

        input[type="checkbox"]:checked:after {
            display: block;
        }

        .items {

            display: flex;
            align-items: center;
            justify-content: center;
            margin: 70px auto;
        }

        .items a {

            font-weight: bold;

            font-size: 18px;

            color: black;

            float: left;

            padding: 8px 16px;

            text-decoration: none;

            border: 1px solid black;

            margin: 2px;

        }

        .items a.active {

            background-color: rgba(175, 201, 244, 0.97);

        }

        .items a:hover:not(.active) {

            background-color: #87ceeb;

        }

        .choose_txt {
            font-weight: bold;
            font-size: 20px;
            margin: auto;
            width: 50%;
        }

        .button {
            display: inline-block;
            padding: 8px 16px;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            background-color: #007bff;
            color: #fff;
            border-radius: 4px;
            transition: all 0.2s ease-in-out;
        }

        .button_container {
            display: flex;
            justify-content: space-between;
            /* or space-between, space-around, etc. */
        }


        /* Button Hover State */
        .button:hover {
            background-color: #0069d9;
            color: #fff;
            cursor: pointer;
        }

        /* Button Active State */
        .button:active {
            background-color: #0052cc;
            color: #fff;
        }

        #myButton,
        #myButton1 {
            background-color: #76934a;
            border: none;
            color: white;
            padding: 8px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 20px;
            margin: 2px;
            cursor: pointer;
            font-weight: 600;
            border-radius: 0.3em;
            width: 100px;
            height: 40px;
        }

        #myButton2 {
            background-color: #76934a;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: block;
            font-size: 16px;
            margin: 5% auto;
            cursor: pointer;
            border-radius: 4px;
            transition-duration: 0.4s;

            /* align-self: center;
        justify-self: end; */
        }

        #myButton2:hover,
        #myButton:hover,
        #myButton1:hover {
            background-color: #ffd180;
        }
    </style>
    <script>
        function SearchPhotos(query) {
            let clientId = "TC80JVCb0gdWbvlspE2T25rtqbmiiRpa4HLjeDg63gc";
            //let query= "potato";

            // let txt1 = " eatables";
            // let query1 = query.concat(txt1);
            let url = "https://api.unsplash.com/search/photos/?client_id=" + clientId + "&query=" + query;

            fetch(url)
                .then(function(data) {
                    return data.json();
                })
                .then(function(data) {
                    //console.log(data.results[1].urls.regular);
                    let x = data.results[1].urls.regular;

                    let result = `<img src="${x}" width="90px" height="90px" >`;

                    $("#" + query).html(result);
                    //document.getElementById("result").append(result)
                });

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
    <br><br><br>
    <div class='choose_txt'>Choose the ingredients you have available with you at home!</div>
    <br><br>
    <?php

    $dbhost = 'localhost';
    $dbname = 'grubhub';
    $dbuser = 'root';
    $dbpass = '';

    try {
        $pdo = new PDO("mysql:host={$dbhost};dbname={$dbname}", $dbuser, $dbpass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $exception) {
        echo "Connection error :" . $exception->getMessage();
    } ?>

    <!-- <div class="page-banner">
        <div class="offer-heading">
            <h1>
                
            </h1>
        </div>
    </div> -->

    <div class="ingredients">
        <?php

        $statement = $pdo->prepare("SELECT * FROM ingredients");
        $statement->execute();
        $total_rows = $statement->rowCount();

        $targetpage = "choose_ingre.php?";
        $limit = 5;
        if (isset($_GET["page"])) {
            $page_number  = $_GET["page"];
        } else {
            $page_number = 1;
        }


        $initial_page = ($page_number - 1) * $limit;


        $statement = $pdo->prepare("SELECT * FROM ingredients LIMIT $initial_page,$limit");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        $total_pages = ceil($total_rows / $limit);

        if (!$total_pages) { ?>
            <h2 class="no-ingredient">No Ingredients found!</h2>
        <?php } else {
        ?> <table class='center'>
                <tr>

                    <th style="width:40%">Ingredient</th>
                    <th style="width:40%">Name</th>
                    <th style="width:20%">Choose</th>
                </tr>
                <?php
                foreach ($result as $row) {
                    $name = $row["ing_name"];
                    //echo gettype($name);
                ?>

                    <tr>
                        <td id="<?php echo $name; ?>">
                            <script language="javascript">
                                SearchPhotos("<?php echo $name; ?>")
                            </script>
                        </td>

                        <td><?php echo ucfirst($row["ing_name"]) ?></td>

                        <td class='chk'>
                            <div class="button-container">
                                <form action="" method="POST">
                                    <input type="hidden" name="name" value="<?php echo $name; ?>">
                                    <button id="myButton" name="add_ingre">Add</button>
                                </form>
                                <!-- <div id="myButtonval"><input type="hidden" name="name" value=""></div> -->
                                <form action="" method="POST">
                                    <input type="hidden" name="name1" value="<?php echo $name; ?>">
                                    <button id="myButton1" name="del_ingre">Remove</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php
                } ?>
            </table><?php
                    ?>
            <div class="items">
                <?php
                $pageURL = "";

                if ($page_number >= 2) {

                    echo "<a href='$targetpage&page=" . ($page_number - 1) . "'>  Prev </a>";
                }

                for ($i = 1; $i <= $total_pages; $i++) {

                    if ($i == $page_number) {
                        $pageURL .= "<a class = 'active' href='$targetpage&page=" . $i . "'>" . $i . " </a>";
                    } else {
                        $pageURL .= "<a href='$targetpage&page=" . $i . "'>" . $i . " </a>";
                    }
                };

                echo $pageURL;

                if ($page_number < $total_pages) {
                    echo "<a href='$targetpage&page=" . ($page_number + 1) . "'>  Next </a>";
                }
                ?>
            </div>
            <form action="show1.php" method="POST">
                <button id="myButton2" type="submit" name="submit">Search</button>
            </form>
        <?php
        }
        ?>
    </div>

    <?php
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $dbname = 'grubhub';

    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    if (isset($_POST['add_ingre'])) {
        $ingre = $_POST['name'];
        // Check if the product is already in the cart
        $result = mysqli_query($conn, "SELECT * FROM ingre WHERE name = '$ingre'");
        if (mysqli_num_rows($result) > 0) {
            // Ingredient already added
            $message = "Ingredient already selected!";
        } else {
            // Product is not in the cart, insert a new row
            mysqli_query($conn, "INSERT INTO ingre VALUES ('$ingre')");
            $message = "Ingredient successfully selected";
        }
    }

    if (isset($_POST['del_ingre'])) {
        $ingre = $_POST['name1'];
        mysqli_query($conn, "DELETE FROM ingre WHERE name = '$ingre'");
        $message = "Ingredient successfully removed";
        echo "<script>alert('$message');</script>";
    }


    ?>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <!-- footer section starts -->
    <section class="footer">
        <?php
        include('footer.php');
        ?>
    </section>


</body>