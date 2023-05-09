<?php
session_start();

?>

<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="home.css" />
  </head>
  <body>
    
    <!--NAV BAR HELP: https://www.youtube.com/watch?v=oLgtucwjVII -->
    <nav>
        <div class="logo">Rocket Game List
        <ul class="nav-links">
          <input type="checkbox" id="checkbox_toggle" />
          <label for="checkbox_toggle" class="hamburger">&#9776;</label>
          <div class="menu">
            <ul>
              <?php
              if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
                  // User is logged in, display logged-in navigation items
                  ?>
                  <li><a href="search.php">Search</a></li>
                  <li><a href="list.php">List</a></li>
                  <li><a href="logout.php">Logout</a></li>
                  <?php
             
            } else {
              // User is not logged in, display default navigation items
              ?>
              <li><a href="home.php">Home</a></li>
              <li><a href="search.html">Search</a></li>
              <li><a href="list.php">List</a></li>
              <li><a href="login.php">Login</a></li>
              <li><a href="signup.php">Sign Up</a></li>
              <?php
          }
          ?>
        </ul>
      </div>
    </ul>
</nav>

<div class="Description">
    <p class="text">Rocket Game List is a video game record-keeping web application for gamers to search for game information, save a video game list, and keep track of the played games.</p>
    <a href="login.php" class="homeButton">Login or Sign Up to get started!</a>
</div>


</body>
</html>