<?php
session_start();
//echo $_SESSION['user_name'];
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
    $sql = "SELECT * FROM rocketdb.GAME_LIST where GAME_LIST.user = ?;";

// Prepare SQL query
    $stmt = mysqli_prepare($conn, $sql);

// Bind parameters to prepared statement
    mysqli_stmt_bind_param($stmt, "s", $_SESSION['user_name']);

// Execute prepared statement
    mysqli_stmt_execute($stmt);

// Get results
    $result = mysqli_stmt_get_result($stmt);

// Step 3: Fetch rows and display as cards
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      //display the cards
        // Get game information from RAWG API based on game_id
        $gameId = $row['game_id'];
        $apiUrl = "https://api.rawg.io/api/games/$gameId?&key=df331e96509e4da4b3a9d7e6f4f94818";
        $apiResponse = file_get_contents($apiUrl);
        $gameData = json_decode($apiResponse, true);

        // Extract relevant information from the gameData
        $imageUrl = $gameData['background_image'];
        $gameName = $gameData['name'];
        $genres = "";
        foreach ($gameData['genres'] as $genre) {
            $genres .= $genre['name'] . "/";
        }
        $genres = rtrim($genres, "/"); // Remove trailing slash
        $releaseDate = $gameData['released'];

        // Generate HTML code for the card
        echo '
            <div class="card">
                <div class="card-image"><img src="' . $imageUrl . '"></div>
                <div class="card-title"><h2>' . $gameName . '</h2></div>
                <div class="genre"><p>Genre: ' . $genres . '</p></div>
                <div class="release-date"><p>Release Date: ' . $releaseDate . '</p></div>
            </div>
        ';
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
