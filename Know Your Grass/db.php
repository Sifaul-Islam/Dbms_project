<?php

$servername = "localhost";

$username = "root";

$password = "";

$dbname = "safe_food_traceability";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);

}
else{
    echo "<script>console.log('Database Connected successfully');</script>";
}

?>