document
  .getElementById("loginForm")
  .addEventListener("submit", function (event) {
    if (!this.checkValidity()) {
      event.preventDefault();
      event.stopPropagation();
    } else {
      event.preventDefault();
      const email = document.getElementById("email").value;
      const password = document.getElementById("password").value;

      // Here you would typically send this data to a server for authentication
      console.log("Login data:", { email, password });

      // Simulate successful login
      localStorage.setItem("user", JSON.stringify({ email }));
      alert("Login successful!");
      window.location.href = "index.html";
    }

    this.classList.add("was-validated");
  });