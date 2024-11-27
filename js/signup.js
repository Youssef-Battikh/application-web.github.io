document
  .getElementById("signupForm")
  .addEventListener("submit", function (event) {
    if (!this.checkValidity()) {
      event.preventDefault();
      event.stopPropagation();
    } else {
      event.preventDefault();
      const username = document.getElementById("username").value;
      const email = document.getElementById("email").value;
      const password = document.getElementById("password").value;

      // Here you would typically send this data to a server
      console.log("Sign up data:", { username, email, password });

      alert("Sign up successful! Please log in.");
      window.location.href = "login.html";
    }

    this.classList.add("was-validated");
  });