const form = document.getElementById("form");
const username = document.getElementById("username");
const email = document.getElementById("email");
const password = document.getElementById("password");
const errorElement = document.getElementById("error");

form.addEventListener("submit", (e) => {
  let errors = [];
  if (username) {
    errors = getSignupErrors(username.value, email.value, password.value);
  } else {
    errors = getLoginErrors(email.value, password.value);
  }

  if (errors.length > 0) {
    e.preventDefault();
    errorElement.innerText = errors.join(", ");
  }
});

function getSignupErrors(username, email, password) {
  let errors = [];
  if (username === "" || username == null) {
    errors.push("Username is required");
    username.parentElement.classList.add("inccorect");
  }
  if (email === "" || email == null) {
    errors.push("Email is required");
    email.parentElement.classList.add("inccorect");
  }
  if (password === "" || password == null) {
    errors.push("Password is required");
    password.parentElement.classList.add("inccorect");
  }
  return errors;
}
