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
                  <li><a href="#">Search</a></li>
                  <li><a href="#">List</a></li>
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
        // Step 4: Create card template and populate with data
        echo '<section class="container">';
        echo '    <div class="card">';
        echo '        <div class="card-image card1"></div>';
        echo '        <div class="card-title">';
        echo '            <h2 id="gameTitle">' . $row["game_name"] . '</h2>';
        echo '        </div>';
        echo '        <div id="gameDescription" class="description">';
        echo '            <p>' . $row["game_description"] . '</p>';
        echo '        </div>';
        echo '        <div class="checkbox">';
        echo '          <input type="checkbox" id="check">';
        echo '          <label for="checkbox">Completed?</label>';
        echo '        </div>';
        echo '        <div class="ButtonForm">';
        echo '            <form action="#" method="post">';
        echo '                <button>Remove from List</button>';
        echo '            </form>';
        echo '        </div>';
        echo '    </div>';
        echo '</section>';
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
