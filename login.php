<?php
// Database connection
$host = 'localhost';
$db = 'research_db';
$user = 'root'; // Your database username
$password = ''; // Your database password

$conn = new mysqli($host, $user, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start session
session_start();

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data and sanitize input
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $category = strtolower(trim($_POST['category'])); // Normalize category to lowercase for comparison

    // Validate input
    if (empty($email) || empty($password) || empty($category)) {
        header("Location: login.html?error=All fields are required!");
        exit();
    }

    // Prepare and execute query
    $sql = "SELECT * FROM researchers WHERE email = ? AND category = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $category);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify the password using the column 'password_hash'
        if (password_verify($password, $row['password_hash'])) {
            // Login successful
            $_SESSION['email'] = $email;
            $_SESSION['category'] = $category;

            // Redirect based on category
            if ($category === 'admin') {
                header("Location: admin.html");
                exit();
            } elseif ($category === 'participent') {
                header("Location: schedule.html");
                exit();
            } else {
                // Debugging unexpected category
                header("Location: login.html?error=Unknown category value.");
                exit();
            }
        } else {
            // Invalid password
            header("Location: login.html?error=Invalid password.");
            exit();
        }
    } else {
        // User not found
        header("Location: login.html?error=Invalid email or participation category.");
        exit();
    }

    $stmt->close();
} else {
    // Redirect for invalid request method
    header("Location: login.html?error=Invalid request method.");
    exit();
}

$conn->close();
?>
