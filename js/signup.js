//Function to validate the email and username
function validateSignupForm(email, username, password) {
  // Email validation regex (checks format)
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  // Username validation regex (letters and numbers only)
  const usernameRegex = /^[a-zA-Z0-9]+$/;

  let errors = [];

  // Validate username
  if (!usernameRegex.test(username)) {
    errors.push("Username can only contain letters and numbers.");
  }

  // Validate email
  if (!emailRegex.test(email)) {
    errors.push("Invalid email format.");
  }

  if (!password) {
    errors.push("Password is required.");
  } else if (password.length < 8) {
    errors.push("Password must be at least 8 characters long.");
  }

  return errors;
}


// Link the function to the form
document
  .getElementById("signupForm")
  .addEventListener("submit", function (event) {

    const email = document.getElementById("email").value.trim();
    const username = document.getElementById("username").value.trim();
    const password = document.getElementById("password").value;

    const errors = validateSignupForm(email, username, password);

    const errorMessagesDiv = document.getElementById("errorMessages");
    errorMessagesDiv.innerHTML = ""; // Clear previous messages

    if (errors.length > 0) {
      event.preventDefault(); // Prevent form submission
      // Display errors
      errorMessagesDiv.innerHTML = errors.join("<br>");
    }
  });
