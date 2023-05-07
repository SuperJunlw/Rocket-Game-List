
<?php

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
            echo "Invalid username or password.";
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

validate_login();

?>