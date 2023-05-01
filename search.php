<?php
    function search()
    {
        $searchName = $_POST["name"];

        $searchName = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $servername = "cos-cs106.science.sjsu.edu";
        $dbusername = "rocketuser";
        $dbpassword = "WhVL##77JK";

        //creating a connection
        $conn = new mysqli($servername, $dbusername, $dbpassword);

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        
        $sql = "SELECT * FROM Game WHERE game_name = '$searchName'";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
                echo "Name: " . $row["game_name"]. " - Year: " . $row["game_year"]. " - Genre" . $row["game_genre"].  " - Description: " . $row["game_description"]"<br>";
            }
        } 
        else {
                echo "no results";
        }
        
        mysqli_close($conn);
    }
    search();
?>