<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "fitness_planner", 3306);

// Debug connection issues
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch routines for the logged-in user
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM routine WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$routines = [];
while ($row = $result->fetch_assoc()) {
    $routines[] = $row;
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Custom Routines - GymPro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link href="css/styles.css" rel="stylesheet" />
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
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
                        <a class="nav-link" aria-current="page" href="builtin.php">
                            <i class="fas fa-list-alt me-1"></i>Built-in
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="custom.php">
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
        <h1 class="text-center mb-5">Your Custom Routines</h1>
        <div class="row">
            <?php if (empty($routines)): ?>
                <div class="col-12">
                    <div class="alert alert-info" role="alert">
                        You haven't created any custom routines yet. <a href="create_routine.php" class="alert-link">Start
                            your first routine</a>!
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($routines as $routine): ?>
                    <div class="col-lg-6 mb-4">
                        <div class="card dashboard-card custom-routines h-100">
                            <div class="card-body d-flex flex-column">
                                <h2 class="card-title">
                                <i class="fa-solid fa-link"></i> <?php echo htmlspecialchars($routine['name']); ?>
                                </h2>
                                <p class="card-text flex-grow-1"><?php echo htmlspecialchars($routine['description']); ?></p>
                                <div class="mt-auto">
                                    <!-- Week exercises here -->
                                </div>
                                <a href="view_routine.php?nbr=<?php echo $routine['nbr']; ?>"
                                    class="btn btn-lg btn-outline-light mt-3">
                                    View Full Routine <i class="fas fa-chevron-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <footer class="bg-dark text-light py-4">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <p class="mb-0">&copy; 2024 GymPro. All rights reserved.</p>
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