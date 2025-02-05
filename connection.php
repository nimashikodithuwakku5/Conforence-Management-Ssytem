<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "research_db";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Connection successful message (optional, for debugging)
// echo "Connected successfully";
?>
