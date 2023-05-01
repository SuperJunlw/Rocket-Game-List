<?php

//use this to test if you have mysqli enabled as a extension on your php.ini file.

if (!function_exists('mysqli_init') && !extension_loaded('mysqli')) {
    echo 'We don\'t have mysqli!!!';
} else {
    echo 'Phew we have it!';
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
        $checkSql = mysqli_prepare($conn, "SELECT * FROM rocketdb.USER WHERE user_name = ? AND user_password = ?");

        // Bind parameters to prepared statement
        mysqli_stmt_bind_param($checkSql, "ss", $user, $password);

        // Execute prepared statement
        mysqli_stmt_execute($checkSql);

        $result = mysqli_stmt_get_result($checkSql);

        //check if user account already exist
        if (mysqli_num_rows($result) >= 1) {
            echo "User account already exist. Please login instead.";
        } 
        //if not, insert the new user info to the db
        else {
            $insertSql = "INSERT INTO rocketdb.USER (user_name, user_password, email)
            VALUES ('$user', '$password', '$email')";

            if (mysqli_query($conn, $insertSql)) {
                echo "You have sign up successfully!";
            } 
            else {
                echo "Error: " . $insertSql . "<br>" . mysqli_error($conn);
            }
        }

        mysqli_stmt_close($checkSql);
        mysqli_close($conn);
    }
    validate_signup();
?>