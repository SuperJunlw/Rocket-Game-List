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
        echo '<script> showMessage("Game added to the list.", 2000); </script>';
    } else {
        // Failed insertion
        echo '<script> showMessage("Error adding game to the list: " . $stmt->error, 2000); </script>';
    }

    // Close the statement
    $stmt->close();
}

// Check if the search form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['searchKeyword'])) {
    // Retrieve the search keyword from the form submission
    $searchKeyword = $_POST['searchKeyword'];

    // Create the API URL with the search keyword
    $apiUrl = "https://rawg.io/api/games?search=" . urlencode($searchKeyword) . "&key=df331e96509e4da4b3a9d7e6f4f94818";

    // Fetch the data from the API
    $apiResponse = file_get_contents($apiUrl);

    // Check if the API request was successful
    if ($apiResponse !== false) {
        // Decode the API response JSON
        $data = json_decode($apiResponse, true);

        // Check if the data retrieval was successful
        if (isset($data['results'])) {
            foreach ($data['results'] as $game) {
                $name = $game['name'];
                $description = $game['description'];
                $backgroundImage = $game['background_image'];

                // Display the information for each search result as a card
                echo <<<HTML
                    <div class="card">
                        <div class="card-image"><img src="$backgroundImage"></div>
                        <div class="card-title"><h2>$name</h2></div>
                        <div class="description"><p>Description: $description</p></div>
                        <div class="ButtonForm">
                            <form action="#" method="post">
                                <input type="hidden" name="gameId" value="$name">
                                <button type="submit" name="addToList">Add to List</button>
                            </
                            form>
                        </div>
                    </div>
                HTML;
            }
        } else {
            // Handle the case when no search results are found
            echo '<script> showMessage("No results found.", 2000); </script>';
        }
    } else {
        // Handle the case when API request fails
        echo '<script> showMessage("Error retrieving search results.", 2000); </script>';
    }
}

?>

<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    <link rel="stylesheet" href="search.css" />
    <script src="message.js"></script>
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
    </div>
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
    // Display any messages
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['searchKeyword'])) {
        echo '<div id="message"></div>'; // Create a container for displaying messages
    }
    ?>

</section>

</body>
</html>
