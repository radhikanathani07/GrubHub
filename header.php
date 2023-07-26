<a href="home.php" class="logo">GrubHub.</a>
<nav class="navbar">
        <a href="home.php" id="menu"<?php if (strpos($_SERVER['REQUEST_URI'], '/home.php') !== false) echo 'class="active"'; ?>>Home</a>
        <a href="show.php" id="menu"<?php if (strpos($_SERVER['REQUEST_URI'], '/show.php') !== false) echo 'class="active"'; ?>>Show Recipe</a>
        <a href="add_recipe.php" id="menu"<?php if (strpos($_SERVER['REQUEST_URI'], '/add_recipe.php') !== false) echo 'class="active"'; ?>>Add Recipe</a>
        <a href="recently_added.php" id="menu"<?php if (strpos($_SERVER['REQUEST_URI'], '/recently_added.php') !== false) echo 'class="active"'; ?>>Recently Added</a>
        <a href="faq.php" id="menu" <?php if (strpos($_SERVER['REQUEST_URI'], '/faq.php') !== false) echo 'class="active"'; ?>>FAQ's</a>
</nav>


<div id="menu-btn" class="fas fa-bars"></div>
<script>
        var currentLocation = window.location.href;
        var links = document.querySelectorAll("#menu");
        for (var i = 0; i < links.length; i++) {
                if (links[i].href === currentLocation) {
                        links[i].className = "active";
                        links[i].style.color = "orange"; // replace with the desired color
                }
        }
</script>