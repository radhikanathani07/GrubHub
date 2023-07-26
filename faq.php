<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQs</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">

    <link rel="stylesheet" href="style1.css">
    <link rel="stylesheet" href="style4.css">
</head>
<body>
    
    <section class="header">
    <?php
        include('header.php');
        ?>
    </section>
    <div class="container">

            <h1 class="faq-heading">FAQ'S</h1>
            <div class="faq">
            <div class="question">
            <h2>Can I substitute an ingredient in the recipe?</h2>
            <div class="answer">
                <p>Yes, you can substitute an ingredient in the recipe, but keep in mind that it may alter the taste and texture of the dish. It's always best to use the ingredients listed in the recipe.</p>
            </div>
            </div>
            <div class="question">
            <h2>Can I use metric measurements instead of imperial measurements?</h2>
            <div class="answer">
                <p>Yes, you can use metric measurements instead of imperial measurements, but you may need to convert the measurements yourself.</p>
            </div>
            </div>
            <div class="question">
            <h2>How do I adjust the serving size of a recipe?</h2>
            <div class="answer">
                <p>To adjust the serving size of a recipe, simply multiply or divide the ingredients by the number of servings you want. For example, if a recipe serves 4 and you want to serve 8, double all the ingredients.</p>
            </div>
            </div>
            <div class="question">
            <h2>How to add your own recipe?</h2>
            <div class="answer">
                <p>You can go to <a href="add_recipe.php">Add Recipe </a>page and enter the details accorindingly and add your recipe <p>
            </div>
            </div>
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
    .container{
    background-color: var(--light-white);
    font-size: 16px;
    padding:3em 2.8em;
    width: 90vw;
    max-width: 75;
    position: relative;
    transform: translate(-50%);
    left: 50%;
    top: 2em;
    border-radius: 0.6em;
    border: 2px solid #76934a;
    box-shadow: 0 1.2em 2.5em --box-shadow  ;
}

 .container h2 a{
    color:var(--main-color);
    font-size: 3rem;
}
.faq-heading{
    color:var(--main-color);
    font-size: 5rem;
} 
h1 {
  text-align: center;
  margin-bottom: 30px;
}

.faq {
  margin-bottom: 30px;
}

.question {
  background-color:var(--main-color) ;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
  margin-bottom: 10px;
  transition: transform 0.2s ease-in-out;
}


.question:hover {
  transform: scale(1.05);
}
.question h2 {
  font-size: 20px;
  font-weight: bold;
  margin-bottom: 10px;
  cursor: pointer;
  color:white ;
}

.question .answer {
  display: none;
  font-size: 16px;
  line-height: 1.5;
}

.question .answer p {
  margin: 2rem 0;
  color:var(--font-color);
}
.question:hover h2::after {
  color: var(--lighter-bg-color);;
}

.question.active .answer {
  display: block;
  margin-top: 10px;
}

.question.active h2::after {
  content: "-";
}

.question h2::after {
  content: "+";
  float: right;
  
}


.question.active h2::after {
  float: right;
  content: "-";
 

}

</style>
<script>
    const questions = document.querySelectorAll(".question");

    questions.forEach(function(question) {
        const answer = question.querySelector(".answer");

        question.addEventListener("click", function() {
            if (answer.style.display === "block") {
                answer.style.display = "none";
                question.classList.remove("active");
            } else {
                answer.style.display = "block";
                question.classList.add("active");
            }
        });
    });
</script>
</html>
