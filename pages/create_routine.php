<?php
// check login session
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
$muscle_groups = ["trapz", "shoulders", "chest", "abs", "back", "biceps", "triceps", "forearms", "quadriceps", "calves", "hamstring"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Custom Routine - GymPro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="../css/styles.css" rel="stylesheet">
</head>

<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="routines.php">GymPro</a>
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
    <!-- routine creation form -->
    <div class="container mt-5">
        <h1 class="text-center fw-bold mb-5">Create Your Custom Routine</h1>
        <form id="routineForm" method="POST" action="../php/create.php">
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
                    <button type="button" class="btn btn-secondary add-muscle-group-btn mt-3 btn5">Add Muscle
                        Group</button>
                </div>
            </div>
            <div class="form-actions">
                <button type="button" id="addDay" class="btn btn-secondary lpb3">Add Another Day</button>
                <button type="submit" class="btn btn-primary btn4">Create Routine</button>
            </div>
        </form>
    </div>
    <!-- footer -->
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
    <script type="text/javascript" src="../js/element.js"></script>
    <script src="../js/script.js"></script>
    <script src="../js/create.js"></script>
</body>

</html>