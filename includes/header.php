<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$isLoggedIn = isset($_SESSION['user']);
$userName = $_SESSION['user']['name'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($pageTitle ?? 'LakbayLokal — Explore the Philippines') ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= $rootPath ?? '' ?>assets/style.css">
  <link rel="stylesheet" href="<?= $rootPath ?? '' ?>assets/hotel.css">
  <link rel="stylesheet" href="<?= $rootPath ?? '' ?>assets/auth.css">
</head>

<body>

  <nav>
    <div class="nav-logo" onclick="location.href='<?= $rootPath ?? '' ?>index.php'">Lakbay<span>Lokal</span></div>
    <ul class="nav-links">
      <li><a href="<?= $rootPath ?? '' ?>index.php" class="<?= ($activePage ?? '') === 'home'         ? 'active' : '' ?>">Home</a></li>
      <li><a href="<?= $rootPath ?? '' ?>destinations.php" class="<?= ($activePage ?? '') === 'destinations'  ? 'active' : '' ?>">Destinations</a></li>
      <li><a href="<?= $rootPath ?? '' ?>index.php#about" class="<?= ($activePage ?? '') === 'about'         ? 'active' : '' ?>">About</a></li>
      <li><a href="<?= $rootPath ?? '' ?>index.php#mytrips" class="<?= ($activePage ?? '') === 'mytrips'       ? 'active' : '' ?>">My Trips</a></li>
    </ul>
    <div class="nav-actions">

      <?php if ($isLoggedIn): ?>
        <span class="nav-user"><?= htmlspecialchars($userName) ?></span>
        <button class="nav-ghost" onclick="logoutUser()">Logout</button>
      <?php else: ?>
        <button class="nav-ghost" onclick="openAuthModal('login')">Login</button>
        <button class="nav-cta" onclick="openAuthModal('signup')">Sign Up</button>
      <?php endif; ?>

    </div>
    <button class="hamburger" onclick="document.getElementById('mobileMenu').classList.toggle('open')" aria-label="Menu">
      <span></span><span></span><span></span>
    </button>
  </nav>

  <div class="mobile-menu" id="mobileMenu">

    <a href="index.php">Home</a>
    <a href="destinations.php">Destinations</a>
    <a href="index.php#about">About</a>
    <a href="index.php#mytrips">My Trips</a>

    <?php if ($isLoggedIn): ?>
      <a onclick="logoutUser()">Logout</a>
    <?php else: ?>
      <a onclick="openAuthModal('login')">Login</a>
      <a onclick="openAuthModal('signup')">Sign Up</a>
    <?php endif; ?>

  </div>

  <!-- Auth Modal -->
  <div class="auth-modal-overlay" id="authModal" onclick="if(event.target===this) closeAuthModal()">
    <div class="auth-modal">
      <!-- Login Tab -->
      <div class="auth-tab" id="authLogin">
        <button class="auth-modal-close" onclick="closeAuthModal()">✕</button>
        <div class="auth-kicker">Welcome back</div>
        <h2>Login to LakbayLokal</h2>
        <form class="auth-form" onsubmit="handleLogin(event)" novalidate>
          <div class="form-group">
            <label>Email</label>
            <input type="email" id="loginEmail" placeholder="juan@email.com" required>
          </div>
          <div class="form-group">
            <label>Password</label>
            <input type="password" id="loginPassword" placeholder="••••••••" required>
          </div>
          <button class="btn-primary auth-submit" type="submit">Login</button>
        </form>
        <div class="auth-switch">No account yet? <button type="button" onclick="switchAuthTab('signup')">Create one</button></div>
      </div>
      <!-- Signup Tab -->
      <div class="auth-tab" id="authSignup" style="display:none;">
        <button class="auth-modal-close" onclick="closeAuthModal()">✕</button>
        <div class="auth-kicker">Create account</div>
        <h2>Sign Up</h2>
        <form class="auth-form" onsubmit="handleSignup(event)" novalidate>
          <div class="auth-grid">
            <div class="form-group">
              <label>First Name</label>
              <input type="text" id="signupFName" required>
            </div>
            <div class="form-group">
              <label>Last Name</label>
              <input type="text" id="signupLName" required>
            </div>
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" id="signupEmail" required>
          </div>
          <div class="form-group">
            <label>Password</label>
            <input type="password" id="signupPassword" required>
          </div>
          <button class="btn-primary auth-submit" type="submit">Create Account</button>
        </form>
        <div class="auth-switch">Already have an account? <button type="button" onclick="switchAuthTab('login')">Login</button></div>
      </div>
    </div>
  </div>

  <div class="toast" id="toast"></div>