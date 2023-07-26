<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"/>



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">

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

<!--Home Section start-->
<section class="home">
    <div class="swiper home-slider">
        <div class="swiper-wrapper">
            <div class="swiper-slide slide" style="background:url(images/dal.jpg) no-repeat; margin-top:10%;">
                <div class="content">
                    <h3>Lip-smacking Homely Recipes</h3>
                    <a href="show.php" class="btn">Discover More</a>
                </div>
            </div>

            <div class="swiper-slide slide" style="background:url(images/fish.jpg) no-repeat">
                <div class="content">
                    <h3>No Hassle Appetizers</h3>
                    <a href="show.php" class="btn">Discover More</a>
                </div>
            </div>

            <div class="swiper-slide slide" style="background:url(images/pizza.jpg) no-repeat">
                <div class="content">
                    <h3>Recipe Audio-book for Inclusivity</h3>
                    <a href="show.php" class="btn">Discover More</a>
                </div>
            </div>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</section>

<!--Home Section End-->

<!--services section start-->
<section class="services">
    <h1 class="heading-title">Our Services</h1>
    <div class="box-container">
        <div class="box">
            <a href="add_recipe.php">
            <img src="images/recipes.png" alt="">
            <h3>Add Recipe</h3></a>
        </div>
        <div class="box">
            <a href="show.php">
            <img src="images/search.png" alt="">
            <h3>Find Recipe</h3></a>
        </div>
        <div class="box">
            <img src="images/audiobook.png" alt="">
            <h3>Audio-Book </h3>
        </div>
        <div class="box">
        <a href="recently_added.php">
            <img src="images/recent.png" alt="">
            <h3>Recently Added</h3></a>
        </div>
        
    </div>
</section>
<!--services section end-->

<!--home about section starts-->
<section class="home-about">
    <div class="content">
        <h3>About Us</h3>
        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Officiis omnis distinctio quam aliquid aperiam. Praesentium eum repellat maxime soluta consequatur quas, minima doloremque voluptate, quo nam, odio laboriosam voluptas impedit.</p>
        <a href="about.php" class="btn">Read More</a>
    </div>
    <div class="image">
        <img src="images/about.jpg" alt="">
    </div>
    
</section>
<!--home about section ends-->



<!--home packages section starts-->


<!-- footer section starts -->

<section class="footer">
    <?php
    include('footer.php');
    ?>
</section>









<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>

<script src="script.js"></script>
</body>
</html>