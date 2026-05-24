<?php include '../includes/config.php';

// TEMP: later lalagyan mo ng admin auth check
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard - LakbayPH</title>
  <link rel="stylesheet" href="../assets/styles.css">
</head>

<body>

  <div class="admin-sidebar">
    <h2>Admin Panel</h2>

    <a href="dashboard.php">Dashboard</a>
    <a href="manage_users.php">Users</a>
    <a href="manage_hotels.php">Hotels</a>
    <a href="manage_destinations.php">Destinations</a>
    <a href="../index.php">Back to Site</a>
  </div>

  <section class="admin-dashboard">
    <h1>Admin Dashboard</h1>

    <div class="admin-grid">

      <div class="admin-card">
        <h3>Destinations</h3>
        <p>Manage all places</p>
        <a href="manage_destinations.php">Open</a>
      </div>

      <div class="admin-card">
        <h3>Hotels</h3>
        <p>Add / Edit hotels</p>
        <a href="manage_hotels.php">Open</a>
      </div>

      <div class="admin-card">
        <h3>Bookings</h3>
        <p>View reservations</p>
        <a href="manage_bookings.php">Open</a>
      </div>

      <div class="admin-card">
        <h3>Users</h3>
        <p>User accounts</p>
        <a href="manage_users.php">Open</a>
      </div>

    </div>

  </section>

</body>

</html>