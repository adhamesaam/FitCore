<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Check user role and login status from session
$userRole = isset($_SESSION['role']) ? $_SESSION['role'] : null;
$isLoggedIn = isset($_SESSION["id"]) ? true : false;
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bootstrap demo</title>
  <link rel="stylesheet" href="styles/headerStyle.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <style>
    .navbar-nav .nav-link {
      margin-left: 1rem;
    }
  </style>
</head>

<body>
  <nav class="navbar bg-body-tertiary fixed-top">
    <div class="container-fluid d-flex align-items-center">
      <a class="navbar-brand" href="#">FitCore</a>

      <!-- Desktop Navigation (visible on lg and up) -->
      <ul class="navbar-nav d-none d-lg-flex flex-row justify-content-center flex-grow-1 mb-0">
        <?php if (!$isLoggedIn): ?>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="home.php">Home</a>
          </li>
        <?php endif; ?>
        <?php if ($isLoggedIn && $userRole === 'user'): ?>
          <li class="nav-item">
            <a class="nav-link" href="profile.php">Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="goals.php">Goals</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="gymloc.php">Gym Location</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="supplements.php">Supplements</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="trainingvideos.php">Training videos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="carts.php">Cart</a>
          </li>
        <?php endif; ?>

        <?php if ($isLoggedIn && $userRole === 'admin'): ?>
          <li class="nav-item">
            <a class="nav-link" href="profile.php">Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="userManager.php">Dashboard</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="trainingvideos.php">Training videos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="supplements.php">Supplements</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="gymloc.php">Our Branches</a>
          </li>
          <!-- <li class="nav-item">
            <a class="nav-link" href="carts.php">Cart</a>
          </li> -->

        <?php endif; ?>

        <?php if (!$isLoggedIn): ?>
          <li class="nav-item">
            <a class="nav-link" href="about.php">About</a>
          </li>
        <?php endif; ?>
      </ul>

      <div class="d-none d-lg-block">
        <?php if ($isLoggedIn): ?>
          <button class="btn btn-outline-danger" onclick="window.location.href='logout.php'">Logout</button>
        <?php else: ?>
          <a class="nav-link" href="login.php">Login</a>
        <?php endif; ?>
      </div>

      <button class="navbar-toggler d-lg-none ms-auto" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <?php if (!$isLoggedIn): ?>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="home.php">Home</a>
              </li>
            <?php endif; ?>
            <?php if ($isLoggedIn && $userRole === 'user'): ?>
            <?php endif; ?>
            <?php if (!$isLoggedIn): ?>
              <li class="nav-item">
                <a class="nav-link" href="about.php">About</a>
              </li>
            <?php endif; ?>
            <li class="nav-item">
              <?php if ($isLoggedIn): ?>
                <a class="nav-link" href="logout.php">Logout</a>
              <?php else: ?>
                <a class="nav-link" href="login.php">Login</a>
              <?php endif; ?>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>