<?php
include 'php/config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
// Check if routine_nbr is passed in the URL
if (!isset($_GET['routine_nbr'])) {
    echo "Routine not specified.";
    exit;
}
$routine_nbr = intval($_GET['routine_nbr']);
// Fetch routine details
$routine_query = $conn->prepare("SELECT name, description FROM routine WHERE nbr = ?");
$routine_query->bind_param("i", $routine_nbr);
$routine_query->execute();
$routine_result = $routine_query->get_result();

if ($routine_result->num_rows == 0) {
    echo "Routine not found.";
    exit;
}
$routine = $routine_result->fetch_assoc();
// Fetch exercises for the routine
$exercises_query = $conn->prepare("SELECT day, exercise_name, sets FROM routine_exercises WHERE routine_nbr = ? ORDER BY day ASC, id ASC");
$exercises_query->bind_param("i", $routine_nbr);
$exercises_query->execute();
$exercises_result = $exercises_query->get_result();
// Group exercises by day
$exercises_by_day = [];
while ($exercise = $exercises_result->fetch_assoc()) {
    $exercises_by_day[$exercise['day']][] = $exercise;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>View Routine - GymPro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link href="css/styles.css" rel="stylesheet" />
    <style>
    </style>
</head>

<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark nbs">
        <div class="container">
            <a class="navbar-brand" href="#">GymPro
            </a>
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
                        <a class="nav-link" href="builtin.php">
                            <i class="fas fa-list-alt me-1"></i>Built-in
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="custom.php">
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
    <div class="container mt-5 mb-5">
        <!-- Routine Header -->
        <div class="routine-header">
            <h1><?php echo htmlspecialchars($routine['name']); ?></h1>
            <p class="lead mb-0"><?php echo htmlspecialchars($routine['description']); ?></p>
        </div>
        <!-- Routine Exercises -->
        <?php foreach ($exercises_by_day as $day => $exercises): ?>
            <h2 class="day-header">Day <?php echo $day; ?></h2>
            <?php
            $is_rest_day = count($exercises) === 1 && strtolower($exercises[0]['exercise_name']) === 'rest';
            if ($is_rest_day):
                ?>
                <div class="rest-day">
                    <i class="bi bi-moon-stars me-2"></i> Rest Day
                </div>
            <?php else: ?>
                <div class="row gy-4">
                    <?php foreach ($exercises as $exercise): ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="card exercise-card">
                                <div class="card-body">
                                    <span class="exercise-name"><?php echo htmlspecialchars($exercise['exercise_name']); ?></span>
                                    <span class="sets-badge">Sets: <?php echo $exercise['sets']; ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
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
    <script type="text/javascript" src="js/element.js"></script>
    <script src="js/script.js"></script>
</body>

</html>