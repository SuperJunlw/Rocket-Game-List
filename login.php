<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css" />
  </head>
  <body>
    
    <!--NAV BAR HELP: https://www.youtube.com/watch?v=oLgtucwjVII -->
    <nav>
        
        <div class="logo">Rocket Game List</label>
        <ul class= "nav-links">
          <input type="checkbox" id="checkbox_toggle" />
          <label for="checkbox_toggle" class="hamburger">&#9776;</label>
        
          <div class = "menu">
            <ul>
              <li><a href="home.php">Home</a></li>
              <li><a href="search.php">Search</a></li>
              <li><a href="list.php">List</a></li>
              <li><a href="login.php">Login</a></li>
              <li><a href="signup.php">Sign Up</a></li>
              <button id="logout">LOGOUT</button>
            </ul>
          </div>
        </ul>
    </nav>

    <div class = "LoginForm">
        <h1>Login In</h1>
            <form action = "./login.php" method="post">
                <p> Username: </p>
                <input type = "text" name = "user" placeholder="Username">
                <p> Password: </p>
                <input type = "password" name = "password" placeholder="Password">
                <p></p>
                <button type="submit">Login</button>
                <p class="formText"> Need an account? Sign Up Here</p>
            </form>
    </div>

<?php

if (!empty($_POST)){
    validate_login();
}

function validate_login()
{

    $user = $_POST["user"];
    $password = $_POST["password"];


    $user = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

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
    $sql = "SELECT * FROM rocketdb.USER WHERE user_name = ? AND user_password = ?";

// Prepare SQL query
    $stmt = mysqli_prepare($conn, $sql);

// Bind parameters to prepared statement
    mysqli_stmt_bind_param($stmt, "ss", $user, $password);

// Execute prepared statement
    mysqli_stmt_execute($stmt);

// Get results
    $result = mysqli_stmt_get_result($stmt);
    $userinfo = mysqli_fetch_assoc($result);

        // Check for empty result set
        if (mysqli_num_rows($result) == 0) {
            ?>
                <div class="errorMsg"><p style="color:red;">Invalid username or password</p></div>
            <?php
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
        } else {

            //session start
            session_start();
            $_SESSION['user_name'] = $userinfo['user_name'];
            $_SESSION['logged_in'] = true;
            header("Location: list.php");
           // echo "test";
            
            //close sql connection and redirect to other page
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            
            exit;
        }
}
?>
  </body>
</html>
