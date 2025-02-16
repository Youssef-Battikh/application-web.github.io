<?php
// login session check
session_start();
if (isset($_SESSION['user_id'])) {
  header("Location: routines.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Obsidian Muscle - Your Personalized Community Made Workout Planner</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../css/styles.css" rel="stylesheet" />
  <link href="../css/colours.css" rel="stylesheet" />
</head>

<body>
  <!-- navbar -->
  <nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container">
      <a class="navbar-brand navbar-custom" href="index.php"><span class="obsidian-nav">Obsidian</span>Muscle</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link nav-link-custom active-custom" aria-current="page" href="index.php"><i
                class="fas fa-home me-1"></i>Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-link-custom" href="signup.php"><i class="fa-solid fa-user-plus"></i> Sign Up</a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-link-custom" href="login.php"><i class="fa-solid fa-right-to-bracket"></i> Login</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- background video and header -->
  <div class="video-container">
    <video autoplay loop muted plays-inline>
      <source src="../assets/GymPro.mp4" type="video/mp4">
    </video>
    <header class="py-5">
      <div class="container px-5">
        <div class="row gx-5 justify-content-center">
          <div class="col-lg-8 col-xl-7">
            <div class="text-center">
              <span class="display-4 fw-bold mb-4 lighter-text">
                Transform Your Fitness Journey NOW!
                </h1>
                <p class="lead mb-5 lighter-text">
                  Unlock your potential with personalized workout routines
                  tailored to your goals. Whether you're a beginner or a pro,
                  ObsidianMuscle empowers you to achieve your fitness dreams.
                </p>
                <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                  <a class="btn btn-outline-dark btn-lg px-4 lp-button lp-signup" href="signup.php">Get Started</a>
                  <a class="btn btn-outline-dark btn-lg px-4 lp-button lp-login" href="login.php">Login</a>
                </div>
            </div>
          </div>
        </div>
      </div>
    </header>
  </div>
  <!--lower section -->
  <section class="py-5">
    <div class="container px-5">
      <div class="row gx-5 justify-content-center">
        <div class="col-lg-8 col-xl-6">
          <div class="text-center">
            <h2 class="fw-bold mb-5 dark-text">Why Choose ObsidianMuscle?</h2>
          </div>
        </div>
      </div>
      <div class="row gx-5">
        <div class="col-lg-4 mb-5 mb-lg-0">
          <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3">
            <i class="bi bi-collection"></i>
          </div>
          <h3 class="h4 fw-bold dark-text"><i class="fa-solid fa-wand-magic-sparkles"></i>Expert-Designed Routines</h3>
          <p class="dark-text">
            Access a variety of professionally crafted workout plans suitable
            for all fitness levels.
          </p>
        </div>
        <div class="col-lg-4 mb-5 mb-lg-0">
          <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3">
            <i class="bi bi-building"></i>
          </div>
          <h3 class="h4 fw-bold dark-text"><i class="fa-solid fa-pen-to-square"></i>Customizable Workouts</h3>
          <p class="dark-text">
            Create and tailor your own routines to match your specific goals
            and preferences.
          </p>
        </div>
        <div class="col-lg-4">
          <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3">
            <i class="bi bi-toggles2"></i>
          </div>
          <h3 class="h4 fw-bold dark-text"><i class="fa-solid fa-paper-plane"></i>Community Interaction</h3>
          <p class="dark-text">
            Share your workouts, explore others' routines, and engage with
            our fitness community.
          </p>
        </div>
      </div>
    </div>
  </section>
  <!-- footer -->
  <footer class="py-4 dark-background">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <h5 class="light-text">Contact Us</h5>
          <p class="light-text">Email: info@obsidianmuscle.tn</p>
          <p class="light-text">Phone: (+216) 76543210</p>
        </div>
        <div class="col-md-6">
          <h5 class="light-text">Stay Connected</h5>
          <p class="light-text">
            Subscribe to our newsletter to stay updated!
          </p>
          <form>
            <div class="input-group mb-3">
              <input type="email" class="form-control lp-newsletter" placeholder="Enter your email" aria-label="Email"
                aria-describedby="button-addon2" />
              <button class="btn btn-outline-light" type="button" id="button-addon2">
                Subscribe
              </button>
            </div>
          </form>
        </div>
      </div>
      <hr class="my-4" />
      <div class="row">
        <div class="col-md-12 text-center">
          <p class="mb-1 light-text">&copy; 2024 GymPro. All rights reserved.</p>
          <a href="#" class="light-text me-2"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="light-text me-2"><i class="fab fa-twitter"></i></a>
          <a href="#" class="light-text me-2"><i class="fab fa-instagram"></i></a>
          <a href="#" class="light-text"><i class="fab fa-linkedin-in"></i></a>
        </div>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../js/script.js"></script>
</body>

</html>