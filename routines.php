<?php
require_once 'php/config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
  header("Location: index.php");
  exit();
}

// Get the user's name from the database
$id = $_SESSION['user_id'];
$sql = "SELECT name FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $name = $row['name'];
} else {
  $name = "User"; // Default name if not found
}

$stmt->close();
// Don't close the connection here as it might be needed later in the script
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard - GymPro</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
  <link href="css/styles.css" rel="stylesheet" />
</head>

<body>
  <!-- navbar -->
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
            <a class="nav-link active" aria-current="page" href="routines.php">
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
  <!-- dashbord containers -->
  <div class="container-fluid mt-5 dashboard-container">
    <h1 class="text-center fw-bold mb-5">Welcome to Your Fitness Journey</h1>
    <h4 class="text-center mb-5 small-title">Hey <?php echo htmlspecialchars($name); ?>, let's crush those fitness
      goals! Dive into your
      personalized
      routines or explore our pre-built options below to take your journey to the next level</h4>
    <div class="row justify-content-center">
      <div class="col-lg-4 mb-4">
        <div class="card dashboard-card custom-routines">
          <div class="card-body d-flex flex-column">
            <h2 class="card-title">
              <i class="fas fa-cog icon-large"></i>Custom Routines
            </h2>
            <p class="card-text flex-grow-1">View and manage your personalized workout routines tailored to your fitness
              goals. Take control of your training and achieve the results you desire.</p>
            <a href="custom.php" class="btn btn-lg btn-outline-light mt-auto">
              Explore Custom Routines <i class="fas fa-chevron-right ms-2"></i>
            </a>
          </div>
        </div>
      </div>
      <div class="col-lg-4 mb-4">
        <div class="card dashboard-card create-routine">
          <div class="card-body d-flex flex-column">
            <h2 class="card-title">
              <i class="fas fa-plus-circle icon-large"></i>Create New Routine
            </h2>
            <p class="card-text flex-grow-1">Design a new workout routine that fits your schedule and targets your
              specific fitness objectives. Customize every aspect of your training plan.</p>
            <a href="create_routine.php" class="btn btn-lg btn-outline-light mt-auto">
              Create New Routine <i class="fas fa-plus ms-2"></i>
            </a>
          </div>
        </div>
      </div>
      <div class="col-lg-4 mb-4">
        <div class="card dashboard-card builtin-routines">
          <div class="card-body d-flex flex-column">
            <h2 class="card-title">
              <i class="fas fa-list-alt icon-large"></i>Built-in Routines
            </h2>
            <p class="card-text flex-grow-1">Discover our professionally designed "Bro Split" and "PPL" routines for
              optimal muscle growth and strength. Get started with proven workout plans.</p>
            <a href="builtin.php" class="btn btn-lg btn-outline-light mt-auto">
              View Built-in Routines <i class="fas fa-list-ul ms-2"></i>
            </a>
          </div>
        </div>
      </div>
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
  <script type="text/javascript" src="js/element.js"></script>
  <script src="js/script.js"></script>
</body>

</html>