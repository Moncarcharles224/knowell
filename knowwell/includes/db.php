<?php
// to Check if the server is localhost 
if ($_SERVER['SERVER_NAME'] == 'localhost') {
    // Local database credentials
    $servername = "";
    $username = "root";
    $password = "";
    $dbname = "courses_quiz_db";
} else {
    // Live hosting credentials
   
$servername = "mysql1003.site4now.net"; 
$username = "abcee0_knowwel";
$password = "Killerman1_"; 
$dbname = "db_abcee0_knowwel";
}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>