<?php
session_start();
echo $_SESSION['user_name'];

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
        echo "Game added to the list.";
    } else {
        // Failed insertion
        echo "Error adding game to the list: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}
?>

<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
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
                  <li><a href="#">Logout</a></li>
                  <?php
             
            } else {
              // User is not logged in, display default navigation items
              ?>
              <li><a href="#">Search</a></li>
              <li><a href="#">List</a></li>
              <li><a href="#">Login</a></li>
              <li><a href="#">Sign Up</a></li>
              <?php
          }
          ?>
        </ul>
      </div>
    </ul>
</nav>

<div class="title">
  <h1>Search</h1>
</div>

<div class="searchBar">
  <form method="post">
    <input type="text" name="searchKeyword" placeholder="Search your game">
    <button type="submit">Search</button>
  </form>
</div>

<!--CARD HELP: https://www.youtube.com/watch?v=qXRYMdvq_Dc -->
<section class="container">

  <?php
  // Retrieve form data
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Retrieve the search keyword from the form submission
      $searchKeyword = $_POST['searchKeyword'];

      // Create SQL query
      $sql = "SELECT * FROM rocketdb.GAME WHERE game_name LIKE CONCAT('%', ?, '%')";

      // Prepare SQL query
      $stmt = mysqli_prepare($conn, $sql);

      // Bind parameters to prepared statement
      $searchKeyword = '%' . $searchKeyword . '%';
      mysqli_stmt_bind_param($stmt, "s", $searchKeyword);

      // Execute prepared statement
      mysqli_stmt_execute($stmt);

      // Get results
      $result = mysqli_stmt_get_result($stmt);

      while ($row = $result->fetch_assoc()) {
          // Display the information for each search result as a card
          echo '<div class="card">';
          echo '    <div class="card-image card1"></div>';
          echo '    <div class="card-title">';
          echo '        <h2>' . $row['game_name'] . '</h2>';
          echo '    </div>';
          echo '    <div class="description">';
          echo '        <p>' . $row['game_description'] . '</p>';
          echo '    </div>';
          echo '    <div class="ButtonForm">';
          echo '        <form action="#" method="post">';
          echo '            <input type="hidden" name="gameId" value="' . $row['game_id'] . '">';
          echo '            <button type="submit" name="addToList">Add to List</button>';
          echo '        </form>';
          echo '    </div>';
          echo '</div>';
      }

      // Close the statement
      mysqli_stmt_close($stmt);
  }

  ?>

</section>

</body>
</html>
