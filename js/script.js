document.addEventListener("DOMContentLoaded", function () {
  const customRoutineForm = document.getElementById("customRoutineForm");
  const routineForm = document.getElementById("routineForm");
  const workoutDays = document.getElementById("workoutDays");
  let dayCount = 0;

  // Function to select a pre-defined routine
  function selectRoutine(routineName) {
    alert(`You've selected the ${routineName} routine!`);
    // Here you would typically save the selection or redirect to a detailed page
  }

  // Function to show the custom routine form
  function showCustomRoutineForm() {
    customRoutineForm.style.display = "block";
  }

  // Function to add a workout day to the custom routine form
  function addWorkoutDay() {
    dayCount++;
    const dayDiv = document.createElement("div");
    dayDiv.className = "mb-3";
    dayDiv.innerHTML = `
            <h4>Day ${dayCount}</h4>
            <div class="mb-2">
                <input type="text" class="form-control" name="day${dayCount}exercise1" placeholder="Exercise 1" required>
            </div>
            <div class="mb-2">
                <input type="text" class="form-control" name="day${dayCount}exercise2" placeholder="Exercise 2" required>
            </div>
            <div class="mb-2">
                <input type="text" class="form-control" name="day${dayCount}exercise3" placeholder="Exercise 3" required>
            </div>
        `;
    workoutDays.appendChild(dayDiv);
  }

  // Event listener for pre-defined routine selection
  document.querySelectorAll(".btn-select-routine").forEach((button) => {
    button.addEventListener("click", function () {
      selectRoutine(this.dataset.routine);
    });
  });

  // Event listener for showing custom routine form
  document
    .getElementById("createCustomRoutine")
    .addEventListener("click", showCustomRoutineForm);

  // Event listener for adding workout day
  document
    .getElementById("addWorkoutDay")
    .addEventListener("click", addWorkoutDay);

  // Event listener for custom routine form submission
  routineForm.addEventListener("submit", function (e) {
    e.preventDefault();
    const routineName = document.getElementById("routineName").value;
    const formData = new FormData(routineForm);
    const customRoutine = {
      name: routineName,
      days: [],
    };

    // Collect exercise data for each day
    for (let i = 1; i <= dayCount; i++) {
      const dayExercises = {
        exercise1: formData.get(`day${i}exercise1`),
        exercise2: formData.get(`day${i}exercise2`),
        exercise3: formData.get(`day${i}exercise3`),
      };
      customRoutine.days.push(dayExercises);
    }

    // Here you would typically save the custom routine data
    console.log("Custom Routine:", customRoutine);
    alert(`Custom routine "${routineName}" created!`);

    // Reset the form
    this.reset();
    customRoutineForm.style.display = "none";
    workoutDays.innerHTML = "";
    dayCount = 0;
  });

  // Check if user is logged in and display welcome message
  const user = JSON.parse(localStorage.getItem("user"));
  if (user) {
    const welcomeMessage = document.createElement("p");
    welcomeMessage.className = "text-center mb-4";
    welcomeMessage.textContent = `Welcome back, ${user.email}!`;
    document
      .querySelector(".container h1")
      .insertAdjacentElement("afterend", welcomeMessage);
  }
});