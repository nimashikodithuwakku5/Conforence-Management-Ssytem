<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "research_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data query
$sql = "SELECT name, country, track, phone FROM researchers";
$result = $conn->query($sql);

// Return data as JSON
if ($result->num_rows > 0) {
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
} else {
    echo json_encode([]);
}

$conn->close();
?>
