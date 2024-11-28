<?php
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
    <title>Routines - GymPro</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link href="css/styles.css" rel="stylesheet" />
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <a class="navbar-brand" href="#">GymPro</a>
        <div id="google_translate_element"></div>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
          aria-controls="navbarNav"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a
                class="nav-link active"
                aria-current="page"
                href="routines.php"
                >Routines</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Built-in</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Custom</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Log Out</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container mt-5">
      <h2 class="text-center mb-4">Your Gym Routines</h2>
      <div id="routinesList" class="row">
        <!-- Routines will be dynamically added here -->
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
    <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <script src="js/routines.js"></script>
    <script src="js/script.js"></script>
  </body>
</html>