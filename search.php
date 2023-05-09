<?php
session_start();
//echo $_SESSION['user_name'];

// Step 1: Establish database connection
$servername = "cos-cs106.science.sjsu.edu";
$dbusername = "rocketuser";
$dbpassword = "WhVL##77JK";
$dbname = "rocketdb";

// Create a new instance of MySQLi
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the "Add to List" button is clicked
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addToList'])) {
      // Retrieve the game ID from the form submission
      $gameId = $_POST['gameId'];

      // Get the logged-in user ID from the session (assuming you have implemented user authentication)
      $userId = $_SESSION['user_name'];

      // Prepare the SQL statement to insert into the game list
      $sql = "INSERT INTO rocketdb.GAME_LIST (game_id, user) VALUES (?, ?)";

      // Prepare the statement
      $stmt = $conn->prepare($sql);

      // Bind parameters to the prepared statement
      $stmt->bind_param("is", $gameId, $userId);

      // Execute the statement
      if ($stmt->execute()) {
          // Successful insertion
          echo 'Game added to list.';
      } else {
          // Failed insertion
          echo 'Game added to list.';
      }

      // Close the statement
      $stmt->close();
      exit;
}
?>

<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    <script type = "text/javascript" src="search.js"></script>
    <link rel="stylesheet" href="search.css" />
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
              <li><a href="search.php">Search</a></li>
              <li><a href="list.php">List</a></li>
              <li><a href="login.html">Login</a></li>
              <li><a href="signup.html">Sign Up</a></li>
              <?php
          }
          ?>
        </ul>
      </div>
    </ul>
</nav>

<!--
<div class="title">
  <h1>Search</h1>
</div>
        -->


        <div class="searchBar">
          <form action="" method="post" class="search" id="searchform">
            <label for="searchgame"></label>
            <input required type="text" placeholder="Search.." id="searchgame" name="searchgame">
            <button type="button" id="search-button">Search</button>
          </form>
        </div>


        <script>
          const searchButton = document.getElementById("search-button");
          const input = document.getElementById("searchgame");
          const searchForm = document.getElementById("searchform");

          input.addEventListener("keyup", function(event) {
            if (event.key === "Enter")
            {
              event.preventDefault();
              searchButton.click();
            }
          });

          
          searchForm.addEventListener("submit", function(event) {
            event.preventDefault(); // Prevent form submission
            getInfos();
          });
          

          searchButton.addEventListener("click", event => {
          event.preventDefault();
          getInfos();
          });
        </script>

<!--CARD HELP: https://www.youtube.com/watch?v=qXRYMdvq_Dc -->
<section section id="container" class="container">



</section>

</body>
</html>
