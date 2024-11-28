<?php
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
    <title>GymPro - Your Personal Fitness Journey Starts Here</title>
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
              <a class="nav-link active" aria-current="page" href="index.php"
                >Home</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link" href="signup.php">Sign Up</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="login.php">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link disabled" href="routines.php">Routines</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <header class="py-5">
      <div class="container px-5">
        <div class="row gx-5 justify-content-center">
          <div class="col-lg-8 col-xl-7">
            <div class="text-center">
              <h1 class="display-4 fw-bold mb-4">
                Transform Your Fitness Journey with GymPro
              </h1>
              <p class="lead mb-5">
                Unlock your potential with personalized workout routines
                tailored to your goals. Whether you're a beginner or a pro,
                GymPro empowers you to achieve your fitness dreams.
              </p>
              <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                <a
                  class="btn btn-primary btn-lg px-4 me-sm-3 butcol"
                  href="signup.php"
                  >Get Started</a
                >
                <a class="btn btn-outline-dark btn-lg px-4" href="login.php"
                  >Login</a
                >
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>

    <section class="py-5">
      <div class="container px-5">
        <div class="row gx-5 justify-content-center">
          <div class="col-lg-8 col-xl-6">
            <div class="text-center">
              <h2 class="fw-bold mb-5">Why Choose GymPro?</h2>
            </div>
          </div>
        </div>
        <div class="row gx-5">
          <div class="col-lg-4 mb-5 mb-lg-0">
            <div
              class="feature bg-primary bg-gradient text-white rounded-3 mb-3"
            >
              <i class="bi bi-collection"></i>
            </div>
            <h3 class="h4 fw-bold">Expert-Designed Routines</h3>
            <p>
              Access a variety of professionally crafted workout plans suitable
              for all fitness levels.
            </p>
          </div>
          <div class="col-lg-4 mb-5 mb-lg-0">
            <div
              class="feature bg-primary bg-gradient text-white rounded-3 mb-3"
            >
              <i class="bi bi-building"></i>
            </div>
            <h3 class="h4 fw-bold">Customizable Workouts</h3>
            <p>
              Create and tailor your own routines to match your specific goals
              and preferences.
            </p>
          </div>
          <div class="col-lg-4">
            <div
              class="feature bg-primary bg-gradient text-white rounded-3 mb-3"
            >
              <i class="bi bi-toggles2"></i>
            </div>
            <h3 class="h4 fw-bold">Progress Tracking</h3>
            <p>
              Monitor your fitness journey with easy-to-use tools and stay
              motivated to reach your targets.
            </p>
          </div>
        </div>
      </div>
    </section>

    <footer class="bg-dark text-light py-4">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <h5>Contact Us</h5>
            <p>Email: info@gympro.tn</p>
            <p>Phone: (+216) 76543210</p>
          </div>
          <div class="col-md-6">
            <h5>Stay Connected</h5>
            <p>
              Subscribe to our newsletter for the latest fitness tips and
              exclusive offers!
            </p>
            <form>
              <div class="input-group mb-3">
                <input
                  type="email"
                  class="form-control inpcol2"
                  placeholder="Enter your email"
                  aria-label="Email"
                  aria-describedby="button-addon2"
                />
                <button
                  class="btn btn-outline-light  "
                  type="button"
                  id="button-addon2"
                >
                  Subscribe
                </button>
              </div>
            </form>
          </div>
        </div>
        <hr class="my-4" />
        <div class="row">
          <div class="col-12 text-center">
            <p class="mb-0">&copy; 2024 GymPro. All rights reserved.</p>
          </div>
        </div>
      </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <script src="js/script.js"></script>
  </body>
</html>