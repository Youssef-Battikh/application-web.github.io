<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Define the built-in routines
$routines = [
    [
        'id' => 'bro-split',
        'title' => 'Bro Split',
        'description' => 'A classic bodybuilding split that targets different muscle groups on separate days, allowing for focused training and recovery.',
        'schedule' => [
            'Monday' => [
                ['name' => 'Incline bench press', 'sets' => 4],
                ['name' => 'Bench press', 'sets' => 4],
                ['name' => 'Decline bench press', 'sets' => 4],
                ['name' => 'Dips', 'sets' => 4],
                ['name' => 'Push-down', 'sets' => 4],
            ],
            'Tuesday' => [
                ['name' => 'Deadlift', 'sets' => 4],
                ['name' => 'Lat pulldown', 'sets' => 4],
                ['name' => 'Cable row', 'sets' => 4],
                ['name' => 'Bicep curl', 'sets' => 4],
                ['name' => 'Hammer curl', 'sets' => 4],
            ],
            'Wednesday' => [
                ['name' => 'Rest day', 'sets' => 0],
            ],
            'Thursday' => [
                ['name' => 'Side lateral raise', 'sets' => 4],
                ['name' => 'Overhead press', 'sets' => 4],
                ['name' => 'Face pull', 'sets' => 4],
                ['name' => 'Barbell shrug', 'sets' => 4],
                ['name' => 'Dumbbell shrug', 'sets' => 4],
            ],
            'Friday' => [
                ['name' => 'Seated calf raise', 'sets' => 4],
                ['name' => 'Standing calf raise', 'sets' => 4],
                ['name' => 'Squat', 'sets' => 4],
                ['name' => 'Leg extensions', 'sets' => 4],
                ['name' => 'Leg press', 'sets' => 4],
                ['name' => 'Leg curl', 'sets' => 4],
            ],
            'Saturday' => [
                ['name' => 'Rest day', 'sets' => 0],
            ],
            'Sunday' => [
                ['name' => 'Rest day', 'sets' => 0],
            ],
        ],
    ],
    [
        'id' => 'ppl',
        'title' => 'PPL (Push, Pull, Legs)',
        'description' => 'A balanced routine that groups muscles with similar functions, allowing for frequent training of each muscle group while providing adequate recovery time.',
        'schedule' => [
            'Monday' => [
                ['name' => 'Incline bench press', 'sets' => 4],
                ['name' => 'Bench press', 'sets' => 4],
                ['name' => 'Overhead press', 'sets' => 4],
                ['name' => 'Dips', 'sets' => 4],
                ['name' => 'Push-down', 'sets' => 4],
            ],
            'Tuesday' => [
                ['name' => 'Deadlift', 'sets' => 4],
                ['name' => 'Lat pulldown', 'sets' => 4],
                ['name' => 'Side lateral raise', 'sets' => 4],
                ['name' => 'Face pull', 'sets' => 4],
                ['name' => 'Bicep curl', 'sets' => 4],
                ['name' => 'Hammer curl', 'sets' => 4],
            ],
            'Wednesday' => [
                ['name' => 'Standing calf raise', 'sets' => 4],
                ['name' => 'Squat', 'sets' => 4],
                ['name' => 'Leg extensions', 'sets' => 4],
                ['name' => 'Leg press', 'sets' => 4],
                ['name' => 'Leg curl', 'sets' => 4],
            ],
            'Thursday' => [
                ['name' => 'Rest day', 'sets' => 0],
            ],
            'Friday' => [
                ['name' => 'Incline bench press', 'sets' => 4],
                ['name' => 'Bench press', 'sets' => 4],
                ['name' => 'Overhead press', 'sets' => 4],
                ['name' => 'Dips', 'sets' => 4],
                ['name' => 'Push-down', 'sets' => 4],
            ],
            'Saturday' => [
                ['name' => 'Deadlift', 'sets' => 4],
                ['name' => 'Lat pulldown', 'sets' => 4],
                ['name' => 'Side lateral raise', 'sets' => 4],
                ['name' => 'Face pull', 'sets' => 4],
                ['name' => 'Bicep curl', 'sets' => 4],
                ['name' => 'Hammer curl', 'sets' => 4],
            ],
            'Sunday' => [
                ['name' => 'Rest day', 'sets' => 0],
            ],
        ],
    ],
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Built-in Routines - GymPro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link href="css/styles.css" rel="stylesheet" />
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-dumbbell me-2"></i>GymPro
            </a>
            <div id="google_translate_element"></div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="routines.php">
                            <i class="fas fa-home me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="builtin.php">
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

    <div class="container mt-5">
        <h1 class="text-center mb-5">Built-in Routines</h1>
        <div class="row">
            <?php foreach ($routines as $routine): ?>
                <div class="col-lg-6 mb-4">
                    <div class="card dashboard-card builtin-routines h-100">
                        <div class="card-body d-flex flex-column">
                            <h2 class="card-title">
                                <i class="fas fa-dumbbell icon-large"></i><?php echo htmlspecialchars($routine['title']); ?>
                            </h2>
                            <p class="card-text flex-grow-1"><?php echo htmlspecialchars($routine['description']); ?></p>
                            <div class="mt-auto">
                                <?php
                                $dayCount = 0;
                                foreach ($routine['schedule'] as $day => $exercises):
                                    if ($dayCount < 3):  // Show only first 3 days
                                        $dayCount++;
                                        ?>
                                        <h5 class="mt-3"><?php echo htmlspecialchars($day); ?></h5>
                                        <ul class="list-unstyled">
                                            <?php foreach (array_slice($exercises, 0, 3) as $exercise): // Show only first 3 exercises ?>
                                                <li><?php echo htmlspecialchars($exercise['name']); ?> -
                                                    <?php echo htmlspecialchars($exercise['sets']); ?> sets</li>
                                            <?php endforeach; ?>
                                            <?php if (count($exercises) > 3): ?>
                                                <li>...</li>
                                            <?php endif; ?>
                                        </ul>
                                        <?php
                                    endif;
                                endforeach;
                                if ($dayCount < count($routine['schedule'])):
                                    ?>
                                    <p>...</p>
                                <?php endif; ?>
                            </div>
                            <a href="view_routine.php?type=builtin&id=<?php echo urlencode($routine['id']); ?>"
                                class="btn btn-lg btn-outline-light mt-3">
                                View Full Routine <i class="fas fa-chevron-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">&copy; 2024 GymPro. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
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