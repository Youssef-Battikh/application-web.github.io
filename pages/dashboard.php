<?php
// login session check
require_once '../php/config.php';
if (!isset($_SESSION['user_id'])) {
  header("Location: index.php");
  exit();
}
// fetching user's username
$id = $_SESSION['user_id'];
$sql = "SELECT name FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $name = $row['name'];
}
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Navigation - Obsidian Muscle</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
  <link href="../css/styles.css" rel="stylesheet" />
  <link href="../css/colours.css" rel="stylesheet" />
  <link href="../css/fun.css" rel="stylesheet" />
</head>

<body class="light-background">
  <!-- navbar -->
  <nav class="navbar navbar-expand-lg navbar-custom sticky-navbar">
    <div class="container">
      <a class="navbar-brand navbar-custom" href="dashboard.php"><span class="obsidian-nav">Obsidian</span>Muscle</a>
      </a>
      <div id="google_translate_element"></div>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link nav-link-custom active-custom" aria-current="page" href="dashboard.php">
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
  <!-- dashbord containers -->
  <div class="container-fluid mt-5 dashboard-container">
    <h1 class="text-center fw-bold mb-5 dark-text">Welcome Back <?php echo htmlspecialchars($name); ?></h1>
    <!-- username display -->
    <h4 class="text-center mb-5 small-title">Welcome to your Navigation Menu! What are you choosing today?
    </h4>
    <div class="row justify-content-center">
      <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
        <div class="card dashboard-card purple-card">
          <div class="card-body d-flex flex-column">
            <h2 class="card-title">
              <i class="fa-solid fa-users icon-large"></i>Community Workouts
            </h2>
            <p class="card-text flex-grow-1">Browse and discover routines shared by fellow ObsidianMuscle users.</p>
            <a href="community.php" class="btn btn-lg btn-outline-light mt-auto">
              Explore<i class="fas fa-list-ul ms-2"></i>
            </a>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
        <div class="card dashboard-card gold-card">
          <div class="card-body d-flex flex-column">
            <h2 class="card-title">
              <i class="fas fa-plus-circle icon-large"></i>Create Workout
            </h2>
            <p class="card-text flex-grow-1">Design a new workout routine that fits your schedule and targets your
              specific fitness objectives.</p>
            <a href="create_routine.php" class="btn btn-lg btn-outline-light mt-auto">
              Create<i class="fas fa-plus ms-2"></i>
            </a>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
        <div class="card dashboard-card purple-card">
          <div class="card-body d-flex flex-column">
            <h2 class="card-title">
              <i class="fa-solid fa-bookmark icon-large"></i>Your Library
            </h2>
            <p class="card-text flex-grow-1">View and manage your personally/community created workout routines.</p>
            <a href="custom.php" class="btn btn-lg btn-outline-light mt-auto">
              View <i class="fas fa-chevron-right ms-2"></i>
            </a>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
        <div class="card dashboard-card gold-card">
          <div class="card-body d-flex flex-column">
            <h2 class="card-title">
              <i class="fa-solid fa-box-archive icon-large"></i>Built-in Routines
            </h2>
            <p class="card-text flex-grow-1">Discover our built-in workouts!
              Recommanded for newcomers.</p>
            <a href="builtin.php" class="btn btn-lg btn-outline-light mt-auto">
              Explore<i class="fas fa-list-ul ms-2"></i>
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