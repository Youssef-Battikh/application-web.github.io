// Display current year in the footer
document.addEventListener("DOMContentLoaded", () => {
    const footerText = document.querySelector("footer p");
    const year = new Date().getFullYear();
    footerText.innerHTML = `&copy; ${year} Fitness Planner. All Rights Reserved.`;
});
document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("signupForm");
    const passwordField = document.getElementById("password");
    const confirmPasswordField = document.getElementById("confirmPassword");

    form.addEventListener("submit", (e) => {
        e.preventDefault(); // Stop form submission for validation

        // Check form validity
        if (!form.checkValidity()) {
            form.classList.add("was-validated");
            return;
        }

        // Check if passwords match
        if (passwordField.value !== confirmPasswordField.value) {
            confirmPasswordField.setCustomValidity("Passwords do not match");
        } else {
            confirmPasswordField.setCustomValidity("");
        }

        if (form.checkValidity()) {
            alert("Account created successfully!");
            form.reset();
        }
    });

    form.addEventListener("input", () => {
        confirmPasswordField.setCustomValidity(""); // Reset validation on input
        form.classList.remove("was-validated");
    });
});
document.addEventListener("DOMContentLoaded", () => {
    const loginForm = document.getElementById("loginForm");
    const passwordField = document.getElementById("password");
    const showPasswordCheckbox = document.getElementById("showPassword");

    // Toggle "Show Password" functionality
    showPasswordCheckbox.addEventListener("change", () => {
        passwordField.type = showPasswordCheckbox.checked ? "text" : "password";
    });

    // Validate Login Form
    loginForm.addEventListener("submit", (e) => {
        e.preventDefault(); // Stop form submission for demo purposes

        if (!loginForm.checkValidity()) {
            loginForm.classList.add("was-validated");
            return;
        }

        // Simulate login success
        alert("Login successful!");
        // Redirect to Dashboard (placeholder URL for now)
        window.location.href = "dashboard.html";
    });

    loginForm.addEventListener("input", () => {
        loginForm.classList.remove("was-validated"); // Reset validation on input
    });
});
document.addEventListener("DOMContentLoaded", () => {
    // Simulate user login
    const username = "John Doe"; // You can later replace this with a dynamic username
    document.getElementById("username").textContent = username;

    // Random Motivational Quotes
    const quotes = [
        "Push yourself, no one else is going to do it for you!",
        "The body achieves what the mind believes.",
        "Success starts with self-discipline.",
        "Don’t stop when you’re tired, stop when you’re done!",
        "It never gets easier, you just get stronger."
    ];

    const quoteElement = document.getElementById("motivationalQuote");
    const randomQuote = quotes[Math.floor(Math.random() * quotes.length)];
    quoteElement.textContent = randomQuote;

    // Handle Progress Bar
    const progressBar = document.getElementById("progress");
    const progressText = document.getElementById("progressText");

    // Save Workout Goal and Track Progress
    const saveGoalButton = document.getElementById("saveGoal");
    const workoutGoalInput = document.getElementById("workoutGoal");

    saveGoalButton.addEventListener("click", () => {
        const goal = workoutGoalInput.value;
        if (goal) {
            alert(`Goal saved: ${goal}`);
            workoutGoalInput.value = ''; // Clear the input after saving goal

            // Simulate progress (you can customize this logic)
            let progress = 0;
            const progressInterval = setInterval(() => {
                if (progress < 100) {
                    progress += 10;
                    progressBar.style.width = `${progress}%`;
                    progressText.textContent = `${progress}% completed`;
                } else {
                    clearInterval(progressInterval);
                }
            }, 1000); // Update progress every second
        } else {
            alert("Please enter a workout goal!");
        }
    });
});