document.addEventListener("DOMContentLoaded", function () {
  let dayCount = 1;
  const addDayButton = document.getElementById("addDay");
  const workoutDays = document.getElementById("workoutDays");
  const routineForm = document.getElementById("routineForm");
  // exercise options for each muscle group
  const exerciseOptions = {
    trapz: [
      "Barbell Shrugs",
      "Dumbbell Shrugs",
      "Farmers Carry",
      "Upright Rows",
      "Face Pulls",
    ],
    shoulders: [
      "Overhead Press",
      "Arnold Press",
      "Front Raises",
      "Lateral Raises",
      "Cable Lateral Raises",
      "Face Pulls",
      "Rear Delt Rows",
    ],
    chest: [
      "Incline Barbell Press",
      "Incline Dumbbell Press",
      "Incline Chest Flyes",
      "Flat Barbell Bench Press",
      "Flat Dumbbell Press",
      "Chest Dips",
      "Decline Barbell Bench Press",
      "Decline Dumbbell Press",
      "Cable Chest Flyes",
      "Push-Ups",
    ],
    abs: [
      "Crunches",
      "Cable Crunches",
      "Decline Sit-Ups",
      "Leg Raises",
      "Hanging Leg Raises",
      "Russian Twists",
      "Side Plank",
      "Plank",
    ],
    back: [
      "Deadlifts",
      "Pull-Ups",
      "Barbell Rows",
      "Dumbbell Rows",
      "Lat Pulldowns",
      "T-Bar Rows",
      "Single-Arm Dumbbell Rows",
      "Chest-Supported Rows",
      "Seated Cable Rows",
      "Face Pulls",
    ],
    biceps: [
      "Barbell Curls",
      "Dumbbell Curls",
      "Hammer Curls",
      "Preacher Curls",
      "Concentration Curls",
      "Cable Curls",
      "Incline Dumbbell Curls",
      "EZ Bar Curls",
    ],
    triceps: [
      "Close-Grip Bench Press",
      "Tricep Dips",
      "Tricep Pushdowns",
      "Skull Crushers",
      "Overhead Tricep Extensions",
      "Dumbbell Kickbacks",
      "Cable Overhead Extensions",
      "Diamond Push-Ups",
      "Tricep Rope Pushdowns",
    ],
    forearms: [
      "Reverse Wrist Curls",
      "Farmers Walk",
      "Finger Curls",
      "Wrist Roller",
      "Cable Wrist Curls",
    ],
    quadriceps: [
      "Barbell Squats",
      "Leg Press",
      "Lunges",
      "Bulgarian Split Squats",
      "Leg Extensions",
      "Goblet Squats",
      "Front Squats",
      "Walking Lunges",
      "Smith Machine Squats",
    ],
    calves: ["Standing Calf Raises", "Seated Calf Raises", "Jump Rope"],
    hamstring: [
      "Romanian Deadlifts",
      "Leg Curls",
      "Sumo Deadlifts",
      "Kettlebell Swings",
      "Lunges",
      "Hip Thrusts",
    ],
  };

  function attachEventListeners(dayElement) {
    const muscleSelects = dayElement.querySelectorAll(".muscle-select");
    const restDayCheckbox = dayElement.querySelector(".rest-day-checkbox");
    const exerciseSelects = dayElement.querySelector(".exercise-selects");

    muscleSelects.forEach((muscleSelect) => {
      muscleSelect.addEventListener("change", function () {
        const muscleGroup = this.closest(".muscle-group");
        const exercises = muscleGroup.querySelector(".exercises");
        exercises.innerHTML = "";
        if (this.value) {
          addExerciseRow(exercises, this.value);
          updateAddExerciseButton(exercises);
        }
      });
    });

    restDayCheckbox.addEventListener("change", function () {
      exerciseSelects.style.display = this.checked ? "none" : "block";
      if (this.checked) {
        exerciseSelects
          .querySelectorAll(".muscle-select")
          .forEach((select) => (select.value = ""));
        exerciseSelects
          .querySelectorAll(".exercises")
          .forEach((div) => (div.innerHTML = ""));
      }
    });
  }

  function addExerciseRow(container, muscleGroup) {
    const exerciseRow = document.createElement("div");
    exerciseRow.className = "exercise-row";
    exerciseRow.innerHTML = `
    <select class="form-select exercise-select inpcol" name="exercises[${
      dayCount - 1
    }][exercise][]">
        <option value="">Select exercise</option>
        ${exerciseOptions[muscleGroup]
          .map((exercise) => `<option value="${exercise}">${exercise}</option>`)
          .join("")}
    </select>
    <input type="number" class="form-control sets-input inpcol" name="exercises[${
      dayCount - 1
    }][sets][]" min="1" max="6" placeholder="Sets">
    <button type="button" class="remove-exercise-btn"><i class="fa-solid fa-delete-left"></i></button>
`;
    container.appendChild(exerciseRow);

    exerciseRow
      .querySelector(".remove-exercise-btn")
      .addEventListener("click", function () {
        exerciseRow.remove();
        if (container.children.length === 0) {
          addExerciseRow(container, muscleGroup);
        }
        updateAddExerciseButton(container);
      });

    updateAddExerciseButton(container);
  }

  function updateAddExerciseButton(container) {
    let addExerciseBtn = container.querySelector(".add-exercise-btn");
    if (!addExerciseBtn) {
      addExerciseBtn = document.createElement("button");
      addExerciseBtn.type = "button";
      addExerciseBtn.className = "btn btn-secondary add-exercise-btn mt-2 btn6";
      addExerciseBtn.textContent = "Add Exercise";
      addExerciseBtn.addEventListener("click", () =>
        addExerciseRow(
          container,
          container.closest(".muscle-group").querySelector(".muscle-select")
            .value
        )
      );
      container.appendChild(addExerciseBtn);
    } else {
      container.appendChild(addExerciseBtn);
    }
  }

  function addMuscleGroup(dayElement) {
    const exerciseSelects = dayElement.querySelector(".exercise-selects");
    const newMuscleGroup = document.createElement("div");
    newMuscleGroup.className = "muscle-group mt-3";
    newMuscleGroup.innerHTML = `
    <div class="mb-3">
        <select class="form-select muscle-select inpcol" name="exercises[${
          dayCount - 1
        }][muscle][]">
            <option value="">Select muscle group</option>
            ${Object.keys(exerciseOptions)
              .map(
                (muscle) =>
                  `<option value="${muscle}">${
                    muscle.charAt(0).toUpperCase() + muscle.slice(1)
                  }</option>`
              )
              .join("")}
        </select>
    </div>
    <div class="exercises"></div>
`;
    exerciseSelects.appendChild(newMuscleGroup);
    attachEventListeners(newMuscleGroup);
  }

  attachEventListeners(workoutDays.querySelector(".workout-day"));

  workoutDays
    .querySelector(".workout-day .add-muscle-group-btn")
    .addEventListener("click", function () {
      addMuscleGroup(this.closest(".workout-day"));
    });

  addDayButton.addEventListener("click", function () {
    dayCount++;
    const newDay = document.createElement("div");
    newDay.className = "workout-day";
    newDay.innerHTML = `
    <div class="day-header">
        <div class="day-label">Day ${dayCount}</div>
        <button type="button" class="btn btn-danger btn-sm remove-day-btn btn4">Remove Day</button>
    </div>
    <div class="form-check mb-3">
        <input class="form-check-input rest-day-checkbox nocb" type="checkbox" name="exercises[${
          dayCount - 1
        }][rest_day]" id="restDay${dayCount - 1}">
        <label class="form-check-label" for="restDay${
          dayCount - 1
        }">Rest Day</label>
    </div>
    <div class="exercise-selects">
        <div class="muscle-group">
            <div class="mb-3">
                <select class="form-select muscle-select inpcol" name="exercises[${
                  dayCount - 1
                }][muscle][]">
                    <option value="">Select muscle group</option>
                    ${Object.keys(exerciseOptions)
                      .map(
                        (muscle) =>
                          `<option value="${muscle}">${
                            muscle.charAt(0).toUpperCase() + muscle.slice(1)
                          }</option>`
                      )
                      .join("")}
                </select>
            </div>
            <div class="exercises"></div>
        </div>
    </div>
    <button type="button" class="btn btn-secondary add-muscle-group-btn mt-3 btn5">Add Muscle Group</button>
`;
    workoutDays.appendChild(newDay);
    attachEventListeners(newDay);

    const removeDayBtn = newDay.querySelector(".remove-day-btn");
    removeDayBtn.style.display = "block";
    removeDayBtn.addEventListener("click", function () {
      newDay.remove();
      updateDayLabels();
    });

    newDay
      .querySelector(".add-muscle-group-btn")
      .addEventListener("click", function () {
        addMuscleGroup(newDay);
      });
  });

  function updateDayLabels() {
    const days = workoutDays.querySelectorAll(".workout-day");
    days.forEach((day, index) => {
      day.querySelector(".day-label").textContent = `Day ${index + 1}`;
    });
    dayCount = days.length;
  }
  // empty day check
  function isDayEmpty(day) {
    const restDayCheckbox = day.querySelector(".rest-day-checkbox");
    if (restDayCheckbox.checked) {
      return false;
    }
    const exerciseSelects = day.querySelectorAll(".exercise-select");
    for (let select of exerciseSelects) {
      if (select.value !== "") {
        return false;
      }
    }
    return true;
  }

  routineForm.addEventListener("submit", function (e) {
    e.preventDefault();

    const days = workoutDays.querySelectorAll(".workout-day");
    let hasEmptyDay = false;

    days.forEach((day, index) => {
      if (isDayEmpty(day)) {
        hasEmptyDay = true;
      }
    });

    if (hasEmptyDay) {
      window.alert("Please fill up all of the selected days");
    } else {
      this.submit();
    }
  });
});
