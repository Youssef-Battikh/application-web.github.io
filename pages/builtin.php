<?php
// login session check
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
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
            </a>
            <div id="google_translate_element"></div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="dashboard.php">
                            <i class="fa-solid fa-address-card"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom active-custom" aria-current="page" href="builtin.php">
                            <i class="fas fa-list-alt me-1"></i>Built-in
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="custom.php">
                            <i class="fas fa-cog me-1"></i>Custom
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
    <!-- containers -->
    <div class="container mt-5">
        <h1 class="text-center fw-bold mb-5 dark-text">Editors' Built-in Programs</h1>
        <h4 class="text-center mb-5 small-title">Select a workout program that suits your fitness journey, made by our
            editors!</h4>
        <div class="row row justify-content-center">
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="card dashboard-card purple-card">
                    <div class="card-body d-flex flex-column">
                        <h2 class="card-title">
                            <i class="fa-solid fa-server"></i> Bro Split ?
                        </h2>
                        <p class="card-text flex-grow-1">A classic bodybuilding split that targets different muscle
                            groups on separate days, allowing for focused training and recovery.</p>
                        <span class="yellow-text left"><i class="fa-solid fa-calendar-days gold-text"></i> 5 Days</span>
                        <span class="yellow-text right"><i class="fa-solid fa-bullseye gold-text"></i> 21
                            Exercises</span>
                        <a href="view_routine.php?routine_nbr=<?php echo 1; ?>"
                            class="btn btn-lg btn-outline-light mt-3">
                            View Full Routine <i class="fas fa-chevron-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="card dashboard-card purple-card">
                    <div class="card-body d-flex flex-column">
                        <h2 class="card-title">
                            <i class="fa-solid fa-server"></i> PPL (Push, Pull, Legs) ?
                        </h2>
                        <p class="card-text flex-grow-1">A balanced routine that groups muscles with similar functions,
                            allowing for frequent training of each muscle group while providing adequate recovery time.
                        </p>
                        <span class="yellow-text left"><i class="fa-solid fa-calendar-days gold-text"></i> 3 Days</span>
                        <span class="yellow-text right"><i class="fa-solid fa-bullseye gold-text"></i> 16
                            Exercises</span>
                        <a href="view_routine.php?routine_nbr=<?php echo 2; ?>"
                            class="btn btn-lg btn-outline-light mt-3">
                            View Full Routine <i class="fas fa-chevron-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
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