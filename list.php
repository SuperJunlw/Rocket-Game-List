<?php
session_start();
echo $_SESSION['user_name'];
?>

<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List</title>
    <link rel="stylesheet" href="list.css" />
  </head>
  <body>

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
                  <li><a href="search.php">Search</a></li>
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
        <h1>My List</h1>
    </div>

    <section class="container">
    <?php
// Step 1: Establish database connection

$servername = "cos-cs106.science.sjsu.edu";
$dbusername = "rocketuser";
$dbpassword = "WhVL##77JK";

    //creating a connection
    $conn = new mysqli($servername, $dbusername, $dbpassword);
    
    //checking the connection
    
    if ($conn->connect_error)
    {
        die("Connection failed: " . $conn->connect_error);
    
    }

    // Retrieve form data


    // Create SQL query
    $sql = "SELECT * FROM rocketdb.GAME_LIST natural join rocketdb.GAME where GAME_LIST.user = ?;";

// Prepare SQL query
    $stmt = mysqli_prepare($conn, $sql);

// Bind parameters to prepared statement
    mysqli_stmt_bind_param($stmt, "s", $_SESSION['user_name']);

// Execute prepared statement
    mysqli_stmt_execute($stmt);

// Get results
    $result = mysqli_stmt_get_result($stmt);
    $userinfo = mysqli_fetch_assoc($result);

// Step 3: Fetch rows and display as cards
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      //display the cards
      echo <<<HTML
    <div class="card">
        <div class="card-image card1"></div>
        <div class="card-title">
            <h2>{$row['game_name']}</h2>
        </div>
        <div class="description">
            <p>{$row['game_description']}</p>
        </div>
        <div class="checkbox">
          <input type = "checkbox" id = "check">
          <label for="checkbox">Completed?</label>
        </div>
        <div class="ButtonForm">
            <form action="#" method="post">
                <input type="hidden" name="gameId" value="{$row['game_id']}">
                <button type="submit" name="removeFromList">Remove From List</button>
            </form>
        </div>
    </div>
HTML;
    }
} else {
    echo "No rows found.";
}

// Step 5: Close the database connection
$conn->close();
?>



    </section>

  </body>
</html>
