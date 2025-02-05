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

// Get the email of the user from the query parameter
$email = $_GET['email'];  // The email passed via URL (e.g., send_qr_email.php?email=user@example.com)

// Fetch user details from the database
$sql = "SELECT * FROM researchers WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Check if user exists
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    
    // Prepare the details to include in the QR code
    $qrData = "Name: " . $user['name'] . "\nEmail: " . $user['email'] . "\nPhone: " . $user['phone'] . "\nTrack: " . $user['track'] . "\nCountry: " . $user['country'] . "\nCategory: " . $user['category'];
    
    // Generate the QR code URL using Google Chart API
    $qrCodeUrl = "https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=" . urlencode($qrData);
    
    // Save the QR code image locally (optional)
    $qrFilePath = 'qrcodes/' . uniqid('qr_', true) . '.png';
    file_put_contents($qrFilePath, file_get_contents($qrCodeUrl));

    // Send the QR code via email
    $to = $user['email'];
    $subject = "Your QR Code for International Research Conference 2024";
    $body = "Dear " . $user['name'] . ",<br><br>Here is your QR code for the International Research Conference 2024. Please find the attached QR code.";

    // Read the QR code image file
    $qrImage = file_get_contents($qrFilePath);
    $encodedImage = base64_encode($qrImage);

    // Define the email headers with an attachment
    $boundary = "----=_NextPart_" . md5(time());
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";
    $headers .= "From: your_email@example.com\r\n";
    $headers .= "Reply-To: your_email@example.com\r\n";
    
    // Email body
    $headers .= "--$boundary\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $headers .= "Content-Transfer-Encoding: 7bit\r\n";
    $headers .= "$body\r\n";
    
    // Attach the QR code image
    $headers .= "--$boundary\r\n";
    $headers .= "Content-Type: image/png; name=\"qr_code.png\"\r\n";
    $headers .= "Content-Transfer-Encoding: base64\r\n";
    $headers .= "Content-Disposition: attachment; filename=\"qr_code.png\"\r\n";
    $headers .= "\r\n" . $encodedImage . "\r\n";
    $headers .= "--$boundary--\r\n";
    
    // Send the email
    if (mail($to, $subject, "", $headers)) {
        echo 'QR code has been sent to your email!';
    } else {
        echo 'Error sending email.';
    }
    
    // Optional: Clean up the generated QR file
    unlink($qrFilePath);
} else {
    echo "User not found!";
}

$conn->close();
?>
