<html>
  <head>
    <title>Signup</title>
    <link rel="stylesheet" type="text/css" href="./signup.css" />
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
    
    <div class = "SignUpForm">
        <h1>Sign Up</h1>
            <form action = './signup.php' method="post">
                <p>Email Address:</p>
                <input type = "text" name = "email" placeholder="Email Address">
                <p>Username:</p>
                <input type = "text" name = "user" placeholder="Username">
                <p>Password:</p>
                <input type = "password" name = "password" placeholder="Password">
                <p></p>
                <button type="submit">Sign Up</button>
            </form>
    </div>

    <?php

    if (!empty($_POST)){
        if(empty($_POST["email"]) || empty($_POST["user"]) || empty($_POST["password"])){
            ?>
            <div class="emptyerrorMsg"><p style="color:red;">One or more missing fields</p></div>
            <?php
        }
        else{
            validate_signup();
        }
    }

    function validate_signup()
    {
        $email = $_POST["email"];
        $user = $_POST["user"];
        $password = $_POST["password"];

        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
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

        //prepare statement
        $checkSql = mysqli_prepare($conn, "SELECT * FROM rocketdb.USER WHERE user_name = ? OR email = ?");

        // Bind parameters to prepared statement
        mysqli_stmt_bind_param($checkSql, "ss", $user, $email);

        // Execute prepared statement
        mysqli_stmt_execute($checkSql);

        $result = mysqli_stmt_get_result($checkSql);

        //check if user account already exist
        if (mysqli_num_rows($result) >= 1) {
            ?>
            <div class="errorMsg"><p style="color:red;">Username or email already used. Please use another username or email</p></div>
            <?php
            mysqli_stmt_close($checkSql);
            mysqli_close($conn);
        } 
        //if not, insert the new user info to the db
        else {
            $insertSql = "INSERT INTO rocketdb.USER (user_name, user_password, email)
            VALUES ('$user', '$password', '$email')";

            if (mysqli_query($conn, $insertSql)) {

                $selectSql = "SELECT * FROM rocketdb.USER WHERE user_name = '$user' AND user_password = '$password'";
                $res = mysqli_query($conn, $selectSql);
                $userinfo = mysqli_fetch_assoc($res);

                session_start();
                $_SESSION['user_name'] = $userinfo['user_name'];
                $_SESSION['logged_in'] = true;

                mysqli_stmt_close($checkSql);
                mysqli_close($conn);
                header("Location: list.php");
            } 
            else {
                ?>
                <div class="errorMsg"><p style="color:red;">Error on creating account. Please try again later</p></div>
                <?php
                mysqli_stmt_close($checkSql);
                mysqli_close($conn);
            }
        }
    }
?>
    
  </body>
</html>
