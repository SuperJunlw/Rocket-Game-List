<?php

/* use this to test if you have mysqli enabled as a extension on your php.ini file.

if (!function_exists('mysqli_init') && !extension_loaded('mysqli')) {
    echo 'We don\'t have mysqli!!!';
} else {
    echo 'Phew we have it!';
}

*/
$servername = "cos-cs106.science.sjsu.edu";
$username = "rocketuser";
$password = "WhVL##77JK";

//creating a connection
$conn = new mysqli($servername, $username, $password);

//checking the connection

if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);

}

function validate_login()
{

    //select 

    //if a query is returned, the login is successful

}


function session_token()
{

    //this should just return a valid session token for a user

}



function sign_up()
{

    //insert into the database based on user input


}

echo "Connected successfully.";












?>