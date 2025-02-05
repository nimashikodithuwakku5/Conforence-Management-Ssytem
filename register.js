document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
  
    form.addEventListener("submit", function (event) {
      let errors = [];
  
      // Validate name
      const name = document.getElementById("name").value.trim();
      if (name === "") {
        errors.push("Name is required.");
      }
  
      // Validate email
      const email = document.getElementById("email").value.trim();
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(email)) {
        errors.push("A valid email address is required.");
      }
  
      // Validate NIC/Passport
      const nic = document.getElementById("nic").value.trim();
      if (nic === "") {
        errors.push("NIC/Passport number is required.");
      }
  
      // Validate phone number
      const phone = document.getElementById("phone").value.trim();
      const phoneRegex = /^[0-9]{10}$/;
      if (!phoneRegex.test(phone)) {
        errors.push("A valid 10-digit phone number is required.");
      }
  
      // Validate country
      const country = document.getElementById("country").value.trim();
      if (country === "") {
        errors.push("Country is required.");
      }
  
      // Validate password
      const password = document.getElementById("password").value;
      const confirmPassword = document.getElementById("confirm_password").value;
      if (password.length < 6) {
        errors.push("Password must be at least 6 characters long.");
      }
      if (password !== confirmPassword) {
        errors.push("Passwords do not match.");
      }
  
      // If there are errors, prevent submission and display them
      if (errors.length > 0) {
        event.preventDefault(); // Prevent form submission
  
        // Display errors
        const errorContainer = document.getElementById("error-messages") || document.createElement("div");
        errorContainer.id = "error-messages";
        errorContainer.style.color = "red";
        errorContainer.innerHTML = errors.map(error => `<p>${error}</p>`).join("");
        form.prepend(errorContainer);
      }
    });
  });
  