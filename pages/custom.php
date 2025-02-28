<?php
// login session check
require_once '../php/config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
// fetching user's already created routines
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
    <link href="../css/styles.css" rel="stylesheet" />
    <!-- delete button style (bugs out externally because of bootstrap) -->
    <style>
        .delete-routine {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            color: #fff;
            font-size: 1.2rem;
            cursor: pointer;
        }

        .delete-routine:hover {
            color: #ff0000;
        }
    </style>
</head>

<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark nbs">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">GymPro
            </a>
            <div id="google_translate_element"></div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="dashboard.php">
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
    <!-- routine creation container -->
    <div class="container mt-5">
        <h1 class="text-center fw-bold mb-5">Your Custom Fitness Routines</h1>
        <h4 class="text-center mb-5 small-title">Designed by you, for you. Unlock your potential with the routines
            you’ve created. Select a plan, stay committed, and push yourself to new heights with every rep!</h4>
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card dashboard-card create-routine h-100">
                    <div class="card-body d-flex flex-column">
                        <h2 class="card-title">
                            <i class="fas fa-plus-circle"></i> Create New Routine
                        </h2>
                        <p class="card-text flex-grow-1">Design a new workout routine that fits your schedule and
                            targets your
                            specific fitness objectives. Customize every aspect of your training plan.</p>
                        <a href="create_routine.php" class="btn btn-lg btn-outline-light mt-auto">
                            Create New Routine <i class="fas fa-plus ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- custom routines display containers -->
            <?php foreach ($routines as $routine): ?>
                <div class="col-lg-6 mb-4">
                    <div class="card dashboard-card custom-routines h-100">
                        <div class="card-body d-flex flex-column">
                            <button class="delete-routine" onclick="deleteRoutine(<?php echo $routine['nbr']; ?>)">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                            <h2 class="card-title">
                                <i class="fa-solid fa-link"></i> <?php echo htmlspecialchars($routine['name']); ?>
                            </h2>
                            <p class="card-text flex-grow-1"><?php echo htmlspecialchars($routine['description']); ?></p>
                            <a href="view_routine.php?routine_nbr=<?php echo $routine['nbr']; ?>"
                                class="btn btn-lg btn-outline-light mt-3">
                                View Full Routine <i class="fas fa-chevron-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
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
    <script> // custom routine delete button
        function deleteRoutine(routineNbr) {
            if (confirm('Are you sure you want to delete this routine?')) {
                fetch('../php/delete_routine.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'routine_nbr=' + routineNbr
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Routine deleted successfully');
                            location.reload();
                        } else {
                            alert('Error deleting routine');
                        }
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                        alert('Error deleting routine');
                    });
            }
        }
    </script>
</body>

</html>
<?php
$conn->close();
?>