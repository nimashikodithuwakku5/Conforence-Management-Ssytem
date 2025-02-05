/*for Register tab*/

// Generate QR code
document.addEventListener("DOMContentLoaded", function() {
    const qrCodeContainer = document.getElementById('qrcode');
    const registrationUrl = 'https://your-website.com/register';  // Replace with actual URL for registration
    QRCode.toCanvas(qrCodeContainer, registrationUrl, function(error) {
        if (error) {
            console.error('Error generating QR code:', error);
        } else {
            console.log('QR code generated successfully');
        }
    });
});

document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById('registration-form');
    const successMessage = document.getElementById('success-message');

    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent form submission and page reload

        // Simulate form processing (you can add validation or server logic here)
        setTimeout(function() {
            // Show the success message
            successMessage.style.display = 'block';

            // Optionally, hide the form after submission
            form.style.display = 'none'; // Hide form after successful registration
        }, 1000); // Optional: Simulate a short delay before showing the success message
    });
});

/*session-register tab*/

function register(sessionNumber) {
    // Retrieve values from the corresponding form
    let name = document.getElementById('name' + sessionNumber).value;
    let email = document.getElementById('email' + sessionNumber).value;

    // Basic validation
    if (name === "" || email === "") {
        alert("Please fill in both fields.");
        return;
    }

    // Simulate successful registration with an alert
    alert("You have successfully registered for Tracking " + sessionNumber + "!");
    
    // Clear form inputs
    document.getElementById('form' + sessionNumber).reset();
}
