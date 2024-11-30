<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Database connection (for custom routines)
$conn = new mysqli("localhost", "root", "", "fitness_planner",3306);

// Debug connection issues
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Built-in routines data
$builtin_routines = [
    'bro-split' => [
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
    'ppl' => [
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

$type = $_GET['type'] ?? '';
$id = $_GET['id'] ?? '';

$routine = null;

if ($type === 'builtin' && isset($builtin_routines[$id])) {
    $routine = $builtin_routines[$id];
} elseif ($type === 'custom') {
    // Fetch custom routine from database
    $stmt = $conn->prepare("SELECT * FROM routine WHERE nbr = ? AND id = ?");
    $stmt->bind_param("ii", $id, $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $routine = [
            'title' => $row['title'],
            'description' => $row['description'],
            'schedule' => []
        ];
        
        // Fetch exercises for each week
        for ($week = 1; $week <= 7; $week++) {
            $week_table = "week" . $week;
            $stmt = $conn->prepare("SELECT * FROM $week_table WHERE nbr = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $week_result = $stmt->get_result();
            
            $day_name = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'][$week - 1];
            $routine['schedule'][$day_name] = [];
            
            while ($exercise = $week_result->fetch_assoc()) {
                $routine['schedule'][$day_name][] = [
                    'name' => $exercise['exercice_name'],
                    'sets' => $exercise['sets']
                ];
            }
        }
    }
    $stmt->close();
}

if (!$routine) {
    header("Location: routines.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo htmlspecialchars($routine['title']); ?> - GymPro</title>
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

    <div class="container mt-5">
        <h1 class="text-center mb-5"><?php echo htmlspecialchars($routine['title']); ?></h1>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card dashboard-card <?php echo $type === 'builtin' ? 'builtin-routines' : 'custom-routines'; ?> mb-4">
                    <div class="card-body">
                        <h2 class="card-title">
                            <i class="fas fa-info-circle icon-large"></i>Description
                        </h2>
                        <p class="card-text"><?php echo htmlspecialchars($routine['description']); ?></p>
                    </div>
                </div>
                <?php foreach ($routine['schedule'] as $day => $exercises): ?>
                    <div class="card dashboard-card <?php echo $type === 'builtin' ? 'builtin-routines' : 'custom-routines'; ?> mb-4">
                        <div class="card-body">
                            <h2 class="card-title">
                                <i class="fas fa-calendar-day icon-large"></i><?php echo htmlspecialchars($day); ?>
                            </h2>
                            <ul class="list-unstyled">
                                <?php foreach ($exercises as $exercise): ?>
                                    <li class="mb-2">
                                        <strong><?php echo htmlspecialchars($exercise['name']); ?></strong> - 
                                        <?php echo htmlspecialchars($exercise['sets']); ?> sets
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
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
<?php
$conn->close();
?>

