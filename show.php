<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style1.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"/>



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">

    

</head>
<body>
 
<!-- header section starts -->

<section class="header">
<?php
    include('header.php');
    ?>
    </section>

<!--Header ends-->

<div class="background-image">
    <div class="two-buttons">
        <div><a id="first" href="choose_ingre.php">Choose by ingredients available</a></div>
        <div><a id="second" href="choose_recipe.php">Choose by recipe name</a></div>
        <div><a id="third" href="choose_cuisine.php">Choose by cuisine name</a></div>
    </div>
</div>
<!-- footer section starts -->

<section class="footer">
    <?php
    include('footer.php');
    ?>
</section>
    
</body>

<style>

    .background-image{
        background-image: url(images/show.jpg);
        background-size: cover;
        background-repeat: no-repeat;
        height: 100vh;
        opacity: 0.8;
        display:flex;
        position: relative;
        top: 10em;
        
    }

    .two-buttons{
        display:flex;
        justify-content: space-between;
        width: 75%;
        
        margin: 20px auto;
        padding-top: 80px;
    }

    .two-buttons a{
        font-size: 15px ;
        padding: 10px 45px;
        border-radius: 15px;
        border: 2px solid #76934a;

    }

    #first,#second,#third{
        position: relative;
        top:200px;
        background-color: #fff; 
        color: #76934a;
    }

    #first:hover,#second:hover,#third:hover{
        color: white;
        background-color: #76934a;
    }

</style>