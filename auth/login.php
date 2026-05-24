<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - LakbayPH</title>
</head>
<body>

  <h2>Login</h2>

  <form action="auth/login-process.php" method="POST">
    <input type="email" name="email" placeholder="Email address" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Log In</button>
  </form>

  <p>Don't have an account? <a href="register.php">Register</a></p>

</body>
</html>