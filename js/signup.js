// Form Check
document
  .getElementById("signupForm")
  .addEventListener("submit", function (event) {
    if (!this.checkValidity()) {
      event.preventDefault();
      event.stopPropagation();
    }
    this.classList.add("was-validated");
  });
