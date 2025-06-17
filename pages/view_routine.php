<?php
// login session check
include '../php/config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
// routine_nbr url check
if (!isset($_GET['routine_nbr'])) {
    echo "Routine not specified.";
    exit;
}
$routine_nbr = intval($_GET['routine_nbr']);
// fetching routine table info for the nbr passed in the url
$routine_query = $conn->prepare("SELECT name, description FROM routine WHERE nbr = ?");
$routine_query->bind_param("i", $routine_nbr);
$routine_query->execute();
$routine_result = $routine_query->get_result();

if ($routine_result->num_rows == 0) {
    echo "Routine not found.";
    exit;
}
$routine = $routine_result->fetch_assoc();
// fetching exercises sorted by day and id 
$exercises_query = $conn->prepare("SELECT day, exercise_name, sets FROM routine_exercises WHERE routine_nbr = ? ORDER BY day ASC, id ASC");
$exercises_query->bind_param("i", $routine_nbr);
$exercises_query->execute();
$exercises_result = $exercises_query->get_result();
// grouping exercices by day
$exercises_by_day = [];
while ($exercise = $exercises_result->fetch_assoc()) {
    $exercises_by_day[$exercise['day']][] = $exercise;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Built-in - Obsidian Muscle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=fitness_center" />
    <link href="../css/styles.css" rel="stylesheet" />
    <link href="../css/colours.css" rel="stylesheet" />
    <link href="../css/fun.css" rel="stylesheet" />
</head>

<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-navbar">
        <div class="container">
            <a class="navbar-brand navbar-custom" href="dashboard.php"><span
                    class="obsidian-nav">Obsidian</span>Muscle</a>
            </a>
            <div id="google_translate_element"></div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" aria-current="page" href="dashboard.php">
                            <i class="fa-solid fa-address-card"></i> Menu
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="community.php">
                            <i class="fas fa-users me-1"></i>Community
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="custom.php">
                            <i class="fas fa-bookmark me-1"></i>Library
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="builtin.php">
                            <i class="fas fa-box-archive me-1"></i>Built-in
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="logout.php">
                            <i class="fas fa-sign-out-alt me-1"></i>Log Out
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5 mb-5">
        <!-- routine header (title,description) -->
        <div class="routine-header">
            <h1><?php echo htmlspecialchars($routine['name']); ?></h1>
            <p class="lead mb-0"><?php echo htmlspecialchars($routine['description']); ?></p>
        </div>
        <!-- routine exercices -->
        <?php foreach ($exercises_by_day as $day => $exercises): ?>
            <h2 class="day-header">Day <?php echo $day; ?></h2>
            <?php // rest day check
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
    <footer class="py-4 dark-background">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <p class="mb-1 light-text">&copy; 2025 ObsidianMuscle. All rights reserved.</p>
                    <a href="#" class="light-text me-2"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="light-text me-2"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="light-text me-2"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="light-text"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="../js/element.js"></script>
    <script src="../js/script.js"></script>
</body>

</html>