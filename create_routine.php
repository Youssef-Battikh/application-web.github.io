<?php
// check login session
require_once 'php/config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$muscle_groups = ["trapz", "shoulders", "chest", "abs", "back", "biceps", "triceps", "forearms", "quadraceps", "calves", "hamstring"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $routine_name = $_POST['routine_name'];
    $routine_description = $_POST['routine_description'];
    $user_id = $_SESSION['user_id'];
    // Insert new routine
    $sql = "INSERT INTO routine (name, description, id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $routine_name, $routine_description, $user_id);
    $stmt->execute();
    $routine_nbr = $stmt->insert_id;
    $stmt->close();

    // Insert exercises for each day
    if (isset($_POST['exercises'])) {
        $day = 1;
        foreach ($_POST['exercises'] as $day_exercises) {
            if (isset($day_exercises['rest_day']) && $day_exercises['rest_day'] == 'on') {
                // Insert rest day
                $sql = "INSERT INTO routine_exercises (routine_nbr, day, exercise_name, sets) VALUES (?, ?, 'rest', 0)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ii", $routine_nbr, $day);
                $stmt->execute();
                $stmt->close();
            } else if (!empty($day_exercises['muscle']) && !empty($day_exercises['exercise'])) {
                // Insert exercises for the day
                for ($i = 0; $i < count($day_exercises['muscle']); $i++) {
                    $muscle = $day_exercises['muscle'][$i];
                    $exercise = $day_exercises['exercise'][$i];
                    $sets = $day_exercises['sets'][$i];
                    if (!empty($exercise)) {
                        $sql = "INSERT INTO routine_exercises (routine_nbr, day, exercise_name, sets) VALUES (?, ?, ?, ?)";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("iisi", $routine_nbr, $day, $exercise, $sets);
                        $stmt->execute();
                        $stmt->close();
                    }
                }
            } else {
                // Insert an empty day
                $sql = "INSERT INTO routine_exercises (routine_nbr, day, exercise_name, sets) VALUES (?, ?, 'empty', 0)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ii", $routine_nbr, $day);
                $stmt->execute();
                $stmt->close();
            }
            $day++;
        }
    }

    header("Location: view_routine.php?routine_nbr=" . $routine_nbr);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Custom Routine - GymPro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="css/styles.css" rel="stylesheet">
    <style>
        .workout-day {
            background-color: #f5f5f5;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .day-label {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 15px;
            color: #333;
        }

        .rest-day-checkbox {
            transform: scale(1.5);
            margin-right: 10px;
        }

        .muscle-select {
            max-width: 300px;
            margin: 0 auto;
        }

        .day-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .remove-day-btn {
            display: none;
        }

        .exercise-row {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .exercise-select {
            flex-grow: 1;
            margin-right: 10px;
        }

        .remove-exercise-btn {
            background: none;
            border: none;
            color: #dc3545;
            cursor: pointer;
        }

        .add-muscle-group-btn {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">GymPro</a>
            <div id="google_translate_element"></div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="routines.php">
                            <i class="fa-solid fa-address-card"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="builtin.php">
                            <i class="fas fa-list-alt me-1"></i>Built-in
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="custom.php">
                            <i class="fas fa-cog me-1"></i>Custom
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">
                            <i class="fas fa-sign-out-alt me-1"></i>Log Out
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center fw-bold mb-5">Create Your Custom Routine</h1>
        <form id="routineForm" method="POST" action="create_routine.php">
            <div class="mb-4">
                <label for="routine_name" class="form-label">Routine Name</label>
                <input type="text" class="form-control inpcol" id="routine_name" name="routine_name" required>
            </div>
            <div class="mb-4">
                <label for="routine_description" class="form-label">Routine Description</label>
                <textarea class="form-control inpcol" id="routine_description" name="routine_description" rows="3"
                    required></textarea>
            </div>
            <div id="workoutDays">
                <div class="workout-day inpcol">
                    <div class="day-header">
                        <div class="day-label">Day 1</div>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input rest-day-checkbox nocb" type="checkbox"
                            name="exercises[0][rest_day]" id="restDay0">
                        <label class="form-check-label" for="restDay0">Rest Day</label>
                    </div>
                    <div class="exercise-selects">
                        <div class="muscle-group">
                            <div class="mb-3">
                                <select class="form-select muscle-select inpcol" name="exercises[0][muscle][]">
                                    <option value="">Select muscle group</option>
                                    <?php foreach ($muscle_groups as $muscle): ?>
                                        <option value="<?php echo $muscle; ?>"><?php echo ucfirst($muscle); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="exercises"></div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary add-muscle-group-btn mt-3">Add Muscle Group</button>
                </div>
            </div>
            <div class="form-actions">
                <button type="button" id="addDay" class="btn btn-secondary">Add Another Day</button>
                <button type="submit" class="btn btn-primary">Create Routine</button>
            </div>
        </form>
    </div>

    <footer class="bg-dark text-light py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <p class="mb-1">&copy; 2024 GymPro. All rights reserved.</p>
                    <a href="#" class="text-light me-2"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-light me-2"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-light me-2"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-light"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="js/element.js"></script>
    <script src="js/script.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let dayCount = 1;
            const addDayButton = document.getElementById('addDay');
            const workoutDays = document.getElementById('workoutDays');
            const routineForm = document.getElementById('routineForm');

            // Exercise options for each muscle group
            const exerciseOptions = {
                trapz: ['Barbell Shrugs', 'Dumbbell Shrugs', 'Farmers Carry', 'Upright Rows', 'Face Pulls'],
                shoulders: ['Overhead Press', 'Arnold Press', 'Front Raises', 'Lateral Raises', 'Cable Lateral Raises', 'Face Pulls', 'Rear Delt Rows'],
                chest: ['Incline Barbell Press', 'Incline Dumbbell Press', 'Incline Chest Flyes', 'Flat Barbell Bench Press', 'Flat Dumbbell Press', 'Chest Dips', 'Decline Barbell Bench Press', 'Decline Dumbbell Press', 'Cable Chest Flyes', 'Push-Ups'],
                abs: ['Crunches', 'Cable Crunches', 'Decline Sit-Ups', 'Leg Raises', 'Hanging Leg Raises', 'Russian Twists', 'Side Plank', 'Plank'],
                back: ['Deadlifts', 'Pull-Ups', 'Barbell Rows', 'Dumbbell Rows', 'Lat Pulldowns', 'T-Bar Rows', 'Single-Arm Dumbbell Rows', 'Chest-Supported Rows', 'Seated Cable Rows', 'Face Pulls'],
                biceps: ['Barbell Curls', 'Dumbbell Curls', 'Hammer Curls', 'Preacher Curls', 'Concentration Curls', 'Cable Curls', 'Incline Dumbbell Curls', 'EZ Bar Curls'],
                triceps: ['Close-Grip Bench Press', 'Tricep Dips', 'Tricep Pushdowns', 'Skull Crushers', 'Overhead Tricep Extensions', 'Dumbbell Kickbacks', 'Cable Overhead Extensions', 'Diamond Push-Ups', 'Tricep Rope Pushdowns'],
                forearms: ['Reverse Wrist Curls', 'Farmers Walk', 'Finger Curls', 'Wrist Roller', 'Cable Wrist Curls'],
                quadriceps: ['Barbell Squats', 'Leg Press', 'Lunges', 'Bulgarian Split Squats', 'Leg Extensions', 'Goblet Squats', 'Front Squats', 'Walking Lunges', 'Smith Machine Squats'],
                calves: ['Standing Calf Raises', 'Seated Calf Raises', 'Jump Rope'],
                hamstring: ['Romanian Deadlifts', 'Leg Curls', 'Sumo Deadlifts', 'Kettlebell Swings', 'Lunges', 'Hip Thrusts']
            };

            function attachEventListeners(dayElement) {
                const muscleSelects = dayElement.querySelectorAll('.muscle-select');
                const restDayCheckbox = dayElement.querySelector('.rest-day-checkbox');
                const exerciseSelects = dayElement.querySelector('.exercise-selects');

                muscleSelects.forEach(muscleSelect => {
                    muscleSelect.addEventListener('change', function () {
                        const muscleGroup = this.closest('.muscle-group');
                        const exercises = muscleGroup.querySelector('.exercises');
                        exercises.innerHTML = '';
                        if (this.value) {
                            addExerciseRow(exercises, this.value);
                            updateAddExerciseButton(exercises);
                        }
                    });
                });

                restDayCheckbox.addEventListener('change', function () {
                    exerciseSelects.style.display = this.checked ? 'none' : 'block';
                    if (this.checked) {
                        exerciseSelects.querySelectorAll('.muscle-select').forEach(select => select.value = '');
                        exerciseSelects.querySelectorAll('.exercises').forEach(div => div.innerHTML = '');
                    }
                });
            }

            function addExerciseRow(container, muscleGroup) {
                const exerciseRow = document.createElement('div');
                exerciseRow.className = 'exercise-row';
                exerciseRow.innerHTML = `
            <select class="form-select exercise-select inpcol" name="exercises[${dayCount - 1}][exercise][]">
                <option value="">Select exercise</option>
                ${exerciseOptions[muscleGroup].map(exercise => `<option value="${exercise}">${exercise}</option>`).join('')}
            </select>
            <input type="number" class="form-control sets-input inpcol" name="exercises[${dayCount - 1}][sets][]" min="1" max="6" placeholder="Sets">
            <button type="button" class="remove-exercise-btn">&times;</button>
        `;
                container.appendChild(exerciseRow);

                exerciseRow.querySelector('.remove-exercise-btn').addEventListener('click', function () {
                    exerciseRow.remove();
                    if (container.children.length === 0) {
                        addExerciseRow(container, muscleGroup);
                    }
                    updateAddExerciseButton(container);
                });

                updateAddExerciseButton(container);
            }

            function updateAddExerciseButton(container) {
                let addExerciseBtn = container.querySelector('.add-exercise-btn');
                if (!addExerciseBtn) {
                    addExerciseBtn = document.createElement('button');
                    addExerciseBtn.type = 'button';
                    addExerciseBtn.className = 'btn btn-secondary add-exercise-btn mt-2';
                    addExerciseBtn.textContent = 'Add Exercise';
                    addExerciseBtn.addEventListener('click', () => addExerciseRow(container, container.closest('.muscle-group').querySelector('.muscle-select').value));
                    container.appendChild(addExerciseBtn);
                } else {
                    container.appendChild(addExerciseBtn);
                }
            }

            function addMuscleGroup(dayElement) {
                const exerciseSelects = dayElement.querySelector('.exercise-selects');
                const newMuscleGroup = document.createElement('div');
                newMuscleGroup.className = 'muscle-group mt-3';
                newMuscleGroup.innerHTML = `
            <div class="mb-3">
                <select class="form-select muscle-select inpcol" name="exercises[${dayCount - 1}][muscle][]">
                    <option value="">Select muscle group</option>
                    ${Object.keys(exerciseOptions).map(muscle => `<option value="${muscle}">${muscle.charAt(0).toUpperCase() + muscle.slice(1)}</option>`).join('')}
                </select>
            </div>
            <div class="exercises"></div>
        `;
                exerciseSelects.appendChild(newMuscleGroup);
                attachEventListeners(newMuscleGroup);
            }

            attachEventListeners(workoutDays.querySelector('.workout-day'));

            workoutDays.querySelector('.workout-day .add-muscle-group-btn').addEventListener('click', function () {
                addMuscleGroup(this.closest('.workout-day'));
            });

            addDayButton.addEventListener('click', function () {
                dayCount++;
                const newDay = document.createElement('div');
                newDay.className = 'workout-day';
                newDay.innerHTML = `
            <div class="day-header">
                <div class="day-label">Day ${dayCount}</div>
                <button type="button" class="btn btn-danger btn-sm remove-day-btn">Remove Day</button>
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input rest-day-checkbox nocb" type="checkbox" name="exercises[${dayCount - 1}][rest_day]" id="restDay${dayCount - 1}">
                <label class="form-check-label" for="restDay${dayCount - 1}">Rest Day</label>
            </div>
            <div class="exercise-selects">
                <div class="muscle-group">
                    <div class="mb-3">
                        <select class="form-select muscle-select inpcol" name="exercises[${dayCount - 1}][muscle][]">
                            <option value="">Select muscle group</option>
                            ${Object.keys(exerciseOptions).map(muscle => `<option value="${muscle}">${muscle.charAt(0).toUpperCase() + muscle.slice(1)}</option>`).join('')}
                        </select>
                    </div>
                    <div class="exercises"></div>
                </div>
            </div>
            <button type="button" class="btn btn-secondary add-muscle-group-btn mt-3">Add Muscle Group</button>
        `;
                workoutDays.appendChild(newDay);
                attachEventListeners(newDay);

                const removeDayBtn = newDay.querySelector('.remove-day-btn');
                removeDayBtn.style.display = 'block';
                removeDayBtn.addEventListener('click', function () {
                    newDay.remove();
                    updateDayLabels();
                });

                newDay.querySelector('.add-muscle-group-btn').addEventListener('click', function () {
                    addMuscleGroup(newDay);
                });
            });

            function updateDayLabels() {
                const days = workoutDays.querySelectorAll('.workout-day');
                days.forEach((day, index) => {
                    day.querySelector('.day-label').textContent = `Day ${index + 1}`;
                });
                dayCount = days.length;
            }

            // New function to check if a day is empty
            function isDayEmpty(day) {
                const restDayCheckbox = day.querySelector('.rest-day-checkbox');
                if (restDayCheckbox.checked) {
                    return false; // Rest day is not considered empty
                }

                const exerciseSelects = day.querySelectorAll('.exercise-select');
                for (let select of exerciseSelects) {
                    if (select.value !== '') {
                        return false; // Day has at least one exercise selected
                    }
                }

                return true; // Day is empty
            }

            // Form submission handler
            routineForm.addEventListener('submit', function (e) {
                e.preventDefault();

                const days = workoutDays.querySelectorAll('.workout-day');
                let hasEmptyDay = false;

                days.forEach((day, index) => {
                    if (isDayEmpty(day)) {
                        hasEmptyDay = true;
                    }
                });

                if (hasEmptyDay) {
                    window.alert("Please fill up all of the selected days");
                } else {
                    // If no empty days, submit the form
                    this.submit();
                }
            });
        });
    </script>
</body>

</html>