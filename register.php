<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $servername = "localhost";  // Update if necessary
    $username = "root";         // Your database username
    $password = "";             // Your database password
    $dbname = "research_db";

    // Connect to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $errors = [];

    // Sanitize inputs
    $name = htmlspecialchars(trim($_POST["name"]));
    $category = htmlspecialchars(trim($_POST["category"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $nic = htmlspecialchars(trim($_POST["nic"]));
    $phone = htmlspecialchars(trim($_POST["phone"]));
    $country = htmlspecialchars(trim($_POST["country"]));
    $track = htmlspecialchars(trim($_POST["track"]));
    $slip = htmlspecialchars(trim($_POST["slip"]));
    $password = htmlspecialchars(trim($_POST["password"]));
    $confirm_password = htmlspecialchars(trim($_POST["confirm_password"]));

    // Validate inputs
    if (empty($name)) $errors[] = "Name is required.";
    if (empty($category)) $errors[] = "Participation category is required.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format.";
    if (empty($nic)) $errors[] = "NIC/Passport number is required.";
    if (!preg_match("/^[0-9]{10}$/", $phone)) $errors[] = "Phone number must be 10 digits.";
    if (empty($country)) $errors[] = "Country is required.";
    if (empty($slip)) $errors[] = "Slip code is required.";
    if (strlen($password) < 6) $errors[] = "Password must be at least 6 characters.";
    if ($password !== $confirm_password) $errors[] = "Passwords do not match.";

    // If validation fails, display errors
    if (!empty($errors)) {
        echo "<div style='color: red;'>";
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
        echo "</div>";
    } else {
        // Hash the password
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Prepare SQL statement
        $stmt = $conn->prepare("INSERT INTO researchers (name, category, email, nic, phone, country, track, slip_code, password_hash) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $name, $category, $email, $nic, $phone, $country, $track, $slip, $password_hash);

        // Execute and check if successful
        if ($stmt->execute()) {
            // Send QR code email in background
            $userEmail = urlencode($email);
            exec("php send_qr_email.php?email=$userEmail > /dev/null 2>/dev/null &");

            // Redirect to login page after successful registration
            header("Location: login.html");
            exit();
            
        } else {
            echo "<p style='color: red;'>Error: " . $stmt->error . "</p>";
        }

        $stmt->close();
    }

    // Close the database connection
    $conn->close();
}
?>
