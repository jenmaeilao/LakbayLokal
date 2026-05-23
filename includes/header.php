<nav>
  <div class="nav-logo">Lakbay<span>PH</span></div>
  <ul class="nav-links">
    <li><a href="#destinations">Destinations</a></li>
    <li><a href="#hotels">Hotels</a></li>
    <li><a href="#itinerary">Plan Trip</a></li>
    <li><a href="#reviews">Reviews</a></li>
  </ul>

  <?php if (isset($_SESSION['user_id'])): ?>
    <div class="nav-actions">
      <a href="profile.php" class="btn-nav">Profile</a>
      <a href="logout.php" class="btn-nav">Log Out</a>
    </div>
  <?php else: ?>
    <div class="nav-actions">
      <button class="btn-nav" onclick="openModal('login')">Log In</button>
      <button class="btn-nav filled" onclick="openModal('register')">Sign Up</button>
    </div>
  <?php endif; ?>
</nav>