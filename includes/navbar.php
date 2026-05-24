<?php
session_start();
?>

<?php include_once __DIR__ . '/config.php'; ?>

<nav>
  <div class="nav-logo">Lakbay<span>PH</span></div>

  <ul class="nav-links">
    <li><a href="index.php">Home</a></li>
    <li><a href="/pages/destinations.php">Destinations</a></li>
    <li><a href="hotels/list.php">Hotels</a></li>
    <li><a href="/pages/itinerary.php">Plan Trip</a></li>
  </ul>
  
  <div class="nav-actions">

    <?php if (!isset($_SESSION['user'])): ?>
      
      <!-- GUEST -->
      <a href="auth/login.php" class="btn-nav">Log In</a>
      <a href="auth/signup.php" class="btn-nav filled">Sign Up</a>

    <?php else: ?>

      <!-- LOGGED IN USER -->
      <span style="color:white; margin-right:10px;">
        👤 <?php echo htmlspecialchars($_SESSION['user']); ?>
      </span>

      <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <a class="btn-nav" href="/admin/dashboard.php">Admin</a>
      <?php endif; ?>

      <a class="btn-nav filled" href="/auth/logout.php">Logout</a>

    <?php endif; ?>

  </div>
</nav>